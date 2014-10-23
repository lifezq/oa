<?php

/**
 * @filename Assignment.php
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-9-22  11:07:20
 * @version 1.0
 * Description of Assignment
 */

class Assignment extends AppModel{
    
    public $name = 'Assignment';
    public $primaryKey = 'a_id';
    public $validate = array(
        'a_use_time'=>array(
            'rule'=>'/^\d(\.\d{1,2})?$/',
            'required'=>false,
            'message'=>'请输入正确的计划用时数'
        ),
        'a_users'=>array(
            'rule'=>'notEmpty',
            'required'=>false,
            'message'=>'请选择至少一个接收任务的员工'
        ),
        'a_task'=>array(
            'rule'=>'notEmpty',
            'required'=>false,
            'message'=>'任务描述不能为空'
        ),
    );
    
}

?>
