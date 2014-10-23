<?php

/**
 * @filename GoodsTypes.php
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-9-6  14:30:08
 * @version 1.0
 * Description of GoodsTypes
 */
class GoodsTypes extends AppModel{
    
    public $name = 'GoodsTypes';
    public $primaryKey = 'gt_id';
    public $validate = array(
      'gt_name'  =>array(
          'rule'=>array('minLength',2),
          'allowEmpty' => false,
          'required'=>true,
          'message' => '物品分类名称不能为空,且不能少于两个字符'
      )
    );
}

?>
