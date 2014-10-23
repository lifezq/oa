<!--**
 * @filename staff.ctp
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-9-13  17:30:05
 * @version 1.0 
 *-->
<div class='div_main'>
       
          <?php 
echo '<table>';
if(empty($this->request['pass']) && empty($this->request['named'])){
echo $this->Html->tableHeaders(array('编号','员工姓名','性别','年龄','所在部门','所在职位','个人简历','启用','操作'),array(),array('align'=>'center','class'=>'table_th')); 

          foreach($users as $v):
          echo $this->Html->tableCells(
           array($v['User']['u_id'],$v['User']['u_true_name'],($v['User']['u_sex']?"男":"女"),$v['User']['u_age'],$v['Class']['cp_name'],$v['Posts']['cp_name'],($v['User']['u_resume_type']==0?"<span class='_yellow'>未创建简历</span>":($v['User']['u_resume_type']==1?"<span class='_green'>已上传简历</span>":"<span class='_green'>已完善简历信息</span>")),($v['User']['u_is_close'] == 0)?$this->Html->link('已启用',array('controller'=>'Users','action'=>'userOption/close/'.$v['User']['u_id']),array('title'=>'点击禁用','style'=>'color:green')):$this->Html->link('已禁用',array('controller'=>'Users','action'=>'userOption/open/'.$v['User']['u_id']),array('title'=>'点击启用','style'=>'color:red')),($v['User']['u_resume_type']==1?$this->Html->link('【下载简历】|',array('controller'=>'Staff','action'=>'staff/down:'.$v['User']['u_id']),array('title'=>'下载简历')):($v['User']['u_resume_type']==2?$this->Html->link('【查看简历】|',array('controller'=>'Staff','action'=>'staff/read:'.$v['User']['u_id']),array('title'=>'查看简历')):"")).$this->Html->link($v['User']['u_resume_type']!=0?'【更新个人简历】':'【创建个人简历】',array('controller'=>'Staff','action'=>$v['User']['u_resume_type']!=0?'staff/resumeEdit:'.$v['User']['u_id']:'staff/resumeCreate:'.$v['User']['u_id']),array('title'=>$v['User']['u_resume_type']!=0?'更新个人简历':'创建个人简历')))
);
endforeach;
}elseif($this->request['named']['resumeCreate'] || $this->request['named']['resumeEdit']){
echo $this->Form->create('UserInfos',array('type'=>'file','url'=>array('controller'=>'Staff','action'=>'staff/resumeCreate:'.($this->request['named']['resumeCreate']?$this->request['named']['resumeCreate']:$this->request['named']['resumeEdit']),'plugin'=>false)));
            echo $this->Html->tableCells(array(
                 array(array('简历类型 '.$this->Form->radio('u_resume_type',array('1'=>'上传个人简历 ','2'=>'编辑个人简历信息'),array('legend'=>false,'hiddenField'=>false,'onClick'=>"changeResume(this.value)",'value'=>1)))),
                 array(array($this->Form->input('resume1',array('type'=>'file','div'=>false,'class'=>'_input','label'=>'请选择简历 '))."<span class='oa_td_notice'>允许上传格式:doc,docx,dps,rtf,wps</span>",array('id'=>'resume_1'))),
                 array(array('简历信息 '.$this->Form->textarea('resume2',array('style'=>'height:400px;')),array('style'=>'display:none;','id'=>'resume_2'))),
                 array(array($this->Form->end(array('label'=>'提 交','class'=>'_button','onClick'=>"return checkResume()"))))
));
echo $this->Html->script('tiny_mce/tiny_mce.js'); 
echo $this->Html->scriptBlock("
function checkResume(){
var _allowType = ['doc','docx','dps','rtf','wps'];
var resume = $('#UserInfosResume1').val();

if(resume == '') return true;
var _ext = resume.substr(resume.lastIndexOf('.')+1);

for(var i=0;i<_allowType.length;i++){
   if(_allowType[i] == _ext.toLowerCase()){
   return true;
}
}

return false;
}
function changeResume(_type){
if(_type == 1){
$('#resume_2').hide();
$('#resume_1').show();
}else{
$('#resume_1').hide();
$('#resume_2').show();

}
}
tinyMCE.init({
		// General options
		mode : \"textareas\",
		theme : \"advanced\",
		plugins : \"autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks\",

		// Theme options
		theme_advanced_buttons1 : \"save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect\",
		theme_advanced_buttons2 : \"cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor\",
		theme_advanced_buttons3 : \"tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen\",
		theme_advanced_buttons4 : \"insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks\",
		theme_advanced_toolbar_location : \"top\",
		theme_advanced_toolbar_align : \"left\",
		theme_advanced_statusbar_location : \"bottom\",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
//		content_css : \"css/content.css\",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : \"lists/template_list.js\",
		external_link_list_url : \"lists/link_list.js\",
		external_image_list_url : \"lists/image_list.js\",
		media_external_list_url : \"lists/media_list.js\",

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
			username : \"Some User\",
			staffid : \"991234\"
		}
	});

");




        }elseif($this->request['named']['read']){
echo $this->Html->tableCells(array(
      array(array('员工姓名 :'.$username)),
      array(array('<h2 class=_center>简历信息 </h2>'.$this->Html->tag('div',$resume,array('class'=>'read_content')))),
));
}
echo '</table>';
?>

</div>
