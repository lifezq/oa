<?php

/**
 * @filename Meeting.php
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-9-12  13:43:20
 * @version 1.0
 * Description of Meeting
 */
class Meeting extends AppModel{
    
    public $name = 'Meeting';
    public $primaryKey = 'm_id';
    public $validate = array(
        'm_subject'=>array(
            'rule'=>array('minLength',4),
            'required'=>true,
            'message'=>'会议主题不能少于4个字符'
        ),
        'm_meet_time'=>array(
            'rule'=>'notEmpty',
            'required'=>true,
            'message'=>'会议开始时间不能为空'
        ),
        'your_choice'=>array(
            'rule'=>'notEmpty',
            'required'=>true,
            'message'=>'会议参加者为必须项'
        )
    );
    public $belongsTo = array(
      'User'  =>array(
          'className'=>'User',
          'foreignKey'=>'u_id',
          'type'=>'inner',
          'fields'=>'User.u_true_name'
      ),
      'MeetingRooms'=>array(
          'className'=>'MeetingRooms',
          'foreignKey'=>'mr_id',
          'type'=>'inner',
          'fields'=>array('MeetingRooms.mr_room','MeetingRooms.mr_person_num','MeetingRooms.mr_clean','MeetingRooms.u_order_time','MeetingRooms.u_order_end_time')
      )
    );
}

?>
