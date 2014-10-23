<!DOCTYPE>
<html>
<head>
<link href="../css/lifezq.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript" src="../js/jquery.js"></script>
</head>
<body style="background:#ccc;">
  <div class="zq_left_menu" >
  	<h1 class="zq_left_title">OA 菜单</h1>
    <ul class="zq_left_menu_list">
      <?php foreach($navList[0] as $k=>$v){
?>
<li class="zq_left_li">
       	  <a href="javascript:void(0)" style="color:#000;"><?php echo $v['n_name']?></a>
          <ul  <?php if($k != 0){ ?>style="display:none;" <?php } ?> class="zq_left_inner_ul">
            <?php foreach($navList[$v['n_id']] as $m){ ?>
             <li><a href="../<?php echo $m['n_link']; ?>" target="main"><?php echo $m['n_name']; ?></a></li>
             <?php } ?>
          </ul>
</li>
<?php

}
?>

    </ul>
    
  </div>
    <script>
        $(function(){
	$(".zq_left_li   a").click(function(){
		$(this).next().slideDown(800);
		$(this).parent().siblings().find("ul").slideUp(800);		
	});
	
	$(".zq_left_inner_ul li a").hover(function(){
		 $(this).addClass("zq_left_li_hover");
	},function(){
	     $(this).removeClass("zq_left_li_hover");	
	});
});
</script>
</body>
</html>