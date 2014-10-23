<!--**
 * @filename mail_setting.ctp
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-8-27  11:57:07
 * @version 1.0
 *-->
<div class="div_main">
<?php echo $this->Html->link('【内部邮件管理】',array('controller'=>'Emails','action'=>'innerEmails')).'&nbsp;'.$this->Html->link('【外部邮件管理】',array('controller'=>'Emails','action'=>'internetEmails')).'&nbsp;'.$this->Html->link('【发送内部邮件】',array('controller'=>'Emails','action'=>'innerEmails/send/1')).'&nbsp;'.$this->Html->link('【发送外部邮件】',array('controller'=>'Emails','action'=>'internetEmails/send/1')).'&nbsp;&nbsp;'.$this->Html->link('【个人邮件配置】',array('controller'=>'Emails','action'=>'mailSetting'));
      echo $this->Form->create('MailServer',array('url'=>array('controller'=>'Emails','action'=>'mailSetting'),'plugin'=>false));
?>

<table>
<?php echo $this->Html->tableCells(array(
           array(array('邮件服务器主机',array('align'=>'right','width'=>100)),array($this->Form->input('m_server',array('div'=>false,'label'=>false,'class'=>'_input','value'=>$MailServer['m_server'])).'&nbsp;<font color=#ccc>例:smtp.126.com</font>',array('align'=>'left'))),
           array(array('邮件服务器端口',array('align'=>'right','width'=>100)),array($this->Form->input('m_port',array('div'=>false,'label'=>false,'class'=>'_input','value'=>$MailServer['m_port']?$MailServer['m_port']:25,'style'=>'width:45px;')).'&nbsp;<font color=#ccc>默认端口25,端口根据不同邮件服务器会有所不同</font>',array('align'=>'left'))),
           array(array('邮件服务器账号',array('align'=>'right','width'=>100)),array($this->Form->input('m_username',array('div'=>false,'label'=>false,'class'=>'_input','value'=>$MailServer['m_username'])).'&nbsp;<font color=#ccc>用户名,例:username@126.com</font>',array('align'=>'left'))),
           array(array('邮件服务器密码',array('align'=>'right','width'=>100)),array($this->Form->input('m_password',array('div'=>false,'label'=>false,'class'=>'_input','value'=>$MailServer['m_password'])).'&nbsp;<font color=#ccc>邮箱密码</font>',array('align'=>'left'))),
           array(array('&nbsp;',array('align'=>'right','width'=>100)),array($this->Form->end(array('div'=>false,'label'=>'配 置','class'=>'_button')).'&nbsp;',array('align'=>'left'))),
)); 
     echo $this->Html->tableHeaders(array('发送测试邮件'),array(),array('class'=>'table_th','colspan'=>2,'align'=>'left'));
     echo $this->Form->create('Email',array('type' => 'post','url'=>array('controller'=>'Emails','action'=>'mailSetting','plugin'=>false)));
     echo $this->Html->tableCells(array(
          array(array('收件人地址',array('align'=>'right','width'=>100)),array($this->Form->input('em_come_to',array('div'=>false,'label'=>false,'class'=>'_input','style'=>'width:420px;color:#aaa;','readonly'=>true)).$this->Html->tag('div',$this->Html->link('选择收件人','javascript:;',array('onClick'=>"javascript:$('#EmailEmComeToSelect').slideToggle();"))).$this->Html->tag('div',$UserLink,array('id'=>'EmailEmComeToSelect')),array('align'=>'left','width'=>160))),
          array(array('邮件主题',array('align'=>'right','width'=>100)),array($this->Form->input('em_subject',array('div'=>false,'label'=>false,'class'=>'_input','style'=>'width:420px;')),array('align'=>'left','width'=>160))),
          array(array('邮件内容',array('align'=>'right','width'=>100)),array($this->Form->textarea('em_content',array('div'=>false,'label'=>false,'id'=>'em_content','style'=>'width:500px;height:400px;')),array('align'=>'left','width'=>160))),
          array(array($this->Form->hidden('em_inner_out',array('value'=>1)),array('align'=>'right','width'=>100)),array($this->Form->end(array('div'=>false,'label'=>'发送邮件','class'=>'_button','id'=>'em_submit')),array('align'=>'left','width'=>160))),
));
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