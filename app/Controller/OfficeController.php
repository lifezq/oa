<?php

/**
 * @filename OfficeController.php
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-8-29  14:26:17
 * @version 1.0
 * Description of OfficeController
 */
app::uses('AppController', 'Controller');

class OfficeController extends AppController {

    public $uses = array('Sms', 'User', 'SmsRecord', 'ClassPosts', 'Announcement', 'ClassAnnouncements', 'UserAnnouncements');

    /*
     * 短消息
     */

    public function sms() {
        $onLineUser = $this->onLineUser;
        if ($this->request->is('post')) {
            if ($this->request['named']['read']) {//回复消息
                //找到原消息信息
                $sms_info = $this->Sms->find('all', array('conditions' => array('Sms.s_id' => $this->request->data['Sms']['s_pid']), 'fields' => array('Sms.s_from_uid', 'Sms.s_from_user', 'Sms.s_receivers')));
                $this->request->data['Sms']['s_receivers'] = $sms_info[0]['Sms']['s_receivers'];
                $this->request->data['Sms']['s_from_uid'] = $this->onLineUser['u_id'];
                $this->request->data['Sms']['s_from_user'] = $this->onLineUser['u_true_name'];
                $msg = $this->_L('reply_failed');


                $this->request->data['Sms']['s_message'] = "@" . $sms_info[0]['Sms']['s_from_user'] . ":" . $this->request->data['Sms']['s_message'];

                if ($this->Sms->save($this->request->data)) {
//                    $SmsId = $this->Sms->getInsertID();
                    $SmsId = $this->request['named']['read'];//因为是回复，所以这里插入顶级消息ID，以便查看回复
                    //更新原消息回复数
                    $this->Sms->updateAll(array('Sms.s_reply_num' => 'Sms.s_reply_num+1'), array('Sms.s_id' => $this->request['named']['read']));
                    //通知接收回复的人
                    unset($this->request->data);
                    $data = array(
                        'sr_uid' => $sms_info[0]['Sms']['s_from_uid'],
                        'sr_unread_sms_id' => $SmsId,
                        'sr_status' => 0,
                        'sr_type' => 1,
                        'sr_hide' => 0,
                    );
                    $this->SmsRecord->save($data);


                    $msg = $this->_L('reply_success');
                }
                $this->redirect(array('controller' => 'Office', 'action' => 'sms/read:' . $this->request['named']['read']));
            }

            $this->request->data['Sms']['s_from_uid'] = $onLineUser['u_id'];
            $this->request->data['Sms']['s_from_user'] = $onLineUser['u_true_name'];
            $msg = $this->_L('send_failed');
            //重新组装接收人，并插入到 sms_record 消息记录表
            $receiver = explode(';', $this->request->data['Sms']['s_receivers']);
            $receiver_uid = array();
            $receiver_user = '';
            foreach ($receiver as $v) {
                $temp = explode(':', $v);
                $receiver_uid[] = $temp[0];
                $receiver_user .= $temp[1] . ',';
            }
            $receiver_user = rtrim($receiver_user, ',');
            $this->request->data['Sms']['s_receivers'] = $receiver_user;
            if ($this->Sms->save($this->request->data)) {
                $_insertId = $this->Sms->getInsertID();
                //将消息按接收人依次插入到消息记录表 sms_record 
                foreach ($receiver_uid as $m) {
                    $this->request->data['sr_uid'] = $m;
                    $this->request->data['sr_unread_sms_id'] = $_insertId;
                    $this->SmsRecord->save($this->request->data);
                }

                $msg = $this->_L('send_success');
                $this->Session->setFlash($msg);
                $this->redirect(array('controller' => 'Office', 'action' => 'sms'));
            }
            $this->Session->setFlash($msg);
        }
        if ((empty($this->request['pass']) || $this->request['pass'][0] == 'read') && empty($this->request['named'])) {
            //如果用户有请求阅读未读消息时，更新消息记录表状态为已读
            if ($this->request['pass'][0] == 'read')
                $this->SmsRecord->updateAll(array('SmsRecord.sr_status' => 1), array('SmsRecord.sr_uid' => $onLineUser['u_id'], 'SmsRecord.sr_hide' => 0, 'SmsRecord.sr_type' => 0, 'SmsRecord.sr_status' => 0));
            //找出我的短消息，并且该条信息用户未删除记录 的已读消息
            $sms = $this->SmsRecord->find('all', array('conditions' => array('SmsRecord.sr_uid' => $onLineUser['u_id'], 'SmsRecord.sr_hide' => 0, 'SmsRecord.sr_type' => 0, 'SmsRecord.sr_status' => 1), 'fields' => array('sr_unread_sms_id', 'sr_status')));
            //统计我未读的新消息
            $unReadSms = $this->SmsRecord->find('count', array('conditions' => array('SmsRecord.sr_uid' => $onLineUser['u_id'], 'SmsRecord.sr_hide' => 0, 'SmsRecord.sr_status' => 0, 'SmsRecord.sr_type' => 0), 'fields' => array('SmsRecord.sr_status')));
            //统计我未读的新回复
            $unReadReplySms = $this->SmsRecord->find('count', array('conditions' => array('SmsRecord.sr_uid' => $onLineUser['u_id'], 'SmsRecord.sr_hide' => 0, 'SmsRecord.sr_status' => 0, 'SmsRecord.sr_type' => 1), 'fields' => array('SmsRecord.sr_status')));

            $s_id = '';
            foreach ($sms as $v) {
                $s_id .= $v['SmsRecord']['sr_unread_sms_id'] . ',';
            }
            $s_id = rtrim($s_id, ',');
            //找出相应消息信息 
            $sqlWhere = $s_id ? 'Sms.s_id in (' . $s_id . ') ' : ' Sms.s_id=0 ';
            $this->Paginator->settings = array(
                'Sms' => array(
                    'limit' => 10,
                    'maxLimit' => 10,
                    'conditions' => $sqlWhere,
                    'order' => 'Sms.s_id desc'
                )
            );
            $this->set('smsInfo', $this->Paginator->paginate('Sms'));
            $this->set(array('unReadReplySms' => $unReadReplySms, 'unReadSms' => $unReadSms));
            $this->set('_position', $this->_L('sms_list'));
        } elseif ($this->request['named']['read']) {
            //更新该消息的所有回复为已读 
            $conditions = array('SmsRecord.sr_uid' => $onLineUser['u_id'], 'SmsRecord.sr_unread_sms_id' => $this->request['named']['read'], 'SmsRecord.sr_hide' => 0,'SmsRecord.sr_type' => 0,'SmsRecord.sr_status' => 0);
            if($this->request['named']['readReply']) //当查看回复时，更新回复
                $conditions = array('SmsRecord.sr_uid' => $onLineUser['u_id'], 'SmsRecord.sr_unread_sms_id' => $this->request['named']['read'], 'SmsRecord.sr_hide' => 0,'SmsRecord.sr_type' => 1,'SmsRecord.sr_status' => 0);
            $this->SmsRecord->updateAll(array('SmsRecord.sr_status' => 1), $conditions);
            $this->set('_position', $this->_L('read_sms'));
            $Sms = $this->Sms->find('all', array('conditions' => array('Sms.s_id' => $this->request['named']['read']), 'fields' => array('Sms.s_id', 'Sms.s_from_uid', 'Sms.s_from_user', 'Sms.created', 'Sms.s_message')));
            $this->set('Sms', $Sms);
            //找到该消息的回复
            $SmsReply = $this->getChildComment($this->request['named']['read']);
            //$this->Sms->find('all',array('conditions'=>array('Sms.s_pid'=>$this->request['named']['read']),'fields'=>array('Sms.s_id','Sms.s_from_uid','Sms.s_from_user','Sms.created','Sms.s_message')));
            /*//如果消息没有回复，那么判断消息发送人和当前查看是否同一人，如果同一人，那么就不用显示回复
            $replyBox = true;
            if (empty($SmsReply) && $Sms[0]['Sms']['s_from_uid'] == $this->onLineUser['u_id'])
                $replyBox = false;

            $this->set('replyBox', $replyBox);
*/
            $this->set('SmsReply', $SmsReply);


            $this->set('cur_uid', $this->onLineUser['u_id']);
        }elseif ($this->request['pass'][0] == 'del') {
            $msg = $this->_L('del_failed');
            if ($this->SmsRecord->updateAll(array('SmsRecord.sr_hide' => 1), array("SmsRecord.sr_uid" => $onLineUser['u_id'])))
                $msg = $this->_L('del_success');
            $this->Session->setFlash($msg);
            $this->redirect(array('controller' => 'Office', 'action' => 'sms'));
        }elseif ($this->request['pass'][0] == 'sent') {
            //找出我发出的消息 

            $this->Paginator->settings = array(
                'limit' => 10,
                'maxLimit' => 10,
                'order' => 'Sms.s_id desc',
                'conditions' => array('Sms.s_from_uid' => $onLineUser['u_id'], 'Sms.s_pid' => 0)
            );
            $sent = $this->Paginator->paginate('Sms');

            $this->set('smsInfo', $sent);
            $this->set('_position', $this->_L('sent_sms_list'));
        } elseif ($this->request['pass'][0] == 'add') { // 发送新消息
            $CompanyU = $this->User->find('all', array('conditions' => 'User.u_is_close=0 and User.u_id!=' . $onLineUser['u_id'] . ' and User.u_company_id=' . $this->onLineUser['u_company_id'], 'fields' => array('User.u_true_name', 'User.u_id')));

            $UserLink = '';
            foreach ($CompanyU as $v) {
                $UserLink .= "<a href='javascript:void(0);' onClick=companyUserEmail('" . $v['User']['u_id'] . ':' . $v['User']['u_true_name'] . "')>" . $v['User']['u_true_name'] . "</a>&nbsp;&nbsp;";
            }
            $this->set('UserLink', $UserLink);
            $this->set('_position', $this->_L('sent_sms'));
        } elseif ($this->request['pass'][0] == 'reply') { // 查看回复消息列表
            //找到用户收到的最新回复
            $sms = $this->SmsRecord->find('all', array('conditions' => array('SmsRecord.sr_type' => 1, 'SmsRecord.sr_status' => 0, 'SmsRecord.sr_uid' => $this->onLineUser['u_id']), 'fields' => 'SmsRecord.sr_unread_sms_id'));

            $smsId = array();


            $smsId = $this->getCommentTopId($sms);

            $sms_id = '';
            //循环顶级ID
            foreach ($smsId as $k => $v) {
                $sms_id .= $v . ',';
            }

           
            $sms_id = rtrim($sms_id, ',');

                   $sms_id = !empty($sms_id)?$sms_id:0;
                   $this->set('smsInfo',$this->Sms->find('all',array('conditions'=>'Sms.s_id in ('.$sms_id.')')));
                   $this->set('_position',$this->_L('new_reply_list'));
        }
    }

