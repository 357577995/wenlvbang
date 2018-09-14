<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:73:"D:\project\szy\wenlvbang\public/../application/admin\view\news\index.html";i:1530264399;s:57:"D:\project\szy\wenlvbang\application\admin\view\base.html";i:1534141002;}*/ ?>
<!--_meta 作为公共模版分离出去-->
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<link rel="Bookmark" href="favicon.ico" >
<link rel="icon" href="/image<?php echo $config['icon']; ?>" type="image/x-icon" />
<!--[if lt IE 9]>
<script type="text/javascript" src="/admin/lib/html5.js"></script>
<script type="text/javascript" src="/admin/lib/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="/admin/static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="/admin/lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/style.css" />
<link rel="stylesheet" type="text/css" href="/admin/static/datetimepicker/css/bootstrap-datetimepicker.css" />
<!--[if IE 6]>
<script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<!--/meta 作为公共模版分离出去-->

<title>资讯列表</title>
<style type="text/css">
/*分页样式*/
.fenye{
  width:100%;
  text-align: center;
}
.pagination { 
  display: inline-block; padding-left: 0; margin: 20px 0; border-radius: 4px; }
.pagination li { 
  display: inline; }
.pagination li a,.pagination li span { position: relative; float: left; 
  padding: 6px 12px; 
  margin-left: -1px; 
  line-height: 1.428571429; 
  text-decoration: none; 
  background-color: #fff; 
  border: 1px solid #ddd; }
.pagination li:first-child a { 
  margin-left: 0; 
  border-bottom-left-radius: 4px; 
  border-top-left-radius: 4px; }
.pagination li:last-child a { 
  border-top-right-radius: 4px; 
  border-bottom-right-radius: 4px; }
.pagination li a:hover, .pagination li a:focus { 
  background-color: #eee; }
.pagination .active span, .pagination .active span:hover, .pagination .active span:focus { z-index: 2; color: #fff; cursor: default; 
  background-color: #428bca; 
  border-color: #428bca; }
.pagination .disabled span, .pagination .disabled span:hover, .pagination .disabled span:focus { 
  color: #999; cursor: not-allowed; background-color: #fff; 
  border-color: #ddd; }
.pagination-lg li a { 
  padding: 10px 16px; 
  font-size: 18px; }
.pagination-sm li a, .pagination-sm li span { padding: 5px 10px; 
  font-size: 12px; }
</style>
</head>
<body>
<!--_header 作为公共模版分离出去-->
<header class="navbar-wrapper">
  <div class="navbar navbar-fixed-top">
    <div class="container-fluid cl"> <a class="logo navbar-logo f-l mr-10 hidden-xs" href="/admin/index/index">总后台管理</a> 
      <a aria-hidden="false" class="nav-toggle Hui-iconfont visible-xs" href="javascript:;">&#xe667;</a>
      
      <nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
        <ul class="cl">
          
          <li class="dropDown dropDown_hover"> <a href="#" class="dropDown_A"><?php echo session('admin_username'); ?> <i class="Hui-iconfont">&#xe6d5;</i></a>
            <ul class="dropDown-menu menu radius box-shadow">
              <li><a href="/admin/login/logout">退出</a></li>
        </ul>
      </li>
          
          <li id="Hui-skin" class="dropDown right dropDown_hover"> <a href="javascript:;" class="dropDown_A" title="换肤"><i class="Hui-iconfont" style="font-size:18px">&#xe62a;</i></a>
            <ul class="dropDown-menu menu radius box-shadow">
              <li><a href="javascript:;" data-val="default" title="默认（黑色）">默认（黑色）</a></li>
              <li><a href="javascript:;" data-val="blue" title="蓝色">蓝色</a></li>
              <li><a href="javascript:;" data-val="green" title="绿色">绿色</a></li>
              <li><a href="javascript:;" data-val="red" title="红色">红色</a></li>
              <li><a href="javascript:;" data-val="yellow" title="黄色">黄色</a></li>
              <li><a href="javascript:;" data-val="orange" title="橙色">橙色</a></li>
        </ul>
      </li>
    </ul>
  </nav>
</div>
</div>
</header>
<!--/_header 作为公共模版分离出去-->
<!--_menu 作为公共模版分离出去-->
<aside class="Hui-aside">
  <div class="menu_dropdown bk_2">
   
    
    <dl id="menu-picture">
      <dt><i class="Hui-iconfont">&#xe613;</i> 方案库<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
          <li><a href="/admin/plan/index" >方案库列表</a></li>
          <li><a href="/admin/plan/apply" >待审核列表</a></li>
        </ul>
      </dd>
    </dl> 
    <dl id="menu-picture">
      <dt><i class="Hui-iconfont">&#xe61a;</i> 方案订单<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
          <li><a href="/admin/order/index" >方案订单列表</a></li>
        </ul>
      </dd>
    </dl> 
    <dl id="menu-member">
      <dt><i class="Hui-iconfont">&#xe602;</i> 普通会员管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
          <li><a href="/admin/user/userlist" >会员列表</a></li>
          <li><a href="/admin/user/useradd" >添加会员</a></li>
        </ul>
      </dd>
    </dl>
    <dl id="menu-member">
      <dt><i class="Hui-iconfont">&#xe60d;</i> 服务商管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
          <li><a href="/admin/service/index" >服务商列表</a></li>
          <li><a href="/admin/service/add" >添加服务商</a></li>
          <li><a href="/admin/service/apply" >待审核列表</a></li>
        </ul>
      </dd>
    </dl>
    <dl id="menu-member">
      <dt><i class="Hui-iconfont">&#xe630;</i> 项目方管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
          <li><a href="/admin/project/index" >项目方列表</a></li>
          <li><a href="/admin/project/add" >添加项目方</a></li>
          <li><a href="/admin/project/apply" >待审核列表</a></li>
        </ul>
      </dd>
    </dl>
    <dl id="menu-picture">
      <dt><i class="Hui-iconfont">&#xe622;</i> 业态管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
          <li><a href="/admin/cate/add" >添加业态分类</a></li>
          <li><a href="/admin/cate/index" >业态分类列表</a></li>
        </ul>
      </dd>
    </dl>
    <dl id="menu-article">
      <dt><i class="Hui-iconfont">&#xe616;</i> 文旅资讯<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
          <li><a href="/admin/news/index" >资讯列表</a></li>
          <li><a href="/admin/news/add" >添加资讯</a></li>
          <li><a href="/admin/news/cate" >资讯分类</a></li>
        </ul>
      </dd>
    </dl>
    <dl id="menu-article">
      <dt><i class="Hui-iconfont">&#xe616;</i>SEO<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
          <li><a href="/admin/seo/index?is_list=1" >首页SEO</a></li>
          <li><a href="/admin/seo/listseo?is_list=1" >列表页SEO</a></li>
           <li><a href="/admin/news/seo?is_list=1" >资讯列表SEO</a></li>
          <li><a href="/admin/seo/dakashuoseo?is_list=1" >大咖说列表SEO</a></li>
          <li><a href="/admin/seo/expertseo?is_list=1" >文旅智库列表SEO</a></li>
          <li><a href="/admin/seo/researchseo?is_list=1" >文旅研究列表SEO</a></li>
          <li><a href="/admin/seo/activityeo?is_list=1" >文旅活动列表SEO</a></li>
          <li><a href="/admin/seo/meetingseo?is_list=1" >文旅峰会列表SEO</a></li>
          <li><a href="/admin/seo/investmentseo?is_list=1" >投融项目列表SEO</a></li>
        </ul>
      </dd>
    </dl>
	<dl id="menu-article">
      <dt><i class="Hui-iconfont">&#xe620;</i> 帮空间<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
          <li><a href="/admin/project/project" >信息列表</a></li>
          <li><a href="/admin/project/cate" >信息分类</a></li>
        </ul>
      </dd>
    </dl>
	<dl id="menu-article">
      <dt><i class="Hui-iconfont">&#xe625;</i> 大咖说<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
     <!--      <li><a href="/admin/dakashuo/index?type=1" >大咖驾到</a></li>
          <li><a href="/admin/dakashuo/index?type=2" >大咖专访</a></li>  -->
		  <li><a href="/admin/dakashuo/add" >添加信息</a></li>
		  <li><a href="/admin/dakashuo/index" >信息列表</a></li>
          <li><a href="/admin/dakashuo/cate" >信息分类</a></li>

        </ul>
      </dd>
    </dl>
    <dl id="menu-article">
      <dt><i class="Hui-iconfont">&#xe611;</i> 文旅智库<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
          <li><a href="/admin/expert/index" >专家列表</a></li>
          <li><a href="/admin/expert/add" >添加专家</a></li>
        </ul>
      </dd>
    </dl>
    <dl id="menu-article">
      <dt><i class="Hui-iconfont">&#xe611;</i> 入驻专家审核<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
          <li><a href="/admin/settled/index" >入驻专家列表</a></li>
        </ul>
      </dd>
    </dl>
    <dl id="menu-article">
      <dt><i class="Hui-iconfont">&#xe625;</i> 文旅研究<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
          <li><a href="/admin/research/index" >文旅研究列表</a></li>
          <li><a href="/admin/research/add" >添加文旅研究</a></li>
          <li><a href="/admin/research/cate" >文旅研究分类</a></li>
        </ul>
      </dd>
    </dl>
    <dl id="menu-article">
      <dt><i class="Hui-iconfont">&#xe625;</i> 文旅活动<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
           <li><a href="/admin/activity/index" >文旅活动列表</a></li>
          <li><a href="/admin/activity/add" >添加文旅活动</a></li>
          <li><a href="/admin/activity/cate" >文旅活动分类</a></li>
          <li><a href="/admin/activity/order" >文旅活动报名</a></li>
        </ul>
      </dd>
    </dl>
    <dl id="menu-article">
      <dt><i class="Hui-iconfont">&#xe625;</i> 文旅峰会<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
           <li><a href="/admin/meeting/index" >文旅峰会列表</a></li>
          <li><a href="/admin/meeting/add" >添加文旅峰会</a></li>
          <li><a href="/admin/meeting/cate" >文旅峰会分类</a></li>
        </ul>
      </dd>
    </dl>	
    <dl id="menu-article">
      <dt><i class="Hui-iconfont">&#xe625;</i>外部推荐活动<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
           <li><a href="/admin/recommend/index" >外部推荐活动列表</a></li>
          <li><a href="/admin/recommend/add" >添加外部推荐活动</a></li>
        </ul>
      </dd>
    </dl>	
    <dl id="menu-article">
      <dt><i class="Hui-iconfont">&#xe610;</i> 投融项目<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
          <li><a href="/admin/investment/index" >项目列表</a></li>
          <li><a href="/admin/investment/add" >添加项目</a></li>
          <li><a href="/admin/investment/cate" >项目分类</a></li>
        </ul>
      </dd>
    </dl>
    <dl id="menu-article">
      <dt><i class="Hui-iconfont">&#xe610;</i> 标签管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
          <li><a href="/admin/tab/index" >标签列表</a></li>
          <li><a href="/admin/tab/add" >添加标签</a></li>
        </ul>
      </dd>
    </dl>
    
    <dl id="menu-admin">
      <dt><i class="Hui-iconfont">&#xe62d;</i> 管理员管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
          <li><a href="/admin/user/role" >角色管理</a></li>
          <li><a href="/admin/user/index" >管理员列表</a></li>
          <li><a href="/admin/user/admin_log" >管理员日志</a></li>
        </ul>
      </dd>
    </dl>
    <dl id="menu-system">
      <dt><i class="Hui-iconfont">&#xe62e;</i> 系统管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
          <li><a href="/admin/config/index" title="系统设置">系统设置</a></li>
        </ul>
      </dd>
    </dl>
</div>
</aside>
<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div>
<!--/_menu 作为公共模版分离出去-->

<link rel="stylesheet" href="/admin/lib/zTree/v3/css/zTreeStyle/zTreeStyle.css" type="text/css">

<section class="Hui-article-box">
	<nav class="breadcrumb">
		<i class="Hui-iconfont">&#xe67f;</i>
		首页
		<span class="c-gray en">&gt;</span>
		新闻资讯
		<span class="c-gray en">&gt;</span>
		资讯列表
		<a class="btn btn-success radius r" style="line-height: 1.6em; margin-top: 3px" href="javascript:location.replace(location.href);" title="刷新">
			<i class="Hui-iconfont">&#xe68f;</i>
		</a>
	</nav>
	<div class="Hui-article">
		<div>
			<div class="pd-20">
				<div class="mt-20">
					<form action="/admin/news/index" method="get" accept-charset="utf-8">
						<div class="text-c">
							<input type="text" class="input-text" style="width: 250px" placeholder="资讯标题" name="title" value="<?php if(isset($_GET['title'])): ?><?php echo $_GET['title']; endif; ?>">
							<span class="select-box inline">
								<select class="select" name="cate_id">
									<option value="">--资讯类别--</option>
									<?php foreach($catelist as $cate): ?>
									<option value="<?php echo $cate['id']; ?>" <?php if(isset($_GET['cate_id'])): if($_GET['cate_id'] == $cate['id']): ?>selected<?php endif; endif; ?> ><?php echo $cate['name']; ?></option>
									<?php endforeach; ?>
								</select>
							</span>
							发布时间：
							<input type="text" onfocus="WdatePicker()" id="logmin" class="input-text Wdate" name="time1" style="width: 120px;" value="<?php if(isset($time1)): ?><?php echo date('Y-m-d H:i:s',$time1); endif; ?>">
							-
							<input type="text" onfocus="WdatePicker()" id="logmax" class="input-text Wdate" name="time2" style="width: 120px;" value="<?php if(isset($time2)): ?><?php echo date('Y-m-d H:i:s',$time2); endif; ?>">
							<button type="submit" class="btn btn-success" id="" name="">
								<i class="Hui-iconfont">&#xe665;</i>
								搜资讯
							</button>
						</div>
					</form>
					<div class="cl pd-5 bg-1 bk-gray mt-20">
						<span class="r">
							共有数据：
							<strong><?php echo $total; ?></strong>
							条
						</span>
					</div>
					<br />
					<table width="1278" class="table table-border table-bordered table-bg table-hover table-sort">
						<thead>
							<tr class="text-c">
								<th width="55">ID</th>
								<th width="395">资讯标题</th>
								<th width="105">资讯类别</th>
								<th width="233">是否推荐</th>
								<th width="67">排序</th>
								<th width="145">发布时间</th>
								<th width="116">操作</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($news as $vo): ?>
							<tr class="text-c va-m">
								<td><?php echo $vo['id']; ?></td>
								<td><?php echo $vo['title']; ?></td>
								<td><?php echo $vo['cate']; ?></td>
								<td><?php if($vo['recommend']==0): ?>不<?php endif; ?>推荐</td>
								<td><?php echo $vo['sort']; ?></td>
								<td><?php echo $vo['time']; ?></td>
								<td class="td-manage">
									<a style="text-decoration: none" class="btn btn-success radius" href="/admin/news/edit?id=<?php echo $vo['id']; ?>">编辑</a>
									<a style="text-decoration: none" class="btn btn-primary radius" href="/admin/news/del?id=<?php echo $vo['id']; ?>" onclick="javascript:return confirm('确认删除吗？')">删除</a>								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<div class="fenye"><?php echo $page; ?></div>
			</div>
		</div>
	</div>
</section>
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/admin/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript" src="/admin/lib/zTree/v3/js/jquery.ztree.all-3.5.min.js"></script>

<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/admin/static/h-ui/js/H-ui.js"></script> 
<script type="text/javascript" src="/admin/static/h-ui.admin/js/H-ui.admin.page.js"></script> 
<script type="text/javascript" src="/admin/static/datetimepicker/js/bootstrap-datetimepicker.js"></script> 
<!--/_footer /作为公共模版分离出去-->
<!--此乃百度统计代码，请自行删除-->
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?080836300300be57b7f34f4b3e97d911";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
<!--/此乃百度统计代码，请自行删除-->
</body>
</html>