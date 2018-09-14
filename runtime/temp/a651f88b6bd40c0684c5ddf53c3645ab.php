<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:79:"D:\project\szy\wenlvbang\public/../application/mobile\view\investment\list.html";i:1534841633;s:64:"D:\project\szy\wenlvbang\application\mobile\view\common\top.html";i:1534477148;s:65:"D:\project\szy\wenlvbang\application\mobile\view\common\foot.html";i:1534839054;}*/ ?>
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
<!--内容区域 start-->
<div class="detail_class">
	<ul>
		<!-- <?php foreach($m_investment_cate as $dakashuo_cate): ?> -->
		<li <?php if($cate_id == $dakashuo_cate['id']): ?>class="sel"<?php endif; ?>>
			<a href="/mobile/investment/index.html?cate_id=<?php echo $dakashuo_cate['id']; ?>" title="<?php echo $dakashuo_cate['name']; ?>"><?php echo $dakashuo_cate['name']; ?></a>
		</li>
		<!-- <?php endforeach; ?> -->
	</ul>
</div>
<div class="detail_list_bg">
	<div class="detail_list rzlist">
		<ul class='newslist'>
			<!-- <?php foreach($investment as $investment): ?> -->
			<li>
				<a href="javascript:void(0);">
					<h2>
						<b><?php echo $investment['name']; ?></b>
					</h2>
					<p>
						<span> <?php echo $investment['fu_title']; ?> </span>
					</p>
					<p>
						<b>项目介绍：</b>
						<?php echo $investment['content']; ?>
					</p>
					<p class="lr">
						<b><?php echo date("Y-m-d",$investment['time']); ?></b>
					</p>
				</a>
			</li>
			<!-- <?php endforeach; ?> -->
		</ul>
		<input type="hidden" value="<?php echo $limit; ?>" id='limit' />
		<input type="hidden" value="<?php echo $cate_id; ?>" id='cate_id' />
	</div>
</div>
<script type="text/javascript">
	$(window).scroll(function() {
		//已经滚动到上面的页面高度
		var scrollTop = $(this).scrollTop();
		//页面高度
		var scrollHeight = $(document).height();
		//浏览器窗口高度
		var windowHeight = $(this).height();
		//此处是滚动条到底部时候触发的事件，在这里写要加载的数据，或者是拉动滚动条的操作
		if (scrollTop + windowHeight == scrollHeight) {
			var limit = $("#limit").val();
			var cate_id = $("#cate_id").val();

			$.ajax({
				type: 'GET',
				url: '/mobile/investment/more',
				data: {
					limit: limit,
					cate_id: cate_id
				},
				success: function(result) {
					if (result.code == 1) {
						limit++;
						$("#limit").val(limit);
						$(".newslist").append(result.data);
					} else {
					}
				},
				dataType: 'json'
			});
		}
	});
</script>
<!--内容区域 end-->
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
