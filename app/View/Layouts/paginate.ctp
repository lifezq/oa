<?php

//分页开始
echo "<div class='paginate_box'>";
echo $this->Html->tag('ul');
echo $this->Paginator->first('首页',array('tag'=>'li','class'=>'paginate_first_end'));
echo $this->Paginator->prev(' << ' . __('上一页'), array('tag'=>'li','class'=>'paginate_prev_next'), null, array('tag'=>'li','class'=>'current_prev_next'));
echo $this->Paginator->numbers(array('first' => 2, 'last' => 2,'tag'=>'li','currentClass'=>'current_page','separator'=>''));
echo $this->Paginator->next(' >> ' . __('下一页'), array('tag'=>'li','class'=>'paginate_prev_next'), null, array('tag'=>'li','class'=>'current_prev_next'));
echo $this->Paginator->last('末页',array('tag'=>'li','class'=>'paginate_first_end'));
echo $this->Html->tag('li',$this->Paginator->counter(
    '当前第: {:page} 页,共 {:pages}页,{:count} 条数据'
));
echo '</div>';
echo $this->Html->tag('div','&nbsp;',array('class'=>'_clear'));
//分页结束
