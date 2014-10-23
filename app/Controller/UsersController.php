<?php

/**
 * @filename UsersController.php
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-8-5  11:22:04
 * @version 1.0
 * Description of indexController
 */
App::uses('AppController', 'Controller');

class UsersController extends AppController {
    
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
  
    public $uses = array('User','ClassPosts','Group','AddressBook','LeaveApplications','Schedules','WorkDiarys','Cabinets','Navigation','Permission','UserInfos');


    //用户管理
    public function userManage() {
        $users = $this->User->query('select User.*,Class.cp_name,Posts.cp_name,Groups.g_name,Permission.p_nav_allows from oa_users as User inner join oa_class_posts as Class on User.u_class_id=Class.cp_id inner join oa_class_posts as Posts on User.u_posts_id=Posts.cp_id inner join oa_group as Groups on User.u_gid=Groups.g_id left join oa_permissions as Permission on User.u_id=Permission.p_uid where User.u_company_id='.$this->onLineUser['u_company_id'].'  order by User.u_id desc ');
        $this->set('users', $users);
    }

    /*
     * 访问权限配置
     * 
     */
    public function access(){
        if($this->request->is('post')){
            $permission = '';
            foreach($this->request->data['nid'] as $v){
                $permission .= $v.',';
            }
           $permission = rtrim($permission,',');
           unset($this->request->data['nid']);
           $this->request->data['Permission']['p_nav_allows'] = $permission;
          //查找有没有该用户的权限配置，如果没有，则插入数据
           $per_exists = $this->Permission->find('all',array('conditions'=>array('Permission.p_uid'=>$this->request->data['Permission']['p_uid']),'fields'=>'Permission.p_id'));
           if(!empty($per_exists))//如果存在
               $this->request->data['Permission']['p_id'] = $per_exists[0]['Permission']['p_id'];
           $msg = $this->_L('set_access_permission_failed');
           if($this->Permission->save($this->request->data)){
               $msg = $this->_L('set_access_permission_success');
               $this->Session->setFlash($msg);
               $this->redirect(array('controller'=>'Users','action'=>'userManage'));
           }
           $this->Session->setFlash($msg);
        }
        $this->set('_position',$this->_L('set_user_access_permission'));
        
         //查找到当前用户的权限节点
           $permission = $this->Permission->find('all',array('conditions'=>array('Permission.p_uid'=>$this->request['named']['uid']),'fields'=>'Permission.p_nav_allows'));
           $permissionArr = array();
           if(!empty($permission[0]['Permission']['p_nav_allows']))
           $permissionArr = explode(',', $permission[0]['Permission']['p_nav_allows']); //用户权限节点数组
           
        //找到用户的用户组
        $UserGid = $this->User->find('all',array('conditions'=>array('User.u_id'=>$this->request['named']['uid']),'fields'=>array('User.u_id','User.u_gid','User.u_true_name')));
      
        $navList = $this->getNavList();
        $newNavList = array();
        
           foreach($navList as $v){
                if(count($permissionArr)){ //如果有权限节点，则约束其权限节点，否则约束用户组权限
                    $v['Navigation']['checked'] = false;
                    if(in_array($UserGid[0]['User']['u_gid'],$v['Navigation']['accessGid'])){
                        if(array_intersect($permissionArr,array(0=>$v['Navigation']['n_id'])))
                         $v['Navigation']['checked'] = true;
                          $newNavList[$v['Navigation']['n_pid']][] = $v['Navigation'];  
                    }
                }else{
                     //根据用户用户组过滤掉用户没有权限访问的导航,此时没有配置用户节点，所以所有项均为选中
                     if(in_array($UserGid[0]['User']['u_gid'],$v['Navigation']['accessGid'])){
                         $v['Navigation']['checked'] = true;
                        $newNavList[$v['Navigation']['n_pid']][] = $v['Navigation'];  
                     }
                     
                }
              }
        $this->set(array('navList'=>$newNavList,'_user'=>$UserGid));
        
    }
 
