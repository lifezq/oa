<!--**
 * @author 杨乾磊
 * @email  lifezqy@126.com
 * @link   http://blog.lifezq.com
 * @copyright (c) 2012-2013
 * @license http://www.gnu.org/licenses/
 * @version 1.0
 *-->
<!DOCTYPE>
<html>
<head>
<?php echo $this->Html->charset(); ?>
	<title>
		
		<?php echo $title_for_layout; ?>
	</title>
<link href="<?php echo Configure::read('WEB_ROOT'); ?>css/login.css" type="text/css" rel="stylesheet"/>
</head>
<body>


			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>


</body>
</html>