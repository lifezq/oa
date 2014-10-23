<?php

/**
 * @filename StaffController.php
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-9-13  17:25:52
 * @version 1.0
 * Description of StaffController
 */
App::uses('AppController', 'Controller');

class StaffController extends AppController {

    public $uses = array('User', 'Group', 'UserInfos', 'ClassPosts', 'Assignment', 'AssignmentUid', 'Sms', 'SmsRecord');

    /*
     * 管理员工
     */

    public function staff() {
        $_set = array('_position' => $this->_L('company_staff_manage'));
        if (empty($this->request['pass']) && empty($this->request['named'])) {

            //找到所有用户组
            $class = $this->Group->find('all', array('conditions' => array('Group.g_status' => 1, 'Group.com_id' => $this->onLineUser['u_company_id']), 'fields' => array('Group.g_id', 'Group.g_name')));
            $preg = '/管理/';
            $gid = '';
            foreach ($class as $v) {
                if (!preg_match($preg, $v['Group']['g_name'])) {
                    $gid .= $v['Group']['g_id'] . ',';
                }
            }
            $gid = rtrim($gid, ','); //普通用户，员工 ，用户组

            $_set['users'] = $this->User->query('select User.*,Class.cp_name,Posts.cp_name,Groups.g_name,Permission.p_nav_allows from oa_users as User inner join oa_class_posts as Class on User.u_class_id=Class.cp_id inner join oa_class_posts as Posts on User.u_posts_id=Posts.cp_id inner join oa_group as Groups on User.u_gid=Groups.g_id left join oa_permissions as Permission on User.u_id=Permission.p_uid where User.u_company_id=' . $this->onLineUser['u_company_id'] . ' and User.u_gid in(' . $gid . ') order by User.u_id desc ');
        } elseif ($this->request['named']['resumeCreate'] || $this->request['named']['resumeEdit']) {

            $_set['_position'] = $this->_L('create_resume');
            if ($this->request['named']['resumeEdit'])
                $_set['_position'] = $this->_L('edit_resume');
            if ($this->request->is('post')) {
                if ($this->request->data['UserInfos']['u_resume_type'] == 1) { //上传简历文档
                    $dir = Configure::read('UPLOAD_DIR') . 'resume/';
                    if (!is_dir($dir))
                        mkdir($dir, 0777, true);
                    $fileInfo = pathinfo($this->request->data['UserInfos']['resume1']['name']);
                    //判断文件格式是否在允许范围
                    $allowType = array('doc', 'docx', 'dps', 'rtf', 'wps');
                    if (!in_array($fileInfo['extension'], $allowType)) {
                        $this->Session->setFlash($this->_L('resume_type_is_wrong'));
                        $this->redirect(array('controller' => 'Staff', 'action' => 'staff/resumeCreate:' . $this->request['named']['resumeCreate']));
                    }
                    $saveName = rand(0, 5000) . time() . '.' . $fileInfo['extension'];
                    $newName = $dir . $saveName;
                    echo $this->request->data['UserInfos']['resume1']['tmp_name'] . '--' . $newName;
                    if (@move_uploaded_file($this->request->data['UserInfos']['resume1']['tmp_name'], $newName)) {
                        $this->request->data['User']['u_resume_type'] = 1;
                        $this->request->data['UserInfos']['ui_resume'] = preg_replace('/\.\.\/webroot/', '', $dir) . $saveName;
                        unset($this->request->data['UserInfos']['resume1']);
                    }
                } else { //简历信息
                    //查找用户有没有简历文档，如果有删除
                    $resumeFile = $this->UserInfos->find('all', array('conditions' => array('UserInfos.u_id' => $this->request['named']['resumeCreate'])));

                    if (is_file('../webroot' . $resumeFile[0]['UserInfos']['ui_resume']))
                        @unlink('../webroot' . $resumeFile[0]['UserInfos']['ui_resume']);
                    $this->request->data['User']['u_resume_type'] = 2;
                    $this->request->data['UserInfos']['ui_resume'] = $this->request->data['UserInfos']['resume2'];
                    unset($this->request->data['UserInfos']['resume2']);
                }

                unset($this->request->data['UserInfos']['u_resume_type']);
                $msg = $this->_L('resume_update_failed');
                $this->request->data['UserInfos']['u_id'] = $this->request->data['User']['u_id'] = $this->request['named']['resumeCreate'];
                if ($this->UserInfos->save($this->request->data['UserInfos'], false) && $this->User->save($this->request->data['User'], false)) {
                    $msg = $this->_L('resume_update_success');
                    $this->Session->setFlash($msg);
                    $this->redirect(array('controller' => 'Staff', 'action' => 'staff'));
                }
                $this->Session->setFlash($msg);
            }
        } elseif ($this->request['named']['down']) {
            $resumeFile = $this->UserInfos->find('all', array('conditions' => array('UserInfos.u_id' => $this->request['named']['down']), 'fields' => 'UserInfos.ui_resume'));

            $resumeFile = '../webroot' . $resumeFile[0]['UserInfos']['ui_resume'];

            header("Pragma: public");
            header("Expires: 0");
            header('Content-Encoding: none');
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: public");

            Header("Content-type: application/octet-stream");
            Header("Accept-Ranges: bytes");
            Header("Accept-Length: " . filesize($resumeFile));
            Header("Content-Disposition: attachment; filename=" . basename($resumeFile));
            // 输出文件内容
            readfile($resumeFile);
            exit();
        } elseif ($this->request['named']['read']) {
            $this->UserInfos->hasOne = array(
                'User' => array(
                    'className' => 'User',
                    'foreignKey' => 'u_id',
                    'fields' => 'User.u_true_name'
                )
            );
            $resume = $this->UserInfos->find('all', array('conditions' => array('UserInfos.u_id' => $this->request['named']['read']), 'fields' => array('UserInfos.ui_resume', 'User.u_true_name')));
            $_set['username'] = $resume[0]['User']['u_true_name'];
            $_set['_position'] = $this->_L('read_resume');
            $_set['resume'] = $resume[0]['UserInfos']['ui_resume'];
        }
        $this->set($_set);
    }

