<!--**
 * @filename workDiary.ctp
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-9-4  17:27:31
 * @version 1.0
 *-->
<div class="div_main">
<?php
$opLink = '';
if(isset($manageButton))
$opLink = $this->Html->link('【管理工作日志】',array('controller'=>'Users','action'=>'workDiary/manage'),array('title'=>'管理工作日志'));
echo $this->Html->link('【新增工作日志】',array('controller'=>'Users','action'=>'workDiary/add'),array('title'=>'新增工作日志')).'&nbsp;'.$this->Html->link('【近期工作日志】',array('controller'=>'Users','action'=>'workDiary'),array('title'=>'近期工作日志')).'&nbsp;'.$opLink;


   if((empty($this->request['pass']) || $this->request['pass'][0] == 'manage' || $this->request['pass'][0] == 'search') && empty($this->request['named'])):
echo $this->Html->script('My97DatePicker/WdatePicker.js');
echo '<table>';
$searchName = array();

         if(isset($manageButton)):
          $searchName = array($this->Form->create('searchForm',array('url'=>array('controller'=>'Users','action'=>'workDiary/search','plugin'=>false))).' 根据姓名查询 '.$this->Form->input('_searchName',array('div'=>false,'class'=>'_input','label'=>false)).$this->Form->end(array('label'=>'查询','class'=>'_button','div'=>false,"onClick"=>"if($('#searchFormSearchName').val() == '') return false;")),array());
endif;
         echo $this->Html->tableCells(array(
              array(
              array('快速查询',array('width'=>80,'align'=>'center')),
              array($this->Form->create('searchForm',array('url'=>array('controller'=>'Users','action'=>'workDiary/search','plugin'=>false))).' 根据日期查询 '.$this->Form->input('_searchDate',array('div'=>false,'class'=>'_input','label'=>false,'onClick=WdatePicker()')).$this->Form->end(array('label'=>'查询','class'=>'_button','div'=>false,"onClick"=>"if($('#searchFormSearchDate').val() == '') return false;")),array()),
              $searchName     
)
));
echo '</table>';

echo '<table>';
if($this->request['pass'][0] == 'manage' || $this->request['pass'][0] == 'search'):
        echo  $this->Html->tableHeaders(array('编号','姓名','工作总结','领导评价','日志日期','操作'),array(),array('class'=>'table_th'));
        $tdWorkList = array();
        $_edit = '';
        foreach($WorkDiarys as $v):
if($oa_uid == $v['WorkDiarys']['u_id']):
 $_edit = $this->Html->link('【编辑】',array('controller'=>'Users','action'=>'workDiary/edit:'.$v['WorkDiarys']['w_id']),array('title'=>'编辑')).'|';
endif;
           $tdWorkList[] = array(array($v['WorkDiarys']['w_id'],array('width'=>30)),array($v['WorkDiarys']['w_username'],array('width'=>65)),array($v['WorkDiarys']['w_summary'],array()),array($v['WorkDiarys']['w_appraise']?$v['WorkDiarys']['w_appraise']:'<span class=_yellow>暂无评价</span>',array()),array(date('Y/m/d H:i:s',$v['WorkDiarys']['created']),array()),array($this->Html->link('【查看】',array('controller'=>'Users','action'=>'workDiary/read:'.$v['WorkDiarys']['w_id']),array('title'=>'查看')).'|'.$_edit.$this->Html->link('【删除】',array('controller'=>'Users','action'=>'workDiary/del:'.$v['WorkDiarys']['w_id']),array('title'=>'删除'),'确认要删除吗?'),array()));
endforeach;
       echo $this->Html->tableCells($tdWorkList);
