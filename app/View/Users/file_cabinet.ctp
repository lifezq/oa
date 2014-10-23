<!--**
 * @filename file_cabinet.ctp
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-9-5  14:53:02
 * @version 1.0
 *-->
<div class='div_main'>
<?php
echo $this->Html->link('【存放文件】',array('controller'=>'Users','action'=>'fileCabinet/add'),array('title'=>'存放文件')).'|'.$this->Html->link('【文件柜列表】',array('controller'=>'Users','action'=>'fileCabinet'),array('title'=>'文件柜列表'));
if(empty($this->request['pass']) && empty($this->request['named'])){
         $cabinetArr = array();
            echo '<table>';
         echo $this->Html->tableHeaders(array('编号','文件名','文件类型','文件大小','上传时间','操作'),array(),array('class'=>'table_th'));
         foreach($cabinetList as $v){
              $type = strrchr($v['Cabinets']['c_file_path'],'.');
              $cabinetArr[] = array(array($v['Cabinets']['c_id'],array()),array($v['Cabinets']['c_file_name'],array()),array($type,array()),array(number_format($v['Cabinets']['c_file_size']/1024/1024,2).'M',array()),array(date('Y/m/d H:i:s',$v['Cabinets']['created']),array()),array($this->Html->link('【下载】',array('controller'=>'Users','action'=>'fileCabinet/down:'.$v['Cabinets']['c_id']),array('title'=>'下载')).'|'.$this->Html->link('【删除】',array('controller'=>'Users','action'=>'fileCabinet/del:'.$v['Cabinets']['c_id']),array('title'=>'删除'),'确认要删除该文件吗?'),array()));
}
         echo $this->Html->tableCells($cabinetArr);
 echo '</table>';
        }elseif($this->request['pass'][0] == 'add'){
        if($isOpen[0]['User']['u_file_cabinet']){ 
echo '<span class=_red>您当前文件柜已经被禁用了，请联系管理员开启后方能上传文件到文件柜</span>';
}else{

echo "<span class='_green'>当前您的文件柜大小为".number_format($isOpen[0]['User']['u_cabinet_size']/1024/1024,2)."M  &nbsp;&nbsp;剩余空间大小为".number_format($isOpen[0]['User']['u_free_size']/1024/1024,2)."M</span>";
echo $this->Form->create('Cabinets',array('type'=>'file','url'=>array('controller'=>'Users','action'=>'fileCabinet/add','plugin'=>false)));
          echo '<table>';
          echo $this->Html->tableCells(array(
               array(array($this->Form->input('c_file_name',array('div'=>false,'class'=>'_input','label'=>'文件名称 ')).'&nbsp;<span class=oa_td_notice>指定您要上传的文件名称，可以不填，默认为上传的文件名称</span>',array())),
               array(array($this->Form->file('c_file_path',array('div'=>false,'class'=>'_input','label'=>'选择文件 ')).'&nbsp;<span class=oa_td_notice>您上传的文件大小不能超过您当前文件柜剩余空间大小</span>',array())),
               array(array($this->Form->hidden('allow_size',array('value'=>$isOpen[0]['User']['u_free_size'])).$this->Form->end(array('div'=>false,'class'=>'_button','label'=>'上 传')).'&nbsp;',array())),
));
echo '</table>';
  }
        }
?>
</div>