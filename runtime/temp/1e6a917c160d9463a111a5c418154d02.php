<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:77:"D:\project\szy\wenlvbang\public/../application/mobile\view\activity\info.html";i:1535336829;s:64:"D:\project\szy\wenlvbang\application\mobile\view\common\top.html";i:1534477148;s:65:"D:\project\szy\wenlvbang\application\mobile\view\common\foot.html";i:1534839054;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
<meta name="keywords" content="<?php if(isset($keywords)): ?><?php echo $keywords; endif; ?>">
<meta name="description" content="<?php if(isset($description)): ?><?php echo $description; endif; ?>">
<link type="text/css" rel="stylesheet" href="/index/css/index.css">
<link type="text/css" rel="stylesheet" href="/index/css/slide.css">
<script src="/index/js/jquery.min.js"></script>
<script src="/index/js/TouchSlide.1.1.js"></script>
<link type="text/css" rel="stylesheet" href="/index/css/yd.css">
<script src="/index/js/daohang.js" type="text/javascript"></script>
<link rel="stylesheet" href="/index/css/daohang.css">
<link rel="stylesheet" href="/index/css/style.css">
<link href="/index/css/fenlei.css" rel="stylesheet" type="text/css" />
<title><?php if(isset($title)): ?><?php echo $title; endif; ?></title>

</head>
<body>
	<div class="top" id="#top">
		<div class="Menu-icon fl">
			<a href="#" class="nav__trigger">
				<span class="nav__icon"></span>
			</a>
			<nav class="nav">
				<ul class="nav__list">
					<li>
						<h2>
							<a href="/mobile/news/index">文旅资讯</a>
						</h2>
						<h3>
							<!-- <?php foreach($new_cate as $new_cate): ?> -->
							<a href="/mobile/news/index.html?type=<?php echo $new_cate['id']; ?>" title="<?php echo $new_cate['name']; ?>"><?php echo $new_cate['name']; ?></a>
							<!-- <?php endforeach; ?> -->
						</h3>
					</li>
					<li>
						<h2>
							<a href="/mobile/dakashuo/index.html">大咖说</a>
						</h2>
						<h3>
							<!-- <?php foreach($dakashuo_cate as $dakashuo_cate): ?> -->
							<a href="/mobile/dakashuo/index.html?cate_id=<?php echo $dakashuo_cate['id']; ?>" title="<?php echo $dakashuo_cate['name']; ?>"><?php echo $dakashuo_cate['name']; ?></a>
							<!-- <?php endforeach; ?> -->
						</h3>
					</li>
					<li>
						<h2>
							<a href="/mobile/activity/index.html" title="">文旅活动</a>
						</h2>
						<h3>
							<!-- <?php foreach($activity_cate as $activity_cate): ?> -->
							<a href="/mobile/activity/index.html?cate_id=<?php echo $activity_cate['id']; ?>" title="<?php echo $activity_cate['name']; ?>"><?php echo $activity_cate['name']; ?></a>
							<!-- <?php endforeach; ?> -->
						</h3>
					</li>
					<li>
						<h2>
							<a href="/mobile/meeting/index.html" title="">文旅峰会</a>
						</h2>
						<h3></h3>
					</li>
					<li>
						<h2>
							<a href="/mobile/investment/index.html" title="">融资/转让</a>
						</h2>
						<h3>
							<!-- <?php foreach($investment_cate as $investment_cate): ?> -->
							<a href="/mobile/investment/index.html?cate_id=<?php echo $investment_cate['id']; ?>" title="<?php echo $investment_cate['name']; ?>"><?php echo $investment_cate['name']; ?></a>
							<!-- <?php endforeach; ?> -->
						</h3>
					</li>
				</ul>
			</nav>
		</div>
		<div class="logo">
			<img src="/image/mobile/logo.png" />
		</div>
		<div class="search-input">
			<form action="/mobile/search/index" id="search_form">
				<input name="kws" placeholder="请输入业态分类.." value=''>
			</form>
		</div>
		<div class="search-icon">
			<img src="/image/mobile/top_search.png" />
		</div>
	</div>
	<!--top end-->
