<?php
/**
 * @filename Sms.php
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-8-29  14:32:00
 * @version 1.0
 */
class Sms extends AppModel{
    public $name = 'Sms';
    public $primaryKey = 's_id';
    public $useTable = 'sms';
//    public $validate = array(
//           's_receivers'  =>array(
//               'rule'=>'notEmpty',
//               'allowEmpty' => false,
//               'required'=>false,
//               'message'=>'接收人不能为空'
//           ),
//           's_message'=>array(
//               'rule'=>array('minLength',5),
//               'required'=>false,
//               'message'=>'内容不能少于5个字符'
//           )
//    );
    
}

?>