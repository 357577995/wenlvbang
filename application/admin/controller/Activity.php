<?php
namespace app\admin\controller;
// 判断是否登录
use app\admin\controller\Base;
use think\Db;
use think\Request;

// 类继承自公共的类
class activity extends Base
{

	protected function _initialize ()
	{
		parent::_initialize();
	}

	/**
	 * 资讯分类
	 */
	public function cate ()
	{
		// 检查权限
		// admin_role('activity_cate');
		$activity_cate = Db::table('activity_cate')->paginate(5);
		$page = $activity_cate->render();
		// 总个数
		$total = Db::table('activity_cate')->field('COUNT(*) as total')->select();
		$this->assign('total', $total[0]['total']);
		return $this->fetch('activity/cate', [
			'activity_cate' => $activity_cate, 
			'page' => $page
		]);
	}

	/**
	 * 添加资讯分类
	 */
	public function cate_add ()
	{
		// 检查权限
		// admin_role('activity_cate');
		return $this->fetch('activity/cate_add');
	}

	public function cate_insert ()
	{
		$data['name'] = $_POST['name'];
		// 判断该分类是否已存在
		$cate = Db::table('activity_cate')->where('name', $_POST['name'])->find();
		if(! empty($cate))
		{
			$this->error('该分类名称已存在', '/admin/activity/cate');
		}
		else
		{
			$result = Db::name('activity_cate')->insert($data);
			if($result)
			{
				// 添加管理员日志
				admin_log($content = '添加文旅研究分类-' . $_POST['name']);
				$this->success('添加成功', '/admin/activity/cate');
			}
			else
			{
				$this->error('添加失败', '/admin/activity/cate');
			}
		}
	}

	/**
	 * 删除资讯分类
	 */
	public function cate_del ()
	{
		// 检查权限
		// admin_role('activity_cate');
		$id = $_GET['id'];
		$name = Db::table('activity_cate')->where('id', $id)->find();
		$res = Db::table('activity_cate')->where('id', $id)->delete();
		if($res)
		{
			// 添加管理员日志
			admin_log($content = '删除文旅研究分类-' . $name['name']);
			$this->success('删除成功', '/admin/activity/cate');
		}
		else
		{
			$this->error('删除失败', '/admin/activity/cate');
		}
	}

	/**
	 * 修改资讯分类
	 */
	public function cate_edit ()
	{
		// 检查权限
		// admin_role('activity_cate');
		$id = $_GET['id'];
		$list = Db::table('activity_cate')->where('id', $id)->find();
		return $this->fetch('activity/cate_edit', [
			'list' => $list
		]);
	}

	public function cate_update ()
	{
		$data['name'] = $_POST['name'];
		$result = Db::table('activity_cate')->where('id', $_POST['id'])->update($data);
		if($result)
		{
			// 添加管理员日志
			admin_log($content = '修改文旅研究分类-' . $_POST['name']);
			$this->success('修改成功', '/admin/activity/cate');
		}
		else
		{
			$this->error('修改失败', '/admin/activity/cate');
		}
	}

	/**
	 * 资讯列表
	 */
	public function index (Request $request)
	{
		// 检查权限
		// admin_role('new_list');
		$where = '';
		// 标题搜索
		$title = "'%" . $request->param('title') . "%'";
		if(! empty($title))
		{
			$where .= 'title like ' . $title;
		}
		// 分类搜索
		$cate_id = $request->param('cate_id');
		if(! empty($cate_id))
		{
			$where .= ' and cate_id = ' . $cate_id;
		}
		// 发布时间搜索
		if(! empty($request->param('time1')) && ! empty($request->param('time2')))
		{
			$time1 = strtotime($request->param('time1'));
			$time2 = strtotime($request->param('time2')) + 86399; // 截止到当天的23:59:59
			$where .= ' and time > ' . $time1 . ' and time < ' . $time2;
			$this->assign('time1', $time1);
			$this->assign('time2', $time2);
		}
		
		$list = Db::table('activity')->where($where)->paginate(5, false, [
			'query' => request()->param()
		]);
		$page = $list->render();
		$activity = [];
		foreach($list as $k => $vo)
		{
			$activity[] = $vo;
			$activity[$k]['time'] = date('Y-m-d H:i:s', $vo['time']);
			// 分类
			$cate = Db::table('activity_cate')->where('id', $vo['cate_id'])->find();
			$activity[$k]['cate'] = $cate['name'];
		}
		// 搜索用的分类
		$catelist = Db::table('activity_cate')->select();
		// 总个数
		$total = Db::table('activity')->where($where)->field('COUNT(*) as total')->select();
		$this->assign('total', $total[0]['total']);
		
		return $this->fetch('activity/index', [
			'activity' => $activity, 
			'page' => $page, 
			'catelist' => $catelist
		]);
	}

