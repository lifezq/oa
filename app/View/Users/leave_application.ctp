<!--**
 * @filename leave_applications.ctp
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-9-3  14:36:09
 * @version 1.0
 *-->
<div class="div_main">
<?php 
$button = $op_button = '';
if(isset($manageButton)):
$button = $this->Html->link('申请列表管理',array('controller'=>'Users','action'=>'leaveApplication/manage'));
endif;
echo $this->Html->link('填写申请',array('controller'=>'Users','action'=>'leaveApplication/add')).'&nbsp;'.$this->Html->link('我的申请列表',array('controller'=>'Users','action'=>'leaveApplication')).'&nbsp;'.$button; 
echo '<table>';
if((empty($this->request['pass']) || $this->request['pass'][0] == 'manage') && empty($this->request['named'])):

if($this->request['pass'][0] == 'manage'):
echo $this->Html->tableHeaders(array('编号','申请人','申请时间','申请类型','领导是否查看','是否回复','是否批准','操作'),array(),array('class'=>'table_th'));
foreach($leaveList as $v):

if(isset($manageButton)):
$op_button = ($v['LeaveApplications']['la_agree'] == 1)?('|'.$this->Html->link('【不批】',array('controller'=>'Users','action'=>'leaveApplication/refuse:'.$v['LeaveApplications']['la_id']),array('title'=>'点击不批'))):('|'.$this->Html->link('【批准】',array('controller'=>'Users','action'=>'leaveApplication/agree:'.$v['LeaveApplications']['la_id']),array('title'=>'点击批准')));
endif;
        echo $this->Html->tableCells(array(
         array(array($v['LeaveApplications']['la_id'],array('width'=>30)),array($v['LeaveApplications']['la_username'],array('width'=>55)),array(date('Y/m/d H:i:s',$v['LeaveApplications']['created']),array('width'=>145)),array($v['LeaveApplications']['la_type']?'外出':'请假',array('width'=>55)),array($v['LeaveApplications']['la_read']?'<span class=_green>已查看</span>':'<span class=_red>未查看</span>',array('width'=>85)),array(empty($v['LeaveApplications']['la_reply_message'])?'<font  class=_red>未回复</font>':'<font  class=_green>已回复</font>',array('width'=>55)),array(($v['LeaveApplications']['la_agree'] == 1)?'<font  class=_green>已批准</font>':(($v['LeaveApplications']['la_agree'] == -1)?'<font class=_red>未批准</font>':'<font class=_yellow>待审批</font>'),array('width'=>55)),array($this->Html->link('【查看】',array('controller'=>'Users','action'=>'leaveApplication/read:'.$v['LeaveApplications']['la_id'].'/laread:'.$v['LeaveApplications']['la_read']),array('title'=>'查看')).$op_button.'|'.$this->Html->link('【删除】',array('controller'=>'Users','action'=>'leaveApplication/del:'.$v['LeaveApplications']['la_id']),array('title'=>'删除'),'确认要删除？\r\n删除后该申请将失效'),array())),
));
endforeach;
else:
echo $this->Html->tableHeaders(array('编号','申请时间','申请类型','领导是否查看','是否回复','是否批准','操作'),array(),array('class'=>'table_th'));
foreach($leaveList as $v):

if(isset($manageButton)):
$op_button = ($v['LeaveApplications']['la_agree'] == 1)?('|'.$this->Html->link('【不批】',array('controller'=>'Users','action'=>'leaveApplication/refuse:'.$v['LeaveApplications']['la_id']),array('title'=>'点击不批'))):('|'.$this->Html->link('【批准】',array('controller'=>'Users','action'=>'leaveApplication/agree:'.$v['LeaveApplications']['la_id']),array('title'=>'点击批准')));
endif;
        echo $this->Html->tableCells(array(
         array(array($v['LeaveApplications']['la_id'],array('width'=>30)),array(date('Y/m/d H:i:s',$v['LeaveApplications']['created']),array('width'=>145)),array($v['LeaveApplications']['la_type']?'外出':'请假',array('width'=>55)),array($v['LeaveApplications']['la_read']?'<span class=_green>已查看</span>':'<span class=_red>未查看</span>',array('width'=>85)),array(empty($v['LeaveApplications']['la_reply_message'])?'<font  class=_red>未回复</font>':'<font  class=_green>已回复</font>',array('width'=>55)),array(($v['LeaveApplications']['la_agree'] == 1)?'<font  class=_green>已批准</font>':(($v['LeaveApplications']['la_agree'] == -1)?'<font class=_red>未批准</font>':'<font class=_yellow>待审批</font>'),array('width'=>55)),array($this->Html->link('【查看】',array('controller'=>'Users','action'=>'leaveApplication/read:'.$v['LeaveApplications']['la_id'].'/laread:'.$v['LeaveApplications']['la_read']),array('title'=>'查看')).'|'.$this->Html->link('【编辑】',array('controller'=>'Users','action'=>'leaveApplication/edit:'.$v['LeaveApplications']['la_id']),array('title'=>'编辑')).$op_button.'|'.$this->Html->link('【删除】',array('controller'=>'Users','action'=>'leaveApplication/del:'.$v['LeaveApplications']['la_id']),array('title'=>'删除'),'确认要删除？\r\n删除后该申请将失效'),array())),
));
endforeach;
endif;
        

