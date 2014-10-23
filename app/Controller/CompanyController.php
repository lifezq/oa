<?php

/**
 * @filename CompanyController.php
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

class CompanyController extends AppController {
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
    public $uses = array('ClassPosts', 'Company', 'GoodsManages', 'GoodsTypes', 'User', 'GoodsOuts', 'MeetingRooms','Meeting','Sms','SmsRecord');

    public function companyInfo() {
        if ($this->request->data) {
            $msg = $this->_L('put_companyinfo_failed');
            $this->request->data['Company']['com_uid'] = $this->onLineUser['u_id'];
            if ($this->Company->save($this->request->data)) {
                //更新用户所在公司
                $this->User->updateAll(array('User.u_company_id' => $this->Company->getInsertId()), array('User.u_id' => $this->onLineUser['u_id']));
                $msg = $this->_L('put_companyinfo_success');
            }

            $this->Session->setFlash($msg);
        }

        $company = $this->Company->find('all', array('conditions' => array('Company.com_id' => $this->onLineUser['u_company_id'])));
        if ($company)
            $this->set('company', $company[0]['Company']);
    }

    public function classAndPosts() {
        if ($this->request->data['cp_order']) {
            $cp_order_data = array();
            foreach ($this->request->data['cp_order'] as $k => $v) {
                $cp_order_data[$k]['cp_id'] = $k;
                $cp_order_data[$k]['cp_order'] = $v;
            }
            $msg = $this->_L('order_failed');


            if ($this->ClassPosts->saveAll($cp_order_data))
                $msg = $this->_L('order_success');
            $this->Session->setFlash($msg);
        }
        $classPosts = $this->ClassPosts->find('all', array('conditions' => array('ClassPosts.cp_company_id' => $this->onLineUser['u_company_id'])));
        $_Class = array();
        $_Posts = array();
        foreach ($classPosts as $v) {
            if ($v['ClassPosts']['cp_type']) {
                $_Posts[] = $v['ClassPosts'];
            } else {
                $_Class[] = $v['ClassPosts'];
            }
        }
        $this->set(array('_Class' => $_Class, '_Posts' => $_Posts));
    }

    public function createStructure() {
        if ($this->onLineUser['u_company_id'] < 1) { //说明用户还没有创建公司信息
            $this->Session->SetFlash($this->_L('can_not_empty_company_info'));
            $this->redirect(array('controller' => 'Company', 'action' => 'companyInfo'));
        }
        if ($this->request->data) {

            $this->request->data['ClassPosts']['cp_company_id'] = $this->onLineUser['u_company_id'];
            if ($this->ClassPosts->save($this->request->data)) {
                $msg = $this->_L('create_class_success');
                if ($this->request->data['class_posts']['cp_type'])
                    $msg = $this->_L('create_posts_success');
                $this->Session->SetFlash($msg);
                $this->redirect('classAndPosts');
            }else {
                $msg = $this->_L('create_class_failed');
                if ($this->request->data['class_posts']['cp_type'])
                    $msg = $this->_L('create_posts_failed');
            }
            $this->Session->SetFlash($msg);
        }
        $_args = func_get_args();

        if ($_args) {
            if ($_args[0] == 'modify') {
                $classPosts = $this->ClassPosts->findByCpId($_args[1]);
                if ($classPosts['ClassPosts']['cp_type'])
                    $this->set('_Posts', $classPosts['ClassPosts']);
                else
                    $this->set('_Class', $classPosts['ClassPosts']);
            }elseif ($_args[0] == 'del') {
                $msg = $this->_L('del_failed');
                if ($this->ClassPosts->delete($_args[1]))
                    $msg = $this->_L('del_success');
                $this->Session->setFlash($msg);
                $this->redirect('classAndPosts');
            }
        }
        $this->render('classAndPosts');
    }

    /*
     * 公司物品管理
     */

    public function goodsManage() {
        $this->set('_position', $this->_L('goods_manage'));

        if ($this->onLineUser['u_role'] > 0) {
            $this->set('manageButton', true);
        }
        if ($this->request['pass'][0] == 'gid') { //获取选取物品信息
            $goods = $this->GoodsManages->find('all', array('conditions' => array('GoodsManages.gm_id' => $this->request['pass'][1]), 'fields' => array('GoodsManages.gm_price', 'GoodsManages.gm_remain')));
            echo $goods[0]['GoodsManages']['gm_price'] . ',' . $goods[0]['GoodsManages']['gm_remain'];
            exit();
        } elseif ($this->request['pass'][0] == 'getRecord' || $this->request['named']['delRecord'] || $this->request['pass'][0] == 'examine' || $this->request['named']['examine']) {//查找未审核通过的领取并管理是否审核通过
            if ($this->request['named']['examine']) { //操作审核或拒绝
                $msg = $this->_L('do_failed');
                $this->GoodsOuts->hasOne = false;
                if ($this->GoodsOuts->updateAll(array('GoodsOuts.go_type' => $this->request['named']['do']), array('GoodsOuts.go_id' => $this->request['named']['examine']))) {
                    $msg = $this->_L('do_success');
                    if ($this->request['named']['do'] == 1) {//如果通过，则更新库存
                        //更新原物品库存数
                        //找出领取数量 
                        $go_number = $this->GoodsOuts->find('all', array('conditions' => array('GoodsOuts.go_id' => $this->request['named']['examine']), 'fields' => 'GoodsOuts.go_numbers'));

                        $this->GoodsManages->updateAll(array('GoodsManages.gm_remain' => 'GoodsManages.gm_remain-' . $go_number[0]['GoodsOuts']['go_numbers']), array('GoodsManages.gm_id' => $this->request['named']['examine']));
                    }
                }
                $this->Session->setFlash($msg);
                $this->redirect(array('controller' => 'Company', 'action' => 'goodsManage/examine'));
            }
            $this->GoodsOuts->primaryKey = 'go_out_uid';
            $conditions = array('GoodsOuts.com_id' => $this->onLineUser['u_company_id']);
            $this->set('_position', $this->_L('examine_goods_out'));
            if ($this->request['named']['delRecord']) {//删除领取物品记录
                $msg = $this->_L('del_failed');
                $this->GoodsOuts->hasOne = false;
//                if($this->GoodsOuts->updateAll(array('GoodsOuts.go_type'=>'-2'),array('GoodsOuts.go_id'=>$this->request['named']['delRecord']))) $msg = $this->_L('del_success');
                $this->GoodsOuts->primaryKey = 'go_id';
                if ($this->GoodsOuts->delete($this->request['named']['delRecord']))
                    $msg = $this->_L('del_success');
                $this->Session->setFlash($msg);
                $this->redirect(array('controller' => 'Company', 'action' => 'goodsManage/getRecord'));
            }elseif ($this->request['pass'][0] == 'getRecord') {
                $this->set('_position', $this->_L('read_goods_out'));
                $conditions = array('GoodsOuts.go_out_uid' => $this->onLineUser['u_id'], 'GoodsOuts.com_id' => $this->onLineUser['u_company_id']);
            }
            $this->Paginator->settings = array(
                'GoodsOuts' => array(
                    'limit' => 10,
                    'maxLimit' => 10,
                    'conditions' => $conditions,
                    'order' => 'GoodsOuts.go_id desc'
                )
            );
            $this->set('examine', $this->Paginator->paginate('GoodsOuts'));
        } elseif ((empty($this->request['pass']) || $this->request['pass'][0] == 'list') && empty($this->request['named'])) {

            $this->Paginator->settings = array(
                'GoodsManages' => array(
                    'limit' => 10,
                    'maxLimit' => 10,
                    'conditions' => array('GoodsManages.com_id' => $this->onLineUser['u_company_id']),
                    'order' => 'GoodsManages.gm_id desc'
                )
            );
            $this->GoodsManages->primaryKey = 'gt_id';
            $this->set('goodsList', $this->Paginator->paginate('GoodsManages'));
        } elseif ($this->request['pass'][0] == 'add' || $this->request['named']['edit']) {

            $this->set('_position', $this->_L('add_goods_to_warehouse'));
            if ($this->request->is('post')) {
                $msg = $this->_L('do_failed');
                if (empty($this->request['named'])) {
                    $this->request->data['GoodsManages']['gm_uid'] = $this->onLineUser['u_id'];
                    $this->request->data['GoodsManages']['gm_inventory_keeper'] = $this->onLineUser['u_true_name'];
                }
                $this->request->data['GoodsManages']['com_id'] = $this->onLineUser['u_company_id'];
                if ($this->GoodsManages->save($this->request->data)) {
                    $msg = $this->_L('do_success');
                    $this->Session->setFlash($msg);
                    $this->redirect(array('controller' => 'Company', 'action' => 'goodsManage'));
                }
                $this->Session->setFlash($msg);
            }
            //找出物品分类
            $this->set('goodsTypes', $this->GoodsTypes->find('all', array('conditions' => array('GoodsTypes.gt_status' => 1, 'GoodsTypes.com_id' => $this->onLineUser['u_company_id']))));
            if ($this->request['named']['edit']) {
                $this->set('_position', $this->_L('edit_goods_info'));
                $this->set('goods', $this->GoodsManages->find('all', array('conditions' => array('GoodsManages.gm_id' => $this->request['named']['edit']))));
            }
        } elseif ($this->request['named']['del']) {
            $msg = $this->_L('del_failed');
            if ($this->GoodsManages->delete($this->request['named']['del']))
                $msg = $this->_L('del_success');
            $this->Session->setFlash($msg);
            $this->redirect(array('controller' => 'Company', 'action' => 'goodsManage'));
        }elseif ($this->request['named']['get'] || $this->request['pass'][0] == 'get') {//物品出库
            if ($this->request['named']['get']) {//公司物品领取
                if ($this->request->is('post')) {

                    if ($this->request['named']['type']) { //如果有请求参数type ，说明是领取申请
                        $this->request->data['GoodsOuts']['go_type'] = 0;
                    }
                    $this->request->data['GoodsOuts']['go_goods_id'] = $this->request['named']['get'];
                    $this->request->data['GoodsOuts']['go_out_uid'] = $this->onLineUser['u_id'];
                    $this->request->data['GoodsOuts']['com_id'] = $this->onLineUser['u_company_id'];
                    $msg = $this->_L('do_failed');
                    if ($this->GoodsOuts->save($this->request->data)) {

                        $msg = $this->_L('do_success');
                        $this->Session->setFlash($msg);
                        $this->redirect(array('controller' => 'Company', 'action' => 'goodsManage/list'));
                    }
                    $this->Session->setFlash($msg);
                }
                $this->set('_position', $this->_L('get_goods'));
                //找出该物品
                $this->GoodsManages->primaryKey = 'gt_id';

                $this->set('goods', $this->GoodsManages->find('all', array('conditions' => array('GoodsManages.gm_id' => $this->request['named']['get']), 'fields' => array('GoodsManages.gm_goods_name', 'GoodsManages.gm_price', 'GoodsManages.gm_remain', 'GoodsTypes.gt_name'))));
            } else { //公司物品出库
                if ($this->request->is('post')) {
                    $msg = $this->_L('do_failed');
                    $this->request->data['GoodsOuts']['go_out_uid'] = $this->onLineUser['u_id'];
                    $this->request->data['GoodsOuts']['com_id'] = $this->onLineUser['u_company_id'];
                    if ($this->GoodsOuts->save($this->request->data)) {
                        //更新原物品库存数
                        $this->GoodsManages->updateAll(array('GoodsManages.gm_remain' => 'GoodsManages.gm_remain-' . $this->request->data['GoodsOuts']['go_numbers']), array('GoodsManages.gm_id' => $this->request->data['GoodsOuts']['go_goods_id']));
                        $msg = $this->_L('do_success');
                        $this->Session->setFlash($msg);
                        $this->redirect(array('controller' => 'Company', 'action' => 'goodsManage'));
                    }
                    $this->Session->setFlash($msg);
                }
                $this->set('_position', $this->_L('out_goods'));
                //找出所有物品
                $this->set('goodsTypes', $this->GoodsTypes->find('all', array('conditions' => array('GoodsTypes.gt_status' => 1, 'GoodsTypes.com_id' => $this->onLineUser['u_company_id']))));
                //按分类查找出物品

                $conditions = array('GoodsManages.gt_id' => 0, 'GoodsManages.com_id' => $this->onLineUser['u_company_id']);
                if ($this->request['pass'][1])
                    $conditions = array('GoodsManages.gt_id' => $this->request['pass'][1], 'GoodsManages.com_id' => $this->onLineUser['u_company_id']);
                $this->set('goodsList', $this->GoodsManages->find('all', array('conditions' => $conditions, 'fields' => array('GoodsManages.gm_id', 'GoodsManages.gm_goods_name'))));
                //把当前登录用户ID分配过去 
                $this->set('cur_uid', $this->onLineUser['u_id']);
            }
        }elseif ($this->request['pass'][0] == 'type' || $this->request['named']['typeEdit']) { //物品分类
            if ($this->request->is('post')) {
                $msg = $this->request['named']['typeEdit'] ? $this->_L('modify_failed') : $this->_L('add_failed');
                $this->request->data['GoodsTypes']['com_id'] = $this->onLineUser['u_company_id'];
                if ($this->GoodsTypes->save($this->request->data))
                    $msg = $this->request['named']['typeEdit'] ? $this->_L('modify_success') : $this->_L('add_success');
                $this->Session->setFlash($msg);
                $this->redirect(array('controller' => 'Company', 'action' => 'goodsManage/type'));
            }
            if ($this->request['named']['typeEdit']) {
                $this->set('goodsEdit', $this->GoodsTypes->find('all', array('conditions' => array('GoodsTypes.gt_id' => $this->request['named']['typeEdit']))));
            }
            $this->set('GoodsTypes', $this->GoodsTypes->find('all', array('conditions' => array('GoodsTypes.gt_status' => 1, 'GoodsTypes.com_id' => $this->onLineUser['u_company_id']))));
        } elseif ($this->request['named']['typeDel']) { //删除分类
            $msg = $this->_L('del_failed');
            if ($this->GoodsTypes->delete($this->request['named']['typeDel']))
                $msg = $this->_L('del_success');
            $this->Session->setFlash($msg);
            $this->redirect(array('controller' => 'Company', 'action' => 'goodsManage/type'));
        }
    }

    /*
     * 公司会议安排与管理
     */

    public function meeting() {
        
        if(empty($this->request['pass']) && empty($this->request['named'])){
            $this->set('_position', $this->_L('company_meeting_manage'));
            //查找已经安排的会议
            $this->Paginator->settings = array(
              'Meeting'  => array(
                  'limit'=>10,
                  'maxLimit'=>10,
                  'order'=>'Meeting.m_id desc',
                  'conditions'=>array('Meeting.com_id'=>$this->onLineUser['u_company_id'])
              )
            );
            //把当前用户ID分配过去
            $this->set('cur_uid',$this->onLineUser['u_id']);
            
            $this->set('meeting',$this->Paginator->paginate('Meeting'));
            
            }elseif($this->request['named']['del']){ //删除会议
            //查找会议，看看会议时间是否过期
                $meetingTime = $this->Meeting->find('all',array('conditions'=>array('Meeting.m_id'=>$this->request['named']['del'],'Meeting.m_meet_time > '=>time()),'fields'=>'Meeting.m_id'));
                if($meetingTime){ //说明该会议还没过期,也就是还没举行 
                    $msg = $this->_L('meeting_can_not_delete');
                    }else{
                     $msg = $this->_L('del_failed');
                    if($this->Meeting->delete($this->request['named']['del'])) $msg = $this->_L('del_success'); 
                    }
                $this->Session->setFlash($msg);
                $this->redirect(array('controller'=>'Company','action'=>'meeting'));
                
        }elseif($this->request['pass'][0] == 'add' || isset($this->request['named']['edit'])){
            if($this->request->is('post')){
                
                $this->request->data['Meeting']['m_meet_time'] = strtotime($this->request->data['Meeting']['m_meet_time'].' '.$this->request->data['Meeting']['s_hour'].':'.$this->request->data['Meeting']['s_minute']);
                //判断会议开始时间是否在预约时间内
                $rightTime = $this->MeetingRooms->find('all',array('conditions'=>array('MeetingRooms.u_order_time <= '=>$this->request->data['Meeting']['m_meet_time'],'MeetingRooms.u_order_end_time > '=>$this->request->data['Meeting']['m_meet_time']),'fields'=>'MeetingRooms.mr_id'));
                if(empty($rightTime)){ 
                    $this->Session->setFlash($this->_L('meeting_time_is_wrong'));
                    $this->redirect(array('controller'=>'Company','action'=>'meeting/add'));
                }
                
                if($this->request->data['Meeting']['notice_type'] == 1){ //说明通知为部门
                    $this->request->data['Meeting']['m_join_uids'] = '';
                    $this->request->data['Meeting']['m_class_id'] = $this->request->data['Meeting']['final_choice'];
                }else{//通知为个人
                    $this->request->data['Meeting']['m_class_id'] = '';
                    $this->request->data['Meeting']['m_join_uids'] = $this->request->data['Meeting']['final_choice'];
                }
                unset($this->request->data['Meeting']['s_hour']);
                unset($this->request->data['Meeting']['s_minute']);
                unset($this->request->data['Meeting']['notice_type']);
                unset($this->request->data['Meeting']['final_choice']);
                $this->request->data['Meeting']['u_id'] = $this->onLineUser['u_id'];
                $this->request->data['Meeting']['com_id'] = $this->onLineUser['u_company_id'];
                
                $msg = $this->_L('meeting_add_failed');
                
                if($this->Meeting->save($this->request->data)){
                    //读到会议室名称
                    $meetRoom = $this->MeetingRooms->find('all',array('conditions'=>array('MeetingRooms.mr_id'=>$this->request->data['Meeting']['mr_id']),'fields'=>array('MeetingRooms.mr_room')));
                    $meetingSubject = $this->request->data['Meeting']['m_subject'];
                    $m_meet_time = $this->request->data['Meeting']['m_meet_time'];
                    
                    //会议发布成功后，开始发短消息通知
                    if($this->request->data['Meeting']['m_class_id']){ //通知部门
                        //找到该部门所有职员
                        $staffArr = $this->User->find('all',array('conditions'=>'User.u_class_id in ('.$this->request->data['Meeting']['m_class_id'].') and User.u_company_id='.$this->onLineUser['u_company_id'],'fields'=>array('User.u_id','User.u_true_name')));  
                        
                    }else{ //通知个人
                        $staffArr = $this->User->find('all',array('conditions'=>'User.u_id in ('.$this->request->data['Meeting']['m_join_uids'].') and User.u_company_id='.$this->onLineUser['u_company_id'],'fields'=>array('User.u_id','User.u_true_name')));  
                    }
                    unset($this->request->data);//卸载掉DATA
                        $receiveUsers = '';
                        
                        foreach($staffArr as $v){
                            if($v['User']['u_true_name'])
                            $receiveUsers .= $v['User']['u_true_name'].',';
                        }
                            $receiveUsers = rtrim($receiveUsers, ',');
                            $data = array(
                              'Sms'  =>array(
                                  's_receivers'=>$receiveUsers,
                                  's_from_uid'=>$this->onLineUser['u_id'],
                                  's_message'=>$this->onLineUser['u_true_name'].'在会议室《'.$meetRoom[0]['MeetingRooms']['mr_room']."》主持了会议，会议主题为《".$meetingSubject."》,会议开始时间:".date('Y/m/d H:i:s',$m_meet_time)."。希望大家准时参加。谢谢!",
                                  's_from_user'=>$this->onLineUser['u_true_name']
                              )
                            );
                            
                    if($this->Sms->save($data)){ //保存消息,发送通知
                           $SmsId = $this->Sms->getInsertID();
                                //通知消息接收人
                           $data_detail = array();
                            foreach($staffArr as $v){
                            $data_detail[]['SmsRecord'] = array(
                                'sr_uid' =>$v['User']['u_id'],
                                'sr_unread_sms_id' => $SmsId,
                                'sr_status'=>0,
                                'sr_hide' =>0
                            );
                        } 
                               $this->SmsRecord->saveMany($data_detail);
                            }
                   $msg = $this->_L('meeting_add_success'); 
                   $this->Session->setFlash($msg);
                   $this->redirect(array('controller'=>'Company','action'=>'meeting'));
                }
                $this->Session->setFlash($msg);
            }
            
            //发送SQL语句 时时更新预约过期的会议室
            $sql = 'update oa_meeting_rooms set mr_status=1 where mr_id in (select temp.mr_id  from (select m.mr_id from oa_meeting_rooms as m where m.u_order_end_time < ' . time() . ' and m.mr_status=0 ) temp )';
            $this->MeetingRooms->query($sql);
            
            if($this->request['named']['edit']){//编辑会议
                //查找到该会议信息
                $meeting = $this->Meeting->find('all',array('conditions'=>array('Meeting.m_id'=>$this->request['named']['edit'])));
                if(empty($meeting[0]['Meeting']['m_class_id'])){//通知类型为个人
                    //找到用户
                    $user = $this->User->find('all',array('conditions'=>"User.u_id in (".$meeting[0]['Meeting']['m_join_uids'].")",'fields'=>array('User.u_true_name')));
                    $Str = '';
                    foreach($user as $v){
                       $Str .= $v['User'] ['u_true_name'].';';
                    }
                    $Str = trim($Str,';');
                }else{
                    //找到部门
                    
                    $class = $this->ClassPosts->find('all',array('conditions'=>"ClassPosts.cp_id in (".$meeting[0]['Meeting']['m_class_id'].")",'fields'=>array('ClassPosts.cp_name')));
                    $Str = '';
                    foreach($class as $v){
                        $Str .= $v['ClassPosts']['cp_name'].';';
                    }
                    $Str = trim($Str,';');
                }
                
                $this->set('_str',$Str);
                $this->set('meeting',$meeting);
                $this->set('_position', $this->_L('company_meeting_edit'));
            }else{
                $this->set('_position', $this->_L('company_meeting_add'));
            }
             //查找到已预约的会议室
                $this->set('meetingRoom',$this->MeetingRooms->find('all',array('conditions'=>array('MeetingRooms.mr_status'=>0,'MeetingRooms.com_id'=>$this->onLineUser['u_company_id'],'MeetingRooms.u_id'=>$this->onLineUser['u_id']),'fields'=>array('MeetingRooms.mr_id','MeetingRooms.mr_room','MeetingRooms.u_order_time','MeetingRooms.u_order_end_time','MeetingRooms.mr_person_num'))));
           
             //找到部门
            $this->set('_class',$this->ClassPosts->find('all',array('conditions'=>array('ClassPosts.cp_type'=>0,'ClassPosts.cp_company_id'=>$this->onLineUser['u_company_id']),'fields'=>array('ClassPosts.cp_id','ClassPosts.cp_name'))));

            //找到公司所有职员
            $this->set('_users',$this->User->find('all',array('conditions'=>array('User.u_company_id'=>$this->onLineUser['u_company_id']),'fields'=>array('User.u_id','User.u_true_name'))));
            
          
        }elseif($this->request['named']['orderTime']){ //查找会议预约时间
            $orderTime = $this->MeetingRooms->find('all',array('conditions'=>array('MeetingRooms.mr_id'=>$this->request['named']['orderTime']),'fields'=>array('MeetingRooms.u_order_time','MeetingRooms.u_order_end_time','MeetingRooms.mr_person_num')));
            echo date('Y/m/d H:i',$orderTime[0]['MeetingRooms']['u_order_time']).'-'.date('Y/m/d H:i',$orderTime[0]['MeetingRooms']['u_order_end_time']).'-'.$orderTime[0]['MeetingRooms']['mr_person_num'];
            exit();
        }
    }

    /*
     * 会议室管理
     */

    public function meetingRoom() {
        $this->set('_position', $this->_L('company_meeting_room'));
        if (empty($this->request['pass']) && empty($this->request['named'])) {
            $this->Paginator->settings = array(
                'MeetingRooms' => array(
                    'limit' => 10,
                    'maxLimit' => 10,
                    'conditions' => array('MeetingRooms.com_id' => $this->onLineUser['u_company_id']),
                    'order' => 'MeetingRooms.mr_id desc '
                )
            );
            $this->MeetingRooms->hasOne = array(
                'User' => array(
                    'className' => 'User',
                    'foreignKey' => 'u_id',
                    'type' => 'left',
                    'fields' => 'User.u_true_name'
                )
            );
            $this->MeetingRooms->primaryKey = 'u_id';
            $this->set('meetingRoom', $this->Paginator->paginate('MeetingRooms'));
        } elseif ($this->request['pass'][0] == 'add' || $this->request['named']['edit']) {
            if ($this->request->is('post')) {
                $this->request->data['MeetingRooms']['com_id'] = $this->onLineUser['u_company_id'];
                $msg = $this->request['named']['edit'] ? $this->_L('modify_failed') : $this->_L('add_failed');
                if ($this->MeetingRooms->save($this->request->data)) {
                    $msg = $this->request['named']['edit'] ? $this->_L('modify_success') : $this->_L('add_success');
                    $this->Session->setFlash($msg);
                    $this->redirect(array('controller' => 'Company', 'action' => 'meetingRoom'));
                }
                $this->Session->setFlash($msg);
            }
            $this->set('_position', $this->_L('add_meeting_room'));
            if ($this->request['named']['edit']) {
                $this->set('_position', $this->_L('edit_meeting_room'));
                $this->set('meetingR', $this->MeetingRooms->find('all', array('conditions' => array('MeetingRooms.mr_id' => $this->request['named']['edit']))));
            }
        } elseif (isset($this->request['named']['room'])) {
            $this->MeetingRooms->updateAll(array('MeetingRooms.mr_clean' => $this->request['named']['clean']), array('MeetingRooms.mr_id' => $this->request['named']['room']));
            $this->Session->setFlash($this->_L('do_success'));
            $this->redirect(array('controller' => 'Company', 'action' => 'meetingRoom'));
        } elseif ($this->request['pass'][0] == 'orderAdd' || $this->request['named']['orderEdit']) { //会议室预约
            if ($this->request->is('post')) {
                $this->request->data['MeetingRooms']['u_order_time'] = strtotime($this->request->data['MeetingRooms']['u_order_time'] . ' ' . $this->request->data['MeetingRooms']['s_hour'] . ':' . $this->request->data['MeetingRooms']['s_minute']);
                $this->request->data['MeetingRooms']['u_order_end_time'] = strtotime($this->request->data['MeetingRooms']['u_order_end_time'] . ' ' . $this->request->data['MeetingRooms']['e_hour'] . ':' . $this->request->data['MeetingRooms']['e_minute']);
                if ($this->request->data['MeetingRooms']['u_order_time'] >= $this->request->data['MeetingRooms']['u_order_end_time']) {
                    //预约结束时间小于开始时间
                    $this->Session->setFlash($this->_L('order_time_is_wrong'));
                    $this->redirect($_SERVER['HTTP_REFERER']);
                }
                unset($this->request->data['MeetingRooms']['s_hour']);
                unset($this->request->data['MeetingRooms']['s_minute']);
                unset($this->request->data['MeetingRooms']['e_hour']);
                unset($this->request->data['MeetingRooms']['e_minute']);
                $this->request->data['MeetingRooms']['u_id'] = $this->onLineUser['u_id'];
                $this->request->data['MeetingRooms']['mr_status'] = 0; //将会议室状态更新为已预约
                $msg = $this->_L('meeting_room_order_failed');
                if ($this->MeetingRooms->save($this->request->data)) {
                    $msg = $this->_L('meeting_room_order_success');
                    $this->Session->setFlash($msg);
                    $this->redirect(array('controller' => 'Company', 'action' => 'meetingRoom/orderMine'));
                }
                $this->Session->setFlash($msg);
            }


            if ($this->request['named']['orderEdit']) {
                $this->set('_position', $this->_L('meeting_order_edit'));
                $this->set('orderRoom', $this->MeetingRooms->find('all', array('conditions' => array('MeetingRooms.mr_id' => $this->request['named']['orderEdit']), 'fields' => array('MeetingRooms.mr_room', 'MeetingRooms.mr_id'))));
            } else {
                $this->set('_position', $this->_L('meeting_order_add'));
                //找出没有预约以及可预约的会议室
                $rooms = $this->MeetingRooms->find('all', array('conditions' => array('MeetingRooms.mr_status' => 1, 'MeetingRooms.com_id' => $this->onLineUser['u_company_id']), 'fields' => array('MeetingRooms.mr_id', 'MeetingRooms.mr_room')));
                if (count($rooms) < 1) { // 没有可预约 的会议室
                    $this->Session->setFlash($this->_L('会议室爆满啦，没有可预约的会议室'));
                    $this->redirect(array('controller' => 'Company', 'action' => 'meetingRoom/order'));
                }
                $this->set('rooms', $rooms);
            }
        } elseif ($this->request['pass'][0] == 'order' || $this->request['pass'][0] == 'orderMine') { //会议室预约列表
            $this->set('_position', $this->_L('meeting_order_list'));
            $conditions = array('MeetingRooms.mr_status' => 0, 'MeetingRooms.com_id' => $this->onLineUser['u_company_id']);
            if ($this->request['pass'][0] == 'orderMine') {
                $this->set('_position', $this->_L('meeting_order_of_mine'));
                $conditions = array('MeetingRooms.mr_status' => 0, 'MeetingRooms.com_id' => $this->onLineUser['u_company_id'], 'MeetingRooms.u_id' => $this->onLineUser['u_id']);
            }
            $this->Paginator->settings = array(
                'MeetingRooms' =>
                array(
                    'limit' => 10,
                    'maxLimit' => 10,
                    'conditions' => $conditions
                )
            );
            $this->MeetingRooms->hasOne = array(
                'User' => array(
                    'className' => 'User',
                    'foreignKey' => 'u_id',
                    'type' => 'inner',
                    'fields' => 'User.u_true_name'
                )
            );


            //发送SQL语句 时时更新预约过期的会议室
            $sql = 'update oa_meeting_rooms set mr_status=1 where mr_id in (select temp.mr_id  from (select m.mr_id from oa_meeting_rooms as m where m.u_order_end_time < ' . time() . ' and m.mr_status=0 ) temp )';
            $this->MeetingRooms->query($sql);
            $this->MeetingRooms->primaryKey = 'u_id';
            $this->set('meetingR', $this->Paginator->paginate('MeetingRooms'));
        } elseif ($this->request['named']['cancelOrder']) {
            $msg = $this->_L('do_failed');
            if ($this->MeetingRooms->updateAll(array('MeetingRooms.mr_status' => 1), array('MeetingRooms.mr_id' => $this->request['named']['cancelOrder'])))
                $msg = $this->_L('do_success');
            $this->Session->setFlash($msg);
            $this->redirect(array('controller' => 'Company', 'action' => 'meetingRoom/orderMine'));
        }
    }

}

?>