	/**
	 * 添加资讯
	 */
	public function add ()
	{
		// 检查权限
		// admin_role('new_add');
		
		// 读取分类
		$cate = Db::table('activity_cate')->select();
		$tab = Db::table('tab')->where('type', 3)->select();
		return $this->fetch('activity/add', [
			'cate' => $cate, 
			'tab' => $tab
		]);
	}

	public function insert ()
	{
		$data['title'] = $_POST['title'];
		$data['cate_id'] = $_POST['cate_id'];
		$data['content'] = $_POST['content'];
		$data['start_time'] = $_POST['start_time'];
		$data['end_time'] = $_POST['end_time'];
		$data['url'] = $_POST['url'];
		$data['time'] = ! empty($_POST['time']) ? strtotime($_POST['time']) : time();
		$tab = empty($_POST['tab']) ? [] : $_POST['tab'];
		
		$data['seo_title'] = $_POST['seo_title'];
		$data['seo_keywords'] = $_POST['seo_keywords'];
		$data['seo_description'] = $_POST['seo_description'];
		
		if(! empty($_POST['new_tab']))
		{
			$new_tabs = explode(',', $_POST['new_tab']);
			for($i = 0; $i < 5; $i ++)
			{
				if($new_tabs[$i])
				{
					$temp['name'] = $new_tabs[$i];
					$temp['type'] = 3;
					Db::name('tab')->insert($temp);
					$tab[] = Db::name('tab')->getLastInsID();
				}
			}
		}
		// 判断是否有新图片上传
		$size = $_FILES['image']['size'];
		if($size == '0')
		{
			// $this->error('资讯图片未上传','/admin/activity/add');
			$img = '/admin/default.png';
			$data['image'] = $img;
			$result = Db::name('activity')->insert($data);
			if($result)
			{
				$id = Db::name('activity')->getLastInsID();
				foreach($tab as $k => $vo)
				{
					if(!isset($vo)){
						continue;
					}
					$res['tab_id'] = $vo;
					$res['activity_id'] = $id;
					Db::name('tab_map')->insert($res);
				}
				// 添加管理员日志
				admin_log($content = '添加文旅研究-' . $_POST['title']);
				$this->success('添加成功', '/admin/activity/index');
			}
			else
			{
				$this->error('添加失败', '/admin/activity/index');
			}
		}
		else
		{
			$file = $_FILES["image"]["tmp_name"]; // 获取的上传的临时文件
			$type = substr(strrchr($_FILES["image"]["name"], '.'), 1);
			$filetype = [
				'jpg', 
				'jpeg', 
				'gif', 
				'png'
			];
			if(! in_array($type, $filetype))
			{
				$this->error('图片类型上传不正确，允许上传的图片类型：png,jpg,jpeg,gif', '/admin/activity/add');
			}
			$name = time() . rand(1, 9999) . "." . $type;
			$path = $_SERVER['DOCUMENT_ROOT'] . '/image/admin/activity/';
			$res = move_uploaded_file($file, $path . $name) ? 'ok' : 'false';
			if($res == 'ok')
			{
				$img = '/admin/activity/' . $name;
				$data['image'] = $img;
				$result = Db::name('activity')->insert($data);
				if($result)
				{
					$id = Db::name('activity')->getLastInsID();
					foreach($tab as $k => $vo)
					{
						if(!isset($vo)){
							continue;
						}
						$res['tab_id'] = $vo;
						$res['activity_id'] = $id;
						Db::name('tab_map')->insert($res);
					}
					// 添加管理员日志
					admin_log($content = '添加文旅研究-' . $_POST['title']);
					$this->success('添加成功', '/admin/activity/index');
				}
				else
				{
					$this->error('添加失败', '/admin/activity/index');
				}
			}
			else
			{
				$this->error('文件上传失败', '/admin/activity/add');
			}
		}
	}

	/**
	 * 删除资讯
	 */
	public function del ()
	{
		// 检查权限
		// admin_role('new_del');
		$id = $_GET['id'];
		$new = Db::table('activity')->field('image,title')->where('id', $id)->find();
		$res = Db::table('activity')->where('id', $id)->delete();
		if($res)
		{
			// 删除图片
			$image = $_SERVER['DOCUMENT_ROOT'] . '/image' . $new['image'];
			unlink($image);
			// 添加管理员日志
			admin_log($content = '删除文旅研究-' . $new['title']);
			$this->success('删除成功', '/admin/activity/index');
		}
		else
		{
			$this->error('删除失败', '/admin/activity/index');
		}
	}

	/**
	 * 修改资讯
	 */
	public function edit ()
	{
		// 检查权限
		// admin_role('new_edit');
		$id = $_GET['id'];
		$new = Db::table('activity')->where('id', $id)->find();
		// 类别
		$cate = Db::table('activity_cate')->select();
		$tab = Db::table('tab')->where('type', 3)->select();
		$tab_ids = Db::table('tab_map')->where('activity_id', $id)->column("tab_id");
		return $this->fetch('activity/edit', [
			'new' => $new, 
			'cate' => $cate, 
			'tab' => $tab, 
			'tab_ids' => empty($tab_ids) ? [] : $tab_ids
		]);
	}

