<?php

/**
 * @filename Blog.php
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://www.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-8-6  9:28:11
 * @version 1.0
 * Description of Blog
 */
class MailServer extends AppModel{
    //put your code here
    public $components = array('Auth', 'Session');
    public $name = 'mail_server';
    public $primaryKey = 'm_uid';
    public $hasOne = array(
           'users'=>array(
               'classname'=>'User',
               'fields'=>array('users.u_true_name'),
               'conditions'=>array('users.u_is_close'=>0),
               'foreignKey' => 'u_id',
               'dependent' => true
           )
    );

}

?>
