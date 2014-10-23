<!--**
 * @filename announcement.ctp
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-8-30  15:38:23
 * @version 1.0
 *-->
<div class="div_main">
    <?php echo $this->Html->link('【发送新公告】',array('controller'=>'Office','action'=>'announcement/add')).'&nbsp;'.$this->Html->link('【我发出的公告】',array('controller'=>'Office','action'=>'announcement/sent')).'&nbsp;'.$this->Html->link('【接收的公告列表】',array('controller'=>'Office','action'=>'announcement'));
if((empty($this->request['pass'])&& empty($this->request['named'])  || $this->request['pass'][0] == 'sent' )){
echo '<table>';
echo $this->Html->tableHeaders(array('编号','公告标题','接收部门','发布人','级别','发送时间','操作'),array(),array('class'=>'table_th'));

if(count($announcement)){

foreach($announcement as $v):
$del_option = $this->Html->link('【删除记录】',array('controller'=>'Office','action'=>'announcement/del:'.$v['Announcement']['a_id']),array('title'=>'删除'),'确认要删除该条公告记录吗?');
if($this->request['pass'][0] == 'sent') $del_option = $this->Html->link('【编辑】',array('controller'=>'Office','action'=>'announcement/edit:'.$v['Announcement']['a_id'])).'|'.$this->Html->link('【删除】',array('controller'=>'Office','action'=>'announcement/delTrue:'.$v['Announcement']['a_id']),array('title'=>'删除'),'删除后所有人将不会再看到该条公告\r\n确认要删除该条公告吗?');
echo $this->Html->tableCells(array(
      array(array($v['Announcement']['a_id'],array('width'=>28)),array(mb_substr($v['Announcement']['a_title'],0,15),array()),$v['Announcement']['cp_name'],$v['Announcement']['a_author'],$v['Announcement']['a_level']?'<font color=#f00>紧急</font>':'普通',array(date('Y/m/d',$v['Announcement']['created']),array('width'=>70)),$this->Html->link('【查看】',array('controller'=>'Office','action'=>'announcement/show:'.$v['Announcement']['a_id'])).'|'.$del_option),
));
endforeach;
}else{
echo $this->Html->tableCells(array(
      array(array('暂时您还没有收到新公告喔!',array('colspan'=>8)))
));
}
echo '</table>';
if($this->Paginator->hasPage('Announcement')):
include_once '../View/Layouts/paginate.ctp';//载入分页
endif;
}elseif($this->request['named']['show']){
if($this->request['named']['show']){
foreach($announcement[0]['ClassPosts'] as $v){
     $classPost .= $v['cp_name'].'&nbsp;';
}
echo '<table>';
 echo $this->Html->tableCells(array(
    array(array('公告标题',array('align'=>'right','width'=>100)),array($announcement[0]['Announcement']['a_title'],array('align'=>'left','width'=>160))),
    array(array('接收部门',array('align'=>'right','width'=>100)),array($classPost,array('align'=>'left','width'=>160))),
    array(array('公告级别',array('align'=>'right','width'=>100)),array($announcement[0]['Announcement']['a_level']?'<font color=#f00>紧急</font>':'普通',array('align'=>'left','width'=>160))),
    array(array('发布人',array('align'=>'right','width'=>100)),array($announcement[0]['Announcement']['a_author'],array('align'=>'left','width'=>160))),
    array(array('发布时间',array('align'=>'right','width'=>100)),array(date('Y/m/d H:i:s',$announcement[0]['Announcement']['created']),array('align'=>'left','width'=>160))),
    array(array('公告内容:', array('align' => 'right','width'=>'12%')) ,array($announcement[0]['Announcement']['a_content'],array('align'=>'left')))
));
echo '</table>';

}
}elseif($this->request['pass'][0] == 'add' || $this->request['named']['edit']){
$classPost = '';
foreach($ClassPosts as $v){
     $classPost .= $this->Form->checkbox('cp_id',array('name'=>'data[ClassAnnouncements][cp_id][]','hiddenField'=>false,'div'=>false,'value'=>$v['ClassPosts']['cp_id'],'checked'=>$v['ClassPosts']['current_class']?true:false)).$v['ClassPosts']['cp_name'].'&nbsp;&nbsp;';
}

if(empty($classPost)) $classPost = '您还没创建公司结构，赶快先去'.$this->Html->link('创建公司结构',array('controller'=>'Company','action'=>'classAndPosts')).'吧';

echo $this->Form->create('Announcement',array('url'=>array('controller'=>'Office','action'=>'announcement/'.($this->request['named']['edit']?'edit:'.$this->request['named']['edit']:'add')),'plugin'=>false));
echo '<table>';
 echo $this->Html->tableCells(array(
    array(array('公告标题',array('align'=>'right','width'=>100)),array($this->Form->input('a_title',array('div'=>false,'label'=>false,'class'=>'_input','value'=>$announcement[0]['Announcement']['a_title'])),array('align'=>'left','width'=>160))),
    array(array('接收部门',array('align'=>'right','width'=>100)),array($classPost,array('align'=>'left','width'=>160))),
    array(array('公告级别',array('align'=>'right','width'=>100)),array($this->Form->radio('a_level',array('0'=>'普通&nbsp;&nbsp;','1'=>'紧急'),array('div'=>false,'legend'=>false,'value'=>$announcement[0]['Announcement']['a_level']?1:0)),array('align'=>'left','width'=>160))),
    array(array('公告内容:', array('align' => 'right','width'=>'12%')) ,array($this->Form->textarea('a_content',array('class'=>'_input2','value'=>$announcement[0]['Announcement']['a_content'])),array('align'=>'left'))),
    array(array($this->Form->hidden('a_id',array('value'=>$this->request['named']['edit'])), array('align' => 'right','width'=>'12%')) ,array($this->Form->end(array('class'=>'_button','label'=>$this->request['named']['edit']?'修改公告':'发布公告')),array('align'=>'left')))
));
echo '</table>';
}

?>
</div>
<?php echo $this->Html->script('lifezq.js'); ?>