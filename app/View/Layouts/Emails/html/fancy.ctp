<!--**
 * @filename welcome.ctp
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-8-26  17:40:58
 * @version 1.0
 *-->
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
	<title><?php echo $title_for_layout; ?></title>
</head>
<body>
	<?php echo $this->fetch('content'); ?>
        <p style="text-align:right;">之晴OA办公自动化管理系统</p>
        <p style="text-align:right;">http://oa.lifezq.com</p>
        <p style="text-align:right;">发送时间:<?php echo date('Y/m/d H:i:s');?></p>
	<p>此邮件为系统自动发送，请勿直接回复</p>
        
</body>
</html>

