<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:76:"D:\project\szy\wenlvbang\public/../application/index\view\dakashuo\list.html";i:1532948164;s:63:"D:\project\szy\wenlvbang\application\index\view\common\top.html";i:1534054253;s:64:"D:\project\szy\wenlvbang\application\index\view\common\foot.html";i:1532316441;}*/ ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="keywords" content="<?php if(isset($keywords)): ?><?php echo $keywords; endif; ?>">
<meta name="description" content="<?php if(isset($description)): ?><?php echo $description; endif; ?>">
<title>文旅资讯</title>
<link rel="stylesheet" type="text/css" href="/index/skin/child_cart.css">
<link rel="stylesheet" type="text/css" href="/index/skin/child_atm.css">
<link rel="stylesheet" type="text/css" href="/index/skin/master.css">
<link rel="stylesheet" type="text/css" href="/index/skin/inside.css">
<script type="text/javascript" src="/index/skin/jquery.js"></script>
<script type="text/javascript" src="/index/skin/banner.js"></script>
<script type="text/javascript" src="/index/skin/child_atm.js"></script>
<script type="text/javascript" src="/index/skin/jQselect.js"></script>
<script type="text/javascript" src="/index/skin/lihe.js"></script>
<!--[if IE 6]>
<script type="text/javascript" src="js/png.js"></script>
<script>DD_belatedPNG.fix('div,img,span,li,a,a:hover,dd,p,input,select')</script>
<![endif]-->
</head>

<body>
	<!-- 头部 -->
	<div class="header">
		<!-- 顶部 -->
		<div class="h_top_c">
			<div class="h_top">
				<span class="wel">文旅IP业态内容集成平台</span>
				<span class="tel">
					服务热线：
					<font>400-5627-321</font>
				</span>
				<span class="ihand">
					<a href="/index/register/index">项目方入驻</a>
					<a href="/index/register/index">服务商入驻</a>
					<a href="">专家入驻</a>
				</span>
			</div>
		</div>
		<!-- 顶部 end-->

		<!-- logo 搜索 -->
		<div class="h_mid_c">
			<div class="h_mid">
				<div class="logo">
					<a href="../../" class="fl">
						<img src="/image/index/logo.png">
					</a>
					<small class="fl">文旅IP业态内容集成平台</small>
				</div>
				<div class="search">
					<form id="search" name="search" method="get" action="/index/search/index.html">
						<input type="text" name="kws" id="kws" class="text" placeholder="请输入业态分类">
						<input type="submit" title="搜索业态方案" class="button" value="搜索">
					</form>
					<a href="">亲子营地</a>
					<a href="">室内滑雪场</a>
					<a href="">户外婚礼广场</a>
				</div>
				<div class="topshop">
					<input data-type='2' type="input" title="发布业态内容" class="button bbg " value="发布业态内容">
					<input data-type='1' type="input" title="提交项目需求" class="button " value="提交项目需求">
				</div>
			</div>
			<div class="c"></div>
		</div>
		<!-- logo 搜索 end-->
		<!-- 导航 -->
		<div class="nav_a">
			<div class="nav_b">
				<div class="nav">
					<ul>
						<li>
							<a href="/index/search/index.html" title="业态内容分类">业态内容分类</a>
						</li>
						<li>
							<a href="/index/news/index.html" title="" class="cur">文旅资讯</a>
							<div class="nav_dd">
								<div class="nav_dd_bg">
									<!-- <?php foreach($new_cate as $new_cate): ?> -->
									<a href="/index/news/index.html?type=<?php echo $new_cate['id']; ?>" title="<?php echo $new_cate['name']; ?>"><?php echo $new_cate['name']; ?></a>
									<!-- <?php endforeach; ?> -->
								</div>
							</div>
						</li>
						<li>
							<a href="/index/project/index.html" title="">帮空间</a>
							<div class="nav_dd dn">
								<div class="nav_dd_bg">
									<!-- <?php foreach($project_cate as $project_cate): ?> -->
									<a href="/index/project/index.html?cate_id=<?php echo $project_cate['id']; ?>" title="<?php echo $project_cate['name']; ?>"><?php echo $project_cate['name']; ?></a>
									<!-- <?php endforeach; ?> -->
								</div>
							</div>
						</li>
						<li>
							<a href="/index/dakashuo/index.html" title="">大咖说</a>
							<div class="nav_dd dn">
								<div class="nav_dd_bg">
									<!-- <?php foreach($dakashuo_cate as $dakashuo_cate): ?> -->
									<a href="/index/dakashuo/index.html?cate_id=<?php echo $dakashuo_cate['id']; ?>" title="<?php echo $dakashuo_cate['name']; ?>"><?php echo $dakashuo_cate['name']; ?></a>
									<!-- <?php endforeach; ?> -->
								</div>
							</div>
						</li>
						<li>
							<a href="/index/expert/index.html" title="">文旅智库</a>
							<div class="nav_dd dn">
								<div class="nav_dd_bg"></div>
							</div>
						</li>
						<li>
							<a href="/index/research/index.html" title="">文旅研究</a>
							<div class="nav_dd dn">
								<div class="nav_dd_bg">
									<!-- <?php foreach($research_cate as $research_cate): ?> -->
									<a href="/index/research/index.html?cate_id=<?php echo $research_cate['id']; ?>" title="<?php echo $research_cate['name']; ?>"><?php echo $research_cate['name']; ?></a>
									<!-- <?php endforeach; ?> -->
								</div>
							</div>
						</li>
						<li>
							<a href="/index/activity/index.html" title="">文旅活动</a>
							<div class="nav_dd dn">
								<div class="nav_dd_bg">
									<!-- <?php foreach($activity_cate as $activity_cate): ?> -->
									<a href="/index/activity/index.html?cate_id=<?php echo $activity_cate['id']; ?>" title="<?php echo $activity_cate['name']; ?>"><?php echo $activity_cate['name']; ?></a>
									<!-- <?php endforeach; ?> -->
								</div>
							</div>
						</li>
						<li>
							<a href="/index/meeting/index.html" title="">文旅峰会</a>
							<div class="nav_dd dn">
								<div class="nav_dd_bg"></div>
							</div>
						</li>
						<li>
							<a href="/index/investment/index.html" title="">融资/转让</a>
							<div class="nav_dd ">
								<div class="nav_dd_bg">
									<!-- <?php foreach($investment_cate as $investment_cate): ?> -->
									<a href="/index/investment/index.html?cate_id=<?php echo $investment_cate['id']; ?>" title="<?php echo $investment_cate['name']; ?>"><?php echo $investment_cate['name']; ?></a>
									<!-- <?php endforeach; ?> -->
								</div>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- 导航 end-->
	</div>
	<div id="select_box" style="display: none">
		选择 角色
		<input type="radio" name="type" value="1" checked='checked'>
		项目方
		<input type="radio" name="type" value="2">
		服务商
	</div>
	<!-- 头部 end -->
	<script type="text/javascript" src="/index/layer/2.4/layer.js"></script>
	<script type="text/javascript">
		$("#myproject").click(function() {
			window.location.href = "/project/index.html"
		});
	</script>
	<script type="text/javascript">
		$(".topshop").find("input").click(function() {
			var type = $(this).data('type');
			$.ajax({
				type: 'POST',
				url: '/index/login/check',
				data: {
					type: type
				},
				success: function(result) {
					if (result.msg) {
						alert(result.msg);
					}
					//未登录 跳转登陆
					if (result.code == 1) {
						window.location.href = result.url;
					}
					//普通用户弹窗选择
					if (result.code == 0) {
						layer.open({
							type: 1,
							skin: 'layui-layer-rim', //加上边框
							area: ['640px', '360px'], //宽高
							content: $('#select_box'),
							btn: ['确定', '取消'],
							yes: function(index, layero){
								var select = $('#select_box input[name="type"]:checked ').val();
								
								$.ajax({
									type: 'POST',
									url: '/index/login/change',
									data: {
										select: select
									},
									success: function(result) {
										if (result.code == 1) {
											window.location.href = result.url;
										}
									},
									dataType: 'json'
								});
							  }
						});
					}
				},
				dataType: 'json'
			});
		});
	</script>

