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
class IndexController extends AppController{
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
	public $uses = array('User','Group','Navigation','Permission');
        public $layout = false;
        
        public function index(){
         
        }
        public function top(){
        
        }
        public function menu(){
            //查找到当前用户的权限节点
           $permission = $this->Permission->find('all',array('conditions'=>array('Permission.p_uid'=>$this->onLineUser['u_id']),'fields'=>'Permission.p_nav_allows'));
           $permissionArr = array();
           if(!empty($permission[0]['Permission']['p_nav_allows']))
           $permissionArr = explode(',', $permission[0]['Permission']['p_nav_allows']); //用户权限节点数组
           
           $navList = $this->getNavList();
           $newNavList = array();
           
           foreach($navList as $v){
               if(count($permissionArr)){ //如果有权限节点，则约束其权限节点，否则约束用户组权限
                   if(in_array($this->onLineUser['u_gid'],$v['Navigation']['accessGid']) && array_intersect($permissionArr,array(0=>$v['Navigation']['n_id'])))
                           $newNavList[$v['Navigation']['n_pid']][] = $v['Navigation']; 
               }else{
                   if(in_array($this->onLineUser['u_gid'],$v['Navigation']['accessGid']))
                           $newNavList[$v['Navigation']['n_pid']][] = $v['Navigation']; 
               }
           }

           $this->set('navList',$newNavList);
        }
        public function main(){
            
        }
        public function showMe(){
          
            $this->set('page_title','展示自我');
        }

}

?>
