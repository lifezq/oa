<?php

/**
 * @filename indexController.php
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://www.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-8-5  11:22:04
 * @version 1.0
 * Description of indexController
 */
App::uses('AppController', 'Controller');

class SystemController extends AppController {
    //put your code here
    /**
     * Controller name
     *
     * @var string
     */

    /**
     * This controller does not use a model
     *
     * @var array
     */

    public $uses = array('Group', 'Navigation');


    public function navigationManage() {
        if ($this->request->is('post')) {
            $n_per = '';
            if(count($this->request->data['n_permission'])){
                foreach($this->request->data['n_permission'] as $v){
                    $n_per .= $v.',';
                }
                $this->request->data['Navigation']['n_permission'] = rtrim($n_per, ',');
            }else{
                $this->request->data['Navigation']['n_permission'] = '';
            }
            unset($this->request->data['n_permission']);
            //是否有顶级，找出顶级路径，并组合出子导航新路径 n_path ,并且不是在修改情况下才组合路径 
            $path = 0;
            if($this->request->data['Navigation']['n_pid']){
                if(empty($this->request->data['Navigation']['n_id'])){ //创建导航
                $p_path = $this->Navigation->find('all',array('conditions'=>array('Navigation.n_id'=>$this->request->data['Navigation']['n_pid']),'fields'=>'n_path'));
                $path = $p_path[0]['Navigation']['n_path'].'_'.$this->request->data['Navigation']['n_pid'];
               }elseif($this->request->data['Navigation']['n_id']){ //修改导航
                  //找出当前导航pid,路径,对比判断是否修改其上级
                  $cur_path = $this->Navigation->find('all',array('conditions'=>array('Navigation.n_id'=>$this->request->data['Navigation']['n_id']),'fields'=>array('n_pid','n_path')));
                  
                  if($cur_path[0]['Navigation']['n_pid'] == $this->request->data['Navigation']['n_pid']){
                      $path = $cur_path[0]['Navigation']['n_path'];
                  }else{ //说明修改了上级
                     $p_path = $this->Navigation->find('all',array('conditions'=>array('Navigation.n_id'=>$this->request->data['Navigation']['n_pid']),'fields'=>'n_path'));
                     $path = $p_path[0]['Navigation']['n_path'].'_'.$this->request->data['Navigation']['n_pid'];
                  }
              }
             }
            $this->request->data['Navigation']['n_path'] = $path;
            
            if (!$this->request->data['Navigation']['n_id']) {
                $msg = $this->_L('create_failed');
                if ($this->Navigation->save($this->request->data))
                    $msg = $this->_L('create_success');
            }else{
                $msg = $this->_L('modify_failed');
                if ($this->Navigation->save($this->request->data))
                    $msg = $this->_L('modify_success');
            }
            $this->Session->setFlash($msg);
        }
        $this->set('_position', $this->_L('navigation_list'));
        $_create = false;
        if ($this->request['pass']) {
            if ($this->request['pass'][0] == 'add'){//添加导航与子导航
                $this->set('_position', $this->_L('add_navigation'));
                $_create = true;
                $this->set('_pid',0);
                if($this->request['pass'][1]){
                    $this->set('_pid',$this->request['pass'][1]);
                    $this->set('_position', $this->_L('add_child_navigation'));
                }
            }elseif($this->request['pass'][0] == 'edit'){//编辑导航
                $this->set('_position', $this->_L('edit_navigation'));
                $_create = true;
                $this->set('_pid',0);
                //找出当前导航上级 n_pid
                $_pid = $this->Navigation->find('all',array('conditions'=>array('Navigation.n_id'=>$this->request['pass'][1]),'fields'=>'n_pid'));
                if($this->request['pass'][1]) $this->set('_pid',$_pid[0]['Navigation']['n_pid']);
                //分配过去要编辑的导航
                $this->set('Navigation',$this->Navigation->find('all',array('conditions'=>array('Navigation.n_id'=>$this->request['pass'][1]))));
            }elseif($this->request['pass'][0] == 'del'){
                $msg = $this->_L('del_failed');
                if($this->Navigation->delete($this->request['pass'][1])) $msg = $this->_L('del_success');
                $this->Session->setFlash($msg);
            }
                
        }
        //找出已有导航列表
        $navList = $this->getNavList();
        
        $navList_arr = array();
        $navList_arr[''] = $this->_L('choose_parent_nav');
        $navList_arr[0] = $this->_L('top_navigation');
        foreach($navList as $v){
            $navList_arr[$v['Navigation']['n_id']] = $v['Navigation']['n_name'];
        }
        
        //找出用户组列表
        $groupList = $this->Group->find('all',array('conditions'=>array('Group.g_status'=>1,'Group.com_id'=>$this->onLineUser['u_company_id'])));
        
        $this->set('groupList', $groupList);
        $this->set('nav_list', $navList);
        $this->set('navList', $navList_arr);
        $this->set('create', $_create);
        
    }

    public function getNavList() {
        //找出所有启用用户组,组合到导航可访问用户组
        $groups = $this->Group->find('all',array('conditions'=>array('Group.g_status'=>1),'fields'=>array('g_id','g_name')));
        $newGroups =  array();
        foreach($groups as $v){
            $newGroups[$v['Group']['g_id']] = $v['Group']['g_name'];
        }
        
        $navList = $this->Navigation->find('all',array('fields'=>array("concat(Navigation.n_path,'_',Navigation.n_id) as pi",'n_id','n_name','n_permission','n_link'),'order'=>'pi asc'));
        $navListArr = array();
        foreach($navList as $v){
            $level = '|'.str_repeat('-',count(explode('_',$v[0]['pi']))-1);
            $v['Navigation']['n_name'] = $level.$v['Navigation']['n_name'];
            unset($v[0]);
            $permission = explode(',',$v['Navigation']['n_permission']);
            if($permission){
                foreach($permission as $m){
                    $v['Navigation']['accessGroup'][] = $newGroups[$m];
                }
            }
            $navListArr[] = $v;
        }
        return $navListArr;
    }

}

?>
