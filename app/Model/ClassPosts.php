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
class classPosts extends AppModel{
    //put your code here
    public $name='class_posts';
    public $primaryKey='cp_id';
    public $validate=array(
        'cp_name'=>array('allowEmpty'=>false)
    );
}

?>