else:

        echo  $this->Html->tableHeaders(array('编号','工作总结','领导评价','日志日期','操作'),array(),array('class'=>'table_th'));
        $tdWorkList = array();
        foreach($WorkDiarys as $v):
           $tdWorkList[] = array(array($v['WorkDiarys']['w_id'],array('width'=>30)),array($v['WorkDiarys']['w_summary'],array()),array($v['WorkDiarys']['w_appraise']?$v['WorkDiarys']['w_appraise']:'<span class=_yellow>暂无评价</span>',array()),array(date('Y/m/d H:i:s',$v['WorkDiarys']['created']),array()),array($this->Html->link('【查看】',array('controller'=>'Users','action'=>'workDiary/read:'.$v['WorkDiarys']['w_id']),array('title'=>'查看')).'|'.$this->Html->link('【编辑】',array('controller'=>'Users','action'=>'workDiary/edit:'.$v['WorkDiarys']['w_id']),array('title'=>'编辑')).'|'.$this->Html->link('【删除】',array('controller'=>'Users','action'=>'workDiary/del:'.$v['WorkDiarys']['w_id']),array('title'=>'删除'),'确认要删除吗?'),array()));
endforeach;
       echo $this->Html->tableCells($tdWorkList);
endif;
echo '</table>';
if($this->Paginator->hasPage('WorkDiarys')):
include_once '../View/Layouts/paginate.ctp';//载入分页
endif;
      elseif($this->request['pass'][0] == 'add' || $this->request['named']['edit']):
echo '<table>';
        echo $this->Form->create('WorkDiarys',array('url'=>array('controller'=>'Users','action'=>$workDiary[0]['WorkDiarys']['w_id']?'workDiary/edit:'.$workDiary[0]['WorkDiarys']['w_id']:'workDiary/add','plugin'=>false)));
        echo  $this->Html->tableCells(array(
           array(array('今天日期',array('width'=>60)),array(date('Y年m月d日 H:i'),array())),
           array(array('工作内容',array('width'=>60)),array($this->Form->textarea('w_diary',array('style'=>'height:200px','value'=>$workDiary[0]['WorkDiarys']['w_diary'])),array())),
           array(array('工作总结',array('width'=>60)),array($this->Form->textarea('w_summary',array('style'=>'height:70px','value'=>$workDiary[0]['WorkDiarys']['w_summary'])),array())),
           array(array('备注',array('width'=>60)),array($this->Form->textarea('w_remark',array('style'=>'height:120px','value'=>$workDiary[0]['WorkDiarys']['w_remark'])),array())),
           array(array($this->Form->hidden('w_id',array('value'=>$workDiary[0]['WorkDiarys']['w_id'])),array('width'=>60)),array($this->Form->end(array('label'=>$workDiary[0]['WorkDiarys']['w_id']?'编 辑':'添 加','class'=>'_button')),array())),
));
echo '</table>';

elseif($this->request['named']['read']):
echo $this->Form->create('WorkDiarys',array('url'=>array('controller'=>'Users','action'=>'workDiary/read:'.$workDiary[0]['WorkDiarys']['w_id'])));
echo '<table>';
$appraise = $button = array();
if(isset($manageButton)):
$appraise = array(array('给予评价',array('width'=>60)),array($this->Form->textarea('w_appraise',array('style'=>'height:120px','value'=>$workDiary[0]['WorkDiarys']['w_appraise'])),array()));
$button  = array(array($this->Form->hidden('w_id',array('value'=>$workDiary[0]['WorkDiarys']['w_id'])),array('width'=>60)),array($this->Form->end(array('label'=>'评 价','div'=>false,'class'=>'_button')),array()));
endif;
        echo  $this->Html->tableCells(array(
           array(array('今天日期',array('width'=>60)),array(date('Y年m月d日 H:i'),array())),
           array(array('工作内容',array('width'=>60)),array($this->Html->tag('div',$workDiary[0]['WorkDiarys']['w_diary'],array('class'=>'read_content')),array())),
           array(array('工作总结',array('width'=>60)),array($this->Html->tag('div',$workDiary[0]['WorkDiarys']['w_summary'],array('class'=>'read_content')),array())),
           array(array('备注',array('width'=>60)),array($this->Html->tag('div',$workDiary[0]['WorkDiarys']['w_remark'],array('class'=>'read_content')),array())),
           $appraise,$button
));

echo '</table>';
endif;

    echo $this->Html->script('tiny_mce/tiny_mce.js'); 
echo $this->Html->scriptBlock("tinyMCE.init({
		mode : \"textareas\",
		theme : \"simple\",
                
	});");
?>
</div>