    /*
     * 下达任务  任务分派
     */

    public function assignment() {
        $_set = array();
        if (empty($this->request['pass']) && empty($this->request['named'])) {
            //找到公司所有任务
            $this->Paginator->settings = array(
                'Assignment' => array(
                    'limit' => 10,
                    'maxLimit' => 10,
                    'conditions' => array('Assignment.com_id' => $this->onLineUser['u_company_id']),
                    'order' => 'Assignment.a_id desc '
                )
            );
            $this->set('Assignment', $this->Paginator->paginate('Assignment'));
            $_set['_position'] = $this->_L('member_assignment');
        }if ($this->request['pass'][0] == 'add' || $this->request['named']['add'] || $this->request['named']['edit']) {

            if ($this->request->is('post')) {
                $users = $this->request->data['Assignment']['a_users'];
                $users = explode(';', $users);
                $_users = '';
                $uids = array();
                foreach ($users as $v) {
                    $temp = explode(':', $v);
                    $_users .= $temp[1] . ',';
                    $uids[] = $temp[0];
                }
                $_users = trim($_users, ',');

                $this->request->data['Assignment']['a_users'] = $_users;
                $msg = $this->_L('add_task_failed');
                $this->request->data['Assignment']['com_id'] = $this->onLineUser['u_company_id'];
                $this->request->data['Assignment']['a_make_uid'] = $this->onLineUser['u_id'];
                if ($this->Assignment->save($this->request->data)) {
                    $a_id = $this->request['named']['edit'] ? $this->request['named']['edit'] : $this->Assignment->getInsertID();

                    unset($this->request->data);
                    if (empty($this->request['named']['edit'])) {

                        //找到当前下达任务人的部门，职位,修改就不用通知了
                        $class = $this->ClassPosts->find('all', array('conditions' => array('ClassPosts.cp_id' => $this->onLineUser['u_class_id']), 'fields' => 'ClassPosts.cp_name'));
                        $posts = $this->ClassPosts->find('all', array('conditions' => array('ClassPosts.cp_id' => $this->onLineUser['u_posts_id']), 'fields' => 'ClassPosts.cp_name'));
                        //发消息通知员工有新任务
                        $message = $class[0]['ClassPosts']['cp_name'] . "部门" . $posts[0]['ClassPosts']['cp_name'] . " " . $this->onLineUser['u_true_name'] . "给您分配了新任务,快去查看吧!";
                        $data = array(
                            'Sms' => array(
                                's_receivers' => $_users,
                                's_from_uid' => $this->onLineUser['u_id'],
                                's_message' => $message,
                                's_from_user' => $this->onLineUser['u_true_name'],
                            )
                        );
                        $this->Sms->save($data);
                        $s_id = $this->Sms->getInsertID();

                        $data = $smsData = array();
                        foreach ($uids as $k => $v) {
                            $data[]['AssignmentUid'] = array(
                                'a_id' => $a_id,
                                'u_id' => $v
                            );
                            $smsData[]['SmsRecord'] = array(
                                'sr_uid' => $v,
                                'sr_unread_sms_id' => $s_id
                            );
                        }
                        $this->SmsRecord->saveMany($smsData);
                    } else { //修改任务
                        //删除目前任务执行人
                        $this->AssignmentUid->primaryKey = 'a_id';
                        $this->AssignmentUid->deleteAll(array('AssignmentUid.a_id' => $this->request['named']['edit']));

                        $data = array();
                        foreach ($uids as $k => $v) {
                            $data[]['AssignmentUid'] = array(
                                'a_id' => $a_id,
                                'u_id' => $v
                            );
                        }
                    }
                    $msg = $this->_L('add_task_failed');
                    $this->AssignmentUid->primaryKey = false;
                    if ($this->AssignmentUid->saveMany($data)) {
                        $msg = $this->_L('add_task_success');
                        $this->Session->setFlash($msg);
                        $this->redirect(array('controller' => 'Staff', 'action' => 'assignment'));
                    }
                }

                $this->Session->setFlash($msg);
                $this->redirect($_SERVER['HTTP_REFERER']);
            }
            $_set['_position'] = $this->_L('assignment_add');
            //如果是编辑任务,读到编辑任务信息
            if ($this->request['named']['edit']) {
                $assignInfo = $this->Assignment->find('all', array('conditions' => array('Assignment.a_id' => $this->request['named']['edit'])));
                //查找任务执行员工ID
                $users = explode(',', $assignInfo[0]['Assignment']['a_users']);
                $uids = $this->AssignmentUid->find('all', array('conditions' => array('AssignmentUid.a_id' => $this->request['named']['edit'])));
                $userStr = '';


                foreach ($uids as $k => $v) {
                    $userStr .= $v['AssignmentUid']['u_id'] . ':' . $users[$k] . ';';
                }

                $assignInfo[0]['Assignment']['a_users'] = trim($userStr, ';');
                $_set['assignInfo'] = $assignInfo;
                $_set['_position'] = $this->_L('assignment_edit');
            }

            //找到部门
            $class = $this->ClassPosts->find('all', array('conditions' => array('ClassPosts.cp_company_id' => $this->onLineUser['u_company_id'], 'ClassPosts.cp_type' => 0), 'order' => 'ClassPosts.cp_order desc ', 'fields' => array('ClassPosts.cp_id', 'ClassPosts.cp_name')));

            foreach ($class as $v) {
                $_set['_class'][$v['ClassPosts']['cp_id']] = $v['ClassPosts']['cp_name'];
            }
            //查找部门下的员工
            $member = $this->User->find('all', array('conditions' => array('User.u_id !=' => $this->onLineUser['u_id'], 'User.u_company_id' => $this->onLineUser['u_company_id'], 'User.u_class_id' => $this->request['named']['add'] ? $this->request['named']['add'] : ($assignInfo[0]['Assignment']['a_class'] ? $assignInfo[0]['Assignment']['a_class'] : $class[0]['ClassPosts']['cp_id']), 'User.u_is_close' => 0), 'fields' => array('User.u_id', 'User.u_true_name')));
            $_set['member'] = '';
            foreach ($member as $v) {
                $_set['member'] .= "<a href='javascript:void(0);' onClick=addUser('" . $v['User']['u_id'] . ':' . $v['User']['u_true_name'] . "')>" . $v['User']['u_true_name'] . "</a> &nbsp;";
            }
        }
        $this->set($_set);
    }

}

?>
