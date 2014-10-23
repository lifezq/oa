<?php

/**
 * @filename Announcement.php
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-8-30  17:01:52
 * @version 1.0
 * Description of Announcement
 */
class Announcement extends AppModel{
    //put your code here
    public $name = 'Announcement';
    public $primaryKey = 'a_id';
    public $useTable = 'announcement';
    public $validate = array(
        'a_title'=>array(
            'rule'=>array('minLength',5),
            'message'=>'公告标题不得少于5个字符'
        ),
        'a_content'=>array(
            'rule'=>array('minLength',10),
            'message'=>'公告内容不得少于10个字符'
        )
    );
//     public $hasOne = array(
//        'ClassAnnouncements' => array(
//            'className' => 'ClassAnnouncements',
//            'type'=>'inner',
//            'foreignKey' => 'a_id'
//        ),
//         'UserAnnouncements'=>array(
//             'className' => 'UserAnnouncements',
//             'type'=>'inner',
//             'conditions'=>array('UserAnnouncements.hide'=>0),
//            'foreignKey' => 'a_id'
//         )
//         
//    );
    public $hasAndBelongsToMany = array(
           'ClassPosts'=>array(
               'classname'=>'ClassPosts',
               'joinTable' => 'class_announcement',
                'foreignKey' => 'a_id',
               'associationForeignKey' => 'cp_id',
               'unique' => false,
                'fields' => array('ClassPosts.cp_id','ClassPosts.cp_name'),
                'order' => '',
                'limit' => '',
                'offset' => '',
                'finderQuery' => '',
                'with' => 'ClassAnnouncements',
                'dependent' => true
           )
    );
  
}

?>
