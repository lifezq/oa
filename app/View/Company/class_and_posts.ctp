<!--**
 * @author 杨乾磊
 * @email  lifezqy@126.com
 * @link   http://blog.lifezq.com
 * @copyright (c) 2012-2013
 * @license http://www.gnu.org/licenses/
 * @version 1.0
 *-->
<div class="div_main">
<?php echo $this->Html->link('【创建公司结构】',array('controller'=>'Company','action'=>'createStructure')).'&nbsp;'.$this->Html->link('【公司信息】',array('controller'=>'Company','action'=>'companyInfo'));?>
<?php if($this->request->params['action'] == 'createStructure'):?>
<table>
<?php 
echo $this->Form->create('ClassPosts',array('url'=>array('controller'=>'Company','action'=>'createStructure/'.($_Class['cp_id']?'modify/'.$_Class['cp_id']:''),'plugin'=>false)));
echo $this->Html->tableCells(
array(
   array(array('创建公司部门 &gt;&gt;',array('bgcolor'=>'#F0F0F0','colspan'=>3))),
   array(array('部门名称',array('align'=>'right','width'=>85)),array($this->Form->input('cp_name',array('div'=>false,'label'=>false,'class'=>'_input','value'=>$_Class['cp_name'])),array('width'=>160)),array('例如：管理部/技术部/接待部/企划部等等',array('style'=>'color:#ccc'))),
   array(array('部门描述',array('align'=>'right','width'=>85)),array($this->Form->textarea('cp_description',array('div'=>false,'label'=>false,'class'=>'_input2','value'=>$_Class['cp_description'])),array('width'=>160)),array('相关详细描述信息说明',array('style'=>'color:#ccc'))),
   array(array($this->Form->input('cp_type',array('type'=>'hidden','value'=>0)),array('align'=>'right','width'=>85)),array($this->Form->end(array('class'=>'_button','label'=>$_Class['cp_id']?'修改部门':'创建部门')),array('width'=>160)),'&nbsp;'),
)); ?>
</table>
<table>
<?php 
echo $this->Form->create('ClassPosts',array('url'=>array('controller'=>'Company','action'=>'createStructure/'.($_Posts['cp_id']?'modify/'.$_Posts['cp_id']:''),'plugin'=>false)));
echo $this->Html->tableCells(
array(
   array(array('创建公司职位 &gt;&gt;',array('bgcolor'=>'#F0F0F0','colspan'=>3))),
   array(array('职位名称',array('align'=>'right','width'=>85)),array($this->Form->input('cp_name',array('div'=>false,'label'=>false,'class'=>'_input','value'=>$_Posts['cp_name'])),array('width'=>160)),array('例如：总经理/技术部员工/技术部经理/前台接待等等',array('style'=>'color:#ccc'))),
   array(array('职位描述',array('align'=>'right','width'=>85)),array($this->Form->textarea('cp_description',array('div'=>false,'label'=>false,'class'=>'_input2','value'=>$_Posts['cp_description'])),array('width'=>160)),array('相关详细描述信息说明',array('style'=>'color:#ccc'))),
   array(array($this->Form->input('cp_type',array('type'=>'hidden','value'=>1)),array('align'=>'right','width'=>85)),array($this->Form->end(array('class'=>'_button','label'=>$_Posts['cp_id']?'修改职位':'创建职位')),array('width'=>160)),'&nbsp;'),
)); ?>
</table>
<?php else: ?>
<?php echo $this->Form->create('classPosts',array('url'=>array('controller'=>'Company','plugin'=>false))); ?>
<h3>部门信息</h3>
<table>
 <?php echo $this->Html->tableHeaders(array('排序','编号','部门','部门人数','状态','成立时间','操作'),array(),array('align'=>'center')); 
       foreach($_Class as $v):
       echo $this->Html->tableCells(array(
            array(array($this->Form->input('cp_order',array('div'=>false,'name'=>'cp_order['.$v['cp_id'].']','label'=>false,'class'=>'_input','value'=>$v['cp_order'],'size'=>5,'style'=>'width:50px')),array('width'=>50)),$v['cp_id'],$v['cp_name'],$v['cp_members'],$v['cp_status'],date('Y/m/d',$v['created']),$this->Html->link('【修改】','createStructure/modify/'.$v['cp_id']).'|'.$this->Html->link('【删除】','createStructure/del/'.$v['cp_id'],null,'确认要删除吗?')),
));
endforeach;
?>
        </table>
<h3>职位信息</h3>
<table>
 <?php echo $this->Html->tableHeaders(array('排序','编号','职位','职位人数','状态','成立时间','操作'),array(),array('align'=>'center')); 
foreach($_Posts as $v):
       echo $this->Html->tableCells(array(
            array(array($this->Form->input('cp_order',array('div'=>false,'name'=>'cp_order['.$v['cp_id'].']','label'=>false,'class'=>'_input','value'=>$v['cp_order'],'size'=>5,'style'=>'width:50px')),array('width'=>50)),$v['cp_id'],$v['cp_name'],$v['cp_members'],$v['cp_status'],date('Y/m/d',$v['created']),$this->Html->link('【修改】','createStructure/modify/'.$v['cp_id']).'|'.$this->Html->link('【删除】','createStructure/del/'.$v['cp_id'],null,'确认要删除吗?')),
));
endforeach;
?>
        </table>
<?php echo $this->Form->end(array('label'=>'【排 序】','class'=>'_button'));?>
<?php endif; ?>
</div>