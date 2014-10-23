<!--**
 * @filename meetting_room.ctp
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-9-10  16:30:25
 * @version 1.0 
 *-->
<div class="div_main">
<?php
if($this->request['pass'][0] == 'order' || $this->request['pass'][0] == 'orderMine'|| $this->request['pass'][0] == 'orderAdd' || $this->request['named']['orderEdit']){
echo $this->Html->link('【会议室预约】',array('controller'=>'Company','action'=>'meetingRoom/orderAdd'),array('title'=>'会议室预约')).' '.$this->Html->link('【我的预约】',array('controller'=>'Company','action'=>'meetingRoom/orderMine'),array('title'=>'我的预约')).' '.$this->Html->link('【会议室预约列表】',array('controller'=>'Company','action'=>'meetingRoom/order'),array('title'=>'会议室预约列表'));
}else{
echo $this->Html->link('【会议室添加】',array('controller'=>'Company','action'=>'meetingRoom/add'),array('title'=>'会议室添加')).'&nbsp;'.$this->Html->link('【会议室管理】',array('controller'=>'Company','action'=>'meetingRoom'),array('title'=>'会议室管理'));
}
if(empty($this->request['pass']) && empty($this->request['named'])){
            echo '<table>';
echo $this->Html->tableHeaders(array('编号','会议室名称','可容纳人数','会议室状态','是否打扫','操作'),array(),array('class'=>'table_th'));
$meetingArr = array();
foreach($meetingRoom as $v):
$meetingArr[] = array(array($v['MeetingRooms']['mr_id'],array('width'=>30)),array($v['MeetingRooms']['mr_room'],array()),array($v['MeetingRooms']['mr_person_num'].' 人',array()),array($v['MeetingRooms']['mr_status'] == 1?'<span class=_green>开放</span>':($v['MeetingRooms']['mr_status'] == 0?'<span class=_red>已被预约，预约人：'.$v['User']['u_true_name'].' 预约时间:'.date('Y/m/d H:i',$v['MeetingRooms']['u_order_time']).' 至 '.date('Y/m/d H:i',$v['MeetingRooms']['u_order_end_time']).'</span>':'<span class=_yellow>维修关闭中</span>'),array('width'=>285)),array($v['MeetingRooms']['mr_clean']?$this->Html->link("已打扫",array('controller'=>'Company','action'=>'meetingRoom/clean:0/room:'.$v['MeetingRooms']['mr_id']),array('title'=>'点击到未打扫','class'=>'_green')):$this->Html->link("未打扫",array('controller'=>'Company','action'=>'meetingRoom/clean:1/room:'.$v['MeetingRooms']['mr_id']),array('title'=>'点击确认已打扫','class'=>'_red')),array()),array($this->Html->link('【编辑】',array('controller'=>'Company','action'=>'meetingRoom/edit:'.$v['MeetingRooms']['mr_id']),array('title'=>'编辑')).'|'.$this->Html->link('【删除】',array('controller'=>'Company','action'=>'meetingRoom/del:'.$v['MeetingRooms']['mr_id']),array('title'=>'删除'),'确认要删除该会议室吗?\r\n此操作将无法恢复'),array()));
endforeach;
echo $this->Html->tableCells($meetingArr);
echo '</table>';
        }elseif($this->request['pass'][0] == 'add' || $this->request['named']['edit']){
echo $this->Form->create('MeetingRooms',array('url'=>array('controller'=>'Company','action'=>$this->request['named']['edit']?'meetingRoom/edit:'.$this->request['named']['edit']:'meetingRoom/add','plugin'=>false)));
           echo '<table>';
echo $this->Html->tableCells(array(
array(array($this->Form->input('mr_room',array('div'=>false,'label'=>'会议室名称 ','class'=>'_input','value'=>$meetingR[0]['MeetingRooms']['mr_room'])))),
array(array($this->Form->input('mr_person_num',array('div'=>false,'label'=>'可容纳人数 ','class'=>'_input','style'=>'width:80px','value'=>$meetingR[0]['MeetingRooms']['mr_person_num'])).' 人')),
array(array('会议室状态 '.$this->Form->radio('mr_status',array('1'=>'开放 ','2'=>'维修关闭中 '),array('div'=>false,'legend'=>false,'value'=>$meetingR[0]['MeetingRooms']['mr_status'])))),
array(array($this->Form->hidden('mr_id',array('value'=>$this->request['named']['edit'])).$this->Form->end(array('div'=>false,'label'=>$this->request['named']['edit']?'编 辑':'添 加','class'=>'_button')))),
));
 echo '</table>'; 
        }elseif($this->request['pass'][0] == 'order' || $this->request['pass'][0] == 'orderMine'){ //会议室预约列表
            echo '<table>';
if($this->request['pass'][0] == 'orderMine'){
echo $this->Html->tableHeaders(array('编号','会议室名称','可容纳人数','会议室状态','预约人','预约时间','是否打扫','操作'),array(),array('class'=>'table_th'));
$meetingRoom = array();
foreach($meetingR as $v){
$meetingRoom[] =  array(array($v['MeetingRooms']['mr_id'],array('width'=>30)),array($v['MeetingRooms']['mr_room'],array()),array($v['MeetingRooms']['mr_person_num'].' 人',array()),array($v['MeetingRooms']['mr_status'] == 1?'<span class=_green>开放</span>':($v['MeetingRooms']['mr_status'] == 0?'<span class=_red>已被预约</span>':'<span class=_yellow>维修关闭中</span>'),array()),array($v['User']['u_true_name'],array()),array(date('Y/m/d H:i',$v['MeetingRooms']['u_order_time']).' 至 '.date('Y/m/d H:i',$v['MeetingRooms']['u_order_end_time']),array()),array($v['MeetingRooms']['mr_clean']?$this->Html->link("已打扫",array('controller'=>'Company','action'=>'meetingRoom/clean:0/room:'.$v['MeetingRooms']['mr_id']),array('title'=>'点击到未打扫','class'=>'_green')):$this->Html->link("未打扫",array('controller'=>'Company','action'=>'meetingRoom/clean:1/room:'.$v['MeetingRooms']['mr_id']),array('title'=>'点击确认已打扫','class'=>'_red')),array()),array($this->Html->link('【编辑】',array('controller'=>'Company','action'=>'meetingRoom/orderEdit:'.$v['MeetingRooms']['mr_id']),array('title'=>'编辑')).'|'.$this->Html->link('【取消预约】',array('controller'=>'Company','action'=>'meetingRoom/cancelOrder:'.$v['MeetingRooms']['mr_id']),array('title'=>'取消预约'),'确认要取消该预约吗?'),array('width'=>140)));
}
}else{
echo $this->Html->tableHeaders(array('编号','会议室名称','可容纳人数','会议室状态','预约人','预约时间','是否打扫'),array(),array('class'=>'table_th'));
$meetingRoom = array();
foreach($meetingR as $v){
$meetingRoom[] =  array(array($v['MeetingRooms']['mr_id'],array('width'=>30)),array($v['MeetingRooms']['mr_room'],array()),array($v['MeetingRooms']['mr_person_num'].' 人',array()),array($v['MeetingRooms']['mr_status'] == 1?'<span class=_green>开放</span>':($v['MeetingRooms']['mr_status'] == 0?'<span class=_red>已被预约</span>':'<span class=_yellow>维修关闭中</span>'),array()),array($v['User']['u_true_name'],array()),array(date('Y/m/d H:i',$v['MeetingRooms']['u_order_time']).' 至 '.date('Y/m/d H:i',$v['MeetingRooms']['u_order_end_time']),array()),array($v['MeetingRooms']['mr_clean']?$this->Html->link("已打扫",array('controller'=>'Company','action'=>'meetingRoom/clean:0/room:'.$v['MeetingRooms']['mr_id']),array('title'=>'点击到未打扫','class'=>'_green')):$this->Html->link("未打扫",array('controller'=>'Company','action'=>'meetingRoom/clean:1/room:'.$v['MeetingRooms']['mr_id']),array('title'=>'点击确认已打扫','class'=>'_red')),array()));
}
}
echo $this->Html->tableCells($meetingRoom);
echo '</table>';

        }elseif($this->request['pass'][0] == 'orderAdd' || $this->request['named']['orderEdit']){ //会议室预约
 echo '<span class=_yellow>当会议室预约时间过期后，系统会自动释放该会议室状态为开放，届时其它人可以预约该会议室</span>';
echo $this->Html->script('My97DatePicker/WdatePicker.js');
         $meetingR = $hour = $minute = array();
           foreach($rooms as $v){
    $meetingR[$v['MeetingRooms']['mr_id']] = $v['MeetingRooms']['mr_room'];
}
            for($i=1;$i<=24;$i++){
            $hour[$i] =$i;
}
for($i=1;$i<=60;$i++){
            $minute[$i] =$i;
}
            echo $this->Form->create('MeetingRooms',array('url'=>array('controller'=>'Company','action'=>$this->request['named']['orderEdit']?'meetingRoom/orderEdit:'.$this->request['named']['orderEdit']:'meetingRoom/orderAdd','plugin'=>false)));
            echo '<table>';
if($this->request['named']['orderEdit']){
$roomArr = array(array($this->Form->hidden('mr_id',array('value'=>$this->request['named']['orderEdit'])).'预约会议室 '.$orderRoom[0]['MeetingRooms']['mr_room']));
}else{
$roomArr = array(array('可预约会议室 '.$this->Form->select('mr_id',array($meetingR),array('empty'=>false,'class'=>'_input'))));
}
echo $this->Html->tableCells(array(
           $roomArr,
           array(array('预约时间  &nbsp;开始时间'.$this->Form->input('u_order_time',array('div'=>false,'class'=>'_input','onClick'=>'WdatePicker()','label'=>false,'style'=>'width:110px')) .' '.$this->Form->select('s_hour',array($hour),array('empty'=>false)).'时 '.$this->Form->select('s_minute',array($minute),array('empty'=>false)).'分')),
           array(array('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;结束时间'.$this->Form->input('u_order_end_time',array('div'=>false,'class'=>'_input','onClick=WdatePicker()','label'=>false,'style'=>'width:110px')) .' '.$this->Form->select('e_hour',array($hour),array('empty'=>false)).'时 '.$this->Form->select('e_minute',array($minute),array('empty'=>false)).'分')),
           array(array($this->Form->end(array('div'=>false,'label'=>$this->request['named']['orderEdit']?'修改预约':' 预 约 ','class'=>'_button'))))
));
echo '</table>';
        }
?>
</div>