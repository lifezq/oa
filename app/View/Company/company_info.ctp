<!--**
 * @author 杨乾磊
 * @email  lifezqy@126.com
 * @link   http://blog.lifezq.com
 * @copyright (c) 2012-2013
 * @license http://www.gnu.org/licenses/
 * @version 1.0
 *-->
<div class="div_main">
<?php echo $this->Html->link('【创建公司结构】','createStructure').'&nbsp;'.$this->Html->link('【公司信息】','companyInfo');?>
    <table>
        <?php
        echo $this->Form->create('Company',array('url'=>array('controller'=>'Company','action'=>'companyInfo','plugin'=>false)));
         
        echo $this->Html->tableCells(array(
            array(array('公司名称 '.$this->Form->input('com_company',array('div'=>false,'label'=>false,'class'=>'_input','value'=>$company['com_company'])),array()),array('&nbsp;',array('style'=>'color:#ccc'))),
            array(array('移动电话 '.$this->Form->input('com_mobile',array('div'=>false,'label'=>false,'class'=>'_input','value'=>$company['com_mobile'])),array()),array('&nbsp;',array('style'=>'color:#ccc'))),
            array(array('固定电话 '.$this->Form->input('com_telephone',array('div'=>false,'label'=>false,'class'=>'_input','value'=>$company['com_telephone'])),array()),array('公司固定电话,多个以|分开',array('style'=>'color:#ccc'))),
            array(array('传真号码 '.$this->Form->input('com_faxaphone',array('div'=>false,'label'=>false,'class'=>'_input','value'=>$company['com_faxaphone'])),array()),array('公司传真电话,,多个以|分开',array('style'=>'color:#ccc'))),
            array(array('邮箱地址 '.$this->Form->input('com_email',array('div'=>false,'label'=>false,'class'=>'_input','value'=>$company['com_email'])),array()),array('&nbsp;',array('style'=>'color:#ccc'))),
            array(array('所在城市 '.$this->Form->input('com_city',array('div'=>false,'label'=>false,'class'=>'_input','value'=>$company['com_city'])),array()),array('&nbsp;',array('style'=>'color:#ccc'))),
            array(array('公司地址 '.$this->Form->input('com_address',array('div'=>false,'label'=>false,'class'=>'_input','value'=>$company['com_address'])),array()),array('&nbsp;',array('style'=>'color:#ccc'))),
            array(array('客服QQ '.$this->Form->input('com_qq',array('div'=>false,'label'=>false,'class'=>'_input','value'=>$company['com_qq'])),array()),array('&nbsp;',array('style'=>'color:#ccc'))),
            array(array('公司官网 '.$this->Form->input('com_web',array('div'=>false,'label'=>false,'class'=>'_input','value'=>$company['com_web'])),array()),array('注意格式:(例如:http://www.baidu.com)',array('style'=>'color:#ccc'))),
            array(array('公司管理制度 '.$this->Form->textarea('com_regime',array('div'=>false,'label'=>false,'value'=>$company['com_regime'],'style'=>'width:450px;height:400px;')),array('style'=>'width:450px;overflow:hidden;')),array('',array('style'=>'color:#ccc'))),
            array(array($this->Form->hidden('com_id',array('value'=>$company['com_id'])).$this->Form->end(array('div'=>false,'label'=>'录 入','class'=>'_button')),array()),array('&nbsp;',array('style'=>'color:#ccc'))),
          ));?>
    </table>
</div>
<?php
echo $this->Html->script('tiny_mce/tiny_mce.js'); 

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