    //获得顶级ID
    function getCommentTopId($sid) {
        static $_pid = array();

        foreach ($sid as $v) {
            //查找当前消息的上级ID
            $pid = $this->Sms->find('all', array('conditions' => array('Sms.s_id' => $v['SmsRecord']['sr_unread_sms_id']), 'fields' => 'Sms.s_pid'));

            if (!empty($pid)) {
                if ($pid[0]['Sms']['s_pid'] == 0) {
                    $_pid[$v['SmsRecord']['sr_unread_sms_id']] = $v['SmsRecord']['sr_unread_sms_id'];
                } else {
                    $m[]['SmsRecord']['sr_unread_sms_id'] = $pid[0]['Sms']['s_pid'];
                    $this->getCommentTopId($m);
                }
            }
        }

        return $_pid;
    }

    //获得评论
    function getComment($sid) {
        static $_sms = array();
        $_sms = $this->Sms->find('all', array('conditions' => array('Sms.s_id' => $sid), 'fields' => array('Sms.s_id', 'Sms.s_from_uid', 'Sms.s_from_user', 'Sms.created', 'Sms.s_message')));
        $this->getChildComment($sid);
    }

    //获得子级评论
    function getChildComment($pid, $level = 0) {
        static $_sms = array();
        $Sms = $this->Sms->find('all', array('conditions' => array('Sms.s_pid' => $pid), 'fields' => array('Sms.s_id', 'Sms.s_from_uid', 'Sms.s_from_user', 'Sms.created', 'Sms.s_message')));


        if (!empty($Sms)) {
            $level++;
            foreach ($Sms as $v) {
                $v['Sms']['level'] = $level;
                $_sms[] = $v;
                $this->getChildComment($v['Sms']['s_id'], $level);
            }
        }
        return $_sms;
    }

