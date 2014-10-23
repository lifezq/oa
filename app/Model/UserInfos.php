<?php

/**
 * @filename UserInfos.php
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-9-16  9:53:01
 * @version 1.0
 * Description of UserInfos
 */
app::uses('AppModel','Model');
class UserInfos extends AppModel{
    
    public $name = 'UserInfos';
    public $primaryKey = 'u_id';
    
}

?>