<!--center-->
<div class="main_c">
	<div class="main" id="content">
		<!-- 内容部分 -->
		<div class="pro_list dks">
			<ul class="result_list">
				<!-- <?php foreach($dakashuo as $project): ?> -->
				<li>
					<div class="pro_pic">
						<a href="/index/dakashuo/info.html?id=<?php echo $project['id']; ?>" title="">
							<img src="/image/<?php echo $project['image']; ?>" alt="">
						</a>
					</div>
					<div class="pro_c">
						<a href="/index/dakashuo/info.html?id=<?php echo $project['id']; ?>" title="">
							<h2><?php echo $project['title']; ?></h2>
						</a>
						 <div><?php echo $project['abstract']; ?></div> 
					</div>
					<div class="pro_ico">
						<span><?php echo date("Y-m-d",$project['time']); ?></span>
					</div>
				</li>
				<!-- <?php endforeach; ?> -->
			</ul>
			<div class="c"></div>
			<div class="paging" data-limit="<?php echo $limit; ?>">
				<input type="hidden" value="<?php echo $cate_id; ?>" id='cate_id' />
				<a class="next" href="javascript:void(0);">查看更多</a>
			</div>
		</div>
		<!-- 内容部分 end-->
	</div>
</div>
<!--center end-->
<script type="text/javascript">
	$(".paging").click(function() {

		var limit = $(this).data('limit');
		var cate_id = $("#cate_id").val();

		$(this).data('limit', limit + 1);
		$.ajax({
			type: 'GET',
			url: '/index/dakashuo/more',
			data: {
				limit: limit,
				cate_id: cate_id
			},
			success: function(result) {
				if (result.code == 1) {
					$(".result_list").append(result.data);
				} else {
					$(".paging").hide();
				}
			},
			dataType: 'json'
		});
	})
