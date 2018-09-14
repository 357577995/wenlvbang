<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:76:"D:\project\szy\wenlvbang\public/../application/service\view\login\index.html";i:1532270785;}*/ ?>
﻿<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="0">
<title>后台登录</title>
<link rel="icon" href="/image<?php echo $config['icon']; ?>" type="image/x-icon" />
<link href="/admin/static/login.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div class="login_box">
		<div class="login_l_img">
			<img src="/image/service/login-img.png" />
		</div>
		<div class="login" style="height: 500px; margin-top: 0px;">
			<div class="login_logo">
				<a href="#">
					<img src="/image/service/login_logo.png" />
				</a>
			</div>
			<div class="login_name">
				<p>服务商管理系统</p>
			</div>
			<form method="post" action="/service/login/login" method="post">
				<input name="username" type="text" value="用户名" onFocus="this.value=''" onBlur="if(this.value==''){this.value='用户名'}">
				<span id="password_text" onClick="this.style.display='none';document.getElementById('password').style.display='block';document.getElementById('password').focus().select();">密码</span>
				<input name="password" type="password" id="password" style="display: none;" onBlur="if(this.value==''){document.getElementById('password_text').style.display='block';this.style.display='none'};" />
				<input type="text" name="code" id="code" placeholder="验证码" />
				<div>
					<img id="verify_img" src="<?php echo captcha_src(); ?>" alt="验证码" onClick="refreshVerify()">
				</div>
				<input value="登录" style="width: 100%;" type="submit" onClick="return validate()">
				<a href="/index/register/index" class="btn btn-default radius size-L">没有账号，去注册</a>
				<!--<a href="/service/login/email" style="float: right">忘记密码？</a>-->
			</form>
		</div>
		<div class="copyright">文旅帮 版权所有©2016-2018</div>
	</div>
</body>
<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
	//提交表单的事件监听  
	function validate() {
		var code = $('#code').val();
		if (code == '') {
			alert('验证码不能为空');
			return false;
		}

	}
	function refreshVerify() {
		var ts = Date.parse(new Date()) / 1000;
		var img = document.getElementById('verify_img');
		img.src = "/captcha?id=" + ts;
	}
</script>
</html>