	public function update ()
	{
		$data['title'] = $_POST['title'];
		$data['cate_id'] = $_POST['cate_id'];
		$data['content'] = $_POST['content'];
		$data['start_time'] = $_POST['start_time'];
		$data['end_time'] = $_POST['end_time'];
		$data['url'] = $_POST['url'];
		$data['time'] = ! empty($_POST['time']) ? strtotime($_POST['time']) : time();
		$oldimg = Db::table('activity')->field('image')->where('id', $_POST['id'])->find();
		$data['seo_title'] = $_POST['seo_title'];
		$data['seo_keywords'] = $_POST['seo_keywords'];
		$data['seo_description'] = $_POST['seo_description'];
		
		$tab = empty($_POST['tab']) ? [] : $_POST['tab'];
		if(! empty($_POST['new_tab']))
		{
			$new_tabs = explode(',', $_POST['new_tab']);
			for($i = 0; $i < 5; $i ++)
			{
				if($new_tabs[$i])
				{
					$temp['name'] = $new_tabs[$i];
					$temp['type'] = 3;
					Db::name('tab')->insert($temp);
					$tab[] = Db::name('tab')->getLastInsID();
				}
			}
		}
		
		// 判断是否有新图片上传
		$size = $_FILES['image']['size'];
		if($size == '0')
		{
			$result = Db::table('activity')->where('id', $_POST['id'])->update($data);
			if($result)
			{
				Db::table('tab_map')->where('activity_id', $_POST['id'])->delete();
				foreach($tab as $k => $vo)
				{
					if(!isset($vo)){
						continue;
					}
					$res['tab_id'] = $vo;
					$res['activity_id'] = $_POST['id'];
					Db::name('tab_map')->insert($res);
				}
				// 添加管理员日志
				admin_log($content = '修改文旅研究-' . $_POST['title']);
				$this->success('修改成功', '/admin/activity/edit?id=' . $_POST['id']);
			}
			else
			{
				$this->error('修改失败', '/admin/activity/edit?id=' . $_POST['id']);
			}
		}
		else
		{
			
			$file = $_FILES["image"]["tmp_name"]; // 获取的上传的临时文件
			$type = substr(strrchr($_FILES["image"]["name"], '.'), 1);
			$filetype = [
				'jpg', 
				'jpeg', 
				'gif', 
				'png'
			];
			if(! in_array($type, $filetype))
			{
				$this->error('图片类型上传不正确，允许上传的图片类型：png,jpg,jpeg,gif', '/admin/activity/edit?id=' . $_POST['id']);
			}
			$name = time() . rand(1, 9999) . "." . $type;
			$path = $_SERVER['DOCUMENT_ROOT'] . '/image/admin/activity/';
			$res = move_uploaded_file($file, $path . $name) ? 'ok' : 'false';
			if($res == 'ok')
			{
				$img = '/admin/activity/' . $name;
				$data['image'] = $img;
				$result = Db::table('activity')->where('id', $_POST['id'])->update($data);
				if($result)
				{
					Db::table('tab_map')->where('activity_id', $_POST['id'])->delete();
					foreach($tab as $k => $vo)
					{
						if(!isset($vo)){
							continue;
						}
						$res['tab_id'] = $vo;
						$res['activity_id'] = $_POST['id'];
						Db::name('tab_map')->insert($res);
					}
					// 删掉原图
					$oldimg = $_SERVER['DOCUMENT_ROOT'] . '/image' . $oldimg['image'];
					unlink($oldimg);
					// 添加管理员日志
					admin_log($content = '修改文旅研究-' . $_POST['title']);
					$this->success('修改成功', '/admin/activity/edit?id=' . $_POST['id']);
				}
				else
				{
					$this->error('修改失败', '/admin/activity/edit?id=' . $_POST['id']);
				}
			}
			else
			{
				$this->error('文件上传失败', '/admin/activity/edit?id=' . $_POST['id']);
			}
		}
	}

	/**
	 * 资讯列表
	 */
	public function order (Request $request)
	{
		$list = Db::table('activity_order')->paginate(5, false, [
			'query' => request()->param()
		]);
		$page = $list->render();
		// 总个数
		$total = Db::table('activity_order')->field('COUNT(*) as total')->select();
		$this->assign('total', $total[0]['total']);
		$activity = [];
		foreach($list as $k => $vo)
		{
			$activity[] = $vo;
			$activity[$k]['activity'] = Db::table('activity')->where('id', $vo['activity_id'])->find();
		}
		return $this->fetch('activity/order', [
			'activity' => $activity, 
			'page' => $page
		]);
	}
}
