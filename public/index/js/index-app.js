	//底部导航显示隐藏	

	$(function(){		

	$('.fix-footer').css('display','block');		
	
		$('.menuNavs ul li').click(function(event){			
	
	event.preventDefault();			

	var src=event.target||event.srcElement;			
	
	var href=$(src).attr('href');			
	
	if (!href){				
		
	return;		

	}			

	$('.on').removeClass('on');			

	$(src).addClass('on');			

	$('[class=pop_show]').attr('class','pop_hidden');			

	$(href).attr('class','pop_show');		

	})	//click
	

	})	<!-- 下拉菜单 -->		

	

	
	


  