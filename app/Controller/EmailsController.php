<?php

/**
 * @filename EmailController.php
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-8-21  10:17:26
 * @version 1.0
 * Description of EmailController
 */
app::uses('AppController', 'Controller');

class EmailsController extends AppController {

    public $uses = array('Email', 'User', 'MailServer', 'AddressBook', 'EmailRecords');

    public function innerEmails() {
        $_args = func_get_args();
        $onLineUser = $this->Session->read('Auth.User');
        if ($this->request->is('post')) {
            if ($_args[0] == 'del') {
                if (!empty($_POST['email_ck'])) {//批量删除
                    
                    foreach ($_POST['email_ck'] as $v) {
                        $this->delEmail($_args[1],$onLineUser['u_id']);
                    }
                    $this->redirect($_SERVER['HTTP_REFERER']);
                }
                $this->Session->setFlash($this->_L('select_option_to_del'));
                $this->redirect(array('controller' => 'Emails', 'action' => 'innerEmails'));
            }
            $_file = $this->request->data['Email']['em_attachment_path'];
            //上传附件
            if ($_file['tmp_name'] && is_uploaded_file($_file['tmp_name'])) {
                app::uses('upload.Class', 'Lib');
                app::load('upload.Class');

                $upload = new upLoad(5, Configure::read('UPLOAD_DIR'));
                $_upload_result = $upload->upLoadFile($_file);

                if (is_array($_upload_result)) {
                    $upload_result = '';
                    foreach ($_upload_result as $v) {
                        if ($v)
                            $upload_result .= $v . ',';
                    }
                    $_upload_result = rtrim($upload_result, ',');
                }

                $this->request->data['Email']['em_attachment_path'] = str_replace('../webroot', '', $_upload_result);
            } else {
                $this->request->data['Email']['em_attachment_path'] = '';
            }

            $redirect = array('controller' => 'Emails', 'action' => 'innerEmails/send/1');

            //分离组合出收件人和收件邮箱
            $em_come_to_arr = explode(';', $this->request->data['Email']['em_come_to']);
            $come_to = $to_user = '';
            //记录收件人ID到数组
            $come_to_uid = array();
            foreach ($em_come_to_arr as $v) {
                $temp = explode(':', $v);
                $come_to .= $temp[1] . ',';
                $to_user .= $temp[0] . ',';
                $toUid = $this->User->find('all', array('conditions' => array('User.u_company_email' => $temp[1]), 'fields' => 'User.u_id'));
                $come_to_uid[] = $toUid[0]['User']['u_id'];
            }

            $come_to = rtrim($come_to, ',');
            $to_user = rtrim($to_user, ',');
            $this->request->data['Email']['em_come_to'] = $come_to;
            $this->request->data['Email']['em_to_user'] = $to_user;
            
            $this->request->data['Email']['em_from'] = $onLineUser['u_company_email'];
            $this->request->data['Email']['em_from_uid'] = $onLineUser['u_id'];

            if ($this->Email->save($this->request->data)) {
                //清空reqest->data数组
                unset($this->request->data);
                //拿到邮件ID
                $em_id = $this->Email->getInsertId();
                //将邮件的收件人插入到邮件记录表 oa_email_records 
                $this->request->data = array();
                foreach ($come_to_uid as $k => $v) {
                    $this->request->data[$k]['EmailRecords']['em_id'] = $em_id;
                    $this->request->data[$k]['EmailRecords']['em_to_uid'] = $v;
                }
                $msg = $this->_L('send_success');

                if (!$this->EmailRecords->saveMany($this->request->data)) { //保存邮件接收者到记录表
                    //如果没有成功，那么删除邮件，并提示用户
                    $msg = $this->_L('send_failed');
                    $this->Email->delete($em_id);
                } else {
                    $url = array('controller' => 'Emails', 'action' => 'innerEmails');
                    $this->Session->setFlash($msg);
                    $this->redirect($url);
                }
            } else {
                $msg = $this->_L('send_failed');
                $url = array('controller' => 'Emails', 'action' => 'innerEmails/send/1');
                $this->Session->setFlash($msg);
                $this->redirect($url);
            }
        }

        $this->set('_position', $this->_L('inner_mail_manage')); //把当前位置分配过去
        $this->set('_send', false); //默认不发送邮件
        
        if ($_args) {
            if ($_args[0] == 'send') { //发送内部邮件
                $this->set('_send', true);

                $CompanyU = $this->User->find('all', array('conditions' => 'User.u_is_close=0 and User.u_id!=' . $onLineUser['u_id'].' and User.u_company_id='.$this->onLineUser['u_id'], 'fields' => array('User.u_true_name', 'User.u_company_email')));

                $UserLink = '';

                foreach ($CompanyU as $v) {
                    $UserLink .= "<a href='javascript:void(0);' onClick=companyUserEmail('" . $v['User']['u_true_name'] . ':' . $v['User']['u_company_email'] . "')>" . $v['User']['u_true_name'] . "</a>&nbsp;&nbsp;";
                }

                $this->set('UserLink', $UserLink);
                $LineUser = array();
                $LineUser['u_true_name'] = $onLineUser['u_true_name'];
                $LineUser['u_company_email'] = $onLineUser['u_company_email'];
                $this->set('LineUser', $LineUser);
                $this->set('_position', $this->_L('send_inner_email'));
            } elseif ($_args[0] == 'del') {//删除邮件 
                $this->delEmail($_args[1],$onLineUser['u_id']);
                $this->redirect($_SERVER['HTTP_REFERER']);
            }
        }


        //如果是管理员或以上级别，那么就读所有内部邮件

        if ($onLineUser['u_role'] > 0) {
            $this->set('manageButton', true); //管理操作按钮
            $conditions = array('Email.em_inner_out' => 0);
        }
        if ($this->request['pass'][0] == 'received') {
            //找到用户是否有接收到邮件
            $emIds = $this->EmailRecords->find('all', array('conditions' => array('EmailRecords.em_to_uid' => $onLineUser['u_id'], 'EmailRecords.em_hide' => 0), 'fields' => 'EmailRecords.em_id'));
            $receivedIdStr = '';
            foreach ($emIds as $v) {
                $receivedIdStr .= $v['EmailRecords']['em_id'] . ',';
            }
            $receivedIdStr = rtrim($receivedIdStr, ',');
            if(empty($receivedIdStr))  $receivedIdStr=0;
            //接收的内部邮件
            $conditions = "em_inner_out=0 and Email.em_id in ({$receivedIdStr})";
            $this->set('_position', $this->_L('received_inner_email'));
        } elseif ($this->request['pass'][0] == 'sent') {
            $conditions = array('Email.em_inner_out' => 0, 'Email.em_from_uid' => $onLineUser['u_id']);
            $this->set('_position', $this->_L('sent_inner_email'));
        }

        if (empty($_args) || $_args[0] == 'del' || $_args[0] == 'received' || $_args[0] == 'sent') {
            $this->Paginator->settings = array(
                'Email' => array(
                    'limit' => 10,
                    'conditions' => $conditions,
                    'order' => 'Email.em_id desc',
                    'maxLimit' => 10
                )
            );
            if ($_args[0] == 'received') { //找出发件人姓名
                $this->Email->hasOne = array(
                    'User' => array(
                        'className' => 'User',
                        'foreignKey' => 'u_id',
                        'fields' => 'User.u_true_name'
                    )
                );
                $this->Email->primaryKey = 'em_from_uid';  //指定主键，由主键进行关联  
            }elseif(empty($_args)){
                $this->Email->hasOne = array(
                    'User' => array(
                        'className' => 'User',
                        'foreignKey' => 'u_id',
                        'type'=>'inner',
                        'fields' => 'User.u_id',
                        'conditions'=>array('User.u_company_id'=>$this->onLineUser['u_company_id'])
                    )
                );
                 $this->Email->primaryKey = 'em_from_uid';  //指定主键，由主键进行关联 
            }

            $this->set('emails', $this->Paginator->paginate('Email'));
        }
    }
/*
 * 删除邮件
 */
    public function delEmail($emId,$onLineUid) {
        try {

            //判断确认是发件者删除还是收件者删除，从而达到双方或者所有跟该邮件有关的人都删除时，那么真正删除该邮件 ，及与该邮件相关的数据
            $em_from_uid = $this->Email->find('all', array('conditions' => array('Email.em_id' => $emId), 'fields' => array('Email.em_from_uid', 'Email.em_del_from', 'Email.em_del_to')));
            if ($onLineUser['u_id'] == $em_from_uid[0]['Email']['em_from_uid']) { //说明是发件人删除
                if ($em_from_uid[0]['Email']['em_del_to']) {//说明所有收件人已经删除过了,那么就可以真正删除邮件了
                    $this->Email->delete($emId);
                    $this->EmailRecords->deleteAll(array('EmailRecords.em_id' => $emId), true);
                } else {
                    $this->EmailRecords->updateAll(array('EmailRecords.em_hide' => 1), array('EmailRecords.em_id' => $emId,'EmailRecords.em_to_uid'=>$onLineUid));
                }
            } else {
                if ($em_from_uid[0]['Email']['em_del_from']) {//说明发件人已经删除过了
                    //然后查找oa_email_records 表，即收件人表记录中所有 关于该em_id的删除记录，查找是否全部删除过了
                    $isDel = $this->EmailRecords->find('all', array('conditions' => array('EmailRecords.em_id' => $emId, 'EmailRecords.hide' => 0), 'fields' => array('EmailRecords.em_id')));
                    $remainNum = count($isDel); //统计剩余没有删除的条数
                    if ($remainNum <2) {  //说明就差这一用户没有删除，其余用户全删除了，那么就更新email表的em_del_to 为1
                        $this->Email->delete($emId);
                        $this->EmailRecords->deleteAll(array('EmailRecords.em_id' => $emId), true);
                    }
                } else {
                    $this->EmailRecords->updateAll(array('EmailRecords.em_hide' => 1), array('EmailRecords.em_id' => $emId,'EmailRecords.em_to_uid'=>$onLineUid));
                }
            }
            $this->Session->setFlash($this->_L('del_success'));
            return true;
        } catch (Exception $e) {
            $this->Session->setFlash($this->_L('del_failed').'<br/>'.$e->getMessage());
            return false;
        }
    }

