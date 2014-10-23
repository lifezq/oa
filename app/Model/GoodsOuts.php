<?php

/**
 * @filename GoodsOuts.php
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-9-6  17:31:41
 * @version 1.0
 * Description of GoodsOuts
 */
class GoodsOuts extends AppModel{
    
    public $name = 'GoodsOuts';
    public $primaryKey = 'go_id';
    public $validate = array(
      'go_numbers'=>  array(
          'rule'=>'/\d+/',
          'allowEmpty'=>false,
          'required'=>true,
          'message'=>'出库数量有误'
      )
    );
    public $hasOne = array(
        'GoodsManages'=>array(
            'className'=>'GoodsManages',
            'foreignKey'=>'gm_id',
            'type'=>'inner',
            'fields'=>'GoodsManages.gm_goods_name'
        ),
        'User'=>array(
            'className'=>'User',
            'foreignKey'=>'u_id',
            'type'=>'inner',
            'fields'=>'User.u_true_name'
        )
    );
}

?>
