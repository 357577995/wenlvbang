<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:72:"D:\project\szy\wenlvbang\public/../application/index\view\news\info.html";i:1535336330;s:63:"D:\project\szy\wenlvbang\application\index\view\common\top.html";i:1534054253;s:65:"D:\project\szy\wenlvbang\application\index\view\common\right.html";i:1532267974;s:64:"D:\project\szy\wenlvbang\application\index\view\common\foot.html";i:1532316441;}*/ ?>
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
<!-- 头部 end -->

<!--center-->
<div class="main_c">
	<div class="main" id="content">

		<!-- 内容部分 -->
		<div class="sp_content" id="contentLeft">
			<div class="content cpage">
				<div class="c_crumb">
					<a href="">首页</a>
					&gt;
					<a href="">文旅资讯</a>
					&gt;
					<a href=""><?php echo $cate_info['name']; ?></a>
				</div>
				<h1 class="c_tit"><?php echo $news['title']; ?></h1>
				<div class="c_data">资讯分类：<?php echo $cate_info['name']; ?> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $news['author']; ?>&nbsp;&nbsp;&nbsp;&nbsp; 发布时间：<?php echo date("Y-m-d",$news['time']); ?> </div>
				 
				 
				<div class="c_txt"><?php echo $news['content']; ?></div>
			 
				<div>
					<?php if($tab): foreach($tab as $tab): ?>
					<span><?php echo $tab['name']; ?></span>
					<?php endforeach; endif; ?>
					<br />
					<br />

				</div>
				<div>
					<!-- <?php if($last): ?> -->
					上一篇：
					<a href="/index/news/info.html?id=<?php echo $last['id']; ?>"><?php echo $last['title']; ?></a>
					<!-- <?php endif; ?> -->
					<!-- <?php if($next): ?> -->
					下一篇：
					<a href="/index/news/info.html?id=<?php echo $next['id']; ?>"><?php echo $next['title']; ?></a>
					<!-- <?php endif; ?> -->
					<br />
					<br />

				</div>
				<?php if($recomme): ?>
				<div>
					相关推荐：
					<br />
					 <?php foreach($recomme as $recomm): ?>
					<a href="/index/news/info.html?id=<?php echo $recomm['id']; ?>"><?php echo $recomm['title']; ?></a>
					<br />
					<?php endforeach; ?>

				</div>
				<?php endif; ?>
			</div>
		</div>
		<!-- 内容部分 end-->

		<!-- 右侧部分 -->
		
<div class="sp_right" id="contentRight">

	<div class="sub_common">
		<div class="sub_common_title">
			<h2>游学营</h2>
			<a href="/index/activity/index.html?cate_id=5" title="更多">更多</a>
		</div>
		<div class="sub_youhui_content ilist2">
			<ul>
				<!-- <?php foreach($activity as $activity): ?> -->
				<li>
					<div>
						<span>15</span>
						<br>
						<span>07月</span>
					</div>
					<a href="/index/activity/info.html?id=<?php echo $activity['id']; ?>" title="">
						<h2><?php echo $activity['title']; ?></h2>
						<!-- <span>姚明</span> -->
					</a>
				</li>
				<!-- <?php endforeach; ?> -->
		
			</ul>
		</div>
	</div>
	<div class="sub_common">
		<div class="sub_common_title">
			<h2>大咖驾到</h2>
			<a href="/index/dakashuo/index.html" title="更多">更多</a>
		</div>
		<div class="sub_youhui_content itao">
			<ul>
				<li>
					<a href="/index/dakashuo/info.html?id=<?php echo $dakazhuanfang['id']; ?>" title="">
						<img src="/image/<?php echo $dakazhuanfang['image']; ?>" />
						<span>大咖专访</span>
						<h2><?php echo $dakazhuanfang['title']; ?></h2>
					</a>
				</li>
			</ul>
		</div>
		<div class="sub_youhui_content ilist">
			<ul>
				<!-- <?php foreach($daka_arcitle as $daka_arcitle): ?> -->
				<li>
					<a href="/index/dakashuo/info.html?id=<?php echo $daka_arcitle['id']; ?>" title="">
						<span>订阅</span>
						<h2><?php echo $daka_arcitle['title']; ?></h2>
					</a>
				</li>
				<!-- <?php endforeach; ?> -->
			</ul>
		</div>
	</div>
</div>
		<!-- 右侧部分 end-->
	</div>
</div>
<!--center end-->

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