<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:75:"D:\project\szy\wenlvbang\public/../application/service\view\plan\apply.html";i:1526350050;s:59:"D:\project\szy\wenlvbang\application\service\view\base.html";i:1526353268;}*/ ?>
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
<!--[if IE 6]>
<script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<!--/meta 作为公共模版分离出去-->

<title>方案列表</title>
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
    <div class="container-fluid cl"> <a class="logo navbar-logo f-l mr-10 hidden-xs" href="/service/index/index">服务商-管理</a> 
      <a aria-hidden="false" class="nav-toggle Hui-iconfont visible-xs" href="javascript:;">&#xe667;</a>
      
      <nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
        <ul class="cl">
          
          <li class="dropDown dropDown_hover"> <a href="#" class="dropDown_A"><?php echo session('service_username'); ?> <i class="Hui-iconfont">&#xe6d5;</i></a>
            <ul class="dropDown-menu menu radius box-shadow">
              <li><a href="/service/login/logout">退出</a></li>
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
      <dt><i class="Hui-iconfont">&#xe613;</i> 方案列表<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
          <li><a href="/service/plan/add" >添加方案</a></li>
          <li><a href="/service/plan/apply" >方案列表</a></li>
        </ul>
      </dd>
    </dl> 
    <dl id="menu-admin">
      <dt><i class="Hui-iconfont">&#xe62d;</i> 账号管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
      <dd>
        <ul>
          <li><a href="/service/user/index" >账号信息</a></li>
          <li><a href="/service/user/edit" >修改密码</a></li>
        </ul>
      </dd>
    </dl>
</div>
</aside>
<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div>
<!--/_menu 作为公共模版分离出去-->

<link rel="stylesheet" href="/admin/lib/zTree/v3/css/zTreeStyle/zTreeStyle.css" type="text/css">
<section class="Hui-article-box">
	<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 方案列表管理 <span class="c-gray en">&gt;</span> 方案列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
	<div class="Hui-article">
		<div>
			<div class="pd-20">
				<div class="mt-20">
					<form action="/service/plan/apply" method="get" accept-charset="utf-8">
						<div class="text-c"> 
							<input type="text" class="input-text" style="width:250px" placeholder="方案名称" id="name" name="name" value="<?php if(isset($_GET['name'])): ?><?php echo $_GET['name']; endif; ?>">
							<select class="input-text" style="width:250px" name="cate_id">
								<option value="">--搜分类--</option>
								<?php foreach($cate as $k => $vo): ?>
								<option value="<?php echo $vo['id']; ?>" <?php if(isset($_GET['cate_id'])): if($_GET['cate_id'] == $vo['id']): ?>selected<?php endif; endif; ?> disabled=""><?php echo $vo['name']; ?></option>
									<?php foreach($vo['son'] as $son): ?>
									<option value="<?php echo $son['id']; ?>" <?php if(isset($_GET['cate_id'])): if($_GET['cate_id'] == $son['id']): ?>selected<?php endif; endif; ?> >&nbsp;&nbsp;<?php echo $son['name']; ?></option>
										<?php foreach($son['sun'] as $sun): ?>
										<option value="<?php echo $sun['id']; ?>" <?php if(isset($_GET['cate_id'])): if($_GET['cate_id'] == $sun['id']): ?>selected<?php endif; endif; ?> >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $sun['name']; ?></option>
										<?php endforeach; endforeach; endforeach; ?>
							</select>
							<select class="input-text" style="width:250px" name="status">
								<option value="">--搜状态--</option>
								<option value="2" <?php if(isset($_GET['status'])): if($_GET['status'] == 2): ?>selected<?php endif; endif; ?> >已通过</option>
								<option value="1" <?php if(isset($_GET['status'])): if($_GET['status'] == 1): ?>selected<?php endif; endif; ?> >审核中</option>
								<option value="3" <?php if(isset($_GET['status'])): if($_GET['status'] == 3): ?>selected<?php endif; endif; ?> >已拒绝</option>
							</select>
							<button type="submit" class="btn btn-success" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
						</div>
					</form>
					<div class="cl pd-5 bg-1 bk-gray mt-20">
						<span class="r">共有数据：<strong><?php echo $total; ?></strong> 条</span>
					</div><br/>
					<table class="table table-border table-bordered table-bg table-hover table-sort">
						<thead>
							<tr class="text-c">
								<th width="40">ID</th>
								<th width="120">方案名称</th>
								<th width="120">头图</th>
								<th width="120">分类</th>
								<th >参数</th>
								<th width="120">收藏数</th>
								<th width="120">纳入订单数</th>
								<th width="120">状态</th>
								<th width="100">操作</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($plan as $vo): ?>
							<tr class="text-c va-m">
								<td><?php echo $vo['id']; ?></td>
								<td><?php echo $vo['name']; ?></td>
								<td><img src="/image<?php echo $vo['image']; ?>" alt="" width="100"></td>
								<td><?php echo $vo['cate1']; ?>-><?php echo $vo['cate2']; ?></td>
								<td>
									<!-- <a href="/service/plan/param?plan_id=<?php echo $vo['id']; ?>&cate_id=<?php echo $vo['cate_id']; ?>&plan_name=<?php echo $vo['name']; ?>" class="btn btn-primary radius">修改参数</a> -->
									<?php foreach($vo['param'] as $param): ?>
										<?php echo $param['name']; ?>:<?php echo $param['value']; ?>;
									<?php endforeach; ?>
								</td>
								<td><?php echo $vo['collect_num']; ?></td>
								<td><?php echo $vo['order_num']; ?></td>
								<td>
									<?php if($vo['status'] == 1): ?>
										审核中
									<?php elseif($vo['status'] == 2): ?>
										<span style="color:green">已通过</span>
									<?php elseif($vo['status'] == 3): ?>
										<span style="color:red">已拒绝</span>
									<?php endif; ?>
								</td>
								<td class="td-manage">
									<a style="text-decoration:none"  class="btn btn-danger radius" href="/service/plan/edit?id=<?php echo $vo['id']; ?>" title="编辑">修改</a>
									<a style="text-decoration:none" class="btn btn-primary radius" href="/service/plan/del?id=<?php echo $vo['id']; ?>" title="编辑" onclick="javascript:return confirm('确认删除吗？')" >删除</a>
								</td>
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