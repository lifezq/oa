<!--**
 * @filename goods_manage.ctp
 * @encoding UTF-8
 * @author 杨乾磊
 * @email yangqianleizq@gmail.com
 * @link http://blog.lifezq.com
 * @copyright (c) 2012-2013  
 * @license http://www.gnu.org/licenses/
 * @datetime 2013-9-6  10:18:03
 * @version 1.0
 *-->
<div class="div_main">
<?php 
$opLink = '';
if(isset($manageButton)):
$opLink = $this->Html->link('【物品入库】',array('controller'=>'Company','action'=>'goodsManage/add'),array('title'=>'物品入库')).'&nbsp;'.$this->Html->link('【物品管理】',array('controller'=>'Company','action'=>'goodsManage'),array('title'=>'物品管理')).'&nbsp;'.$this->Html->link('【审核领取】',array('controller'=>'Company','action'=>'goodsManage/examine'),array('title'=>'审核领取')).'&nbsp;'.$this->Html->link('【物品分类】',array('controller'=>'Company','action'=>'goodsManage/type'),array('title'=>'物品分类')).'&nbsp;'.$this->Html->link('【物品出库】',array('controller'=>'Company','action'=>'goodsManage/get'),array('title'=>'物品出库'));
endif;
 echo $opLink.'&nbsp;'.$this->Html->link('【物品查看与领取申请】',array('controller'=>'Company','action'=>'goodsManage/list'),array('title'=>'物品查看与领取申请')).'&nbsp;'.$this->Html->link('【物品领取申请记录】',array('controller'=>'Company','action'=>'goodsManage/getRecord'),array('title'=>'物品领取申请记录'));