</script>
<!-- footer -->
	<div class="footclear"></div>
	<div class="foot">
		<div class="fmain">
			<div class="bootTxt">
				<ul>
					<li>
					<!--  -->
					<a href="/index/news/index.html?type=1" title="干货分享">干货分享</a>
					<!--  -->
					<a href="/index/news/index.html?type=2" title="深度报道">深度报道</a>
					<!--  -->
					<a href="/index/news/index.html?type=3" title="融资消息">融资消息</a>
					<!--  -->
					<a href="/index/news/index.html?type=9" title="文旅早报">文旅早报</a>
					<!--  -->	 
					</li>
					<li>
					<!--  -->
					<a href="/index/project/index.html?cate_id=1" title="帮顾问">帮顾问</a>
					<!--  -->
					<a href="/index/project/index.html?cate_id=2" title="帮运营">帮运营</a>
					<!--  -->
					<a href="/index/project/index.html?cate_id=3" title="帮培训">帮培训</a>
					<!--  -->
					<a href="/index/project/index.html?cate_id=4" title="帮招商">帮招商</a>
					<!--  -->
					<a href="/index/project/index.html?cate_id=5" title="帮设计">帮设计</a>
					<!--  -->
					<a href="/index/project/index.html?cate_id=6" title="帮营销">帮营销</a>
					<!--  -->
					<a href="/index/project/index.html?cate_id=7" title="帮对接">帮对接</a>
					<!--  -->
					</li>
					<li>
					<!--  -->
					<a href="/index/dakashuo/index.html?cate_id=1" title="大咖驾到">大咖驾到</a>
					<!--  -->
					<a href="/index/dakashuo/index.html?cate_id=2" title="大咖专访">大咖专访</a>
					<!--  -->
					<li>
						<!--  -->
									<a href="/index/activity/index.html?cate_id=1" title="论道沙龙">论道沙龙</a>
									<!--  -->
									<a href="/index/activity/index.html?cate_id=2" title="文旅唠磕会">文旅唠磕会</a>
									<!--  -->
									<a href="/index/activity/index.html?cate_id=4" title="众人问道">众人问道</a>
									<!--  -->
									<a href="/index/activity/index.html?cate_id=5" title="游学营 ">游学营 </a>
									<!--  -->
									<a href="/index/activity/index.html?cate_id=6" title="走进企业">走进企业</a>
									<!--  -->
					</li>
					<li>
						<!--  -->
									<a href="/index/investment/index.html?cate_id=1" title="投融信息">投融信息</a>
									<!--  -->
									<a href="/index/investment/index.html?cate_id=2" title="项目转让">项目转让</a>
									<!--  -->
					</li>
					<li>
						<p>联系电话</p>
						<p>服务电话：4006-654-123</p>
						<p>服务电话：13716823327</p>
						<p>合作微信：cc13716823327</p>
					</li>
					<li></li>
					<li>
						<img src="/image/index/erweima.png">
						<p>
							扫描二维码，有更多惊喜
							<br>
							Android&IOS
						</p>
					</li>
				</ul>
			</div>

		</div>
	</div>
	<div class="foot_end">©COPYRIGHT 2012 北京文旅帮科技发展有限公司 版权所有京ICP备15047706号-2</div>

	<!--客服-->
	<link rel="stylesheet" href="/index/skin/kefu.css">
	<div class="suspension">
		<div class="suspension-box">
			<a href="/index/search/index.html" class="a a-cart">
				<i class="i">业态内容</i>
			</a>
			<a href="#" class="a a-service ">
				<i class="i"></i>
			</a>
			<a href="" class="a a-service-phone ">
				<i class="i"></i>
			</a>
			<a href="" class="a a-qrcode">
				<i class="i"></i>
			</a>
			<a href="" class="a a-top">
				<i class="i"></i>
			</a>
			<div class="d d-service">
				<i class="arrow"></i>
				<div class="inner-box">
					<div class="d-service-item clearfix">
						<a href="#" class="clearfix">
							<span class="circle">
								<i class="i-qq"></i>
							</span>
							<h3>咨询在线客服</h3>
						</a>
					</div>
				</div>
			</div>
			<div class="d d-service-phone">
				<i class="arrow"></i>
				<div class="inner-box">
					<div class="d-service-item clearfix">
						<span class="circle">
							<i class="i-tel"></i>
						</span>
						<div class="texttel">
							<p>服务热线</p>
							<p class="red number">4006-654-123</p>
						</div>
					</div>
				</div>
			</div>
			<div class="d d-qrcode">
				<i class="arrow"></i>
				<div class="inner-box">
					<div class="qrcode-img">
						<img src="/image/index/side_ewm.jpg" alt="">
					</div>
					<p>微信服务号</p>
				</div>
			</div>

		</div>
	</div>
	<!--客服end-->
</body>
</html>