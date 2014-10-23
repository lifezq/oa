<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $components = array('Auth' => array(
            'loginAction' => array(
                'controller' => 'Logins',
                'action' => 'login',
                'plugin' => null
            )
        ), 'Session','Paginator');

    public $helpers = array('Html','Form','Paginator');
    public $layout = 'oa_main';
     public $plugin = false;
     public $uses = array('Group','Navigation');
    public function beforeFilter() {
        $this->Auth->authorize = array('Controller');
        $this->Auth->authenticate = array(
            'all' => array(
                'scope' => array('User.u_is_close' => 0)
            ),
            'Form'
        );
        $this->_L(); //初始化加载语言包
        $this->onLineUser = $this->Session->read('Auth.User'); //读取在线用户信息
    }

    public function isAuthorized($user) {
//        if ($this->params['prefix'] === 'admin' && $user['u_is_close']) {
        if ($user['u_is_close']) {
            return false;
        }
        return true;
    }

    public function _L($name = null, $value = null) {
        static $languge = array();
        if (is_null($name)) {
            if (!defined('LOAD_LANGUAGE'))
                define('LOAD_LANGUAGE', true);
            $languge = include_once str_replace('Controller', '', __DIR__) . 'Config/lang/zh.php';
            return $languge;
        }

        if (is_string($name)) {
            $name = strtolower($name);
            if (!strstr($name, '.')) {
                if (is_null($value))
                    return isset($languge [$name]) ? $languge [$name] : null;
                $languge [$name] = $value;
                return $languge[$name];
            }
//二维数组
            $name = $this->array_change_key_case_d(explode(".", $name), 0);

            if (is_null($value)) {
                return isset($languge [$name[0]] [$name[1]]) ? $languge [$name[0]][$name[1]] : null;
            }
            $languge [$name[0]] [$name[1]] = $value;
        }
        if (is_array($name)) {
            $languge = array_merge($languge, $this->array_change_key_case_d($name));
            return true;
        }
    }

    /**
     * 将数组键名变成大写或小写
     * @param type $arr
     * @param int   $type   转为大小写方式    1大写   0小写
     */
    public function array_change_key_case_d($arr, $type = 0) {
        $function = $type ? 'strtoupper' : 'strtolower';
        $newArr = array(); //格式化后的数组
        if (!is_array($arr) || empty($arr))
            return $newArr;
        foreach ($arr as $k => $v) {
            $k = $function($k);
            if (is_array($v)) {
                $newArr[$k] = $this->array_change_key_case_d($v, $type);
            } else {
                $newArr[$k] = $v;
            }
        }
        return $newArr;
    }
   /*
     * 读取导航列表
     */
     public function getNavList() {
        //找出所有启用用户组,组合到导航可访问用户组
        $groups = $this->Group->find('all',array('conditions'=>array('Group.g_status'=>1),'fields'=>array('g_id','g_name')));
        $newGroups =  array();
        foreach($groups as $v){
            $newGroups[$v['Group']['g_id']] = $v['Group']['g_name'];
        }
        
        $navList = $this->Navigation->find('all',array('fields'=>array("concat(Navigation.n_path,'_',Navigation.n_id) as pi",'n_id','n_pid','n_name','n_permission','n_link'),'order'=>'pi asc'));
        $navListArr = array();
        foreach($navList as $v){
            unset($v[0]);
            $permission = explode(',',$v['Navigation']['n_permission']);
            if($permission){
                foreach($permission as $m){
                    $v['Navigation']['accessGroup'][] = $newGroups[$m]; //可访问的用户组名称
                    $v['Navigation']['accessGid'][] = $m; //可访问的用户组ID
                }
            }
            $navListArr[] = $v;
        }
        return $navListArr;
    }
    
}
