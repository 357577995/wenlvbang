<?php
namespace app\admin\controller;
// 判断是否登录
use app\admin\controller\Base;
use think\Db;
use think\Request;

// 类继承自公共的类
class dakashuo extends Base
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
		admin_role('dakashuo_cate');
		
		$dakashuo_cate = Db::table('dakashuo_cate')->paginate(5);
		$page = $dakashuo_cate->render();
		// 总个数
		$total = Db::table('dakashuo_cate')->field('COUNT(*) as total')->select();
		$this->assign('total', $total[0]['total']);
		return $this->fetch('dakashuo/cate', [
			'dakashuo_cate' => $dakashuo_cate, 
			'page' => $page
		]);
	}

	/**
	 * 添加资讯分类
	 */
	public function cate_add ()
	{
		// 检查权限
		admin_role('dakashuo_cate');
		
		return $this->fetch('dakashuo/cate_add');
	}

	public function cate_insert ()
	{
		$data['name'] = $_POST['name'];
		// 判断该分类是否已存在
		$cate = Db::table('dakashuo_cate')->where('name', $_POST['name'])->find();
		if(! empty($cate))
		{
			$this->error('该分类名称已存在', '/admin/dakashuo/cate');
		}
		else
		{
			$result = Db::name('dakashuo_cate')->insert($data);
			if($result)
			{
				// 添加管理员日志
				admin_log($content = '添加大咖说分类-' . $_POST['name']);
				$this->success('添加成功', '/admin/dakashuo/cate');
			}
			else
			{
				$this->error('添加失败', '/admin/dakashuo/cate');
			}
		}
	}

	/**
	 * 删除资讯分类
	 */
	public function cate_del ()
	{
		// 检查权限
		admin_role('dakashuo_cate');
		
		$id = $_GET['id'];
		$name = Db::table('dakashuo_cate')->where('id', $id)->find();
		$res = Db::table('dakashuo_cate')->where('id', $id)->ete();
		if($res)
		{
			// 添加管理员日志
			admin_log($content = '删除新闻资讯分类-' . $name['name']);
			$this->success('删除成功', '/admin/dakashuo/cate');
		}
		else
		{
			$this->error('删除失败', '/admin/dakashuo/cate');
		}
	}

	/**
	 * 修改资讯分类
	 */
	public function cate_edit ()
	{
		// 检查权限
		admin_role('dakashuo_cate');
		
		$id = $_GET['id'];
		$list = Db::table('dakashuo_cate')->where('id', $id)->find();
		return $this->fetch('dakashuo/cate_edit', [
			'list' => $list
		]);
	}

	public function cate_update ()
	{
		$data['name'] = $_POST['name'];
		$result = Db::table('dakashuo_cate')->where('id', $_POST['id'])->update($data);
		if($result)
		{
			// 添加管理员日志
			admin_log($content = '修改大咖说分类-' . $_POST['name']);
			$this->success('修改成功', '/admin/dakashuo/cate');
		}
		else
		{
			$this->error('修改失败', '/admin/dakashuo/cate');
		}
	}

	/**
	 * 资讯列表
	 */
	public function index (Request $request)
	{
		// 检查权限
		admin_role('dakashuo_list');
		
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
		
		$list = Db::table('dakashuo')->where($where)->paginate(5, false, [
			'query' => request()->param()
		]);
		$page = $list->render();
		$dakashuo = [];
		foreach($list as $k => $vo)
		{
			$dakashuo[] = $vo;
			$dakashuo[$k]['time'] = date('Y-m-d H:i:s', $vo['time']);
			// 分类
			$cate = Db::table('dakashuo_cate')->where('id', $vo['cate_id'])->find();
			$dakashuo[$k]['cate'] = $cate['name'];
		}
		// 搜索用的分类
		$catelist = Db::table('dakashuo_cate')->select();
		// 总个数
		$total = Db::table('dakashuo')->where($where)->field('COUNT(*) as total')->select();
		$this->assign('total', $total[0]['total']);
		
		return $this->fetch('dakashuo/index', [
			'dakashuo' => $dakashuo, 
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
		admin_role('dakashuo_add');
		
		// 读取分类
		$cate = Db::table('dakashuo_cate')->select();
		return $this->fetch('dakashuo/add', [
			'cate' => $cate
		]);
	}

	public function insert ()
	{
		$data['title'] = $_POST['title'];
		$data['cate_id'] = $_POST['cate_id'];
		$data['content'] = $_POST['content'];
		$data['recommend'] = $_POST['recommend'];
		$data['offline_content'] = $_POST['offline_content'];
		$data['time'] = ! empty($_POST['time']) ? strtotime($_POST['time']) : time();
		// 判断是否有新图片上传
		$size = $_FILES['image']['size'];
		
		$data['seo_title'] = $_POST['seo_title'];
		$data['seo_keywords'] = $_POST['seo_keywords'];
		$data['seo_description'] = $_POST['seo_description'];
		if($size == '0')
		{
			// $this->error('资讯图片未上传','/admin/dakashuo/add');
			$img = '/admin/default.png';
			$data['image'] = $img;
			$result = Db::name('dakashuo')->insert($data);
			if($result)
			{
				// 添加管理员日志
				admin_log($content = '添加大咖说-' . $_POST['title']);
				$this->success('添加成功', '/admin/dakashuo/index');
			}
			else
			{
				$this->error('添加失败', '/admin/dakashuo/index');
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
				$this->error('图片类型上传不正确，允许上传的图片类型：png,jpg,jpeg,gif', '/admin/dakashuo/add');
			}
			$name = time() . rand(1, 9999) . "." . $type;
			$path = $_SERVER['DOCUMENT_ROOT'] . '/image/admin/dakashuo/';
			$res = move_uploaded_file($file, $path . $name) ? 'ok' : 'false';
			if($res == 'ok')
			{
				$img = '/admin/dakashuo/' . $name;
				$data['image'] = $img;
				$result = Db::name('dakashuo')->insert($data);
				if($result)
				{
					// 添加管理员日志
					admin_log($content = '添加大咖说-' . $_POST['title']);
					$this->success('添加成功', '/admin/dakashuo/index');
				}
				else
				{
					$this->error('添加失败', '/admin/dakashuo/index');
				}
			}
			else
			{
				$this->error('文件上传失败', '/admin/dakashuo/add');
			}
		}
	}

	/**
	 * 删除资讯
	 */
	public function del ()
	{
		// 检查权限
		admin_role('dakashuo_del');
		
		$id = $_GET['id'];
		$dakashuo = Db::table('dakashuo')->field('image,title')->where('id', $id)->find();
		$res = Db::table('dakashuo')->where('id', $id)->delete();
		if($res)
		{
			// 删除图片
			$image = $_SERVER['DOCUMENT_ROOT'] . '/image' . $dakashuo['image'];
			unlink($image);
			// 添加管理员日志
			admin_log($content = '删除大咖说-' . $dakashuo['title']);
			$this->success('删除成功', '/admin/dakashuo/index');
		}
		else
		{
			$this->error('删除失败', '/admin/dakashuo/index');
		}
	}

	/**
	 * 修改资讯
	 */
	public function edit ()
	{
		// 检查权限
		admin_role('dakashuo_edit');
		
		$id = $_GET['id'];
		$dakashuo = Db::table('dakashuo')->where('id', $id)->find();
		// 类别
		$cate = Db::table('dakashuo_cate')->select();
		return $this->fetch('dakashuo/edit', [
			'dakashuo' => $dakashuo, 
			'cate' => $cate
		]);
	}

	public function update ()
	{
		$data['title'] = $_POST['title'];
		$data['cate_id'] = $_POST['cate_id'];
		$data['content'] = $_POST['content'];
		$data['recommend'] = $_POST['recommend'];
		$data['offline_content'] = $_POST['offline_content'];
		$data['time'] = ! empty($_POST['time']) ? strtotime($_POST['time']) : time();
		$oldimg = Db::table('dakashuo')->field('image')->where('id', $_POST['id'])->find();
		// 判断是否有新图片上传
		$size = $_FILES['image']['size'];
		
		$data['seo_title'] = $_POST['seo_title'];
		$data['seo_keywords'] = $_POST['seo_keywords'];
		$data['seo_description'] = $_POST['seo_description'];
		if($size == '0')
		{
			$result = Db::table('dakashuo')->where('id', $_POST['id'])->update($data);
			if($result)
			{
				// 添加管理员日志
				admin_log($content = '修改新闻资讯-' . $_POST['title']);
				$this->success('修改成功', '/admin/dakashuo/edit?id=' . $_POST['id']);
			}
			else
			{
				$this->error('修改失败', '/admin/dakashuo/edit?id=' . $_POST['id']);
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
				$this->error('图片类型上传不正确，允许上传的图片类型：png,jpg,jpeg,gif', '/admin/dakashuo/edit?id=' . $_POST['id']);
			}
			$name = time() . rand(1, 9999) . "." . $type;
			$path = $_SERVER['DOCUMENT_ROOT'] . '/image/admin/dakashuo/';
			$res = move_uploaded_file($file, $path . $name) ? 'ok' : 'false';
			if($res == 'ok')
			{
				$img = '/admin/dakashuo/' . $name;
				$data['image'] = $img;
				$result = Db::table('dakashuo')->where('id', $_POST['id'])->update($data);
				if($result)
				{
					// 删掉原图
					$oldimg = $_SERVER['DOCUMENT_ROOT'] . '/image' . $oldimg['image'];
					unlink($oldimg);
					// 添加管理员日志
					admin_log($content = '修改新闻资讯-' . $_POST['title']);
					$this->success('修改成功', '/admin/dakashuo/edit?id=' . $_POST['id']);
				}
				else
				{
					$this->error('修改失败', '/admin/dakashuo/edit?id=' . $_POST['id']);
				}
			}
			else
			{
				$this->error('文件上传失败', '/admin/dakashuo/edit?id=' . $_POST['id']);
			}
		}
	}
}
