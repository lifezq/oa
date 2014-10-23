<!DOCTYPE>
<html>
<head>
<?php echo $this->Html->charset(); ?>
	<title>
		
		<?php echo $title_for_layout; ?>
	</title>
<link href="<?php echo Configure::read('WEB_ROOT'); ?>css/zq_main.css" type="text/css" rel="stylesheet"/>
<link href="<?php echo Configure::read('WEB_ROOT'); ?>css/lifezq.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript" src="<?php echo Configure::read('WEB_ROOT'); ?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo Configure::read('WEB_ROOT'); ?>js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>
  <div class="div_main_box">
     <div class="div_main_top">
        <h1> &gt;&gt; <?php if(isset($_position)) echo $_position.'&nbsp;&nbsp;'; echo $this->Html->link('【返回】','javascript:void(0);',array('onClick'=>'javascript:history.back();')).'&nbsp;'.$this->Html->link('【刷新】','javascript:void(0);',array('onClick'=>'javascript:window.location.reload(true);'));?> </h1>
     </div>

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>

	
	<?php echo $this->element('sql_dump'); ?>
  </div>
</body>
</html>