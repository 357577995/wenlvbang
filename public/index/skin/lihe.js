$(function(){
$(".banner").slide({ titCell:".num ul" , mainCell:".banner_pic" , effect:"leftLoop", autoPlay:true, delayTime:700 , autoPage:true });

	//点击空白处收起
	$("body").click(function(event) {
		$(".dd_list").slideUp(200);
	});

	/*导航下拉*/
	
	$('.nav ul li').mouseover(function(){

	$('.nav ul li a').removeClass("cur");
	$('.nav_dd').addClass("dn");
	$(this).find('.nav_dd').stop(true,true).slideDown();
	$(this).children("a").addClass("cur");
	});
	$('.nav ul li').mouseleave(function(){
		
	$(this).find('.nav_dd').stop(true,true).slideUp('fast');
	$(this).children("a").removeClass("cur");
	});
     //返顶
	 $('.back_top').click(function(){
        $('body,html').animate({scrollTop:0},500)
    });
	$('.linktop').click(function(){
        $('body,html').animate({scrollTop:0},500)
    });
	

})