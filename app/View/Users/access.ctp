<!--**
 * @filename access.ctp
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-9-13  11:16:53
 * @version 1.0 
 *-->
<div class='div_main'>
<?php
echo $this->Html->link('【管理用户】',array('controller'=>'Users','action'=>'userManage')).'&nbsp;'.$this->Html->link('【用户组】',array('controller'=>'Users','action'=>'userGroup'));; 
echo "<span class='_green'>您当前正在配置用户: ".$_user[0]['User']['u_true_name']." 的访问权限</span>";
echo $this->Form->create('Permission',array('url'=>array('controller'=>'Users','action'=>'access/uid:'.$_user[0]['User']['u_id']),'plugin'=>false));
echo $this->Form->hidden('p_uid',array('value'=>$_user[0]['User']['u_id']));
?>
    <ul class="access_menu_ul">
      <?php foreach($navList[0] as $k=>$v){
?>
<li class="access_menu_li">
       	  <div class='access_menu_div'> <?php echo $this->Form->checkbox('nid[]',array('name'=>'nid[]','value'=>$v['n_id'],'id'=>'nid_'.$v['n_id'],'checked'=>$v['checked'],'hiddenField'=>false,'onClick'=>'checkPermission(this.value);')); ?><a href="javascript:void(0)" class="access_menu_a"><?php echo $v['n_name']?></a> </div>
          <ul id="nid_ul_<?php echo $v['n_id']; ?>">
            <?php foreach($navList[$v['n_id']] as $m){ ?>
             <li class='access_menu_child'><?php echo $this->Form->checkbox('nid[]',array('name'=>'nid[]','value'=>$m['n_id'],'checked'=>$m['checked'],'hiddenField'=>false)); ?><?php echo $m['n_name']; ?></li>
             <?php } ?>
          </ul>
</li>
<?php

}
?>
      
    </ul>
<div class='_clear'></div>
<br/>
<?php 
echo $this->Form->end(array('label'=>'配 置','class'=>'_button'));
?>
</div>
<script type="text/javascript">
function checkPermission(nid){

 var _len = $('#nid_ul_'+nid+' input:checkbox').length;
for(var i=0;i<_len;i++){
if($('#nid_'+nid).attr('checked')){
$('#nid_ul_'+nid+' input:checkbox').attr('checked',true);
}else{
$('#nid_ul_'+nid+' input:checkbox').attr('checked',false);
}
}


}
</script>