<!--**
 * @author 杨乾磊
 * @email  lifezqy@126.com
 * @link   http://blog.lifezq.com
 * @copyright (c) 2012-2013
 * @license http://www.gnu.org/licenses/
 * @version 1.0
 *-->
<div class="div_main">
<?php echo $this->Html->link('【管理用户】',array('controller'=>'Users','action'=>'userManage')); ?>
<table>
<?php echo  $this->Form->create('User', array('type' => 'post','action'=>'userAE'.($user[0]['User']['u_id']?'/modify/'.$user[0]['User']['u_id']:''),'url'=>array('controller'=>'Users','plugin'=>false),'name'=>'userAdd','id'=>'userAddFrom'));?>
<?php 

if($_mpwd):
    $show_check_mpwd = array(); //当用户选择一次是否修改密码后，将用户选择显示密码修改隐藏
    $pwd1 = array(array('用户密码:', array('align' => 'right','width'=>'12%')) ,array($this->Form->password('u_password',array('name'=>'u_password','class'=>'_input','onKeyUp'=>'pwStrength(this.value,0)','onBlur'=>'pwStrength(this.value,0)')).'<br/>'.$this->Html->tag('span','弱',array('class'=>'pwd_strong','id'=>'pwd1_strong_l')).$this->Html->tag('span','中',array('class'=>'pwd_strong','id'=>'pwd1_strong_m')).$this->Html->tag('span','强',array('class'=>'pwd_strong','id'=>'pwd1_strong_h')),array('align'=>'left')));
    $pwd2 = array(array('确认密码:', array('align' => 'right','width'=>'12%')) ,array($this->Form->password('u_password2',array('name'=>'u_password2','class'=>'_input','onKeyUp'=>'pwStrength(this.value,1)','onBlur'=>'pwStrength(this.value,2)')).'<span id=pwd_is_equal>&nbsp;</span><br/>'.$this->Html->tag('span','弱',array('class'=>'pwd_strong','id'=>'pwd2_strong_l')).$this->Html->tag('span','中',array('class'=>'pwd_strong','id'=>'pwd2_strong_m')).$this->Html->tag('span','强',array('class'=>'pwd_strong','id'=>'pwd2_strong_h')),array('align'=>'left')));
else:
$show_check_mpwd = array(array('是否修改密码:', array('align' => 'right','width'=>'12%')) ,array($this->Html->link('是',"javascript:void(0);",array('onClick'=>"javascript:window.location=window.location+'/mpwd/1'"))." &nbsp;&nbsp;&nbsp;&nbsp;<font color='#ccc'>当您不用修改密码时，该项可以忽视</font>",array('align'=>'left')));

$pwd1 = $pwd2 = array();

