<!--**
 * @filename sms.ctp
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-8-29  14:30:47
 * @version 1.0
 *-->
<div class="div_main">
    <?php echo $this->Html->link('【发送新消息】',array('controller'=>'Office','action'=>'sms/add')).'&nbsp;'.$this->Html->link('【我发出的消息】',array('controller'=>'Office','action'=>'sms/sent')).'&nbsp;'.$this->Html->link('【接收的短消息列表】',array('controller'=>'Office','action'=>'sms'));
if((empty($this->request['pass']) || $this->request['pass'][0] == 'read') && empty($this->request['named'])){
echo '<table>';
echo $this->Html->tableHeaders(array('编号','发送人','消息内容','接收时间','回复','操作'),array(),array('class'=>'table_th'));
//用户是否有新消息
if($unReadSms){
echo $this->Html->tableCells(array(
      array(array('您有'.$this->Html->link($unReadSms,'javascript:void(0)',array('onClick'=>"this.href=window.location+'/read'")).'条新消息喔!',array('colspan'=>8,'align'=>'center','class'=>'tr_notice')))
));
}
//用户是否有新的回复
if($unReadReplySms){
echo $this->Html->tableCells(array(
      array(array('您有'.$this->Html->link($unReadReplySms,'javascript:void(0)',array('onClick'=>"this.href=window.location+'/reply'")).'条新的回复消息喔!',array('colspan'=>8,'align'=>'center','class'=>'tr_notice')))
));
}
if(count($smsInfo)){
foreach($smsInfo as $v):
echo $this->Html->tableCells(array(
      array($v['Sms']['s_id'],$v['Sms']['s_from_user'],oa_mb_substr($v['Sms']['s_message'],0,15),date('Y/m/d H:i:s',$v['Sms']['created']),$v['Sms']['s_reply_num']?"<span class='_green'>".$v['Sms']['s_reply_num'].'条回复</span>':'<span class=_yellow>未回复</span>',$this->Html->link('【查看】',array('controller'=>'Office','action'=>'sms/read:'.$v['Sms']['s_id']),array('title'=>'查看')).'|'.$this->Html->link('【删除记录】',array('controller'=>'Office','action'=>'sms/del/'.$v['Sms']['s_id']),array('title'=>'删除'),'确认要删除该条消息记录吗?')),
));
endforeach;
}else{
echo $this->Html->tableCells(array(
      array(array('暂时您还没有收到新消息喔!',array('colspan'=>8)))
));
}
echo '</table>';
if($this->Paginator->hasPage('Sms'))
include_once '../View/Layouts/paginate.ctp';//载入分页
}elseif($this->request['pass'][0] == 'sent'){
echo '<table>';
echo $this->Html->tableHeaders(array('编号','接收人','消息内容','发送时间','回复','操作'),array(),array('class'=>'table_th'));
//用户是否有新消息
if($unReadSms){
echo $this->Html->tableCells(array(
      array(array('您有'.$this->Html->link($unReadSms,'javascript:void(0)',array('onClick'=>"this.href=window.location+'/read'")).'条新消息喔!',array('colspan'=>8,'align'=>'center','class'=>'tr_notice')))
));
}
if(count($smsInfo)){
foreach($smsInfo as $v):
echo $this->Html->tableCells(array(
      array($v['Sms']['s_id'],oa_mb_substr($v['Sms']['s_receivers'],0,9),oa_mb_substr($v['Sms']['s_message'],0,15),date('Y/m/d H:i:s',$v['Sms']['created']),$v['Sms']['s_reply_num']?"<span class='_green'>".$v['Sms']['s_reply_num'].'条回复</span>':'<span class=_yellow>未回复</span>',$this->Html->link('【查看】',array('controller'=>'Office','action'=>'sms/read:'.$v['Sms']['s_id']),array('title'=>'查看')).'|'.$this->Html->link('【删除记录】',array('controller'=>'Office','action'=>'sms/del/'.$v['Sms']['s_id']),array('title'=>'删除'),'确认要删除该条消息记录吗?')),
));
endforeach;
}else{
echo $this->Html->tableCells(array(
      array(array('暂时您还没有收到新消息喔!',array('colspan'=>8)))
));
}
echo '</table>';
if($this->Paginator->hasPage('Sms'))
include_once '../View/Layouts/paginate.ctp';//载入分页
}elseif($this->request['named']['read']){

?>
<h3 class='sms_h3_1'>原消息</h3>
<div class='sms_div_box'>
<p class="sms_user <?php if($cur_uid==$Sms[0]['Sms']['s_from_uid']){echo ' _green';}else{echo '_blue';}?>"><?php echo $Sms[0]['Sms']['s_from_user'].'&nbsp;&nbsp;'.date('Y-m-d H:i:s',$Sms[0]['Sms']['created']);?> </p>
<div class='sms_message'><?php echo $Sms[0]['Sms']['s_message'];?></div>
</div>
<div class='sms_reply_box'>
<?php
if(count($SmsReply)){
?>
<h3 class='sms_h3_1'>回复列表</h3>
<?php
$i=0;
foreach($SmsReply as $v){

?>
<p class='sms_floor'><?php if($v['Sms']['level'] ==1 ){ $i++; echo '#'.$i.'楼';}?></p>
<div class="sms_reply_list <?php echo ' sms_reply_list_'.$v['Sms']['level']; if($v['Sms']['level']==1){echo ' sms_reply_list_top';} ?>">

<div class='sms_message'><span class="sms_user  <?php if($cur_uid == $v['Sms']['s_from_uid']){echo ' _green';}else{echo '_blue';}?>"><?php echo $v['Sms']['s_from_user'].':';?> </span><p class='sms_reply_content'><?php echo $v['Sms']['s_message'];?></p></div>
<div class='sms_reply_list_but' id='sms_reply_list_but_<?php echo $v['Sms']['s_id'];?>'> <?php echo date('Y-m-d H:i',$v['Sms']['created']);?> <a href='javascript:void(0);' onClick='sms_comment(<?php echo $v['Sms']['s_id'];?>);'>回复</a></div>
</div>

<?php
}
}else{
echo "<p class='_yellow no_reply'>还没有回复，等您坐沙发呢</p>";
}
echo '</div>';


?>
<div class='sms_reply_box' id='sms_reply_box'>
<?php 
echo $this->Form->create('Sms',array('url'=>array('controller'=>'Office','action'=>'sms/read:'.$this->request['named']['read'],'plugin'=>false)));

?>
<h3 class='sms_h3_2'>发表回复</h3>
<?php
echo $this->Form->hidden('s_pid',array('value'=>$Sms[0]['Sms']['s_id'])).$this->Form->textarea('s_message',array('class'=>'_input2','value'=>''));
echo $this->Form->end(array('label'=>'回 复','class'=>'sms_button'));

echo '</div>';

//echo $this->Html->script('tiny_mce/tiny_mce.js'); 
echo $this->Html->scriptBlock("
//tinyMCE.init({
//		mode : \"textareas\",
//		theme : \"simple\",
 //               
//	});
function sms_comment(_id){
$('#SmsSPid').val(_id);
$('#sms_reply_list_but_'+_id).append($('#sms_reply_box'));

}
");
}elseif($this->request['pass'][0] == 'add' || $this->request['pass'][0] == 'edit'){
echo $this->Form->create('Sms',array('url'=>array('controller'=>'Office','action'=>'sms/'.($addressBook[0]['AddressBook']['a_id']?'edit':'add')),'plugin'=>false));
echo '<table>';
 echo $this->Html->tableCells(array(
    array(array('接收人',array('align'=>'right','width'=>100)),array($this->Form->input('s_receivers',array('id'=>'EmailEmComeTo','div'=>false,'label'=>false,'class'=>'_input','style'=>'width:420px;color:#aaa;','readonly'=>true)).$this->Html->tag('div',$this->Html->link('选择接收人','javascript:;',array('onClick'=>"javascript:$('#EmailEmComeToSelect').slideToggle();"))).$this->Html->tag('div',$UserLink,array('id'=>'EmailEmComeToSelect')),array('align'=>'left','width'=>160))),
    array(array('备注:', array('align' => 'right','width'=>'12%')) ,array($this->Form->textarea('s_message',array('class'=>'_input2','value'=>$addressBook[0]['AddressBook']['a_remark'])),array('align'=>'left'))),
    array(array('', array('align' => 'right','width'=>'12%')) ,array($this->Form->end(array('class'=>'_button','label'=>'发送消息','id'=>'create_user_submit')),array('align'=>'left')))
));
echo '</table>';
}elseif($this->request['pass'][0] == 'reply'){ // 查看回复消息列表
echo '<table>';
echo $this->Html->tableHeaders(array('编号','发送人','消息内容','发送时间','回复','操作'),array(),array('class'=>'table_th'));
       if(count($smsInfo)){
foreach($smsInfo as $v):
echo $this->Html->tableCells(array(
      array($v['Sms']['s_id'],$v['Sms']['s_from_user'],oa_mb_substr($v['Sms']['s_message'],0,15),date('Y/m/d H:i:s',$v['Sms']['created']),$v['Sms']['s_reply_num']?"<span class='_green'>".$v['Sms']['s_reply_num'].'条回复</span>':'<span class=_yellow>未回复</span>',$this->Html->link('【查看】',array('controller'=>'Office','action'=>'sms/readReply:1/read:'.$v['Sms']['s_id']),array('title'=>'查看')).'|'.$this->Html->link('【删除记录】',array('controller'=>'Office','action'=>'sms/del/'.$v['Sms']['s_id']),array('title'=>'删除'),'确认要删除该条消息记录吗?')),
));
endforeach;
}else{
echo $this->Html->tableCells(array(
      array(array('暂时您还没有收到新消息喔!',array('colspan'=>8)))
));
}
echo '</table>';             
}
?>
</div>
<?php echo $this->Html->script('lifezq.js'); ?>