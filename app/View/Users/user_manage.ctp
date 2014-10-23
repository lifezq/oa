<!--**
 * @author 杨乾磊
 * @email  lifezqy@126.com
 * @link   http://blog.lifezq.com
 * @copyright (c) 2012-2013
 * @license http://www.gnu.org/licenses/
 * @version 1.0
 *-->

<div class="div_main">
<?php echo $this->Html->link('【创建用户】',array('controller'=>'Users','action'=>'userAE')).'&nbsp;'.$this->Html->link('【管理用户】',array('controller'=>'Users','action'=>'userManage')).'&nbsp;'.$this->Html->link('【用户组】',array('controller'=>'Users','action'=>'userGroup'));?>
       <table>
          <?php echo $this->Html->tableHeaders(array('编号','账号','用户姓名','性别','年龄','所在部门','所在职位','用户组','权限配置','启用','操作'),array(),array('align'=>'center')); 
          foreach($users as $v):
          echo $this->Html->tableCells(
           array($v['User']['u_id'],$v['User']['u_username'],$v['User']['u_true_name'],($v['User']['u_sex']?"男":"女"),$v['User']['u_age'],$v['Class']['cp_name'],$v['Posts']['cp_name'],$v['Groups']['g_name'],($v['Permission']['p_nav_allows']?"<span class='_green'>已配置</span>":"<span class='_yellow'>未配置</span>"),($v['User']['u_is_close'] == 0)?$this->Html->link('已启用',array('controller'=>'Users','action'=>'userOption/close/'.$v['User']['u_id']),array('title'=>'点击禁用','style'=>'color:green')):$this->Html->link('已禁用',array('controller'=>'Users','action'=>'userOption/open/'.$v['User']['u_id']),array('title'=>'点击启用','style'=>'color:red')),$this->Html->link('【修改】',array('controller'=>'Users','action'=>'userAE/modify/'.$v['User']['u_id'].''),array('title'=>'修改')).'|'.$this->Html->link('【访问权限配置】',array('controller'=>'Users','action'=>'access/uid:'.$v['User']['u_id']),array('title'=>'访问权限配置')).'|'.$this->Html->link('【删除】',array('controller'=>'Users','action'=>'userOption/del/'.$v['User']['u_id'].''),array('title'=>'删除'),'确认要删除吗?'))
);
endforeach;
?>
       </table>
</div>
