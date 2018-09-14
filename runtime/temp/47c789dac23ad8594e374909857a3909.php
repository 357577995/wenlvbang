<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:74:"D:\project\szy\wenlvbang\public/../application/service\view\plan\edit.html";i:1534142587;s:59:"D:\project\szy\wenlvbang\application\service\view\base.html";i:1526353268;}*/ ?>
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

<title>修改方案</title>
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

<script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/ueditor/lang/zh-cn/zh-cn.js"></script>
<section class="Hui-article-box">
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
		<span class="c-gray en">&gt;</span>
		方案列表
		<span class="c-gray en">&gt;</span>
		修改方案 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a> </nav>
<div class="Hui-article">
		<article class="cl pd-20">
			<div class="page-container">
			<form action="/service/plan/update" method="post" class="form form-horizontal" id="form-article-add" enctype="multipart/form-data">
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>方案名称：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text" class="input-text" value="<?php echo $list['name']; ?>" id="name" name="name">
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>业态分类：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<select name="cate_id" class="input-text" onchange="selected()" id="cate_id">
							<option value="0">--请选择--</option>
							<?php foreach($cate as $vo): ?>
							<option value="<?php echo $vo['id']; ?>" disabled><?php echo $vo['name']; ?></option>
								<?php foreach($vo['son'] as $son): ?>
								<option value="<?php echo $son['id']; ?>" <?php if($list['cate_id'] == $son['id']): ?>selected<?php endif; ?> >&nbsp;&nbsp;<?php echo $son['name']; ?></option>
									<?php foreach($son['sun'] as $sun): ?>
									<option value="<?php echo $sun['id']; ?>" <?php if($list['cate_id'] == $sun['id']): ?>selected<?php endif; ?> >&nbsp;&nbsp;<?php echo $sun['name']; ?></option>
									<?php endforeach; endforeach; endforeach; ?>
						</select>
					</div>
				</div>
			<!-- 	<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>业态参数：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<span id="desc"></span>
						<?php foreach($param as $k => $po): ?>
						<div class='params'><?php echo $po['name']; ?>：<input type='text' class='input-text' name='param[<?php echo $po['param_id']; ?>]' id='<?php echo $po['param_id']; ?>' value="<?php echo $po['value']; ?>"></div>
						<?php endforeach; ?>
					</div>
				</div> -->

				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>首页显示图片：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<img src="/image<?php echo $list['image']; ?>" alt="" width="100">
						<input type="file" value="" id="image" name="image">
					</div>
				</div>
				<div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>方案内容：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <script id="editor" name="content" type="text/plain" style="width:1000px;height:500px;"><?php echo $list['content']; ?></script>
                    </div>
                </div>
                <input type="hidden" name="id" value="<?php echo $list['id']; ?>">
				<div class="row cl" style="margin-top:100px;">
					<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
						<button id="submits" class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存</button>
					</div>
				</div>
			</form>
		</div>
		</article>
	</div>
</section>
<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript">
	//实例化编辑器
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    var ue = UE.getEditor('editor');

	var form = document.getElementById('form-article-add');  
	var name = document.getElementById('name');
	var cate_id = document.getElementById('cate_id');
	var html = ue.getContent();
    //提交表单的事件监听  
    form.onsubmit = function (){  
        if(name==''){
        	alert('方案名称不能为空');
        	return false;
        } 
        if(cate_id==0){
        	alert('业态分类不能为空');
        	return false;
        } 
        if(html==''){
        	alert('方案内容不能为空');
        	return false;
        } 

    }  
    //分类改变-相应参数改变
    function selected(){
    	
    	$('.params').remove();

    	var cate_id = $('#cate_id').val();
    /* 	$.post("/service/plan/changeparam", {cate_id: cate_id}, function(msg) {
    		var myobj=eval(msg);
    		
			for(var i=0;i<myobj.length;i++){ 
				
			    text = "<div class='params'>"+myobj[i].name+"：<input type='text' class='input-text' name='param["+myobj[i].id+"]' id='"+myobj[i].id+"'></div>";
                $("#desc").after(text);
			}
			
        }); */
    }
    

</script>

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