echo '</table>';
if($this->Paginator->hasPage('LeaveApplications')):
include_once '../View/Layouts/paginate.ctp';//载入分页
endif;
elseif($this->request['pass'][0] == 'add' || $this->request['named']['edit']):
echo '<table>';
        echo $this->Form->create('LeaveApplications',array('url'=>array('controller'=>'Users','action'=>($this->request['named']['edit'])?'leaveApplication/edit:'.$leaveInfo[0]['LeaveApplications']['la_id']:'leaveApplication/add')));
        echo $this->Html->tableCells(array(
           array(array('申请类型',array('width'=>80)),array($this->Form->radio('la_type',array('0'=>'请假&nbsp;','1'=>'外出'),array('legend'=>false,'value'=>$leaveInfo[0]['LeaveApplications']['la_type']?$leaveInfo[0]['LeaveApplications']['la_type']:0)))),
           array(array('申请内容',array('width'=>80)),array($this->Form->textarea('la_message',array('style'=>'height:260px','value'=>$leaveInfo[0]['LeaveApplications']['la_message'])))),
           array(array($this->Form->hidden('la_id',array('value'=>$leaveInfo[0]['LeaveApplications']['la_id'])),array('width'=>80)),array($this->Form->end(array('label'=>'提 交','class'=>'_button','div'=>false)))),
));
elseif($this->request['named']['read']):
echo '<table>';
if(!isset($manageButton)):


        
        echo $this->Html->tableCells(array(
           array(array('申请类型',array('width'=>80)),array($readLeave[0]['LeaveApplications']['la_type']?'外出':'请假',array())),
           array(array('申请时间',array('width'=>80)),array(date('Y/m/d H:i:s',$readLeave[0]['LeaveApplications']['created']),array())),
           array(array('领导是否查看',array('width'=>80)),array($readLeave[0]['LeaveApplications']['la_read']?'已查看':'未查看',array())),
           array(array('是否批准',array('width'=>80)),array(($readLeave[0]['LeaveApplications']['la_agree'] == 1)?'已批准':(($readLeave[0]['LeaveApplications']['la_agree'] == -1)?'未批准':'待审批'),array())),
           array(array('申请内容',array('width'=>80)),array($this->Html->tag('div',$readLeave[0]['LeaveApplications']['la_message'],array('class'=>'read_content')))),
           array(array('回复',array('width'=>80)),array($this->Html->tag('div',empty($readLeave[0]['LeaveApplications']['la_reply_message'])?'未回复':'已回复',array('class'=>'read_content'))))
));
else:
$op_button = '&nbsp;'.$this->Html->link('【不批】',array('controller'=>'Users','action'=>'leaveApplication/refuse:'.$readLeave[0]['LeaveApplications']['la_id']),array('title'=>'点击不批')).'&nbsp;'.$this->Html->link('【批准】',array('controller'=>'Users','action'=>'leaveApplication/agree:'.$readLeave[0]['LeaveApplications']['la_id']),array('title'=>'点击批准'));
echo $this->Form->create('LeaveApplications',array('url'=>array('controller'=>'Users','action'=>'leaveApplication/read:'.$readLeave[0]['LeaveApplications']['la_id']),'plugin'=>false));
 echo $this->Html->tableCells(array(
           array(array('申请类型',array('width'=>80)),array($readLeave[0]['LeaveApplications']['la_type']?'外出':'请假',array())),
           array(array('申请时间',array('width'=>80)),array(date('Y/m/d H:i:s',$readLeave[0]['LeaveApplications']['created']),array())),
           array(array('是否批准',array('width'=>80)),array((($readLeave[0]['LeaveApplications']['la_agree'] == 1)?'已批准':(($readLeave[0]['LeaveApplications']['la_agree'] == -1)?'未批准':'待审批')).$op_button,array())),
           array(array('申请内容',array('width'=>80)),array($this->Html->tag('div',$readLeave[0]['LeaveApplications']['la_message'],array('class'=>'read_content')))),
           array(array('回复',array('width'=>80)),array($this->Form->textarea('la_reply_message',array('style'=>'height:260px','value'=>$readLeave[0]['LeaveApplications']['la_reply_message'])),array())),
           array(array($this->Form->hidden('la_id',array('value'=>$readLeave[0]['LeaveApplications']['la_id'])),array()),array($this->Form->end(array('div'=>false,'label'=>'提 交','class'=>'_button')),array()))
));        

endif;


endif;
echo '</table>';
    echo $this->Html->script('tiny_mce/tiny_mce.js'); 

?>

<script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "simple",
                
	});
</script>
</div>