    public function internetEmails() {
        $_args = func_get_args();
        $onLineUser = $this->Session->read('Auth.User');
        if ($this->request->is('post')) {
            if ($_args[0] == 'del') {
                if (!empty($_POST['email_ck'])) {//批量删除
                    foreach ($_POST['email_ck'] as $v) {
                        foreach ($_POST['email_ck'] as $v) {
                        $this->delEmail($_args[1],$onLineUser['u_id']);
                    }
                    $this->redirect($_SERVER['HTTP_REFERER']);
                    }
                   }
                $this->Session->setFlash($this->_L('select_option_to_del'));
                $this->redirect(array('controller' => 'Emails', 'action' => 'internetEmails'));
            }
            $this->request->data['Email']['em_attachment_path'] = '';
            $redirect = array('controller' => 'Emails', 'action' => 'internetEmails/send/1');

            //分离组合出收件人和收件邮箱
            $em_come_to_arr = explode(';', $this->request->data['Email']['em_come_to']);
            $come_to = $to_user = '';
            $come_to_arr = $to_user_arr = $come_to_uid = array();
            foreach ($em_come_to_arr as $v) {
                $temp = explode(':', $v);
                $come_to .= $temp[1] . ',';
                $to_user .= $temp[0] . ',';
                $come_to_arr[] = $temp[1];
                $to_user_arr[] = $temp[0];
                $toUid = $this->User->find('all', array('conditions' => array('User.u_company_email' => $temp[1]), 'fields' => 'User.u_id'));
                $come_to_uid[] = $toUid[0]['User']['u_id']; //记录所有收件人ID
            }
            $come_to = rtrim($come_to, ',');
            $to_user = rtrim($to_user, ',');
            $this->request->data['Email']['em_come_to'] = $come_to;
            $this->request->data['Email']['em_to_user'] = $to_user;
            App::uses('CakeEmail', 'Network/Email');
            $Email = new CakeEmail('smtp');
            $MailServer = $this->getUserMailServer();

            if (!$come_to_arr) {
                $this->setFlash($this->_L('write_the_right_recipient'));
                $this->redirect(array('controller' => 'Emails', 'action' => 'internetEmails/send/1'));
            }

            foreach ($come_to_arr as $v) {
                //尝试发送邮件，捕捉错误信息并中断
                try {
                    $Email->config(array(
                        'transport' => 'Smtp',
                        'from' => array($MailServer[0]['MailServer']['m_username'] => $this->request->data['Email']['em_from']),
                        'host' => $MailServer[0]['MailServer']['m_server'],
                        'port' => $MailServer[0]['MailServer']['m_port'],
                        'timeout' => 30,
                        'username' => $MailServer[0]['MailServer']['m_username'],
                        'password' => $MailServer[0]['MailServer']['m_password'],
                        'client' => null,
                        'log' => false,
                    ))->template('welcome', 'fancy')->emailFormat('html')->to($v)->subject($this->request->data['Email']['em_subject'])->send($this->request->data['Email']['em_content']);
                } catch (Exception $e) {
                    $msg = iconv('gb2312', 'utf-8', $e->getMessage());
                    $this->Session->setFlash($msg . $this->_L('check_the_config_of_email'));
                    $this->redirect(array('controller' => 'Emails', 'action' => 'mailSetting'));
                }
            }
            
            $this->request->data['Email']['em_from'] = $onLineUser['u_email'];
            $this->request->data['Email']['em_from_uid'] = $onLineUser['u_id'];
            if ($this->Email->save($this->request->data)) {
                //清空reqest->data数组
                unset($this->request->data);
                //拿到邮件ID
                $em_id = $this->Email->getInsertId();
                //将邮件的收件人插入到邮件记录表 oa_email_records 
                $this->request->data = array();
                foreach ($come_to_uid as $k => $v) {
                    $this->request->data[$k]['EmailRecords']['em_id'] = $em_id;
                    $this->request->data[$k]['EmailRecords']['em_to_uid'] = $v;
                }
                $msg = $this->_L('send_success');

                if (!$this->EmailRecords->saveMany($this->request->data)) { //保存邮件接收者到记录表
                    //如果没有成功，那么删除邮件，并提示用户
                    $msg = $this->_L('send_failed');
                    $this->Email->delete($em_id);
                } else {
                    $url = array('controller' => 'Emails', 'action' => 'internetEmails');
                    $this->Session->setFlash($msg);
                    $this->redirect($url);
                }
                $this->Session->setFlash($msg);
            }
        }

        $this->set('_position', $this->_L('out_mail_manage')); //把当前位置分配过去
        $this->set('_send', false); //默认不发送邮件
        
        //如果是管理员或以上级别，那么就读所有外部邮件

        if ($onLineUser['u_role'] > 0) {
            $this->set('manageButton', true); //管理操作按钮
            $conditions = array('Email.em_inner_out' => 1);
        }else{
            $conditions = array('Email.em_inner_out' => 1,'Email.em_from_uid'=>$onLineUser['u_id']);
        }
        
        if ($_args) {
            if ($_args[0] == 'send') { //发送外部邮件
                $this->set('_send', true);
                
                if (!$this->getUserMailServer()) {
                    $this->Session->setFlash($this->_L('the_mail_server_configuration_error'));
                    $this->redirect(array('controller' => 'Emails', 'action' => 'mailSetting'));
                }

                $CompanyU = $this->User->find('all', array('conditions' => 'User.u_is_close=0 and User.u_id!=' . $onLineUser['u_id'].' and User.u_company_id='.$this->onLineUser['u_company_id'], 'fields' => array('User.u_true_name', 'User.u_email')));

                //找出用户通讯薄中联系人
                $AddressBook = $this->AddressBook->find('all', array('conditions' => ' AddressBook.a_uid=' . $onLineUser['u_id'] . " and AddressBook.a_email != '' ", 'fields' => array('a_username', 'a_email')));


                $UserLink = '';
                foreach ($AddressBook as $v) {
                    $UserLink .= "<a href='javascript:void(0);' onClick=companyUserEmail('" . $v['AddressBook']['a_username'] . ':' . $v['AddressBook']['a_email'] . "')>" . $v['AddressBook']['a_username'] . "</a>&nbsp;&nbsp;";
                }
                foreach ($CompanyU as $k => $v) {
                    $UserLink .= "<a href='javascript:void(0);' onClick=companyUserEmail('" . $v['User']['u_true_name'] . ':' . $v['User']['u_email'] . "')>" . $v['User']['u_true_name'] . "</a>&nbsp;&nbsp;";
                }
                $this->set('UserLink', $UserLink);

                $LineUser = array();
                $LineUser['u_true_name'] = $onLineUser['u_true_name'];
                $LineUser['u_email'] = $onLineUser['u_email'];
                $this->set('LineUser', $LineUser);
                $this->set('_position', $this->_L('send_out_email')); 
            } elseif ($_args[0] == 'del') {//删除邮件 
                $this->delEmail($_args[1],$onLineUser['u_id']);
                $this->redirect($_SERVER['HTTP_REFERER']);
                
            }elseif($_args[0] == 'sent'){
                 $this->set('_position', $this->_L('sent_out_email'));
                $conditions = array('Email.em_inner_out' => 1,'Email.em_from_uid'=>$onLineUser['u_id']);
            }
        }
        
        if (empty($_args) || $_args[0] == 'del' || $_args[0] == 'sent') {
            $this->Paginator->settings = array(
                'Email'=> array(
                  'limit'  =>10,
              "maxLimit"=>10,
              'conditions' => $conditions ,
                    'order' => 'Email.em_id desc'
                )
            );
            if(empty($_args)){
                $this->Email->hasOne = array(
                    'User'=>array(
                        'className'=>'User',
                        'type'=>'inner',
                        'foreignKey'=>'u_id',
                        'conditions'=>array('User.u_company_id'=>$this->onLineUser['u_company_id']),
                    )
                );
                $this->Email->primaryKey = 'em_from_uid';
            }
            $this->set('emails', $this->Paginator->paginate('Email'));
        }
    }

