//导航菜单
$(function(){
	$('.nav__trigger').on('click', function(e){
		e.preventDefault();
		$(this).parent().toggleClass('nav--active');
	});
})
//搜索
$(".search-icon").click(function(){
	$(".search-input").toggle();
});
//动态验证码
$(".generate_code").click(function(){  
      var disabled = $(".generate_code").attr("disabled");  
      if(disabled){  
        return false;  
      }  
      if($("#mobile").val() == "" || isNaN($("#mobile").val()) || $("#mobile").val().length != 11 ){  
        alert("请填写正确的手机号！");  
        return false;  
      }
      /*$.ajax({ 
        async:false,  
        type: "GET",  
        url: "这里是获取验证码的网址", 
        data: {mobile:$("#mobile").val()}, 
        dataType: "json",  
        async:false,
        success:function(data){  
          console.log(data);  
          settime();  
        },  
        error:function(err){  
          console.log(err);  
        }
      }); */
      settime();//使用ajax，这行去掉。
    });  
    var countdown=60;  
    var _generate_code = $(".generate_code");  
    function settime() {
      if (countdown == 0) {  
        _generate_code.attr("disabled",false);  
        _generate_code.val("获取验证码");  
        countdown = 60;
        return false;  
      } else {  
        $(".generate_code").attr("disabled", true);  
        _generate_code.val("重新发送(" + countdown + ")");  
        countdown--;  
      }  
      setTimeout(function() {  
        settime();  
      },1000);  
    }  