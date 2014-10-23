<?php

/**
 * @filename Client.php
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-9-30  10:10:17
 * @version 1.0
 * Description of Client
 */
class Client extends AppModel{
    
    public $name = 'Client';
    public $primaryKey = 'c_id';
    public $hasOne = array(
      'ClientInfo'=>array(
          'className'=>'ClientInfo',
          'type'=>'inner',
          'foreignKey'=>'c_id'
      )  
    );
}

?>
