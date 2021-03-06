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
class Group extends AppModel{
    //put your code here
    public $name='Group';
    public $primaryKey = 'g_id';
    public $useTable='group';

    public $validate =  array(
        'g_name'=>array(
            'rule'=>'notEmpty',
            'message'=>'用户组名称不能为空'
        )
    );
}

?>
