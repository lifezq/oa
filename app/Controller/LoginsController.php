<?php

/**
 * @filename EmailController.php
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-8-16  20:20:26
 * @version 1.0
 * Description of EmailController
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
class LoginsController extends Controller {

    public $components = array('Auth'=>array(
         'loginAction' => array(
            'controller' => 'Logins',
            'action' => 'login',
             'plugin' => null
            
        )
     ), 'Session' );
    public $layout = 'login';
    public $uses = 'User';
    public $helpers = array('Html', 'Form');
    public $plugin = '';

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allowedActions = array('showCode');
    }

    public function login() {
        
        if ($this->request->is('post')) {
            if(strtoupper($this->request->data['User']['verify']) != $this->Session->read('verify')){//验证码是否相等
                $this->Session->setFlash('验证码错误');
                $this->redirect('login');
            }elseif($this->Auth->login()) {
                $onLineUser = $this->Session->read('Auth.User'); //读取在线用户信息
                if($onLineUser['u_is_close'] == 1 || $onLineUser['u_is_close'] == 2){
                    $this->Session->setFlash('无法登入系统,您的帐号已经被管理员禁用了');
                    $this->logout();
                }
                return $this->redirect('/');
            } else {
//                $this->Session->setFlash(__('用户名或密码错误'), 'default', array(), 'auth');
                $this->Session->setFlash('用户名或密码错误');
            }
        }
    }
    public function logout() {
        $this->redirect($this->Auth->logout());
        }
    public function showCode() {
        require_once '../Lib/Authnum.class.php';

        $authnum = new Authnum();
        $authnum->create();
        $this->Session->write('verify',strtoupper($authnum->randnum));
        exit();
    }

}
