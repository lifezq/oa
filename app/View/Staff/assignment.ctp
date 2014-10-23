<!--**
 * @filename assignment.ctp
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-9-18  16:37:32
 * @version 1.0 
 *-->
<?php
echo "<div class='div_main'>";
if($this->request['pass'][0] != 'add'){
echo $this->Html->link('【任务分配】',array('controller'=>'Staff','action'=>'assignment/add'),array('title'=>'任务分配')).' '.$this->Html->link('【任务分配管理列表】',array('controller'=>'Staff','action'=>'assignment'),array('title'=>'任务分配管理列表'));
}
if(empty($this->request['pass']) && empty($this->request['named'])){
            
echo '<table>';
echo $this->Html->tableHeaders(array('编号','执行员工','计划用时','任务状态','备注','发布时间','操作'),array(),array('class'=>'table_th'));
$_Assignment = array();
foreach($Assignment as $v){
$_Assignment[] = array(array($v['Assignment']['a_id'],array('width'=>30)),array(oa_mb_substr($v['Assignment']['a_users'],0,20),array()),array($v['Assignment']['a_use_time'].'小时',array()),array($v['Assignment']['a_status']==0?"<span class='_yellow'>待完成</span>":($v['Assignment']['a_status']==1?"<span class='_green'>已完成</span>":"<span class='_red'>进行中</span>"),array()),array($v['Assignment']['a_remark'],array()),array(date('Y/m/d H:i',$v['Assignment']['created']),array()),array($this->Html->link('【编辑】',array('controller'=>'Staff','action'=>'assignment/edit:'.$v['Assignment']['a_id']),array('title'=>'编辑')),array()));
}
echo $this->Html->tableCells($_Assignment);
echo '</table>';
if($this->Paginator->hasPage('Assignment')):
 include_once '../View/Layouts/paginate.ctp';//载入分页
endif;
        }if($this->request['pass'][0] == 'add' || $this->request['named']['add'] || $this->request['named']['edit']){
echo "<span class='_yellow'>任务下达后，系统会自动通知接收任务的员工</span>";
echo $this->Form->create('Assignment',array('url'=>array('controller'=>'Staff','action'=>'assignment/'.($this->request['named']['edit']?'edit:'.$this->request['named']['edit'].'/':'').($this->request['named']['add']?"add:".$this->request['named']['add']:(empty($this->request['named']['edit'])?'add':'')),'plugin'=>false)));
            echo '<table>';
            echo $this->Html->tableCells(array(
             

             array(array('选择部门 '.$this->Form->select('a_class',array($_class),array('empty'=>false,'onChange'=>"selectClass(this.value)",'default'=>$this->request['named']['add']?$this->request['named']['add']:$assignInfo[0]['Assignment']['a_class'])))),
             array(array($this->Form->input('a_use_time',array('div'=>false,'label'=>'计划用时 ','class'=>'_input','style'=>'width:50px;','value'=>$assignInfo[0]['Assignment']['a_use_time'])).' 小时')),
             
             array(array($this->Form->input('a_users',array('div'=>false,'label'=>'接受任务员工 ','class'=>'_input','style'=>'width:350px;','readonly'=>true,'value'=>$assignInfo[0]['Assignment']['a_users'],'onClick'=>"$('#users').slideToggle()")))),
             array(array($member,array('id'=>'users','style'=>'display:none;'))),
             array(array('任务描述 <br/>'.$this->Form->textarea('a_task',array('class'=>'_input2','style'=>'height:300px;','value'=>$assignInfo[0]['Assignment']['a_task'])))),
             array(array($this->Form->input('a_remark',array('div'=>false,'label'=>'备注 ','class'=>'_input','style'=>'width:350px;','value'=>$assignInfo[0]['Assignment']['a_remark']))."<span class='oa_td_notice'>用于在管理列表内，更好更清楚地看到任务详细</span>")),
             array(array($this->Form->hidden('a_id',array('value'=>$this->request['named']['edit'])).$this->Form->end(array('label'=>$this->request['named']['edit']?'编辑任务':'下达任务','class'=>'_button'))))
));
echo '</table>';
echo $this->Html->script('tiny_mce/tiny_mce.js'); 
echo $this->Html->scriptBlock("
//tinyMCE.init({
//		mode : \"textareas\",
//		theme : \"simple\",
//              
//	});
var _uid  =[];
function addUser(_val){
var isAdd = true;

for(var i=0;i<_uid.length;i++){
     if(_uid[i] == _val){
       _uid.splice(i,1);
isAdd=false;
}
}

if(isAdd ==  true)
 _uid.push(_val);    

$('#AssignmentAUsers').val(_uid.join(';'));
}
function selectClass(classId){
var url = window.location.toString();

url = url.lastIndexOf('add')>0?url.substr(0,url.lastIndexOf('add'))+'add:'+classId:url+'/add:'+classId;

window.location.href = url;
}
");
?>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
//		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
<?php
        }
echo "</div>";
?>