if((empty($this->request['pass']) || $this->request['pass'][0] == 'list') && empty($this->request['named'])){
                echo "<span class='oa_td_notice'>当库存数量为0时，将会出现删除按钮</span>";
                echo '<table>';
                echo $this->Html->tableHeaders(array('编号','物品名称','物品分类','物品单价','物品库存','入库人姓名','最后更新时间','操作'),array(),array('class'=>'table_th'));
                $goods = array();
                foreach($goodsList as $v):
                 if($this->request['pass'][0] == 'list'):
                  $opButton = $v['GoodsManages']['gm_remain']?$this->Html->link('【领取申请】',array('controller'=>'Company','action'=>'goodsManage/get:'.$v['GoodsManages']['gm_id'].'/type:1'),array('title'=>'领取申请')):"<span class='oa_td_notice'>领取申请</span>";
                 else:
                 $opButton = $this->Html->link('【编辑】',array('controller'=>'Company','action'=>'goodsManage/edit:'.$v['GoodsManages']['gm_id']),array('title'=>'编辑')).'|'.($v['GoodsManages']['gm_remain']?$this->Html->link('【出库】',array('controller'=>'Company','action'=>'goodsManage/get:'.$v['GoodsManages']['gm_id']),array('title'=>'出库')):$this->Html->link('【删除】',array('controller'=>'Company','action'=>'goodsManage/del:'.$v['GoodsManages']['gm_id']),array('title'=>'删除'),'确认要删除该物品吗?'));
                 endif;
                 $goods[] = array(array($v['GoodsManages']['gm_id'],array('width'=>30)),array(mb_substr($v['GoodsManages']['gm_goods_name'],0,15),array('width'=>140)),array($v['GoodsTypes']['gt_name']?$v['GoodsTypes']['gt_name']:"<span class='_yellow'>未分类</span>",array()),array($v['GoodsManages']['gm_price'],array()),array($v['GoodsManages']['gm_remain'],array()),array($v['GoodsManages']['gm_inventory_keeper'],array()),array(date('Y/m/d H:i',$v['GoodsManages']['modified']),array()),array($opButton,array()));
 endforeach;
                echo $this->Html->tableCells($goods);
echo '</table>';
if($this->Paginator->hasPage('GoodsManages')):
 include_once '../View/Layouts/paginate.ctp';//载入分页
endif;
            }elseif($this->request['pass'][0] == 'add' || $this->request['named']['edit']){
                echo $this->Form->create('GoodsManages',array('url'=>array('controller'=>'Company','action'=>$this->request['named']['edit']?'goodsManage/edit:'.$this->request['named']['edit']:'goodsManage/add'),'plugin'=>false));
                echo '<table>';
                $typeArr = array();
                $typeArr[0] = '--物品分类--';
                $typeNotice = count($goodsTypes) ? "<span class='oa_td_notice'>物品分类可以很快的帮助您查找和管理公司物品</span>" :"<span class='oa_td_notice'>您还没有物品分类喔，赶快创建分类吧，创建后查找物品更加便捷喔</span>";
                foreach($goodsTypes as $v){
                $typeArr[$v['GoodsTypes']['gt_id']] = $v['GoodsTypes']['gt_name'];
}
                echo $this->Html->tableCells(array(
array(array('请选择物品分类'.$this->Form->select('gt_id',array($typeArr),array('div'=>false,'class'=>'_input','empty'=>false,'default'=>$goods[0]['GoodsManages']['gt_id'])).'&nbsp;&nbsp;'.$typeNotice)),
                     array(array($this->Form->input('gm_goods_name',array('div'=>false,'label'=>' 物品名称 ','class'=>'_input','value'=>$goods[0]['GoodsManages']['gm_goods_name']))."<span class='oa_td_notice'>物品名称</span>")),
                     
                     array(array($this->Form->input('gm_price',array('div'=>false,'label'=>' 物品单价 ','class'=>'_input','value'=>$goods[0]['GoodsManages']['gm_price']))."<span class='oa_td_notice'>单位：人民币 元 最多只能包含两位小数</span>")),
                     array(array($this->Form->input('gm_remain',array('div'=>false,'label'=>' 物品库存 ','class'=>'_input','value'=>$goods[0]['GoodsManages']['gm_remain'])))),
                     array(array($this->Form->hidden('gm_id',array('value'=>$goods[0]['GoodsManages']['gm_id'])).$this->Form->end(array('div'=>false,'label'=>$this->request['named']['edit']?' 编 辑 ':' 入 库 ','class'=>'_button')))),
));
                echo '</table>';
            }elseif($this->request['pass'][0] == 'type' || $this->request['named']['typeEdit']){
           echo '<table>';
           echo $this->Html->tableHeaders(array('编号','分类名称','状态','操作'),array(),array('class'=>'table_th'));
           $goodsType = array();
           foreach($GoodsTypes as $v){
               $goodsType[] = array(array($v['GoodsTypes']['gt_id'],array('width'=>30)),array($v['GoodsTypes']['gt_name'],array()),array($v['GoodsTypes']['gt_status']?"<span class='_green'>开启</span>":"<span class='_red'>关闭</span>",array()),array($this->Html->link('【编辑】',array('controller'=>'Company','action'=>'goodsManage/typeEdit:'.$v['GoodsTypes']['gt_id']),array('title'=>'编辑')).'|'.$this->Html->link('【删除】',array('controller'=>'Company','action'=>'goodsManage/typeDel:'.$v['GoodsTypes']['gt_id']),array('title'=>'删除'),'确认要删除该分类吗?'),array()));
}
           echo $this->Html->tableCells($goodsType);
 echo '</table>';

 echo $this->Form->create('GoodsTypes',array('url'=>array('controller'=>'Company','action'=>'goodsManage/type')));
 echo '<table>';
           echo $this->Html->tableHeaders(array($this->request['named']['typeEdit']?'<strong>编辑物品分类</strong>':'<strong>添加物品分类</strong>'),array(),array('class'=>'table_th','align'=>'left'));
           echo $this->Html->tableCells(array(
                array(array($this->Form->input('gt_name',array('div'=>false,'label'=>' 分类名称 ','class'=>'_input','value'=>$goodsEdit[0]['GoodsTypes']['gt_name']))."&nbsp;&nbsp;<span class='oa_td_notice'>物品分类名称。例如：常用物品，贵重物品等</span>")),
                array(array($this->Form->hidden('gt_id',array('value'=>$this->request['named']['typeEdit'])).$this->Form->end(array('label'=>$this->request['named']['typeEdit']?'编 辑':'添 加','class'=>'_button'))))
));
           echo '</table>';
}elseif($this->request['pass'][0] == 'get' || $this->request['named']['get']){ //物品出库

echo '<table>';

if(empty($this->request['named']['get'])):
$typeArr = $goodsArr =  array();
                $typeArr[0] = '--物品分类--';
                $typeNotice = count($goodsTypes) ? "<span class='oa_td_notice'>物品分类可以很快的帮助您查找和管理公司物品</span>" :"<span class='oa_td_notice'>您还没有物品分类喔，赶快创建分类吧，创建后查找物品更加便捷喔</span>";
                foreach($goodsTypes as $v){
                $typeArr[$v['GoodsTypes']['gt_id']] = $v['GoodsTypes']['gt_name'];
}
$goodsArr[0] = '--选择出库物品--';

foreach($goodsList as $v){
     $goodsArr[$v['GoodsManages']['gm_id']] = $v['GoodsManages']['gm_goods_name'];
}


echo $this->Form->create('GoodsOuts',array('url'=>array('controller'=>'Company','action'=>'goodsManage/get/'.$this->request['pass'][1],'plugin'=>false)));
echo $this->Html->tableCells(array(
array(               array('请选择物品分类'.$this->Form->select('gt_id',array($typeArr),array('div'=>false,'class'=>'_input','empty'=>false,'default'=>$this->request['pass'][1],'onChange'=>"var url=window.location.toString();window.location=url.substr(0,url.indexOf('get')+3)+'/'+this.value")).'&nbsp;&nbsp;'.$typeNotice)),
array(               array('出库物品'.$this->Form->select('go_goods_id',array($goodsArr),array('div'=>false,'class'=>'_input','empty'=>false,'onChange'=>"goodsInfo(this.value)")).'&nbsp;&nbsp;')),
                     array(array($this->Form->input('go_numbers',array('div'=>false,'label'=>' 出库数量 ','class'=>'_input','onBlur'=>"goods_check(this.value)"))."<span class='oa_td_notice' id='go_numbers_notice'>小于等于该物品库存数量</span>")),
                     array("物品单价：".$this->Form->hidden('go_price',array('div'=>false,'value'=>0,'id'=>'go_price'))."<span id='gm_price' >0</span> 元"),
                     array("出库总金额：".$this->Form->hidden('go_price_total',array('div'=>false,'value'=>0,'id'=>'go_price_total'))."<span id='total_gm_price' >0</span> 元 "),
                     array("剩余库存：<input type='hidden' value='0' id='gm_remain_input'><span id='gm_remain' >".$goods[0]['GoodsManages']['gm_remain']."</span>"),
                     
                     array(array($this->Form->end(array('div'=>false,'label'=>' 出 库 ','class'=>'_button','id'=>'out_button')))),
));
echo $this->Html->scriptBlock("
function goodsInfo(val){
if(val<1) return false;
var url=window.location.toString();
if(url.indexOf('get')){
 url = url.substr(0,url.indexOf('get'))+'gid/'+val;
}else{
url = 'gid/'+val;
}

 $.ajax({
        'type':'get',
       'url':url,
        success:function (msg){
        var _info=msg.split(',');
      $('#gm_price').html(_info[0])
      $('#go_price').val(_info[0])
      $('#gm_remain_input').val(_info[1])
      $('#gm_remain').html(_info[1])
      
}
       
})
}
function goods_check(val){
  var preg = /^\d+$/;
  if(preg.test(val)){
   
    if(parseInt(val)<=parseInt($('#gm_remain_input').val())){
    var _total = val*$('#gm_price').html();
    $('#total_gm_price').html(_total);
    $('#gm_remain').html($('#gm_remain_input').val()-val);
    $('#go_numbers_notice').html('');
    $('#go_price_total').val(_total);
    $('#out_button').attr('disabled',false);
}else{
$('#out_button').attr('disabled',true);
$('#go_numbers_notice').css({'color':'red'});
$('#go_numbers_notice').html('领取数量不能超过现有库存');
}
}else{
$('#out_button').attr('disabled',true);
$('#go_numbers_notice').css({'color':'red'});
$('#go_numbers_notice').html('领取数量有误');
}
}
");
else:
echo $this->Form->create('GoodsOuts',array('url'=>array('controller'=>'Company','action'=>$this->request['named']['type']?'goodsManage/get:'.$this->request['named']['get'].'/type:1':'goodsManage/get:'.$this->request['named']['get'],'plugin'=>false)));
$examine = array();
if($this->request['named']['type']){
$examine = array('申请说明 '.$this->Form->textarea('examine_info'));
}
echo $this->Html->tableCells(array(
array(               array('物品分类：'.$goods[0]['GoodsTypes']['gt_name'])),
array(               array('出库物品：'.$goods[0]['GoodsManages']['gm_goods_name'])),
                     array('领取数量：'.$this->Form->input('go_numbers',array('div'=>false,'class'=>'_input','label'=>false,"onBlur=goods_check(this.value)"))." <span id='go_numbers_notice' class='_red'></span>"),
                     array("物品单价：".$this->Form->hidden('go_price',array('div'=>false,'value'=>0,'id'=>'go_price'))."<span id='gm_price' >".$goods[0]['GoodsManages']['gm_price']."</span> 元"),
                     array("出库总金额：".$this->Form->hidden('go_price_total',array('div'=>false,'value'=>0,'id'=>'go_price_total'))."<span id='total_gm_price' >0</span> 元 "),
                     array("剩余库存：<input type='hidden' value='".$goods[0]['GoodsManages']['gm_remain']."' id='gm_remain_input'/><span id='gm_remain' >".$goods[0]['GoodsManages']['gm_remain']."</span>"),
                     $examine,
                     array(array($this->Form->end(array('div'=>false,'label'=>$this->request['named']['type']?'领取申请':' 领 取 ','class'=>'_button','id'=>'out_button')))),
));
echo $this->Html->scriptBlock("
function goods_check(val){
  var preg = /^\d+$/;
  if(preg.test(val)){
    $('#out_button').attr('disabled',false);
    if(parseInt(val)<=parseInt($('#gm_remain_input').val())){
    $('#total_gm_price').html(val*$('#gm_price').html());
    $('#go_price').val($('#gm_price').html());
    $('#go_price_total').val(val*$('#gm_price').html());
    $('#gm_remain').html($('#gm_remain_input').val()-val);
    $('#go_numbers_notice').html('');
    
}else{
$('#out_button').attr('disabled',true);
$('#go_numbers_notice').html('领取数量不能超过现有库存');
}
}else{
$('#out_button').attr('disabled',true);
$('#go_numbers_notice').html('领取数量有误');
}
}
");

endif;
                echo '</table>';

}elseif($this->request['pass'][0] == 'examine' || $this->request['pass'][0] == 'getRecord'){
echo '<table>';
 echo $this->Html->tableHeaders(array('编号','物品名称','领取数量','物品单价','总金额','说明','申领人','状态','申领时间','操作'),array(),array('class'=>'table_th'));
 $goods_examine = array();
if(count($examine)){
 foreach($examine as $v){
  
  if($this->request['pass'][0] == 'getRecord'){
$button = $this->Html->link('【删除记录】',array('controller'=>'Company','action'=>'goodsManage/delRecord:'.$v['GoodsOuts']['go_id']),array('title'=>'删除记录'),'确认要删除该条领取记录吗?');
}else{
$button = $this->Html->link('【审核】',array('controller'=>'Company','action'=>'goodsManage/examine:'.$v['GoodsOuts']['go_id'].'/do:1'),array('title'=>'审核')).'|'.$this->Html->link('【拒绝】',array('controller'=>'Company','action'=>'goodsManage/examine:'.$v['GoodsOuts']['go_id'].'/do:-1'),array('title'=>'拒绝'));
}
  $goods_examine[] = array(array($v['GoodsOuts']['go_id'],array('width'=>30)),array($v['GoodsManages']['gm_goods_name'],array()),array($v['GoodsOuts']['go_numbers'],array()),array($v['GoodsOuts']['go_price'],array()),array($v['GoodsOuts']['go_price_total'],array()),array($v['GoodsOuts']['examine_info'],array()),array($v['User']['u_true_name'],array()),array($v['GoodsOuts']['go_type'] == 0?'<span class=_yellow>待审核</span>':($v['GoodsOuts']['go_type'] == 1?'<span class=_green>已通过</span>':'<span class=_red>已拒绝</span>'),array()),array(date('Y/m/d H:i',$v['GoodsOuts']['created']),array()),array($button,array()));
}
 echo $this->Html->tableCells($goods_examine);
echo '</table>';
}else{
 echo $this->Html->tableCells(array(array(array('暂时还没有物品领用申请记录',array('colspan'=>9)))));
}
if($this->Paginator->hasPage('GoodsOuts')):
 include_once '../View/Layouts/paginate.ctp';//载入分页
endif;
}
?>
</div>