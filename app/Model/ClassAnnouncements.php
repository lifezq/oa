<?php

/**
 * @filename ClassAnnouncements.php
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-8-30  17:28:30
 * @version 1.0
 * Description of ClassAnnouncements
 */
class ClassAnnouncements extends AppModel{
    //put your code here
    public $name = 'ClassAnnouncements';
    public $primaryKey = false;

//    public $belongsTo = array(
//           'UserAnnouncements'=>array(
//               'classname'=>'UserAnnouncements',
//               'foreignKey' => 'a_id',
//               'conditions'=>array('UserAnnouncements.hide'=>0),
////               'type'=>'inner'
//           )
//    );
//     public $belongsTo = array(
//        'Announcement' => array(
//            'className' => 'Announcement',
//             'fields'=>array('distinct (Announcement.a_id)'),
//            'unique'=>true,
//            'type'=>'inner',
//            'foreignKey' => 'a_id'
//        ),
//         'ClassPosts'=>array(
//             'className' => 'ClassPosts',
//             'type'=>'inner',
//             'foreignKey' => 'cp_id'
//         ),
//         'UserAnnouncements'=>array(
//             'className' => 'UserAnnouncements',
//             'type'=>'inner',
//             'conditions'=>array('UserAnnouncements.hide'=>0),
//            'foreignKey' => 'a_id'
//         )
//    );
}

?>
