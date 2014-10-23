$(function(){
	$(".OA_Lmenu_li > a").click(function(){
		$(this).next().slideDown(800);
		$(this).parent().siblings().find("ul").slideUp(800);		
	});
	
	$(".OA_Lmenu_ul > li a").hover(function(){
		 $(this).addClass("hover_li");
	},function(){
	     $(this).removeClass("hover_li");	
	});
});