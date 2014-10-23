<!--**
 * @author 杨乾磊
 * @email  lifezqy@126.com
 * @link   http://blog.lifezq.com
 * @copyright (c) 2012-2013
 * @license http://www.gnu.org/licenses/
 * @version 1.0
 *-->

<div class="div_main">
<?php echo $this->Html->link('【创建用户组】',array('controller'=>'Users','action'=>'userGroup/add/1')).'&nbsp;'.$this->Html->link('【管理用户】',array('controller'=>'Users','action'=>'userManage')).'&nbsp;&nbsp;'.$this->Html->link('【用户组】',array('controller'=>'Users','action'=>'userGroup'));?>
       
<?php 
     if(!$create && !isset($Group)){
         ?>
    <table>
             
         <?php
         echo $this->Html->tableHeaders(array('编号','用户组','访问权限','操作'),array(),array('align'=>'center','class'=>'table_th')); 
         foreach($group_list as $v):
         echo $this->Html->tableCells(array(
               array(array($v['Group']['g_id'],array('align'=>'center')),array($v['Group']['g_name'],array('align'=>'center')),array($v['Group']['g_access'],array('align'=>'center')),array($this->Html->link('编辑',array('controller'=>'Users','action'=>'userGroup/edit/'.$v['Group']['g_id']),array('title'=>'编辑')).'|'.$this->Html->link('删除',array('controller'=>'Users','action'=>'userGroup/del/'.$v['Group']['g_id']),array('title'=>"删除"),'确认要删除吗?'),array('align'=>'center'))) ,
         ));
         endforeach;
         ?>
    </table>
    <?php
     }else{
        echo  $this->Form->create('Group',array('url'=>array('controller'=>'Users','action'=>'userGroup'),'plugin'=>false))
         ?>
            <table> 
             <?php
          echo $this->Html->tableCells(array(
    array(array('用户组名称:', array('align' => 'right','width'=>'12%')) ,array($this->Form->input('g_name',array('div'=>false,'label'=>false,'class'=>'_input','value'=>$Group[0]['Group']['g_name'])),array('align'=>'left'))),
    array(array('是否开启:', array('align' => 'right','width'=>'12%')) ,array($this->Form->radio('g_status',array('1'=>'开启 &nbsp;','0'=>'关闭'),array('div'=>false,'empty'=>false,'legend'=>false,'value'=>$Group[0]['Group']['g_status'])),array('align'=>'left'))),
//    array(array('访问权限:', array('align' => 'right','width'=>'12%')) ,array($this->Form->input('g_access',array('div'=>false,'label'=>false,'class'=>'_input','value'=>$Group[0]['Group']['g_access'])),array('align'=>'left'))),
    
    array(array($this->Form->hidden('g_id',array('value'=>$Group[0]['Group']['g_id'])), array('align' => 'right','width'=>'12%')) ,array($this->Form->end(array('div'=>false,'label'=>isset($Group[0]['Group']['g_id'])?'修 改':'创 建','class'=>'_button')),array('align'=>'left'))),
   ));
     }
      
          
?>
       </table>
</div>