    //添加编辑用户
    public function userAE() {
        if ($this->request->is('post')) {
//            $this->request->data = $this->User->_daddslashes($this->request->data,true);//该方法自己后加的，主要用来过滤用户输入字符串  @param1 数据  @param2 是否html实体,但经测，cake本身就有此功能
            //判断密码是否相等
            if ($this->request->data['u_password'] != $this->request->data['u_password2']) {
                $this->Session->setFlash($this->_L('password_is_not_matched'));
                $this->redirect('userAE');
            }

            $create_modify = 0; //创建还是修改, 0修改,1创建 
            
            //查找数据库是否存在该用户,如果是修改就不用了
            if (!$this->request->data['u_id']) { //创建用户
                if ($this->User->findAllByUUsername($this->request->data['u_username'])) {
                    $this->Session->setFlash($this->_L('user_is_exsits'));
                    $this->redirect('userAE');
                } elseif ($this->User->findAllByUEmail($this->request->data['u_email'])) {//用户邮箱是否存在
                    $this->Session->setFlash($this->_L('email'). $this->request->data['u_email'] .$this->_L('has_been_register'));
                    $this->redirect('userAE');
                } elseif ($this->User->findAllByUCompanyEmail($this->request->data['u_company_email'])) {//用户邮箱是否存在
                    $this->Session->setFlash($this->_L('email') . $this->request->data['u_company_email'] . $this->_L('has_been_register'));
                    $this->redirect('userAE');
                }
                $create_modify = 1;
            }
 
            //由于前端填写的是M，所以转为字节B
            $this->request->data['u_cabinet_size'] = $this->request->data['u_cabinet_size']*1024*1024;
            if($create_modify){
               $this->request->data['u_free_size'] = $this->request->data['u_cabinet_size'];//初始化剩余文件柜大小 
            }else{ //当修改的时候
               //找出用户当前文件柜大小，找出修改前修改后的对比大小差值
                $curSize = $this->User->find('all',array('conditions'=>array('User.u_id'=>$this->request->data['u_id']),'fields'=>array('User.u_cabinet_size','User.u_free_size')));
                if($curSize[0]['User']['u_cabinet_size'] > $this->request->data['u_cabinet_size']){ //说明大小减小
                      $diff = $curSize[0]['User']['u_cabinet_size'] - $this->request->data['u_cabinet_size'];
                      $this->request->data['u_free_size'] = $curSize[0]['User']['u_free_size'] - $diff;
               
                     }else{ //大小增加
                         $diff = $this->request->data['u_cabinet_size'] - $curSize[0]['User']['u_cabinet_size'] ;
                         $this->request->data['u_free_size'] = $curSize[0]['User']['u_free_size'] + $diff;
               
                    }
            }
            
            //根据用户组拿到用户角色信息 u_role 0普通会员，1管理员，2超级管理员,-1黑名单,-2禁用
            $g_name = $this->Group->find('all',array('conditions'=>array('Group.g_id'=>$this->request->data['u_gid'],'Group.g_status'=>1),'fields'=>'Group.g_name'));
            $g_name = $g_name[0]['Group']['g_name'];
            $preg_super = '/超级管理/';
            $preg_manage = '/管理/';
            if(preg_match($preg,$g_name)){
                $this->request->data['u_role'] = 2;
            }elseif(preg_match($preg_manage,$g_name)){
                $this->request->data['u_role'] = 1;
            }else{
                $this->request->data['u_role'] = 0;
            }
            $this->request->data['u_company_id'] = $this->onLineUser['u_company_id'];//用户所在公司
            if ($this->User->save($this->request->data)) {
                if($create_modify){ //创建用户
                    //同时将用户信息表 oa_user_infos 和 用户权限表 oa_permissions 插入初始数据
                    $uid = $this->User->getInsertID();
                    $data = array(
                      'UserInfos' => array(
                          'u_uid'=>$uid
                      )  
                    );
                    $this->UserInfos->save($data);
                    $data = array(
                      'Permission' => array(
                          'p_uid'=>$uid
                      )  
                    );
                    $this->Permission->save($data);
                    $msg = $this->_L('create_success');
                }else{ //修改用户
                     $msg = $this->_L('modify_success');
                }
                   
                $this->Session->setFlash($msg);
               
                $this->redirect(array(
                            'controller' => 'Users',
                            'action' => 'userManage'
                        ));
            }
           else{
              if($create_modify){
                  $msg = $this->_L('create_failed');
              }else{
                  $msg = $this->_L('modify_failed');  
                }
                
              
               if($this->User->validationErrors['u_password'][0]) $msg .= '<br/>'.$this->User->validationErrors['u_password'][0];
               if($this->User->validationErrors['u_posts_id'][0]) $msg .= '<br/>'.$this->User->validationErrors['u_posts_id'][0];
               if($this->User->validationErrors['u_class_id'][0]) $msg .= '<br/>'.$this->User->validationErrors['u_class_id'][0];
                $this->Session->setFlash($msg);   
            }
            
        }
        //获取函数参数，判断其操作
        $_args = func_get_args();
        $_mpwd = true;//修改密码用
        if ($_args) {
            if ($_args[0] == 'modify')
                $this->set('user', $this->User->findAllByUId($_args[1]));
            $_mpwd = false;
            if($_args[3]){
                $_mpwd = true;
            }
           
        }
         $this->set('_mpwd',$_mpwd);
        //获取部门职位
        $classPosts = $this->ClassPosts->find('all',array('conditions'=>array('ClassPosts.cp_company_id'=>$this->onLineUser['u_company_id'])));;
        
        $_Posts = array();
        foreach($classPosts  as $v){
             if($v['ClassPosts']['cp_type']){
                 $_Posts[$v['ClassPosts']['cp_id']] = $v['ClassPosts']['cp_name'];
             }else{
                 $_Class[$v['ClassPosts']['cp_id']] = $v['ClassPosts']['cp_name'];
             }
         }
        
         $this->set(array('_Class'=>$_Class,'_Posts'=>$_Posts));
         //找到用户组分配过去
         $groups = $this->Group->find('all',array('conditions'=>array('Group.com_id'=>$this->onLineUser['u_company_id'],'Group.g_status'=>1),'fields'=>array('Group.g_id','Group.g_name')));
         $_group = array();
         $preg = '/普通/';
         foreach($groups as $v){
            $_group[$v['Group']['g_id']] = $v['Group']['g_name'] .' ';
            if(preg_match($preg,$v['Group']['g_name'])){
                $this->set('defaule_g_id',$v['Group']['g_id']);
            }
         }
         if(empty($_group)){
             $this->Session->setFlash($this->_L('add_group_first'));
             $this->redirect(array('controller'=>'Users','action'=>'userGroup/add'));
         }
        
         $this->set('_Groups',$_group);
    }