endif;
 echo $this->Html->tableCells(array(
    array(array('用户账号:', array('align' => 'right','width'=>'12%')) ,array($this->Form->input('u_username',array('div'=>false,'label'=>false,'name'=>'u_username','class'=>'_input','value'=>$user[0]['User']['u_username'])),array('align'=>'left'))),
    $show_check_mpwd,$pwd1,$pwd2,
    array(array('用户姓名:', array('align' => 'right','width'=>'12%')) ,array($this->Form->input('u_true_name',array('div'=>false,'label'=>false,'name'=>'u_true_name','class'=>'_input','value'=>$user[0]['User']['u_true_name'])),array('align'=>'left'))),
    array(array('用户手机:', array('align' => 'right','width'=>'12%')) ,array($this->Form->input('u_mobile',array('div'=>false,'label'=>false,'name'=>'u_mobile','class'=>'_input','value'=>$user[0]['User']['u_mobile'])),array('align'=>'left'))),
    array(array('外部电子邮箱:', array('align' => 'right','width'=>'12%')) ,array($this->Form->input('u_email',array('div'=>false,'label'=>false,'name'=>'u_email','class'=>'_input','value'=>$user[0]['User']['u_email'])).'&nbsp;<font color=#ccc>请认真填写您自己的个人邮箱，在电子邮件里面使用。误填或填错，将导致无法正常接收邮件。</font>',array('align'=>'left'))),
    array(array('内部电子邮箱:', array('align' => 'right','width'=>'12%')) ,array($this->Form->input('u_company_email',array('div'=>false,'label'=>false,'name'=>'u_company_email','class'=>'_input','value'=>$user[0]['User']['u_company_email'])).'&nbsp;<font color=#ccc>请认真填写您自己的个人邮箱，在电子邮件里面使用。误填或填错，将导致无法正常接收邮件。</font>',array('align'=>'left'))),
    array(array('性别:', array('align' => 'right','width'=>'12%')) ,array($this->Form->radio('u_sex',array('1'=>'男&nbsp;&nbsp;','2'=>'女'),array('legend'=>false,'name'=>'u_sex','value'=>$user[0]['User']['u_sex']?($user[0]['User']['u_sex']=='男'?1:2):1)),array('align'=>'left'))),
    array(array('年龄:', array('align' => 'right','width'=>'12%')) ,array($this->Form->input('u_age',array('div'=>false,'label'=>false,'name'=>'u_age','class'=>'_input','maxlength'=>3,'size'=>5,'style'=>'width:50px;','value'=>$user[0]['User']['u_age'])),array('align'=>'left'))),
    array(array('所属部门:', array('align' => 'right','width'=>'12%')) ,array($this->Form->select('u_class_id',array(array(''=>'--请选择--',$_Class)),array('div'=>false,'label'=>false,'name'=>'u_class_id','class'=>'_input','empty'=>false,'default'=>$user[0]['User']['u_class_id'])),array('align'=>'left'))),
    array(array('所属职位:', array('align' => 'right','width'=>'12%')) ,array($this->Form->select('u_posts_id',array(array(''=>'--请选择--',$_Posts)),array('div'=>false,'label'=>false,'name'=>'u_posts_id','class'=>'_input','empty'=>false,'default'=>$user[0]['User']['u_posts_id'])),array('align'=>'left'))),
    array(array('用户所属组:', array('align' => 'right','width'=>'12%')) ,array($this->Form->radio('u_gid',$_Groups,array('legend'=>false,'name'=>'u_gid','value'=>$user[0]['User']['u_gid']?$user[0]['User']['u_gid']:$defaule_g_id)),array('align'=>'left'))),
    array(array('是否启用账号:', array('align' => 'right','width'=>'12%')) ,array($this->Form->radio('u_is_close',array('0'=>'<font color=green>是</font>&nbsp;&nbsp;','1'=>'<font color=red>否</font>'),array('legend'=>false,'name'=>'u_is_close','value'=>$user[0]['User']['u_is_close']?1:0)),array('align'=>'left'))),
    array(array('是否启用文件柜:', array('align' => 'right','width'=>'12%')) ,array($this->Form->radio('u_file_cabinet',array('0'=>'<font color=green>是</font>&nbsp;&nbsp;','1'=>'<font color=red>否</font>'),array('legend'=>false,'name'=>'u_file_cabinet','value'=>$user[0]['User']['u_file_cabinet']?1:0)),array('align'=>'left'))),
    array(array('文件柜空间大小:', array('align' => 'right','width'=>'12%')) ,array($this->Form->input('u_cabinet_size',array('div'=>false,'label'=>false,'name'=>'u_cabinet_size','class'=>'_input','default'=>'20','value'=>number_format($user[0]['User']['u_cabinet_size']/1024/1024,0),'style'=>'width:50px;')).'&nbsp;<font color=#ccc>单位:M</font>',array('align'=>'left'))),
    array(array($this->Form->input('u_id',array('div'=>false,'label'=>false,'name'=>'u_id','type'=>'hidden','value'=>$user[0]['User']['u_id'])), array('align' => 'right','width'=>'12%')) ,array($this->Form->end(array('class'=>'_button','label'=>$user[0]['User']['u_id']?'修改用户':'创建用户','id'=>'create_user_submit')),array('align'=>'left')))
));
?>
        </table>
</div>
<?php echo $this->Html->script('lifezq.js'); ?>