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
<p>亲爱的朋友：</p>
<?php
$content = explode("\n", $content);

foreach ($content as $line):
	echo '<p> ' . $line . "</p>\n";
endforeach;
?>
