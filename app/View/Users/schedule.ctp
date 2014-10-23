<!--**
 * @filename schedule.ctp
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-9-4  13:17:31
 * @version 1.0
 *-->
<div class="div_main">
<?php
$str = array();
   for($i=1;$i<=date('t');$i++){
       $_myschedule = $_schedule[$i-1];
       if($i == date('d'))  $_myschedule = '<span class=_green>今日行程：'.$_schedule[$i-1].'</span>';
       $str []= array(array(date('Y年m月').$i.'日',array('width'=>100)),array((($_schedule == null || empty($_schedule[$i-1]))?'暂无行程安排&nbsp;&nbsp;':$_myschedule).'&nbsp;&nbsp;&nbsp;&nbsp;'.$this->Html->link('【录入行程】','javascript:void(0)',array('onClick'=>'add_schedule('.$i.',0)')),array('id'=>'schedule_'.$i)));
}
echo '<table>';
echo $this->Html->tableCells($str);
echo '</table>';
echo $this->Html->scriptBlock("function add_schedule(_day,_val){
if(!_val){
$('#schedule_'+_day).html(\"<input name='schedule' value='请输入今日行程' onFocus=if(this.value=='请输入今日行程')this.value='' class='_input' style='width:96%' onBlur=add_schedule(\"+_day+\",this.value) />\");
}else{
$.ajax({
 'type':'post',
  'url':'schedule',
  'data':{'day':_day,'schedule':_val},
   success:function (msg){
     if(msg == 1){
     alert('行程已成功录入')
}else{
     alert('行程录入失败，请稍候再试...')
}
}

});
}
}");
?>

</div>
