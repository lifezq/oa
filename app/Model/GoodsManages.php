<?php

/**
 * @filename GoodsManages.php
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-9-6  11:16:16
 * @version 1.0
 * Description of GoodsManages
 */
class GoodsManages extends AppModel{
    
    public $name = 'GoodsManages';
    public $primaryKey = 'gm_id';
    public $validate = array(
      'gm_goods_name'  =>array(
          'rule'=>'notEmpty',
          'allowEmpty' => false,
          'required'=>true,
          'message' => '物品名称不能为空'
      ),
      'gm_price'  =>array(
          'rule'=>'/^\d+\.?\d{0,2}$/',
          'allowEmpty' => false,
          'required'=>true,
          'message' => '物品单价出错，最多只能包含两位小数'
      ),
        'gm_remain'  =>array(
          'rule'=>'/^\d+$/',
          'allowEmpty' => false,
          'required'=>true,
          'message' => '入库数量不能为空，并且只能为数字'
      ),
    );
    public $hasOne = array(
         'GoodsTypes'  =>array(
             'className'=>'GoodsTypes',
             'foreignKey'=>'gt_id',
             'fields'=>'GoodsTypes.gt_name'
         )
    );
}

?>