    /*
     * 公告通知
     */

    public function announcement() {
        $onLineUser = $this->Session->read('Auth.User');
        if ($this->request->is('post')) {
            $this->request->data['Announcement']['a_uid'] = $onLineUser['u_id'];
            $this->request->data['Announcement']['a_author'] = $onLineUser['u_true_name'];
            $msg = $this->request['named']['edit'] ? $this->_L('modify_failed') : $this->_L('release_failed');
            $class_id = $this->request->data['ClassAnnouncements']['cp_id'];
            if (empty($class_id)) {//如果没有选择公告接收部门，则返回
                $this->Session->setFlash($this->_L('release_failed') . '<br/>' . $this->_L('class_id_is_empty'));
                $this->redirect(array('controller' => 'Office', 'action' => 'announcement/add'));
            }
            unset($this->request->data['ClassAnnouncements']);
            $this->request->data['Announcement']['a_company_id'] = $this->onLineUser['u_company_id'];
            if ($this->Announcement->save($this->request->data['Announcement'])) {
                unset($this->request->data['Announcement']);
                $classIdArr = array();
                if (!$this->request['named']['edit']) {
                    $a_id = $this->Announcement->getInsertId();
                } else {//修改公告
                    $a_id = $this->request['named']['edit'];
                    //修改公告时先删除表ClassAnnouncements 里面关于 $a_id 的记录 ,然后在后面重新插入
                    $this->ClassAnnouncements->primaryKey = 'a_id';
                    $this->ClassAnnouncements->deleteAll(array("ClassAnnouncements.a_id" => $a_id));
                }
                foreach ($class_id as $k => $v) {
                    //ClassAnnouncements
                    $this->request->data[$k]['ClassAnnouncements']['cp_id'] = $v;
                    $this->request->data[$k]['ClassAnnouncements']['a_id'] = $a_id;
                }
                //保存部门公告
                $this->ClassAnnouncements->primaryKey = false;
                if ($this->ClassAnnouncements->saveMany($this->request->data)) {

                    $msg = $this->request['named']['edit'] ? $this->_L('modify_success') : $this->_L('release_success');
                    $this->Session->setFlash($msg);
                    $this->redirect(array('controller' => 'Office', 'action' => 'announcement/sent'));
                }
                if (!$this->request['named']['edit'])  //如果是修改就不用删除
                    $this->Announcement->delete($a_id);

                $this->Session->setFlash($msg);
            }else {

                if ($this->Announcement->validationErrors['a_content'])
                    $msg .= '<br/>' . $this->Announcement->validationErrors['a_content'][0];
                $this->Session->setFlash($msg);
            }
            unset($this->request->data);
        }

        if ((empty($this->request['pass']) && empty($this->request['named'])) || $this->request['pass'][0] == 'sent') {
            $this->set('_position', $this->_L('received_announcement'));

            if ($this->request['pass'][0] != 'sent') {
                //找出用户删除的公告记录
                $del_ann = $this->UserAnnouncements->find('all', array('conditions' => array('UserAnnouncements.u_id' => $onLineUser['u_id'], 'UserAnnouncements.hide' => 1), 'fields' => 'UserAnnouncements.a_id'));
                $del_ann_ids = '';
                foreach ($del_ann as $v) {
                    $del_ann_ids .= $v['UserAnnouncements']['a_id'] . ',';
                }
                $del_ann_ids = rtrim($del_ann_ids, ',');
                $conditions = array('ClassAnnouncements.cp_id' => $onLineUser['u_class_id']);
                //找出用户所在部门是否有新公告  
                if($del_ann_ids) $conditions = array('ClassAnnouncements.cp_id' => $onLineUser['u_class_id'], "ClassAnnouncements.a_id not in ($del_ann_ids)");
                $ann_id = $this->ClassAnnouncements->find('all', array('conditions' =>$conditions , 'fields' => 'ClassAnnouncements.a_id'));
                $ann_ids = '';
                foreach ($ann_id as $v) {
                    $ann_ids .= $v['ClassAnnouncements']['a_id'] . ',';
                }
                $ann_ids = rtrim($ann_ids, ',');
                $conditions = ' Announcement.a_company_id=' . $this->onLineUser['u_company_id'] . '';
                if($ann_ids)
                $conditions = 'Announcement.a_id in (' . $ann_ids . ') and Announcement.a_company_id=' . $this->onLineUser['u_company_id'] . '';
            } elseif ($this->request['pass'][0] == 'sent') { //我发出的公告
                $conditions = array('Announcement.a_uid' => $onLineUser['u_id'], 'Announcement.a_company_id' => $this->onLineUser['u_company_id']);
                $this->set('_position', $this->_L('sent_announcement'));
            }



            //找出具体公告信息
            $this->Paginator->settings = array(
                'Announcement' => array(
                    'limit' => '10',
                    'conditions' => $conditions,
                    'order' => 'Announcement.a_id desc',
                    'maxLimit' => 10)
            );
            $announcement = $this->Paginator->paginate('Announcement');

            foreach ($announcement as $k => $v) {
                $announcement[$k]['Announcement']['cp_name'] = '';
                foreach ($announcement[$k]['ClassPosts'] as $m) {
                    $announcement[$k]['Announcement']['cp_name'] .= $m['cp_name'] . '&nbsp;';
                }
                unset($announcement[$k]['ClassPosts']);
            }

            $this->set('announcement', $announcement);
        } elseif ($this->request['pass'][0] == 'add') {
            //找出部门
            $this->set('ClassPosts', $this->ClassPosts->find('all', array('conditions' => array('ClassPosts.cp_type' => 0, 'cp_company_id' => $this->onLineUser['u_company_id']), 'fields' => array('cp_id', 'cp_name'))));

            $this->set('_position', $this->_L('add_announcement'));
        } elseif ($this->request['named']) {
            if ($this->request['named']['show'] || $this->request['named']['edit']) { //查看公告 和 编辑公告
                //找出该条公告信息
                $a_id = isset($this->request['named']['show']) ? $this->request['named']['show'] : $this->request['named']['edit'];
                $announcement = $this->Announcement->find('all', array('conditions' => array('Announcement.a_id' => $a_id)));
                //记录当前公告所拥有的部门
                $current_class = array();
                foreach ($announcement[0]['ClassPosts'] as $v) {
                    $current_class[] = $v['cp_id'];
                }

                if (isset($this->request['named']['edit'])) { //如果是编辑，那么找出所有部门信息
                    //找出部门
                    $ClassPostsRes = $this->ClassPosts->find('all', array('conditions' => array('ClassPosts.cp_type' => 0), 'fields' => array('cp_id', 'cp_name')));
                    //组合出所需的新部门数组，其中记录当前公告所属部门信息字段  current_class
                    $ClassPosts = array();
                    foreach ($ClassPostsRes as $k => $v) {
                        $ClassPosts[$k] = $v;
                        if (in_array($v['ClassPosts']['cp_id'], $current_class)) {
                            $ClassPosts[$k]['ClassPosts']['current_class'] = $v['ClassPosts']['cp_id'];
                        }
                    }
                    $this->set('ClassPosts', $ClassPosts);
                }

                $this->set('announcement', $announcement);
                $this->set('_position', isset($this->request['named']['show']) ? $this->_L('show_announcement') : $this->_L('edit_announcement'));
            } elseif ($this->request['named']['del']) { //删除用户公告记录
                $this->request->data['UserAnnouncements']['u_id'] = $onLineUser['u_id'];
                $this->request->data['UserAnnouncements']['a_id'] = $this->request['named']['del'];
                $msg = $this->_L('do_failed');
                if ($this->UserAnnouncements->save($this->request->data)) {
                    $msg = $this->_L('do_success');
                    $this->Session->setFlash($msg);
                    $this->redirect(array('controller' => 'Office', 'action' => 'announcement'));
                }
                $this->Session->setFlash($msg);
            } elseif ($this->request['named']['delTrue']) { //真正删除公告，同时删除所有关于该公告的信息
                $this->ClassAnnouncements->primaryKey = 'a_id';
                $msg = $this->_L('del_failed');
                if ($this->ClassAnnouncements->deleteAll(array("ClassAnnouncements.a_id" => $this->request['named']['delTrue'])) &&
                        $this->UserAnnouncements->deleteAll(array("UserAnnouncements.a_id" => $this->request['named']['delTrue'])) &&
                        $this->Announcement->delete($this->request['named']['delTrue'], true))
                    $msg = $this->_L('del_success');

                $this->Session->setFlash($msg);
                $this->redirect(array('controller' => $this->request['controller'], 'action' => $this->request['action'] . '/sent'));
            }
        }
    }

}

?>
