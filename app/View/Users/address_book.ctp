<!--**
 * @filename internet_emails.ctp
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-8-27  22:04:32
 * @version 1.0
 *-->
<div class="div_main">
    <?php echo $this->Html->link('【添加联系人】',array('controller'=>'Users','action'=>'addressBook/add')).'&nbsp;'.$this->Html->link('【联系人列表】',array('controller'=>'Users','action'=>'addressBook'));
if(empty($this->request['pass'])){
echo '<table>';
echo $this->Html->tableHeaders(array('编号','联系人','所在公司','移动电话','固定电话','传真电话','QQ','Email','住址','操作'),array(),array('class'=>'table_th'));
foreach($addressBook as $v):
echo $this->Html->tableCells(array(
      array($v['AddressBook']['a_id'],$v['AddressBook']['a_username'],$v['AddressBook']['a_company'],$v['AddressBook']['a_mobile'],$v['AddressBook']['a_telephone'],$v['AddressBook']['a_faxaphone'],$v['AddressBook']['a_qq'],$v['AddressBook']['a_email'],$v['AddressBook']['a_address'],$this->Html->link('【编辑】',array('controller'=>'Users','action'=>'addressBook/edit/'.$v['AddressBook']['a_id']),array('title'=>'编辑')).'|'.$this->Html->link('【删除】',array('controller'=>'Users','action'=>'addressBook/del/'.$v['AddressBook']['a_id']),array('title'=>'删除'),'确认要删除联系人:'.$v['AddressBook']['a_username'].'吗?\r\n 执行此操作后，将无法恢复')),
));
endforeach;
echo '</table>';
}elseif($this->request['pass'][0] == 'add' || $this->request['pass'][0] == 'edit'){
echo $this->Form->create('AddressBook',array('url'=>array('controller'=>'Users','action'=>'addressBook/'.($addressBook[0]['AddressBook']['a_id']?'edit':'add')),'plugin'=>false));
echo '<table>';
 echo $this->Html->tableCells(array(
    array(array('联系人姓名:', array('align' => 'right','width'=>'12%')) ,array($this->Form->input('a_username',array('div'=>false,'label'=>false,'class'=>'_input','value'=>$addressBook[0]['AddressBook']['a_username'])),array('align'=>'left'))),
    array(array('姓名拼音:', array('align' => 'right','width'=>'12%')) ,array($this->Form->input('a_spellname',array('div'=>false,'label'=>false,'class'=>'_input','value'=>$addressBook[0]['AddressBook']['a_spellname'])),array('align'=>'left'))),
    array(array('所在公司:', array('align' => 'right','width'=>'12%')) ,array($this->Form->input('a_company',array('div'=>false,'label'=>false,'class'=>'_input','value'=>$addressBook[0]['AddressBook']['a_company'])),array('align'=>'left'))),
    array(array('移动电话:', array('align' => 'right','width'=>'12%')) ,array($this->Form->input('a_mobile',array('div'=>false,'label'=>false,'class'=>'_input','value'=>$addressBook[0]['AddressBook']['a_mobile'])).'&nbsp;',array('align'=>'left'))),
    array(array('固定电话:', array('align' => 'right','width'=>'12%')) ,array($this->Form->input('a_telephone',array('div'=>false,'label'=>false,'class'=>'_input','value'=>$addressBook[0]['AddressBook']['a_telephone'])).'&nbsp;',array('align'=>'left'))),
    array(array('传真电话:', array('align' => 'right','width'=>'12%')) ,array($this->Form->input('a_faxaphone',array('div'=>false,'label'=>false,'class'=>'_input','value'=>$addressBook[0]['AddressBook']['a_faxaphone'])),array('align'=>'left'))),
    array(array('住址:', array('align' => 'right','width'=>'12%')) ,array($this->Form->input('a_address',array('div'=>false,'label'=>false,'class'=>'_input','value'=>$addressBook[0]['AddressBook']['a_address'])),array('align'=>'left'))),
    array(array('QQ:', array('align' => 'right','width'=>'12%')) ,array($this->Form->input('a_qq',array('div'=>false,'label'=>false,'class'=>'_input','value'=>$addressBook[0]['AddressBook']['a_qq']),array('align'=>'left')))),
    array(array('Email:', array('align' => 'right','width'=>'12%')) ,array($this->Form->input('a_email',array('div'=>false,'label'=>false,'class'=>'_input','value'=>$addressBook[0]['AddressBook']['a_email']),array('align'=>'left')))),
    array(array('备注:', array('align' => 'right','width'=>'12%')) ,array($this->Form->textarea('a_remark',array('class'=>'_input2','value'=>$addressBook[0]['AddressBook']['a_remark'])),array('align'=>'left'))),
    array(array($this->Form->input('a_id',array('div'=>false,'label'=>false,'type'=>'hidden','value'=>$addressBook[0]['AddressBook']['a_id'])), array('align' => 'right','width'=>'12%')) ,array($this->Form->end(array('class'=>'_button','label'=>$addressBook[0]['AddressBook']['a_id']?'修改联系人':'创建联系人','id'=>'create_user_submit')),array('align'=>'left')))
));
echo '</table>';
}
?>
</div>
