<!DOCTYPE>
<html>
<head>
<link href="../css/lifezq.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript" src="../js/jquery.js"></script>
</head>
<body>
  <div class="zq_top">
      <div style="position:absolute;top:20px;left:50px;"><h1>之晴OA办公系统</h1></div>
      
      
      <div class="zq_top_menu">
          
          <div class="zq_time"><span id=localtime></span></div>
             <?php 
             echo $this->Html->link("共 人在线",'javascript:;',array('class'=>'zq_top_a','target'=>'main')).
                     $this->Html->link('办公桌','javascript:;',array('class'=>'zq_top_a','target'=>'main')).
                     $this->Html->link('个人配置','javascript:;',array('class'=>'zq_top_a','target'=>'main')).
                     $this->Html->link('控制面板',array('controller'=>'Index','action'=>'main'),array('class'=>'zq_top_a','target'=>'main')).
                     $this->Html->link('注销',array('controller'=>'Logins','action'=>'logout'),array('class'=>'zq_top_a','target'=>'main'),'确认要退出系统吗?');
             ?>
        
      </div>
      
  </div>
</body>
<!--JS系统时间显示效果-->
<script type="text/javascript">
function showLocale(objD){
	var str,colorhead,colorfoot;
	var yy = objD.getYear();
	if(yy<1900) yy = yy+1900;
	var MM = objD.getMonth()+1;
	if(MM<10) MM = '0' + MM;
	var dd = objD.getDate();
	if(dd<10) dd = '0' + dd;
	var hh = objD.getHours();
	if(hh<10) hh = '0' + hh;
	var mm = objD.getMinutes();
	if(mm<10) mm = '0' + mm;
	var ss = objD.getSeconds();
	if(ss<10) ss = '0' + ss;
	var ww = objD.getDay();
	if  ( ww==0 )  colorhead="<font color=\"#000000\">";
	if  ( ww > 0 && ww < 6 )  colorhead="<font color=\"#373737\">";
	if  ( ww==6 )  colorhead="<font color=\"#008000\">";
	if  (ww==0)  ww="星期日";
	if  (ww==1)  ww="星期一";
	if  (ww==2)  ww="星期二";
	if  (ww==3)  ww="星期三";
	if  (ww==4)  ww="星期四";
	if  (ww==5)  ww="星期五";
	if  (ww==6)  ww="星期六";
	colorfoot="</font>"
	str = colorhead + yy + "-" + MM + "-" + dd + " " + hh + ":" + mm + ":" + ss + "  " + ww + colorfoot;
	return(str);
}
function tick()
{
	var today;
	today = new Date();
	document.getElementById("localtime").innerHTML = showLocale(today);
	window.setTimeout("tick()", 1000);
}

tick();

</script>
</html>