    //用户的开启删除禁用
    public function userOption() {
        $_args = func_get_args();
        $_ok = false; 
       
        if (is_numeric($_args[1])) {
           
            if ($_args[0] == 'close') {
                if ($this->User->save(array('u_id' => $_args[1],'u_is_close' => 1),false))
                    $_ok = true;
                
            }elseif ($_args[0] == 'open') {
                if ($this->User->save(array('u_id' => $_args[1],'u_is_close' => 0),false))
                    $_ok = true;
            }elseif ($_args[0] == 'del') {
                if ($this->User->delete($_args[1]))
                    $_ok = true;
            }
        }
        
        if ($_ok)
            $this->Session->setFlash($this->_L('do_success'));
        else
            $this->Session->setFlash($this->_L('do_failed'));
        $this->redirect($_SERVER['HTTP_REFERER']);
    }
    //通讯薄
    public function addressBook(){
        $onLineUser = $this->Session->read('Auth.User');
        if($this->request->is('post')){
            $this->request->data['AddressBook']['a_uid'] = $onLineUser['u_id'] ;
            $msg = $this->_L('create_failed');
            if($this->request->data['AddressBook']['a_id']) $msg = $this->_L('modify_failed');
            if($this->AddressBook->save($this->request->data)){
                $msg = $this->_L('create_success');
                if($this->request->data['AddressBook']['a_id']) $msg = $this->_L('modify_success');
                $this->Session->setFlash($msg);
                $this->redirect(array('controller'=>'Users','action'=>'addressBook'));
            }else{
                $this->Session->setFlash($msg);  
            }
            
        }
        if(empty($this->request['pass'])){
          //查找通讯薄列表
          $addressBook = $this->AddressBook->find('all',array('conditions'=>array('AddressBook.a_uid'=>$onLineUser['u_id'])));
          $this->set('addressBook',$addressBook);
          $this->set('_position', $this->_L('address_book_users')); //把当前位置分配过去
        }elseif($this->request['pass'][0] == 'edit'){
            $this->set('addressBook',$this->AddressBook->find('all',array('conditions'=>array('AddressBook.a_id'=>$this->request['pass'][1]))));
            $this->set('_position', $this->_L('address_book_edit'));
        }elseif($this->request['pass'][0] == 'add'){
            $this->set('_position', $this->_L('address_book_add')); 
        }elseif($this->request['pass'][0] == 'del'){
            $msg = $this->_L('del_failed');
            if($this->AddressBook->delete($this->request['pass'][1])) $msg = $this->_L('del_success');
            $this->Session->setFlash($msg);
            $this->redirect(array('controller'=>'Users','action'=>'addressBook'));
        }
        
    }
    //用户组
    public function userGroup(){
        if($this->request->is('post')){
            $this->request->data['Group']['com_id'] = $this->onLineUser['u_company_id'];//公司ID
            if(!$this->request->data['Group']['g_id']){ //创建 
            $msg = $this->_L('create_failed');
            if($this->Group->find('all',array('conditions'=>array('Group.g_name'=>$this->request->data['Group']['g_name']),'fields'=>'Group.g_id'))){
                //表明该用户组已经存在，不能再次创建
                $this->Session->setFlash($this->_L('user_group_is_exists'));
                $this->redirect(array('controller'=>'Users','action'=>'userGroup'));
             }
             
             if($this->Group->save($this->request->data))
                $msg = $this->_L('create_success');
            }else{ //修改
                $msg = $this->_L('modify_failed');
                if($this->Group->save($this->request->data))
                $msg = $this->_L('modify_success');
            }
            
                
            $this->Session->setFlash($msg);
        }
        $_args = $this->request['pass'];
        $_create = $_edit = false; //初始化是否创建用户组
        if($_args){
            if($_args[0] == 'add'){
                $_create = true;
            }elseif($_args[0] == 'edit'){
                $this->set('Group',$this->Group->find('all',array('conditions'=>array('Group.g_id'=>$_args[1]))));
            }elseif($_args[0] == 'del'){
                   $msg = $this->_L('del_failed');
                  if($this->Group->delete($_args[1])) $msg = $this->_L('del_success');
                  $this->Session->setFlash($msg);
            }
        }
        if(empty($_args) || $_args[0] == 'del'){
            $this->set('group_list',$this->Group->find('all',array('conditions'=>array('Group.com_id'=>$this->onLineUser['u_company_id']))));
        }else{
            //找到所有导航供配置权限
            
        }
        $this->set('create',$_create);
        $this->set('_position', $this->_L('user_groups')); //把当前位置分配过去
    }
    /*
     * 请假外出申请
     */
    public function leaveApplication(){
        $this->set('_position',$this->_L('my_leave_list'));
        if($this->onLineUser['u_role']>0){
            $this->set('manageButton',true);
        }
        
        if((empty($this->request['pass']) || $this->request['pass'][0] == 'manage') && empty($this->request['named'])){
            //读取我的申请列表
            $conditions = array('LeaveApplications.u_id'=>$this->onLineUser['u_id']);
            if($this->request['pass'][0] == 'manage') $conditions = array();
           
            $this->LeaveApplications->belongsTo = array(
              'User'=>array(
                  'className'=>'User',
                  'foreignKey'=>'u_id',
                  'type'=>'inner',
                  'conditions'=>array('User.u_company_id'=>$this->onLineUser['u_company_id']),
                  'fields'=>'User.u_id'
              )  
            );
            
            $this->Paginator->settings = array(
              'LeaveApplications'  => array(
                  'limit'=>10,
                  'maxLimit'=>10,
                  'order'=>'LeaveApplications.la_id desc',
                  'conditions'=>$conditions
              )
            );
            
            $this->set('leaveList',$this->Paginator->paginate('LeaveApplications'));
            
        }elseif($this->request['pass'][0] == 'add'){
            if($this->request->is('post')){
            $this->request->data['LeaveApplications']['u_id'] = $this->onLineUser['u_id'];
            $this->request->data['LeaveApplications']['la_username'] = $this->onLineUser['u_true_name'];
             $msg = $this->_L('do_failed');
            if($this->LeaveApplications->save($this->request->data)){
                $msg = $this->_L('do_success');
                $this->Session->setFlash($msg);
                $this->redirect(array('controller'=>'Users','action'=>'leaveApplication'));
            }
            $this->Session->setFlash($msg);
            }
            $this->set('_position',$this->_L('add_leave'));
        }elseif($this->request['named']['edit']){
            if($this->request->is('post')){
             $msg = $this->_L('do_failed');
            if($this->LeaveApplications->save($this->request->data)){
                $msg = $this->_L('do_success');
                $this->Session->setFlash($msg);
                $this->redirect(array('controller'=>'Users','action'=>'leaveApplication'));
            }
            $this->Session->setFlash($msg);
            }
            $this->set('leaveInfo',$this->LeaveApplications->find('all',array('conditions'=>array('LeaveApplications.la_id'=>$this->request['named']['edit']))));
            
            $this->set('_position',$this->_L('edit_leave'));
        }elseif($this->request['named']['read']){
            if($this->request->is('post')){
                $msg = $this->_L('reply_failed');
                if($this->LeaveApplications->save($this->request->data)) $msg = $this->_L('reply_success');
                $this->Session->setFlash($msg);
            }
           
            if(!$this->request['named']['laread']){//如果该条申请查看记录还没更新
               if($this->onLineUser['u_role']>0) //更新该申请消息领导已查看
                $this->LeaveApplications->updateAll(array('LeaveApplications.la_read'=>1),array('LeaveApplications.la_id'=>$this->request['named']['read']));  
            }
            $this->set('_position',$this->_L('read_leave'));
            $this->set('readLeave',$this->LeaveApplications->find('all',array('conditions'=>array('LeaveApplications.la_id'=>$this->request['named']['read'])))) ;
            
        }elseif($this->request['named']['agree']){
            
            $msg = $this->_L('do_failed');
            if($this->LeaveApplications->updateAll(array('LeaveApplications.la_agree'=>1),array('LeaveApplications.la_id'=>$this->request['named']['agree']))) $msg = $this->_L('do_success');
            $this->Session->setFlash($msg);
            
            $this->redirect(array('controller'=>'Users','action'=>'leaveApplication'));
        }elseif($this->request['named']['refuse']){
            $msg = $this->_L('do_failed');
            if($this->LeaveApplications->updateAll(array('LeaveApplications.la_agree'=>'-1'),array('LeaveApplications.la_id'=>$this->request['named']['refuse']))) $msg = $this->_L('do_success');
            $this->Session->setFlash($msg);
            $this->redirect(array('controller'=>'Users','action'=>'leaveApplication')); 
        }elseif($this->request['named']['del']){
            $msg = $this->_L('del_failed');
            if($this->LeaveApplications->delete($this->request['named']['del'])) $msg = $this->_L('del_success');
            $this->Session->setFlash($msg);
            $this->redirect(array('controller'=>'Users','action'=>'leaveApplication')); 
        }
        
    }
    /*
     * 日程行程安排
     */
    public function schedule(){
        if($this->request->is('post')){
            $day = $this->request->data['day'];
            $schedule = $this->request->data['schedule'];
            $scheduleInfo = $this->Schedules->find('all',array('conditions'=>array('Schedules.s_uid'=>$this->onLineUser['u_id'],'Schedules.s_year'=>date('Y'),'Schedules.s_month'=>date('m')),'fields'=>'Schedules.s_schedule')); 
            $scheduleInfo = explode('>>>|',$scheduleInfo[0]['Schedules']['s_schedule']); //每天的行程用 >>>| 分开
            
            $str = '';
            //根据当月天数，组合出每日行程
            if(count($scheduleInfo)<2){
                for($i=1;$i<=date('t');$i++){
                   
                    if($i != $day){
                        $str .= ''.'>>>|';
                    }else{
                        $str .= $schedule.'>>>|';
                    }
                }
                
            }else{
                for($i=1;$i<=date('t');$i++){
                    
                    if($i != $day){
                        $str .= $scheduleInfo[$i-1].'>>>|';
                    }else{
                        $str .= $schedule.'>>>|';
                    }
                }
                
            }
            
            if($this->Schedules->updateAll(array('Schedules.s_schedule'=>"'$str'"),array('Schedules.s_uid'=>$this->onLineUser['u_id'],'Schedules.s_year'=>intval(date('Y')),'Schedules.s_month'=>intval(date('m'))))){
               echo 1;  
            }else{
                echo 0; 
            }
               
            exit;
        }
        $this->set('_position',$this->_L('schedule_list'));
        $schedule = $this->Schedules->find('all',array('conditions'=>array('Schedules.s_uid'=>$this->onLineUser['u_id'],'Schedules.s_year'=>date('Y'),'Schedules.s_month'=>date('m')),'fields'=>'Schedules.s_schedule'));
        
        if(empty($schedule)){//如果没有这个月的记录，那么插入这条记录
            $data = array(
              'Schedules'  => array(
                  's_uid'=>intval($this->onLineUser['u_id']),
                  's_year'=>  intval(date('Y')),
                  's_month'=>intval(date('m'))
              )
            );
          
            if($this->Schedules->save($data)){
               $schedule = $this->Schedules->find('all',array('conditions'=>array('Schedules.s_uid'=>$this->onLineUser['u_id'],'Schedules.s_year'=>date('Y'),'Schedules.s_month'=>date('m')),'fields'=>'Schedules.s_schedule')); 
            }
            
        }
        if(empty($schedule[0]['Schedules']['s_schedule'])){ //如果用户还没有生成行程
            $this->set('_schedule',null);
        }
        $schedule = explode('>>>|',$schedule[0]['Schedules']['s_schedule']); //把当月行程分离到$schedule数组
        $this->set('_schedule',$schedule);
    }
    /*
     * 工作日志
     */
    public function workDiary(){
        $this->set('_position',$this->_L('recent_work_diarys'));
        if($this->onLineUser['u_role']>0)
            $this->set('manageButton',true);
        if((empty($this->request['pass']) || $this->request['pass'][0] == 'manage' || $this->request['pass'][0] == 'search') && empty($this->request['named'])){
            $conditions = array('WorkDiarys.u_id'=>$this->onLineUser['u_id']);
            if($this->request['pass'][0] == 'manage'){ //管理工作日志
                $conditions = array();
            }elseif($this->request['pass'][0] == 'search'){ //搜索查询
                $this->set('oa_uid',$this->onLineUser['u_id']);
                if($this->request->data['searchForm']['_searchDate']){ //按日期查询
                    //分离出日，并计算出下一天
                    $date = explode('-',$this->request->data['searchForm']['_searchDate']);
                    $day = intval($date[2])+1;
                    $useDay = strtotime($this->request->data['searchForm']['_searchDate']);
                    $nextDay = strtotime($date[0].'-'.$date[1].'-'.$day);
                    //然后查找时间戳在 $useDay 和 $nextDay 之间的数据
                    $conditions = array('WorkDiarys.u_id'=>$this->onLineUser['u_id'],'WorkDiarys.created > '=>$useDay,'WorkDiarys.created < '=>$nextDay);
                    if($this->onLineUser['u_role']>0) $conditions = array('WorkDiarys.created > '=>$useDay,'WorkDiarys.created < '=>$nextDay);
                }elseif($this->request->data['searchForm']['_searchName']){
                    $this->request->data['searchForm']['_searchName'] = $this->User->_daddslashes($this->request->data['searchForm']['_searchName']);
                    $conditions = array('WorkDiarys.w_username like '=>'%'.$this->request->data['searchForm']['_searchName'].'%');
                }
            }
            
            $this->WorkDiarys->belongsTo = array(
              'User'  =>array(
                  'className'=>'User',
                  'foreignKey'=>'u_id',
                  'conditions'=>array('User.u_company_id'=>$this->onLineUser['u_company_id']),
                  'fields'=>'User.u_id'
              )
            );
            
            $this->Paginator->settings = array(
              'WorkDiarys'  => array(
                  'limit'=>10,
                  'maxLimit'=>10,                 
                  'conditions'=>$conditions,
                  'order' => 'WorkDiarys.w_id desc'
              )
            );
            
            $this->set('WorkDiarys',$this->Paginator->paginate('WorkDiarys'));
        }elseif($this->request['pass'][0] == 'add' || $this->request['named']['edit']){ //添加
            if($this->request->is('post')){
                $this->request->data['WorkDiarys']['u_id'] = $this->onLineUser['u_id'];
                $this->request->data['WorkDiarys']['w_username'] = $this->onLineUser['u_true_name'];
                $msg = $this->request['named']['edit']?$this->_L('modify_failed'):$this->_L('add_failed');
                
                if($this->WorkDiarys->save($this->request->data)){
                    $msg = $this->request['named']['edit']?$this->_L('modify_success'):$this->_L('add_success');
                    $this->Session->setFlash($msg);
                    $this->redirect(array('controller'=>'Users','action'=>'workDiary'));
                }
                $this->Session->setFlash($msg);
               
            }
            $this->set('_position',$this->_L('add_work_diarys'));
            
            if($this->request['named']['edit']){
                $this->set('_position',$this->_L('edit_work_diarys'));
                $this->set('workDiary',$this->WorkDiarys->find('all',array('conditions'=>array('WorkDiarys.w_id'=>$this->request['named']['edit']))));
            }
            
        
            
        }elseif($this->request['named']['read']){//查看
            if($this->request->is('post')){ //领导给予评价
                $this->request->data['WorkDiarys']['w_leader_uid'] = $this->onLineUser['u_id'];
                $msg = $this->_L('appraise_failed');
                if($this->WorkDiarys->save($this->request->data)){
                    $msg = $this->_L('appraise_success');
                    $this->Session->setFlash($msg);
                    $this->redirect(array('controller'=>'Users','action'=>'workDiary/manage'));
                }
                $this->Session->setFlash($msg);
            }
            $this->set('workDiary',$this->WorkDiarys->find('all',array('conditions'=>array('WorkDiarys.w_id'=>$this->request['named']['read']))));
        }elseif($this->request['named']['del']){
                $msg = $this->_L('del_failed');
                if($this->WorkDiarys->delete($this->request['named']['del'])) $msg = $this->_L('del_success');
                 $this->Session->setFlash($msg);
                 $this->redirect($_SERVER['HTTP_REFERER']);
        }
    }
    /*
     * 个人文件柜
     */
    public function fileCabinet(){
        $this->set('_position',$this->_L('file_cabinet_list'));
        if(empty($this->request['pass']) && empty($this->request['named'])){
            $this->Paginator->settings = array(
              'Cabinets'  => array(
                  'limit'=>10,
                  'maxLimit'=>10,
                  'conditions'=>array('Cabinets.c_uid'=>$this->onLineUser['u_id']),
                  'order'=>'Cabinets.c_id desc'
              )
            );
            $this->set('cabinetList',$this->Paginator->paginate('Cabinets'));
        }elseif($this->request['pass'][0] == 'add'){
            
            
            if($this->request->is('post')){
                
                app::uses('upload.Class', 'Lib');
                app::load('upload.Class');

                $this->request->data['Cabinets']['c_uid'] = $this->onLineUser['u_id'];
                $this->request->data['Cabinets']['c_username'] = $this->onLineUser['u_true_name'];
                
                $_file = $this->request->data['Cabinets']['c_file_path'];
                $this->request->data['Cabinets']['c_file_name'] = $this->request->data['Cabinets']['c_file_name']?$this->request->data['Cabinets']['c_file_name']:$_file['name'];;
                $this->request->data['Cabinets']['c_file_size'] = $_file['size'];
                //判断是否用户上传文件大小超过当前用户文件柜剩余空间大小
                
                if($_file['size'] > $this->request->data['Cabinets']['allow_size']){
                    $this->Session->setFlash($this->_L('file_is_too_big'));
                    $this->redirect(array('controller'=>'User','action'=>'fileCabinet/add'));
                }
                $upload = new upLoad(10, Configure::read('UPLOAD_DIR'));
                $this->request->data['Cabinets']['c_file_path'] = str_replace('../webroot', '', $upload->upLoadFile($_file));
                $msg = $this->_L('file_save_failed');
                if($this->Cabinets->save($this->request->data)){
                    //更新用户剩余文件柜空间大小
                    $this->User->updateAll(array('User.u_free_size'=>'User.u_free_size-'.$_file['size']),array('User.u_id'=>$this->onLineUser['u_id']));
                    $msg = $this->_L('file_save_success');
                    $this->Session->setFlash($msg);
                    $this->redirect(array('controller'=>'Users','action'=>'fileCabinet'));
                }
                $this->Session->setFlash($msg); 
            }
            $this->set('_position',$this->_L('add_cabinet'));
            //找到用户是否开启了文件柜,以及文件柜信息
            $this->set('isOpen',$this->User->find('all',array('conditions'=>array('User.u_id'=>$this->onLineUser['u_id']),'fields'=>array('User.u_file_cabinet','User.u_cabinet_size','User.u_free_size'))));
            
            
        }elseif($this->request['named']['down']){ //下载
            //找出文件路径 
            $path = $this->Cabinets->find('all',array('conditions'=>array('Cabinets.c_id'=>$this->request['named']['down']),'fields'=>array('Cabinets.c_file_path','Cabinets.c_file_name')));
            
            $path[0]['Cabinets']['c_file_path'] = '../webroot/'.$path[0]['Cabinets']['c_file_path'];
            header( "Pragma: public" );
            header( "Expires: 0" );
            header( 'Content-Encoding: none' );
            header( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
            header( "Cache-Control: public" );
    
            Header("Content-type: application/octet-stream");
            Header("Accept-Ranges: bytes");
            Header("Accept-Length: ".filesize($path[0]['Cabinets']['c_file_path']));
            Header("Content-Disposition: attachment; filename=" . basename($path[0]['Cabinets']['c_file_path']));
            // 输出文件内容
            readfile($path[0]['Cabinets']['c_file_path']); 
            exit();
        }elseif($this->request['named']['del']) {
            $msg = $this->_L('del_failed');
            //找到文件  删除 释放用户文件柜空间
            $file = $this->Cabinets->find('all',array('conditions'=>array('Cabinets.c_id'=>$this->request['named']['del']),'fields'=>array('Cabinets.c_file_path','Cabinets.c_file_size')));
            
            if($this->Cabinets->delete($this->request['named']['del'])){ //删除文件柜中文件成功
               @unlink('../webroot'.$file[0]['Cabinets']['c_file_path']); 
               $this->User->updateAll(array('User.u_free_size'=>'User.u_free_size+'.$file[0]['Cabinets']['c_file_size']),array('User.u_id'=>$this->onLineUser['u_id']));
               $msg = $this->_L('del_success');
            }
            $this->Session->setFlash($msg);
            $this->redirect(array('controller'=>'Users','action'=>'fileCabinet'));
        }
    }
}

?>
