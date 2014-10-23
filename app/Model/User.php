<?php

/**
 * @filename Users.php
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-8-15  10:44:31
 * @version 1.0
 * Description of Users
 */
class User  extends AppModel{
    //put your code here

    public $components = array('Auth', 'Session' );
    public $primaryKey='u_id';
    public $name = 'User';

    public $validate=array(
        'u_username'=>array(
             'rule'    => '/^[a-zA-Z][a-zA-Z0-9_]{4,15}$/i',
             'allowEmpty' => false,
             'required'=>true,
            
             'message' => '必须以字母开头，只能包含字母，数字，下划线，长度在5-16个字符'
        ),
        'u_password'=>array(
             'rule'    => '/^[\\~!@#$%^&*()-_=+|{}\[\],.?\/:;\'\"\d\w]{6,18}$/',
            'on'=>'create',
             'message' => '密码必须以字母开头，长度在6-18个字符'
        ),
        'u_password2'=>array(
             'rule'    => '/^[\\~!@#$%^&*()-_=+|{}\[\],.?\/:;\'\"\d\w]{6,18}$/',
             'allowEmpty' => false,
              'on'=>'create',
             'message' => '必须以字母开头，长度在6-18个字符'
        ),
        'u_true_name' => array(
            'rule'    => '/^[_\x{4e00}-\x{9fa5}\d]{2,4}$/iu',
            'message' => '必须是中文字符，长度在2-4个字符'
        ),
        'u_mobile' => array(
            'rule'    => '/^[(86)|0]?(13\d{9})|(15\d{9})|(18\d{9})$/',
            'message' => '请填写正确的手机号'
        ),
        'u_email' => array(
            'rule'    => '/^[\w\d]+[\w\d-.]*@[\w\d-.]+\.[\w\d]{2,10}$/i',
            'message' => '请填写正确的邮箱'
        ),
        'u_company_email' => array(
            'rule'    => '/^[\w\d]+[\w\d-.]*@[\w\d-.]+\.[\w\d]{2,10}$/i',
            'message' => '请填写正确的邮箱'
        ),
        'u_age' => array(
            'rule'    => '/^1?\d{1,2}$/',
            'message' => '请输入正确的年龄'
        ),
        'u_posts_id' => array(
            'rule'    => 'notempty',
            'message' => '请选择职位'
        ),
        'u_class_id' => array(
            'rule'    => 'notempty',
            'message' => '请选择部门'
        ),
        'u_cabinet_size' => array(
            'rule'    => '/^\d+$/',
            'message' => '请填入正确的文件柜大小'
        )
    );
     public function passCompare() {   
         return ($this->data[$this->alias]['u_password'] === $this->data[$this->alias]['u_password2']);       
         }      
     public function beforeSave($options = Array()) {  
         parent::beforeSave($options = Array());
         if (!$this->id)
         $this->data['User']['u_password'] = AuthComponent::password($this->data['User']['u_password']);      
         return true;   
         }
}

?>
