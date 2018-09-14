<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:74:"D:\project\szy\wenlvbang\public/../application/index\view\index\index.html";i:1535620805;}*/ ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="keywords" content="<?php if(isset($keywords)): ?><?php echo $keywords; endif; ?>">
<meta name="description" content="<?php if(isset($description)): ?><?php echo $description; endif; ?>">
<title>文旅IP业态内容集成平台</title>
<link rel="stylesheet" type="text/css" href="/index/skin/child_cart.css">
<link rel="stylesheet" type="text/css" href="/index/skin/child_atm.css">
<link rel="stylesheet" type="text/css" href="/index/skin/master.css">
<link rel="stylesheet" type="text/css" href="/index/skin/subpage.css">
<link rel="stylesheet" type="text/css" href="/index/skin/index.css">
<script type="text/javascript" src="/index/skin/jquery.js"></script>
<script type="text/javascript" src="/index/skin/banner.js"></script>
<script type="text/javascript" src="/index/skin/index.js"></script>
<script type="text/javascript" src="/index/skin/child_atm.js"></script>
<script type="text/javascript" src="/index/skin/jQselect.js"></script>
<script type="text/javascript" src="/index/skin/lihe.js"></script>
<script type="text/javascript" src="/index/skin/scroll.1.3.js"></script>
 <script type="text/javascript">
    // borwserRedirect
    (function browserRedirect(){
      var sUserAgent = navigator.userAgent.toLowerCase();
      var bIsIpad = sUserAgent.match(/ipad/i) == 'ipad';
      var bIsIphone = sUserAgent.match(/iphone os/i) == 'iphone os';
      var bIsMidp = sUserAgent.match(/midp/i) == 'midp';
      var bIsUc7 = sUserAgent.match(/rv:1.2.3.4/i) == 'rv:1.2.3.4';
      var bIsUc = sUserAgent.match(/ucweb/i) == 'web';
      var bIsCE = sUserAgent.match(/windows ce/i) == 'windows ce';
      var bIsWM = sUserAgent.match(/windows mobile/i) == 'windows mobile';
      var bIsAndroid = sUserAgent.match(/android/i) == 'android';

      if(bIsIpad || bIsIphone || bIsMidp || bIsUc7 || bIsUc || bIsCE || bIsWM || bIsAndroid ){
        window.location.href = '/mobile';
      }
    })();
 </script>
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
					<font>4006-654-123</font>
				</span>
				<span class="ihand">  <?php echo session('project_username'); ?> 
				  <?php echo session('service_username'); ?> 
				 
					<a href="/index/register/index">项目方入驻</a>
					<a href="/index/register/index">服务商入驻</a>
					 
				</span>
			</div>
		</div>
		<!-- 顶部 end-->

		<!-- logo 搜索 -->
		<div class="h_mid_c">
			<div class="h_mid">
				<div class="logo">
					<a href="../" class="fl">
						<img src="/image/index/logo.png">
					</a>
					<small class="fl">文旅IP业态内容集成平台</small>
				</div>
				<div class="search" style=" ">
					<form id="search" name="search" method="get" action="/index/search/index.html">
						<input type="text" name="kws" id="kws" class="text" placeholder="请输入业态分类进行搜索">
						<input type="submit" title="搜索业态方案" class="button" value="搜索">
					</form>
					<a href="">亲子营地</a>
					<a href="">室内滑雪场</a>
					<a href="">西式户外婚礼</a>
				</div>
				<div class="topshop">
					<div     class="button bbg "  ><a href="/service/index/index" style=" text-decoration:none;">发布业态内容</a></div>
					<div     class="button " ><a href="/project/collect/index"  target="_blank" style=" text-decoration:none;">提交项目需求</a></div>
				</div>
			</div>
			<div class="c"></div>
		</div>
	</div>
	<div id="select_box" style="display: none">
		选择 角色
		<input type="radio" name="type" value="1" checked='checked'>
		项目方
		<input type="radio" name="type" value="2">
		服务商
	</div>
	<!-- 头部 end -->
	<!-- logo 搜索 end-->
	<!-- 导航 -->
	<div class="nav_banner">
		<div class="navindex">
			<ul>
				<li>
					<a href="index.html" title="业态内容分类">业态内容分类</a>
				</li>
				<!-- <?php foreach($cate as $cate): ?> -->
				<li>
					<a href="/index/search/index.html?f_id=<?php echo $cate['id']; ?>" title=""><?php echo $cate['name']; ?></a>
						<div class="nav_right">
							<!-- <?php foreach($cate['next_cate'] as $next_cate): ?> -->
							<a href="/index/search/index.html?s_id=<?php echo $next_cate['id']; ?>" title=""><?php echo $next_cate['name']; ?></a>
							<!-- <?php endforeach; ?> -->
						</div>
				</li>
				<!-- <?php endforeach; ?> -->
			</ul>
			<script type="text/javascript">
				$(function() {
					$(".navindex li").hover(function() {
						$(".nav_right", this).show();
					});
					$(".navindex li").mouseleave(function() {
						$(".nav_right", this).hide();
					});
				});
			</script>
		</div>
		<div class="navright">
			<div class="nav_index_right">
				<ul>
					<li>
						<a href="index/news/index.html" title="">文旅资讯</a>
					</li>
				 
					<li>
						<a href="index/dakashuo/index.html" title="">大咖说</a>
					</li>
					<li>
						<a href="/index/expert/index.html" title="">文旅智库</a>
					</li>
					<li>
						<a href="/index/research/index.html" title="">文旅研究</a>
					</li>
					<li>
						<a href="/index/activity/index.html" title="">文旅培训</a>
					</li>
					<li>
						<a href="/index/meeting/index.html" title="">文旅峰会</a>
					</li>
					<li>
						<a href="/index/investment/index.html" title="">融资/转让</a>
					</li>
				</ul>
			</div>
			<!-- banner -->
			<div class="banner"></div>
			
					 
				
			<script type="text/javascript">
				var atmdateA = [
				
				<?php foreach($recommend as $vo): ?>
				{
					"is_url": "0",
					"url_controller": "",
					"url_action": "",
					"url_para": "#",
					"pic_path": "/image/<?php echo $vo['image']; ?>",
					"title": "<?php echo $vo['title']; ?>",
					"href": "<?php echo $vo['url']; ?>",
					"url": "/image/<?php echo $vo['image']; ?>"
				}, 
				<?php endforeach; ?>
				
				
				];
				$(document).ready(function() {
					var bannerShow = new Atm();
					bannerShow.slide(atmdateA, ".banner", "1043", "444");
				});
			</script>
			<!-- banner -->
			<!--大咖专访-->
			<div class="itao">
				<div class="main1">
					<ul>
						<!-- <?php foreach($daka as $daka): ?> -->
						<li>
							<a href="index/dakashuo/info.html?id=<?php echo $daka['id']; ?>" title="<?php echo $daka['title']; ?>">
								<img src="/image/<?php echo $daka['image']; ?>" />
								<span><?php echo $daka['name']; ?></span>
								<h2><?php echo $daka['title']; ?></h2>
							</a>
						</li>
						<!-- <?php endforeach; ?> -->
					</ul>
				</div>
			</div>
		</div>
		<!--大咖专访end-->
	</div>
	<!-- 导航 end-->
	<!-- {foreach $cate1 as $cate1} -->
	<div class="index_pro" style="position: relative; overflow: hidden;">
		<div class="clear"></div>
		<p class="proname">
			<span>精彩推荐</span>
		</p>
		<div class="clear"></div>
		<div class="pro_list" id="wrapBox1">
			<ul id="count1" class="count">
				<!-- <?php foreach($plan1 as $plan1): ?> -->
				<li>
					<div class="pro_pic">
						<a href="" title="">
							<img src="/image<?php echo $plan1['image']; ?>" alt="">
						</a>
					</div>
					<div class="pro_c">
						<a href="" title="">
							<h2><?php echo $plan1['name']; ?></h2>
						</a>
						<!--<div> </div>-->
					</div>
				</li>
				<!-- <?php endforeach; ?> -->
			</ul>
			<div class="c"></div>
		</div>
		<a id="right1" class="prev icon btn"></a>
		<a id="left1" class="next icon btn"></a>
	</div>
	<div class="clear"></div>
	<!--精彩推荐end-->
	<!--最潮业态-->
	<div class="index_pro" style="position: relative; overflow: hidden;">
		<div class="clear"></div>
		<p class="proname">
			<span>最潮业态</span>
		</p>
		<div class="clear"></div>
		<div class="pro_list" id="wrapBox2">
			<ul id="count2" class="count">
				<!-- <?php foreach($plan2 as $plan2): ?> -->
				<li>
					<div class="pro_pic">
						<a href="" title="">
							<img src="/image<?php echo $plan2['image']; ?>" alt="">
						</a>
					</div>
					<div class="pro_c">
						<a href="" title="">
							<h2><?php echo $plan2['name']; ?></h2>
						</a>
						<!--<div> </div>-->
					</div>
				</li>
				<!-- <?php endforeach; ?> -->
			</ul>
			<div class="c"></div>
		</div>
		<a id="right2" class="prev icon btn"></a>
		<a id="left2" class="next icon btn"></a>
	</div>
	<div class="clear"></div>
	<!--最潮业态end-->
	<!--演绎剧目-->
	<div class="index_pro">
		<div class="clear"></div>
		<p class="proname">
			<span>演绎剧目</span>
			<a href="" title="更多">更多&gt;&gt;</a>
		</p>
		<div class="clear"></div>
		<div class="pro_list">
			<ul>
				<!-- <?php foreach($plan3 as $plan3): ?> -->
				<li>
					<div class="pro_pic">
						<a href="" title="">
							<img src="/image<?php echo $plan3['image']; ?>" alt="">
						</a>
					</div>
					<div class="pro_c">
						<a href="" title="">
							<h2><?php echo $plan3['name']; ?></h2>
						</a>
						<!--<div> </div>-->
					</div>
					<div class="pro_ico">
						<span>
							<img src="/image/index/ico_1.png" alt="收藏">
							收藏
						</span>
						<span>
						
						<a href="/index/cart/add?plan_id=<?php echo $plan3['id']; ?>" title="">	<img src="/image/index/ico_2.png" alt="加入购物车"></a>
						</span>
					</div>
				</li>
				<!-- <?php endforeach; ?> -->
			</ul>
			<div class="c"></div>
		</div>
	</div>
	<div class="clear"></div>
	<!--演绎剧目end-->
	<!--大地艺术-->
	<div class="index_pro">
		<div class="clear"></div>
		<p class="proname">
			<span>大地艺术</span>
			<a href="" title="更多">更多&gt;&gt;</a>
		</p>
		<div class="clear"></div>
		<div class="pro_list">
			<ul>
				<!-- <?php foreach($plan4 as $plan4): ?> -->
				<li>
					<div class="pro_pic">
						<a href="" title="">
							<img src="/image<?php echo $plan4['image']; ?>" alt="">
						</a>
					</div>
					<div class="pro_c">
						<a href="" title="">
							<h2><?php echo $plan4['name']; ?></h2>
						</a>
						<!--<div> </div>-->
					</div>
					<div class="pro_ico">
						<span>
							<img src="/image/index/ico_1.png" alt="收藏">
							收藏
						</span>
						<span>
							<a href="/index/cart/add?plan_id=<?php echo $plan4['id']; ?>" title="">	<img src="/image/index/ico_2.png" alt="加入购物车">
					</a>
						</span>
					</div>
				</li>
				<!-- <?php endforeach; ?> -->
			</ul>
			<div class="c"></div>
		</div>
	</div>
	<div class="clear"></div>
	<!--大地艺术end-->

	<div class="index_banenr_end">
		<img src="/image/index/index_banenr_end.png">
	</div>

	<!--演绎剧目-->
	<div class="index_pro">
		<div class="clear"></div>
		<p class="proname">
			<span>演绎剧目</span>
			<a href="" title="更多">更多&gt;&gt;</a>
		</p>
		<div class="clear"></div>
		<div class="pro_list">
			<ul>
				<!-- <?php foreach($plan5 as $plan5): ?> -->
				<li>
					<div class="pro_pic">
						<a href="" title="">
							<img src="/image<?php echo $plan5['image']; ?>" alt="">
						</a>
					</div>
					<div class="pro_c">
						<a href="" title="">
							<h2><?php echo $plan5['name']; ?></h2>
						</a>
						<!--<div> </div>-->
					</div>
					<div class="pro_ico">
						<span>
							<img src="/image/index/ico_1.png" alt="收藏">
							收藏
						</span>
						<span>
						<a href="/index/cart/add?plan_id=<?php echo $plan5['id']; ?>" title="">	
							<img src="/image/index/ico_2.png" alt="加入购物车">
							</a>
						</span>
					</div>
				</li>
				<!-- <?php endforeach; ?> -->
			</ul>
			<div class="c"></div>
		</div>
	</div>
	<div class="clear"></div>
	<!--演绎剧目end-->
	<!--大地艺术-->
	<div class="index_pro">
		<div class="clear"></div>
		<p class="proname">
			<span>大地艺术</span>
			<a href="" title="更多">更多&gt;&gt;</a>
		</p>
		<div class="clear"></div>
		<div class="pro_list">
			<ul>
				<!-- <?php foreach($plan6 as $plan6): ?> -->
				<li>
					<div class="pro_pic">
						<a href="" title="">
							<img src="/image<?php echo $plan6['image']; ?>" alt="">
						</a>
					</div>
					<div class="pro_c">
						<a href="" title="">
							<h2><?php echo $plan6['name']; ?></h2>
						</a>
						<!--<div> </div>-->
					</div>
					<div class="pro_ico">
						<span>
							<img src="/image/index/ico_1.png" alt="收藏">
							收藏
						</span>
						<span>
						<a href="/index/cart/add?plan_id=<?php echo $plan6['id']; ?>" title="">	
							<img src="/image/index/ico_2.png" alt="加入购物车">
						</a>
						</span>
					</div>
				</li>
				<!-- <?php endforeach; ?> -->
			</ul>
			<div class="c"></div>
		</div>
	</div>
	<div class="clear"></div>
	<!--大地艺术end-->

	<!--投融信息-->
	<div class="index_pro">
		<div class="clear"></div>
		<p class="proname">
			<span>投融信息</span>
		</p>
		<div class="clear"></div>
		<div class="tourong_list">
			<ul>
				<!-- <?php foreach($investment as $investment): ?> -->
				<li>
					<div>
						<a title="" href="">
							<img src="/image/index/bangkongjian1.png" alt="" height="160" width="225">
						</a>
					</div>
					<div>
						<a title="" href=""><?php echo $investment['name']; ?></a>
						<span><?php echo $investment['fu_title']; ?></span>
						<p><?php echo $investment['content']; ?></p>
					</div>
					<div>
						<p>发布于：<?php echo date("Y-m-d",$investment['time']); ?></p>
					</div>
				</li>
				<!-- <?php endforeach; ?> -->
			</ul>
			<div class="c"></div>
		</div>
	</div>
	<div class="clear"></div>
	<!--投融信息end-->
	<!-- footer -->
	<div class="footclear"></div>
	<div class="foot">
		<div class="fmain">
			<div class="bootTxt">
				<ul>
					<li>
					<!-- <?php foreach($new_cate as $new_cate): ?> -->
					<a href="/index/news/index.html?type=<?php echo $new_cate['id']; ?>" title="<?php echo $new_cate['name']; ?>"><?php echo $new_cate['name']; ?></a>
					<!-- <?php endforeach; ?> -->	 
					</li>
					<li>
					<!-- <?php foreach($project_cate as $project_cate): ?> -->
					<a href="/index/project/index.html?cate_id=<?php echo $project_cate['id']; ?>" title="<?php echo $project_cate['name']; ?>"><?php echo $project_cate['name']; ?></a>
					<!-- <?php endforeach; ?> -->
					</li>
					<li>
					<!-- <?php foreach($dakashuo_cate as $dakashuo_cate): ?> -->
					<a href="/index/dakashuo/index.html?cate_id=<?php echo $dakashuo_cate['id']; ?>" title="<?php echo $dakashuo_cate['name']; ?>"><?php echo $dakashuo_cate['name']; ?></a>
					<!-- <?php endforeach; ?> -->
					<li>
						<!-- <?php foreach($activity_cate as $activity_cate): ?> -->
									<a href="/index/activity/index.html?cate_id=<?php echo $activity_cate['id']; ?>" title="<?php echo $activity_cate['name']; ?>"><?php echo $activity_cate['name']; ?></a>
									<!-- <?php endforeach; ?> -->
					</li>
					<li>
						<!-- <?php foreach($investment_cate as $investment_cate): ?> -->
									<a href="/index/investment/index.html?cate_id=<?php echo $investment_cate['id']; ?>" title="<?php echo $investment_cate['name']; ?>"><?php echo $investment_cate['name']; ?></a>
									<!-- <?php endforeach; ?> -->
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
						<a href="http://wpa.qq.com/msgrd?Menu=no&Exe=QQ&Uin=431594464" class="clearfix">
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
	<script type="text/javascript" src="/index/skin/index.js"></script>
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
</body>
</html>