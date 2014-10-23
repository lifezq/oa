<!--**
 * @filename internet_emails.ctp
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-8-21  10:22:32
 * @version 1.0
 *-->
<div class="div_main">
 <?php 
$optionButton = '';
if(isset($manageButton)):
$optionButton = $this->Html->link('【内部邮件管理】',array('controller'=>'Emails','action'=>'innerEmails')).'&nbsp;'.$this->Html->link('【外部邮件管理】',array('controller'=>'Emails','action'=>'internetEmails'));
endif;
echo $this->Html->link('【发送内部邮件】',array('controller'=>'Emails','action'=>'innerEmails/send/1')).'&nbsp;'.$this->Html->link('【发送外部邮件】',array('controller'=>'Emails','action'=>'internetEmails/send/1')).'&nbsp;'.$this->Html->link('【接收的内部邮件】',array('controller'=>'Emails','action'=>'innerEmails/received')).'&nbsp;'.$this->Html->link('【发出的内部邮件】',array('controller'=>'Emails','action'=>'innerEmails/sent')).'&nbsp;'.$this->Html->link('【发出的外部邮件】',array('controller'=>'Emails','action'=>'internetEmails/sent')).'&nbsp;'.$optionButton.'&nbsp;';?>
    <table>
 <?php 
if(!$_send):
       echo $this->Form->create('Email',array('type'=>'post','url'=>array('controller'=>'Emails','action'=>'innerEmails/del','plugin'=>false)));
       if(isset($this->request['pass'][0])&&$this->request['pass'][0] == 'received'):
 echo $this->Html->tableHeaders(array('编号','邮件标题','发送时间','发件人','携带附件','操作'),array(),array('class'=>'table_th'));
else:
 echo $this->Html->tableHeaders(array('编号','邮件标题','发送时间','收件人','发送状态','携带附件','操作'),array(),array('class'=>'table_th'));
endif;
      if(count($emails)):
       foreach($emails as $v):
if(isset($this->request['pass'][0])&&$this->request['pass'][0] == 'received'):
       echo $this->Html->tableCells(array(
            array(array($this->Form->checkbox('email_ck',array('value'=>$v['Email']['em_id'],'name'=>'email_ck[]','hiddenField'=>false)).$v['Email']['em_id'],array('width'=>'32')),mb_substr($v['Email']['em_subject'],0,15),array(date('Y/m/d H:i:s',$v['Email']['created']),array('width'=>'135')),array($v['User']['u_true_name'],array('width'=>60)),array($v['Email']['em_is_attachment']?"<a href=javascript:void(0) onClick=this.href='".Configure::read('ROOT').$v['Email']['em_attachment_path']."'>是</a>":"否",array('width'=>55)),$this->Html->link('删除记录',array('controller'=>'Emails','action'=>'innerEmails/del/'.$v['Email']['em_id']),array(),'确认要删除记录?')),
));
else:
       echo $this->Html->tableCells(array(
            array(array($this->Form->checkbox('email_ck',array('value'=>$v['Email']['em_id'],'name'=>'email_ck[]','hiddenField'=>false)).$v['Email']['em_id'],array('width'=>'32')),mb_substr($v['Email']['em_subject'],0,15),array(date('Y/m/d H:i:s',$v['Email']['created']),array('width'=>'135')),array($v['Email']['em_to_user'],array()),array("<font color='green'>已发送</font>",array('width'=>60)),array($v['Email']['em_is_attachment']?"<a href=javascript:void(0) onClick=this.href='".Configure::read('ROOT').$v['Email']['em_attachment_path']."'>是</a>":"否",array('width'=>55)),$this->Html->link('删除记录',array('controller'=>'Emails','action'=>'innerEmails/del/'.$v['Email']['em_id']),array(),'确认要删除记录?')),
));
endif;

endforeach;
       echo $this->Html->tableCells(array(
            array(array($this->Form->button('全/反选',array('type'=>'button','class'=>'_button','onClick'=>'checkAll()')).' '.$this->Form->button('删除记录',array('type'=>'submit','class'=>'_button','onClick'=>"if(!$('input:checkbox:checked=checked').length){ return false; } return confirm('确认要批量删除记录吗?');")),array('colspan'=>7))),
));
else:
echo $this->Html->tableCells(array(
            array(array($this->Html->tag('span','亲，您还没有收到任何邮件喔！赶快把您的邮箱地址告诉您的好友吧。。。',array('class'=>'no_content')),array('colspan'=>6))),
));
endif;
?>
</table>

<?php
if($this->Paginator->hasPage('Email')):
 include_once '../View/Layouts/paginate.ctp';//载入分页
endif;
else:
    echo $this->Form->create('Email',array('type' => 'file','url'=>array('controller'=>'Emails','action'=>'innerEmails/send/1','plugin'=>false)));
    echo $this->Html->tableCells(array(
          array(array('收件人地址',array('align'=>'right','width'=>100)),array($this->Form->input('em_come_to',array('div'=>false,'label'=>false,'class'=>'_input','style'=>'width:420px;color:#aaa;','readonly'=>true)).$this->Html->tag('div',$this->Html->link('选择收件人','javascript:;',array('onClick'=>"javascript:$('#EmailEmComeToSelect').slideToggle();"))).$this->Html->tag('div',$UserLink,array('id'=>'EmailEmComeToSelect')),array('align'=>'left','width'=>160))),
          array(array('邮件主题',array('align'=>'right','width'=>100)),array($this->Form->input('em_subject',array('div'=>false,'label'=>false,'class'=>'_input','style'=>'width:420px;')),array('align'=>'left','width'=>160))),
          array(array('是否增加附件',array('align'=>'right','width'=>100)),array($this->Form->radio('em_is_attachment',array('1'=>'是 &nbsp;','0'=>'否'),array('legend'=>false,'value'=>0,'onClick'=>"javascript:if(this.value == '1'){ $('._attachment').show();  }else{  $('._attachment').hide(); };")),array('align'=>'left','width'=>160))),
          array(array('邮件附件',array('align'=>'right','width'=>100,'class'=>'_attachment')),array($this->Form->file('em_attachment_path',array('div'=>false,'label'=>false,'class'=>'_input')),array('align'=>'left','width'=>160,'class'=>'_attachment'))),
          array(array('邮件内容',array('align'=>'right','width'=>100)),array($this->Form->textarea('em_content',array('div'=>false,'label'=>false,'id'=>'em_content','style'=>'width:500px;height:400px;')),array('align'=>'left','width'=>160))),
          array(array($this->Form->hidden('em_inner_out',array('value'=>0)),array('align'=>'right','width'=>100)),array($this->Form->end(array('div'=>false,'label'=>'发送邮件','class'=>'_button','id'=>'em_submit')),array('align'=>'left','width'=>160))),
));
endif;
?> 
 </table>
</div>
<?php echo $this->Html->script('lifezq.js'); ?>
<script>
$('._attachment').hide();
$.getScript('<?php echo Configure::read('ROOT');?>plugins/kindeditor/kindeditor-min.js', function() {
KindEditor.basePath = '<?php echo Configure::read('ROOT');?>plugins/kindeditor/';
editor = KindEditor.create('textarea[id="em_content"]');

$('#em_submit').click(function(e){
$('#em_content').html(editor.html());
}) 


});
</script>