<!--**
 * @filename navigation_manage.ctp
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-8-28  10:14:37
 * @version 1.0
 *-->
<div class="div_main">
    <?php echo $this->Html->link('【添加导航】',array('controller'=>'System','action'=>'navigationManage/add/0')).'&nbsp;'.$this->Html->link('【导航列表】',array('controller'=>'System','action'=>'navigationManage'));
    if(!$create):
?>
<table>
<?php 
          echo $this->Html->tableHeaders(array('编号','导航名称','导航链接','导航访问用户组','操作'),array(),array('class'=>'table_th'));

          foreach($nav_list as $v){
          $_accessGroup = '';

          foreach($v['Navigation']['accessGroup'] as $m){

          $_accessGroup .= $m.'|';
}
$_accessGroup = rtrim($_accessGroup,'|');
          echo $this->Html->tableCells(array(
               array(array($v['Navigation']['n_id'],array('align'=>'left','width'=>30)),array($v['Navigation']['n_name'],array('align'=>'left','width'=>150)),array($v['Navigation']['n_link'],array('align'=>'left','width'=>150)),array($_accessGroup,array('align'=>'left')),array($this->Html->link('【添加子导航】',array('controller'=>'System','action'=>'navigationManage/add/'.$v['Navigation']['n_id']),array('title'=>'添加子导航')).'|'.$this->Html->link('【编辑】',array('controller'=>'System','action'=>'navigationManage/edit/'.$v['Navigation']['n_id']),array('title'=>'编辑')).'|'.$this->Html->link('【删除】',array('controller'=>'System','action'=>'navigationManage/del/'.$v['Navigation']['n_id']),array('title'=>'删除'),'确认要删除吗?'),array('align'=>'left'))),
));
}
?>
</table>
<?php
else:
?>
<table>
<?php
$_groupList = '';
if(count($groupList)):

$NPerArr = explode(',',$Navigation[0]['Navigation']['n_permission']);

foreach($groupList as $v){
if(in_array($v['Group']['g_id'],$NPerArr))
   $_groupList .= $this->Form->checkbox('n_permission',array('name'=>'n_permission[]','hiddenField' => false,'value'=>$v['Group']['g_id'],'checked'=>true)).'&nbsp;'.$v['Group']['g_name'];
else
$_groupList .= $this->Form->checkbox('n_permission',array('name'=>'n_permission[]','hiddenField' => false,'value'=>$v['Group']['g_id'])).'&nbsp;'.$v['Group']['g_name'];
}
else:
$_groupList = "请先创建用户组从而分配权限";
endif;
     echo $this->Form->create('Navigation',array('type'=>'post','url'=>array('controller'=>'System','action'=>'navigationManage'),'plugin'=>false));
     echo $this->Html->tableCells(array(
          array(array('导航名称',array('align'=>'right','width'=>110)),array($this->Form->input('n_name',array('div'=>false,'label'=>false,'class'=>'_input','value'=>$Navigation[0]['Navigation']['n_name'])),array('align'=>'left'))),
          array(array('所属上级导航',array('align'=>'right')),array($this->Form->select('n_pid',array($navList),array('div'=>false,'label'=>false,'empty'=>false,'class'=>'_input','default'=>$_pid)).'&nbsp;<font color=#ccc>如果没有父级，那么就为顶级导航</font>',array('align'=>'left'))),
          array(array('导航链接',array('align'=>'right')),array($this->Form->input('n_link',array('div'=>false,'label'=>false,'class'=>'_input','value'=>$Navigation[0]['Navigation']['n_link']))."&nbsp; <font color=#ccc>请正确填写导航链接，否则将导致无法正确链接导航地址</font>",array('align'=>'left'))),
          array(array('用户组访问权限',array('align'=>'right')),array($_groupList."&nbsp; <font color=#ccc>选择可以访问的用户组，选择后只有该用户组成员可以访问该导航</font>",array('align'=>'left'))),
          array(array($this->Form->hidden('n_id',array('value'=>$Navigation[0]['Navigation']['n_id'])),array('align'=>'right')),array($this->Form->end(array('div'=>false,'label'=>$Navigation[0]['Navigation']['n_id']?'修 改':'添 加','class'=>'_button')))),
));
endif;
?>
</table>
</div>
