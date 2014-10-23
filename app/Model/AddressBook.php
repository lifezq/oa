<?php

/**
 * @filename AddressBook.php
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-8-29  12:22:39
 * @version 1.0
 */
 class AddressBook extends AppModel{
     public $name = 'AddressBook';
     public $primaryKey = 'a_id';
     public $useTable = 'address_book';
     public $validate = array(
         'a_username'=>array(
             'rule'    => '/^[_\x{4e00}-\x{9fa5}\d]{2,4}$/iu',
             'message' => '必须是中文字符，长度在2-4个字符'
         ),
         'a_spellname'=>array(
             'rule'=>'/\w+/',
             'allowEmpty'=>true,
             'message'=>'请填写正确的姓名拼音'
         ),
         'a_mobile'=>array(
             'rule'    => '/^[(86)|0]?(13\d{9})|(15\d{9})|(18\d{9})$/',
             'allowEmpty'=>true,
            'message' => '请填写正确的手机号'
         ),
         'a_telephone'=>array(
             'rule'=>'/^(\d{3}-|\d{4}-)?(\d{8}|\d{7})?$/',
             'allowEmpty'=>true,
             'message'=>'请填写正确的电话号码'
         ),
         'a_faxaphone'=>array(
             'rule'=>'/^(\d{3}-|\d{4}-)?(\d{8}|\d{7})?$/',
             'allowEmpty'=>true,
             'message'=>'请填写正确的传真号码'
         ),
         'a_qq'=>array(
             'rule'=>'/[1-9][0-9]{4,10}/',
             'allowEmpty'=>true,
             'message'=>'请填写正确的QQ'
         ),
         'a_email'=>array(
             'rule'    => '/^[\w\d]+[\w\d-.]*@[\w\d-.]+\.[\w\d]{2,10}$/i',
             'allowEmpty'=>true,
             'message' => '请填写正确的邮箱'
         )
         );
     
 }
?>