    public function mailSetting() {
        $MailServer = $this->getUserMailServer(); //用户邮件服务器配置信息

        if ($this->request->is('post')) {
            if (!empty($this->request->data['Email']['em_come_to'])) { //发送测试邮件 
                App::uses('CakeEmail', 'Network/Email');
                $Email = new CakeEmail('smtp');
                if (!$MailServer) {
                    $this->Session->setFlash($this->_L('the_mail_server_configuration_error'));
                    $this->redirect(array('controller' => 'Emails', 'action' => 'mailSetting'));
                }

                //尝试发送邮件，捕捉错误信息并中断
                try {
                    //分离组合出收件人和收件邮箱
                    $come_to_arr = explode(';', $this->request->data['Email']['em_come_to']);
                    $come_to_arr = explode(':', $come_to_arr[0]);

                    $Email->config(array(
                        'transport' => 'Smtp',
                        'from' => array($MailServer[0]['MailServer']['m_username'] => $this->request->data['Email']['em_from']),
                        'host' => $MailServer[0]['MailServer']['m_server'],
                        'port' => $MailServer[0]['MailServer']['m_port'],
                        'timeout' => 30,
                        'username' => $MailServer[0]['MailServer']['m_username'],
                        'password' => $MailServer[0]['MailServer']['m_password'],
                        'client' => null,
                        'log' => false,
                    ))->template('welcome', 'fancy')->emailFormat('html')->to($come_to_arr[1])->subject($this->request->data['Email']['em_subject'])->send($this->request->data['Email']['em_content']);
                } catch (Exception $e) {
                    $msg = iconv('gb2312', 'utf-8', $e->getMessage());
                    $this->Session->setFlash($msg . $this->_L('check_the_config_of_email'));
                    $this->redirect(array('controller' => 'Emails', 'action' => 'mailSetting'));
                }
                $this->Session->setFlash($this->_L('test_email_send_success'));
                $this->redirect(array('controller' => 'Emails', 'action' => 'mailSetting'));
            }
            $onLineUser = $this->Session->read('Auth.User');
            $this->request->data['MailServer']['m_uid'] = $onLineUser['u_id'];
            $msg = $this->_L('mail_server_configuration_failed');
            if ($this->MailServer->save($this->request->data))
                $msg = $this->_L('mail_server_configuration_success');
            $this->Session->setFlash($msg);
        }
        //如果用户已经配置了邮件服务器，那么分配过去以供修改
        $this->set('MailServer', $MailServer[0]['MailServer']);
        //找出通讯录收件人
        $onLineUser = $this->Session->read('Auth.User');
        $CompanyU = $this->User->find('all', array('conditions' => 'User.u_is_close=0 and User.u_id!=' . $onLineUser['u_id'].' and User.u_company_id='.$this->onLineUser['u_company_id'], 'fields' => array('User.u_true_name', 'User.u_email')));
        //找出用户通讯薄中联系人
        $AddressBook = $this->AddressBook->find('all', array('conditions' => ' AddressBook.a_uid=' . $onLineUser['u_id'] . " and AddressBook.a_email != '' ", 'fields' => array('a_username', 'a_email')));


        $UserLink = '';
        foreach ($AddressBook as $v) {
            $UserLink .= "<a href='javascript:void(0);' onClick=companyUserEmail('" . $v['AddressBook']['a_username'] . ':' . $v['AddressBook']['a_email'] . "')>" . $v['AddressBook']['a_username'] . "</a>&nbsp;&nbsp;";
        }

        foreach ($CompanyU as $k => $v) {
            $UserLink .= "<a href='javascript:void(0);' onClick=companyUserEmail('" . $v['User']['u_true_name'] . ':' . $v['User']['u_email'] . "')>" . $v['User']['u_true_name'] . "</a>&nbsp;&nbsp;";
        }
        $this->set('UserLink', $UserLink);
    }

    public function getUserMailServer($uid = 0) {
        if (!$uid) {
            $onLineUser = $this->Session->read('Auth.User');
            $uid = $onLineUser['u_id'];
        }
        return $this->MailServer->find('all', array('conditions' => 'users.u_id = ' . $uid));
    }

}

?>
