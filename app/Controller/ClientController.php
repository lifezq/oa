<?php
/**
 * @filename ClientController.php
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-9-30  9:34:32
 * @version 1.0
 * Description of ClientController
 */

app::uses('AppController','Controller');
class ClientController extends AppController{
    
    
    public $uses = array('Client','ClientInfo');
    public $_set = array();
    public function clientManage(){
        
        if(empty($this->request['pass']) && empty($this->request['named'])){
            $this->Paginator->settings = array(
              'Client'=>array(
                  'limit'=>10,
                  'maxLimit'=>10,
                  'conditions'=>array('Client.c_uid'=>$this->onLineUser['u_id'])
              )  
            );
            $this->_set['clientList'] = $this->Paginator->paginate('Client');
           
        }elseif($this->request['pass']){
            if($this->request['pass'][0] == 'add'){ //新建客户
                if($this->request->is('post')){
                    $this->Client->save($this->request->data);
                    $this->request->data['Client']['c_id'] = $this->Client->getInsertID();
                    if($this->request->data['Client']['c_id']){
                        $this->request->data['ClientInfo'] = $this->request->data['Client'];
                        unset($this->request->data['Client']);
                        if($this->ClientInfo->save($this->request->data)){
                             $this->Session->setFlash($this->_L('add_success'));
                             $this->redirect(array('controller'=>'Client','action'=>'clientManage'));
                        }else{
                            $this->Client->delete($this->request->data['ClientInfo']['c_id']);
                            $msg = $this->_L('add_failed');
                        }
                    }else{
                        $msg = $this->_L('add_failed'); 
                    }
                    $this->Session->setFlash($msg);
                }
                $this->_set['_position'] = $this->_L('add_client');
            }
        }elseif($this->request['named']){
            
        }
        $this->set($this->_set);
    }
}
?>
