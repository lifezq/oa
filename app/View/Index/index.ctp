<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Pages
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

//App::uses('Debugger', 'Utility');
?>
<frameset rows="105,*" frameborder="0">
     <frame src="<?php echo Configure::read('ROOT');?>index/top" name="top" /> 
     <frameset cols="235,*" frameborder="0"> 
         <frame src="<?php echo Configure::read('ROOT');?>index/menu" name="menu" scrolling="no"/>
         <frame src="<?php echo Configure::read('ROOT');?>index/main" name="main" />
     </frameset>
  </frameset><noframes></noframes>
