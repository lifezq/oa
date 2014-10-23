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
class Email extends AppModel{
    //put your code here
    
    public $components = array('Auth', 'Session');
    public $name = 'email';
    public $primaryKey = 'em_id';
    public $useTable = 'email';
    
    public $validate=array(
        'em_from' => array(
            'rule'    => '/^[\w\d]+[\w\d-.]*@[\w\d-.]+\.[\w\d]{2,10}$/i',
            'required'   => true,
        'allowEmpty' => false,
        'on'         => 'create', // or: 'update'
            'message' => '请填写正确的邮箱'
        ),
        'em_come_to' => array(
            'rule'=>'notEmpty',
            'required'   => true,
            'allowEmpty' => false,
            'on'         => 'create', // or: 'update'
            'message' => '请填写正确的邮箱'
        )
    );
}

?>
