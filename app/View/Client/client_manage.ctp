<!--**
 * @filename clients_manage.ctp
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-9-30  9:42:42
 * @version 1.0 
 *-->
<div class="div_main">
<?php
        if(empty($this->request['pass']) && empty($this->request['named'])){
            echo $this->Html->link('添加客户',array('controller'=>'Client','action'=>'clientManage/add'),array('title'=>'添加客户')).'&nbsp;'.$this->Html->link('管理客户列表',array('controller'=>'Client','action'=>'clientManage'),array('title'=>'管理客户列表'));
            echo '<table>';
            echo $this->Html->tableHeaders(array('编号','客户姓名','手机号码','客户热度','客户种类','客户阶段','客户状态','操作'),array(),array('class'=>'table_th'));
            $ClientArr = array();
            foreach($clientList as $v):
              $ClientArr[] = array(array($v['Client']['c_id']),array($v['Client']['c_name']),array($v['Client']['c_mobile']),array($v['Client']['c_hot']),array($v['Client']['c_type']),array($v['Client']['c_stage']),array($v['Client']['c_status']),array(''));
            endforeach;
            echo $this->Html->tableCells($ClientArr);
            echo '</table>';
        }elseif($this->request['pass']){
            if($this->request['pass'][0] == 'add'){ //新建客户
               echo $this->Form->create('Client',array('url'=>array('controller'=>'Client','action'=>'clientManage/add')));
               echo '<table>';
               echo $this->Html->tableCells(array(
                    array(array($this->Form->input('c_name',array('div'=>false,'label'=>'客户姓名 ','class'=>'_input')))),
                    array(array($this->Form->input('c_mobile',array('div'=>false,'label'=>'客户手机 ','class'=>'_input')))),
                    array(array('是否为热点客户 '.$this->Form->radio('c_important',array('1'=>'是 ','2'=>'否'),array('div'=>false,'legend'=>false,'value'=>0,'hiddenfields'=>false)))),
                    array(array('客户热度 '.$this->Form->radio('c_hot',array('3'=>'低热 ','2'=>'中热 ','1'=>'高热 '),array('div'=>false,'legend'=>false,'value'=>0,'hiddenfields'=>false)))),
                    array(array('<strong>客户资料</strong>',array('class'=>'table_th'))),
                    array(array('客户性别 '.$this->Form->radio('c_sex',array('1'=>'男 ','2'=>'女 '),array('div'=>false,'legend'=>false,'value'=>1,'hiddenfields'=>false)))),
                    array(array('客户种类 '.$this->Form->select('c_type',array('0'=>'--请选择客户种类--','5'=>'潜在客户','4'=>'普通客户','3'=>'VIP客户','2'=>'合作伙伴','1'=>'失效客户'),array('div'=>false,'default'=>'0','empty'=>false,'class'=>'_input')))),
                    array(array('客户阶段 '.$this->Form->select('c_stage',array('0'=>'--客户所在阶段--','4'=>'售前跟踪','3'=>'合同执行','2'=>'售后服务','1'=>'合同期满'),array('div'=>false,'default'=>'0','empty'=>false,'class'=>'_input')))),
                    array(array('客户状态 '.$this->Form->select('c_status',array('0'=>'--请选择客户状态--','1'=>'已沟通','2'=>'已报价','3'=>'已做方案','4'=>'已签合同','5'=>'已成交'),array('div'=>false,'default'=>'0','empty'=>false,'class'=>'_input')))),
                    array(array('<strong>详细资料</strong>',array('class'=>'table_th'))),
                    array(array($this->Form->input('c_telephone',array('div'=>false,'label'=>'固定电话 ','class'=>'_input')))),
                    array(array($this->Form->input('c_email',array('div'=>false,'label'=>'邮箱地址 ','class'=>'_input')))),
                    array(array($this->Form->input('c_faxaphone',array('div'=>false,'label'=>'传真电话 ','class'=>'_input')))),
                    array(array($this->Form->input('c_qq',array('div'=>false,'label'=>'QQ号码 ','class'=>'_input')))),
                    array(array($this->Form->input('c_postcode',array('div'=>false,'label'=>'邮政编码 ','class'=>'_input')))),
                    array(array($this->Form->input('c_address',array('div'=>false,'label'=>'家庭住址 ','class'=>'_input')))),
                    array(array('<strong>公司信息</strong>',array('class'=>'table_th'))),
                    array(array($this->Form->input('ci_company',array('div'=>false,'label'=>'所在公司 ','class'=>'_input')))),
                    array(array($this->Form->input('ci_company_address',array('div'=>false,'label'=>'公司地址 ','class'=>'_input')))),
                    array(array($this->Form->input('ci_profession',array('div'=>false,'label'=>'负责业务 ','class'=>'_input')))),
                    array(array($this->Form->input('ci_nickname',array('div'=>false,'label'=>'公司称谓 ','class'=>'_input')))),
                    array(array($this->Form->input('ci_hold_posts',array('div'=>false,'label'=>'担任职务 ','class'=>'_input')))),
                    array(array('<strong>客户分析</strong>',array('class'=>'table_th'))),
                    array(array('客户来源 '.$this->Form->radio('ci_source',array('1'=>'电话咨询 ','2'=>'网站咨询 ','3'=>'上门来访 ','4'=>'好友介绍 '),array('div'=>false,'legend'=>false,'value'=>1,'hiddenfields'=>false)))),
                    array(array('信用等级 '.$this->Form->radio('ci_credit_level',array('1'=>'高 ','2'=>'中 ','3'=>'低 '),array('div'=>false,'legend'=>false,'value'=>1,'hiddenfields'=>false)))),
                    array(array('关系等级 '.$this->Form->radio('ci_relation_level',array('1'=>'密切 ','2'=>'较好 ','3'=>'一般 ','4'=>'较差 '),array('div'=>false,'legend'=>false,'value'=>1,'hiddenfields'=>false)))),
                    array(array('客户价值 '.$this->Form->radio('ci_client_worth',array('1'=>'高 ','2'=>'中 ','3'=>'低 '),array('div'=>false,'legend'=>false,'value'=>1,'hiddenfields'=>false)))),
                    array(array('<strong>联系人分类</strong>',array('class'=>'table_th'))),
                    array(array('联系人分类 '.$this->Form->select('ci_important',array('0'=>'--请选择联系人分类--','1'=>'特别重要','2'=>'重要','3'=>'普通','4'=>'不重要','5'=>'失效'),array('div'=>false,'default'=>'0','empty'=>false,'class'=>'_input')))),
                    array(array('证件类型 '.$this->Form->select('ci_certificate_type',array('0'=>'--请选择证件类型--','1'=>'身份证','2'=>'驾驶证','3'=>'军官证'),array('div'=>false,'default'=>'0','empty'=>false,'class'=>'_input')))),
                    array(array($this->Form->input('ci_certificate_number',array('div'=>false,'label'=>'证件号码 ','class'=>'_input')))),
                    array(array('客户备注<br/> '.$this->Form->textarea('ci_remark',array('div'=>false,'class'=>'_input2')))),
                    array(array($this->Form->end(array('div'=>false,'label'=>'确认添加 ','class'=>'_button')))),
 
));
               echo '</table>';
            }
        }elseif($this->request['named']){
        }
?>
</div>