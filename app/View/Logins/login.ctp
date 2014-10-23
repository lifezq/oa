<!--**
 * @author 杨乾磊
 * @email  lifezqy@126.com
 * @link   http://blog.lifezq.com
 * @copyright (c) 2012-2013
 * @license http://www.gnu.org/licenses/
 * @version 1.0
 *-->
<link href="<?php echo Configure::read('WEB_ROOT'); ?>css/lifezq.css" type="text/css" rel="stylesheet"/>
  <div class="login">
      <br/>
      <h1 class="_center" style="color:#fff;">之晴OA办公系统</h1>
     <div class="login_text">
         
<?php echo $this->Form->create('User');?>
        <table width="100%">
        <?php echo $this->Html->tableCells(array(
        array(array('用户账号',array('align'=>'right')),array($this->Form->input('u_username',array('div'=>false,'label'=>false,'name'=>'User[u_username]','class'=>'L_input1')),array('align'=>'left'))),
        array(array('用户密码',array('align'=>'right')),array($this->Form->input('password',array('div'=>false,'label'=>false,'name'=>'User[u_password]','class'=>'L_input1','type'=>'password')),array('align'=>'left')))
));?>
           <tr>
             <td align="right">验证码:</td>
             <td><input type="text" name="User[verify]" size="6"  class="L_input2"/><img src="<?php echo Configure::read('ROOT'); ?>Logins/showCode" class="verify" onclick="this.src='<?php echo Configure::read('ROOT'); ?>Logins/showCode/'+new Date().getTime();
" /></td>
           </tr>
           <tr>
             <td align="right">&nbsp;</td>
             <td><?php echo $this->Form->end(array('label'=>"登 录",'class'=>'L_input3'));?></td>
           </tr>
          
        </table>
 </form>
     </div>
  </div>