<!--top end-->
<!--内容区域 start-->
<div class="detail_class">
	<ul>
	<!-- <?php foreach($m_activity_cate as $vo): ?> -->
		<li <?php if($project['cate_id'] == $vo['id']): ?>class="sel"<?php endif; ?>>
			<a href="/mobile/activity/index.html?cate_id=<?php echo $vo['id']; ?>" title="<?php echo $vo['name']; ?>"><?php echo $vo['name']; ?></a>
		</li>
		<!-- <?php endforeach; ?> -->
	</ul>
</div>
<div class="detail_title">
	<h1><?php echo $project['title']; ?></h1>
	<p><span><?php echo $cate_info['name']; ?></span><span><?php echo date("Y-m-d",$project['time']); ?></span></p>
</div>
<div class="detail_text">
<?php echo $project['content']; ?>
</div>
<?php if($tab): ?>
<div class="detail_label">
	<h1>标签：</h1>
	<p>
	<?php foreach($tab as $tab): ?><a><?php echo $tab['name']; ?></a><?php endforeach; ?></p>
</div>
<?php endif; ?>
<!-- <?php if($last): ?> -->
<div class="detail_prev">
	<span>上一篇：</span><a href="/mobile/activity/info.html?id=<?php echo $last['id']; ?>"><?php echo $last['title']; ?></a></p>
</div>
<!-- <?php endif; ?> -->
<!-- <?php if($next): ?> -->
<div class="detail_prev">
	<span>下一篇：</span><a href="/mobile/activity/info.html?id=<?php echo $next['id']; ?>"><?php echo $next['title']; ?></a></p>
</div>
<!-- <?php endif; ?> -->
<?php if($recomme): ?>
<div class="detail_commend">
	<h1>相关推荐：</h1>
	<?php foreach($recomme as $recomm): ?>
	<a href="/mobile/activity/info.html?id=<?php echo $recomm['id']; ?>"><img src="/image/mobile//banner.png"><div class="b"></div><div class="t"><?php echo $recomm['title']; ?></div></a>
	<?php endforeach; ?>
</div>
<?php endif; ?>
<div class="detail_baoming">
	<div class="cd-popup-trigger"><img src="/image/mobile//baoming.png"></div>
</div>

<link rel="stylesheet" href="/index/css/tanchuceng.css"> <!-- Resource style -->
<div class="cd-popup" role="alert">
	<div class="cd-popup-container">
	
		<a href="#" class="cd-popup-close img-replace">关闭</a>
	
	<div class="uc_form">
		<form action="/mobile/activity/sub" method="POST" onsubmit='return validate(this)'>
		<ul>
			<li><span>姓名：</span><input value="" name='user_name'></li>
			<li><span>电话：</span><input value="" name='mobile'></li>
			<input type='hidden' name='activity_id' value=<?php echo $project['id']; ?>>
			<li class="sub"><input type="submit" name="" value="提交"></li>
		</ul>
		</form>
	</div>
		
	</div> <!-- cd-popup-container -->
</div>
<script type="text/javascript">
		function validate(form) {
			var mobile = form.mobile.value;
			if (isNaN(mobile)) {
				alert('请输入正确的电话号码！');
				form.mobile.focus();
				return false;
			}
			var reg = /^1[345678][0-9]{9}$/;
			if (!reg.test(mobile)) {
				alert('请输入正确的电话号码！');
				form.mobile.focus();
				return false;
			}
			return true;
		}
	</script>
<script src="/index/js/tanchuceng.js"></script> 
<div class="clear-bg-eee-h4"></div>
<div class="foot">
	<div class="foot_btn"> <a href="/mobile/index"><img src="/image/mobile/end1.png" /><p>首页</p></a> </div>
	<div class="foot_btn"> <a href="/mobile/category/index.html"><img src="/image/mobile/end2.png" /><p>分类</p></a> </div>
	<div class="foot_btn"> <a href="/mobile/activity/index.html"><img src="/image/mobile/end3.png" /><p>活动</p></a> </div>
	<div class="foot_btn"> <a href="/mobile/user/index"><img src="/image/mobile/end4.png" /><p>我的</p></a> </div>
</div>
<script src="/index/js/index.js" type="text/javascript"></script>
</body>
</html>