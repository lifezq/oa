<?php

/**
 * @filename MeetingRooms.php
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-9-10  17:26:32
 * @version 1.0
 * Description of MeetingRooms
 */
class MeetingRooms extends AppModel{
    
    public $name = 'MeetingRooms';
    public $primaryKey = 'mr_id';
    public $validate = array(
      'mr_room'  =>array(
          'rule'=>array('minLength',2),
          'required'=>false,
          'message'=>'会议室名称不能小于两个字符'
      ),
      'mr_person_num'=>array(
          'rule'  =>'/^\d+$/',
          'required'=>false,
          'message'=>'会议室可容纳人数有误'
      ),
      'u_order_time'=>array(
          'rule'  =>'notEmpty',
          'required'=>false,
          'message'=>'开始时间不能为空'
      ),
        'u_order_end_time'=>array(
          'rule'  =>'notEmpty',
          'required'=>false,
          'message'=>'结束时间不能为空'
      ),
    );
}

?>
