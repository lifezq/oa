<?php

/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

    public function beforeDelete($cascade = true) {
        if (!$this->checkDel()) {
            return false;
        }
        return true;
    }

    /*
     * 检查用户是否直接从浏览器地址输入删除，如果这样就不允许删除操作，只能从页面点击删除
     */

    public function checkDel() {
        return strpos($_SERVER['HTTP_REFERER'], substr(Configure::read('ROOT'), 7));
    }
    public function beforeSave($options = Array()) { 
         $this->data = $this->_daddslashes($this->data,false);//保存数据前转义数据
     }

    public function _daddslashes($string,$stripTag=false){
           if(is_array($string)) { 
              foreach($string as $key => $val) {       
                      $string[$key] = $this->_daddslashes($val,$stripTag);
                  } 
                 } else { 
                          if($stripTag)
                          $string = htmlspecialchars(addslashes($string));
                          else
                          $string = addslashes($string); 
                 } 
             return $string; 
       }

}
