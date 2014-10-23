<!--**
 * @filename meetting.ctp
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-9-10  16:20:08
 * @version 1.0 
 *-->
<div class="div_main">
<?php
if(empty($this->request['pass']) && empty($this->request['named'])){
$meetingArr = array();
if(count($meeting)){
foreach($meeting as $v){
if($v['MeetingRooms']['u_order_end_time'] < time()){ //预约已过期，会议已结束
$opButton = "<span class='_ccc'>已结束</span>".'|'.$this->Html->link('【删除】',array('controller'=>'Company','action'=>'meeting/del:'.$v['Meeting']['m_id']),array('title'=>'删除'),'确认要删除该会议吗?');
}elseif($v['Meeting']['u_id'] == $cur_uid){
$opButton = $this->Html->link('【编辑】',array('controller'=>'Company','action'=>'meeting/edit:'.$v['Meeting']['m_id']),array('title'=>'编辑')).'|'.$this->Html->link('【删除】',array('controller'=>'Company','action'=>'meeting/del:'.$v['Meeting']['m_id']),array('title'=>'删除'),'确认要删除该会议吗?');
}else{
$opButton = "<span class='_ccc'>【编辑】 |  【删除】</span>";
}
$meetingArr[] = array(array($v['Meeting']['m_id'],array('width'=>30)),array($v['User']['u_true_name'],array()),array($v['Meeting']['m_subject'],array()),array(date('Y/m/d H:i',$v['Meeting']['m_meet_time']),array()),array($v['MeetingRooms']['mr_room'],array()),array($v['MeetingRooms']['mr_clean']?'<span class=_green>已打扫</span>':'<span class=_yellow>未打扫</span>',array()),array($opButton,array()));
}
}else{
$meetingArr[] = array(array("<span class='_yellow'>暂时还没有任何会议安排</span>",array('colspan'=>7)));
}
           echo '<table>';
           echo $this->Html->tableHeaders(array('编号','会议主办人','会议主题','会议开始时间','会议室名','会议室打扫','操作'),array(),array('class'=>'table_th'));
           echo $this->Html->tableCells($meetingArr);
echo '</table>';
        }elseif($this->request['pass'][0] == 'add' || $this->request['named']['edit']){
echo "<div class='_clear'>&nbsp;</div>";
         $meetingR = $hour = $minute = array();
if(!empty($meetingRoom)){
foreach($meetingRoom as $v){
$meetingR[$v['MeetingRooms']['mr_id']] = $v['MeetingRooms']['mr_room'];
}
 }

      $_classLink = $_personLink = '';
           foreach($_class as $v):
              $_classLink .= $this->Html->link($v['ClassPosts']['cp_name'],'javascript:void(0);',array('title'=>$v['ClassPosts']['cp_name'],'onClick'=>"yourChoice(1,'".$v['ClassPosts']['cp_id']."-".$v['ClassPosts']['cp_name']."')")).'&nbsp;&nbsp;';
endforeach;
foreach($_users as $v):
$_personLink .= $this->Html->link($v['User']['u_true_name'],'javascript:void(0);',array('title'=>$v['User']['u_true_name'],'onClick'=>"yourChoice(0,'".$v['User']['u_id']."-".$v['User']['u_true_name']."')")).'&nbsp;&nbsp;';
endforeach;
            for($i=1;$i<=24;$i++){
            $hour[$i] =$i;
}
for($i=1;$i<=60;$i++){
            $minute[$i] =$i;
}
           echo $this->Form->create('Meeting',array('url'=>array('controller'=>'Company','action'=>$meeting[0]['Meeting']['m_id']?'meeting/edit:'.$meeting[0]['Meeting']['m_id']:'meeting/add','plugin'=>false)));
           echo '<table>';
if(!empty($meetingR)){
           echo $this->Html->tableCells(array(
                array(array('已预约的会议室 '.$this->Form->select('mr_id',array($meetingR),array('div'=>false,'empty'=>false,'class'=>'_input','onChange'=>"readMeetTime(this.value);",'default'=>$meeting[0]['Meeting']['mr_id'])))),
                array(array("会议预约开始时间 <span id='u_order_time' class='_green'>".date('Y/m/d H:i',$meeting[0]['Meeting']['m_id']?$meeting[0]['MeetingRooms']['u_order_time']:$meetingRoom[0]['MeetingRooms']['u_order_time']."</span>"))),
                array(array("会议预约结束时间 <span id='u_order_end_time' class='_red'>".date('Y/m/d H:i',$meeting[0]['Meeting']['m_id']?$meeting[0]['MeetingRooms']['u_order_end_time']:$meetingRoom[0]['MeetingRooms']['u_order_end_time']."</span>"))),
                array(array("会议室可容纳人数  <span id='mr_person_num' class='_green'>".($meeting[0]['Meeting']['m_id']?$meeting[0]['MeetingRooms']['mr_person_num']:$meetingRoom[0]['MeetingRooms']['mr_person_num'])."</span> 人")),
                array(array($this->Form->input('m_subject',array('div'=>false,'label'=>'会议主题 ','class'=>'_input','value'=>$meeting[0]['Meeting']['m_subject'])))),
                array(array($this->Form->input('m_meet_time',array('div'=>false,'label'=>'会议开始时间 ','class'=>'_input','style'=>'width:100px','onClick'=>'WdatePicker()','value'=>$meeting[0]['Meeting']['m_meet_time']?date('Y-m-d',$meeting[0]['Meeting']['m_meet_time']):'')).' '.$this->Form->select('s_hour',array($hour),array('empty'=>false,'default'=>date('H',$meeting[0]['Meeting']['m_meet_time']))).'时 '.$this->Form->select('s_minute',array($minute),array('empty'=>false,'default'=>date('i',$meeting[0]['Meeting']['m_meet_time']))).'分 ')),
                array(array("请选择通知类型  <input type='radio' value='1' id='notice_class' name='data[Meeting][notice_type]' onClick='changeType(1)' ".($meeting[0]['Meeting']['m_class_id']?"checked='checked'":"")."/> <label for='notice_class'>通知部门</label>  <input type='radio' value='0' id='notice_person' name='data[Meeting][notice_type]' onClick='changeType(0)' ".($meeting[0]['Meeting']['m_join_uids']?"checked='checked'":"")."/> <label for='notice_person'>通知个人</label>  "  )),
                array(array($this->Form->hidden('final_choice',array('id'=>'final_choice','value'=>$meeting[0]['Meeting']['m_class_id']?$meeting[0]['Meeting']['m_class_id']:$meeting[0]['Meeting']['m_join_uids'])).$this->Form->input('your_choice',array('div'=>false,'label'=>'您的选择 ','class'=>'_input','style'=>'width:450px;','readonly'=>true,'id'=>'your_choice','value'=>$_str)))),
                array(array('公司部门 '.$_classLink,array('style'=>'display:none','id'=>'_class'))),
                array(array('公司职员 '.$_personLink,array('style'=>'display:none','id'=>'_person'))),
                array(array($this->Form->hidden('m_id',array('value'=>$meeting[0]['Meeting']['m_id'])).$this->Form->end(array('div'=>false,'label'=>$meeting[0]['Meeting']['m_id']?'编辑会议':'提交会议','class'=>'_button')))),
));
}else{
         echo $this->Html->tableCells(array(
                array(array('<span class=_yellow>亲，您还没有预约会议室哦! 点击这里</span>'.$this->Html->link('预约会议室',array('controller'=>'Company','action'=>'meetingRoom/orderAdd'),array('title'=>'预约会议室')))),
));
}
echo '</table>';
echo $this->Html->scriptBlock("
var _yourChoice = [];

function changeType(_type){
    _yourChoice =  [];
    $('#your_choice').val('');
    $('#final_choice').val('');
    if(_type == 1){
        $('#_class').slideToggle();
        $('#_person').hide();
    }else{
        $('#_person').slideToggle();
        $('#_class').hide();
    }
}

function yourChoice(_type,val){
    val = val.split('-');
    var _vals = val[1];
    val = val[0];
    var isAdd = true;
    for(var i=0;i<_yourChoice.length;i++){
        if(_yourChoice[i] == val){
            _yourChoice.splice(i,1);
            var your_choice = $('#your_choice').val();
            your_choice = your_choice.split(';');
            your_choice.splice(i,1);
            $('#your_choice').val(your_choice)
            isAdd = false;
        }
    }
    
    if(isAdd ==  true){
        _yourChoice.push(val); 
        if($('#your_choice').val() != ''){
            $('#your_choice').val($('#your_choice').val()+';'+_vals);
        }else{
            $('#your_choice').val(_vals);
        }
    }


    if(_type == 1){
        $('#final_choice').val(_yourChoice.join(','));
    }else{
        $('#final_choice').val(_yourChoice.join(','));
    }
}
function readMeetTime(_val){
 if(!_val) return;
 $.ajax({
   'type':'get',
   'url':'meeting/orderTime:'+_val,
   success:function(msg){
   var _time = msg.split('-');
   $('#u_order_time').html(_time[0]);
   $('#u_order_end_time').html(_time[1]);
   $('#mr_person_num').html(_time[2]);
    return false;
}
})
return false;
}
");
        }
?>
</div>