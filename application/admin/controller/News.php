<?php
namespace app\admin\controller;
// 判断是否登录
use app\admin\controller\Base;
use think\Db;
use think\Request;

// 类继承自公共的类
class News extends Base
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
		admin_role('new_cate');
		
		$new_cate = Db::table('new_cate')->paginate(5);
		$page = $new_cate->render();
		// 总个数
		$total = Db::table('new_cate')->field('COUNT(*) as total')->select();
		$this->assign('total', $total[0]['total']);
		return $this->fetch('news/cate', [
			'new_cate' => $new_cate, 
			'page' => $page
		]);
	}

	/**
	 * 添加资讯分类
	 */
	public function cate_add ()
	{
		// 检查权限
		admin_role('new_cate');
		
		return $this->fetch('news/cate_add');
	}

	public function cate_insert ()
	{
		$data['name'] = $_POST['name'];
		// 判断该分类是否已存在
		$cate = Db::table('new_cate')->where('name', $_POST['name'])->find();
		if(! empty($cate))
		{
			$this->error('该分类名称已存在', '/admin/news/cate');
		}
		else
		{
			$result = Db::name('new_cate')->insert($data);
			if($result)
			{
				// 添加管理员日志
				admin_log($content = '添加新闻资讯分类-' . $_POST['name']);
				$this->success('添加成功', '/admin/news/cate');
			}
			else
			{
				$this->error('添加失败', '/admin/news/cate');
			}
		}
	}

	/**
	 * 删除资讯分类
	 */
	public function cate_del ()
	{
		// 检查权限
		admin_role('new_cate');
		
		$id = $_GET['id'];
		$name = Db::table('new_cate')->where('id', $id)->find();
		$res = Db::table('new_cate')->where('id', $id)->delete();
		if($res)
		{
			// 添加管理员日志
			admin_log($content = '删除新闻资讯分类-' . $name['name']);
			$this->success('删除成功', '/admin/news/cate');
		}
		else
		{
			$this->error('删除失败', '/admin/news/cate');
		}
	}

	/**
	 * 修改资讯分类
	 */
	public function cate_edit ()
	{
		// 检查权限
		admin_role('new_cate');
		
		$id = $_GET['id'];
		$list = Db::table('new_cate')->where('id', $id)->find();
		return $this->fetch('news/cate_edit', [
			'list' => $list
		]);
	}

	public function cate_update ()
	{
		$data['name'] = $_POST['name'];
		$result = Db::table('new_cate')->where('id', $_POST['id'])->update($data);
		if($result)
		{
			// 添加管理员日志
			admin_log($content = '修改新闻资讯分类-' . $_POST['name']);
			$this->success('修改成功', '/admin/news/cate');
		}
		else
		{
			$this->error('修改失败', '/admin/news/cate');
		}
	}

	/**
	 * 资讯列表
	 */
	public function index (Request $request)
	{
		// 检查权限
		admin_role('new_list');
		
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
		
		$list = Db::table('news')->where($where)->paginate(20, false, [
			'query' => request()->param()
		]);
		$page = $list->render();
		$news = [];
		foreach($list as $k => $vo)
		{
			$news[] = $vo;
			$news[$k]['time'] = date('Y-m-d H:i:s', $vo['time']);
			// 分类
			$cate = Db::table('new_cate')->where('id', $vo['cate_id'])->find();
			$news[$k]['cate'] = $cate['name'];
		}
		// 搜索用的分类
		$catelist = Db::table('new_cate')->select();
		// 总个数
		$total = Db::table('news')->where($where)->field('COUNT(*) as total')->select();
		$this->assign('total', $total[0]['total']);
		
		return $this->fetch('news/index', [
			'news' => $news, 
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
		admin_role('new_add');
		
		// 读取分类
		$cate = Db::table('new_cate')->select();
		$tab = Db::table('tab')->where('type', 1)->select();
		return $this->fetch('news/add', [
			'cate' => $cate, 
			'tab' => $tab
		]);
	}

	public function insert ()
	{
		$data['title'] = $_POST['title'];
		$data['cate_id'] = $_POST['cate_id'];
		$data['content'] = $_POST['content'];
		$data['recommend'] = $_POST['recommend'];
		$data['abstract'] = $_POST['abstract'];
		$data['author'] = $_POST['author'];
		$data['offline_content'] = $_POST['offline_content'];
		$data['sort'] = ! empty($_POST['sort']) ? $_POST['sort'] : 255;
		$data['time'] = ! empty($_POST['time']) ? strtotime($_POST['time']) : time();
		$tab = empty($_POST['tab']) ? [] : $_POST['tab'];
		
		
		$data['seo_title'] = $_POST['seo_title'];
		$data['seo_keywords'] = $_POST['seo_keywords'];
		$data['seo_description'] = $_POST['seo_description'];
		
		
		// 判断是否有新图片上传
		$size = $_FILES['image']['size'];
		
		if(! empty($_POST['new_tab']))
		{
			$new_tabs = explode(',', $_POST['new_tab']);
			for($i = 0; $i < 5; $i ++)
			{
				if(isset($new_tabs[$i]))
				{
					$temp['name'] = $new_tabs[$i];
					$temp['type'] = 1;
					Db::name('tab')->insert($temp);
					$tab[] = Db::name('tab')->getLastInsID();
				}
			}
		}
		// }
		if($size == '0')
		{
			// $this->error('资讯图片未上传','/admin/news/add');
			$img = '/admin/default.png';
			$data['image'] = $img;
			$result = Db::name('news')->insert($data);
			if($result)
			{
				$id = Db::name('news')->getLastInsID();
				foreach($tab as $k => $vo)
				{
					if(! isset($vo))
					{
						continue;
					}
					$res['tab_id'] = $vo;
					$res['activity_id'] = $id;
					Db::name('tab_map')->insert($res);
				}
				
				// 添加管理员日志
				admin_log($content = '添加新闻资讯-' . $_POST['title']);
				$this->success('添加成功', '/admin/news/index');
			}
			else
			{
				$this->error('添加失败', '/admin/news/index');
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
				$this->error('图片类型上传不正确，允许上传的图片类型：png,jpg,jpeg,gif', '/admin/news/add');
			}
			$name = time() . rand(1, 9999) . "." . $type;
			$path = $_SERVER['DOCUMENT_ROOT'] . '/image/admin/news/';
			$res = move_uploaded_file($file, $path . $name) ? 'ok' : 'false';
			if($res == 'ok')
			{
				$img = '/admin/news/' . $name;
				$data['image'] = $img;
				$result = Db::name('news')->insert($data);
				if($result)
				{
					// 添加管理员日志
					$id = Db::name('news')->getLastInsID();
					if(isset($tab))
					{
						foreach($tab as $k => $vo)
						{
							if(! isset($vo))
							{
								continue;
							}
							$res['tab_id'] = $vo;
							$res['activity_id'] = $id;
							Db::name('tab_map')->insert($res);
						}
					}
					admin_log($content = '添加新闻资讯-' . $_POST['title']);
					$this->success('添加成功', '/admin/news/index');
				}
				else
				{
					$this->error('添加失败', '/admin/news/index');
				}
			}
			else
			{
				$this->error('文件上传失败', '/admin/news/add');
			}
		}
	}

	/**
	 * 删除资讯
	 */
	public function del ()
	{
		// 检查权限
		admin_role('new_del');
		
		$id = $_GET['id'];
		$new = Db::table('news')->field('image,title')->where('id', $id)->find();
		$res = Db::table('news')->where('id', $id)->delete();
		if($res)
		{
			// 删除图片
			$image = $_SERVER['DOCUMENT_ROOT'] . '/image' . $new['image'];
			if($new['image'] != '/admin/default.png')
			{
				unlink($image);
			}
			// 添加管理员日志
			admin_log($content = '删除新闻资讯-' . $new['title']);
			$this->success('删除成功', '/admin/news/index');
		}
		else
		{
			$this->error('删除失败', '/admin/news/index');
		}
	}

	/**
	 * 修改资讯
	 */
	public function edit ()
	{
		// 检查权限
		admin_role('new_edit');
		
		$id = $_GET['id'];
		$new = Db::table('news')->where('id', $id)->find();
		// 类别
		$cate = Db::table('new_cate')->select();
		$tab = Db::table('tab')->where('type', 1)->select();
		$tab_ids = Db::table('tab_map')->where('activity_id', $id)->column("tab_id");
		return $this->fetch('news/edit', [
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
		$data['recommend'] = $_POST['recommend'];
		$data['abstract'] = $_POST['abstract'];
		$data['author'] = $_POST['author'];
		$data['offline_content'] = $_POST['offline_content'];
		$data['sort'] = ! empty($_POST['sort']) ? $_POST['sort'] : 255;
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
					$temp['type'] = 1;
					Db::name('tab')->insert($temp);
					$tab[] = Db::name('tab')->getLastInsID();
				}
			}
		}
		
		$oldimg = Db::table('news')->field('image')->where('id', $_POST['id'])->find();
		// 判断是否有新图片上传
		$size = $_FILES['image']['size'];
		if($size == '0')
		{
			$result = Db::table('news')->where('id', $_POST['id'])->update($data);
			if($result)
			{
				
				Db::table('tab_map')->where('activity_id', $_POST['id'])->delete();
				foreach($tab as $k => $vo)
				{
					if(! isset($vo))
					{
						continue;
					}
					$res['tab_id'] = $vo;
					$res['activity_id'] = $_POST['id'];
					Db::name('tab_map')->insert($res);
				}
				// 添加管理员日志
				admin_log($content = '修改新闻资讯-' . $_POST['title']);
				$this->success('修改成功', '/admin/news/edit?id=' . $_POST['id']);
			}
			else
			{
				$this->error('修改失败', '/admin/news/edit?id=' . $_POST['id']);
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
				$this->error('图片类型上传不正确，允许上传的图片类型：png,jpg,jpeg,gif', '/admin/news/edit?id=' . $_POST['id']);
			}
			$name = time() . rand(1, 9999) . "." . $type;
			$path = $_SERVER['DOCUMENT_ROOT'] . '/image/admin/news/';
			$res = move_uploaded_file($file, $path . $name) ? 'ok' : 'false';
			if($res == 'ok')
			{
				$img = '/admin/news/' . $name;
				$data['image'] = $img;
				$result = Db::table('news')->where('id', $_POST['id'])->update($data);
				if($result)
				{
					foreach($tab as $k => $vo)
					{
						if(! isset($vo))
						{
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
					admin_log($content = '修改新闻资讯-' . $_POST['title']);
					$this->success('修改成功', '/admin/news/edit?id=' . $_POST['id']);
				}
				else
				{
					$this->error('修改失败', '/admin/news/edit?id=' . $_POST['id']);
				}
			}
			else
			{
				$this->error('文件上传失败', '/admin/news/edit?id=' . $_POST['id']);
			}
		}
	}

	public function seo (Request $request)
	{
		$is_list = $request->get('is_list');
		$where = 'type = 0 and is_list =' . $is_list;
		$model = Db::table('seo')->where($where)->find();
		$this->assign('model', empty($model) ? ['title'=>'','keywords'=>'','description'=>''] : $model);
		$this->assign('is_list', $is_list);
		
		return $this->fetch('news/list_seo');
	}

	public function seoinsert ()
	{
		$data['title'] = $_POST['title'];
		$data['keywords'] = $_POST['keywords'];
		$data['description'] = $_POST['description'];
		$data['is_list'] = $_POST['is_list'];
		$data['type'] = 0;
		$where = 'type = 0 and is_list =' . $_POST['is_list'];
		$res = Db::table('seo')->where($where)->delete();
		$result = Db::name('seo')->insert($data);
		
		if($result)
		{
			// 添加管理员日志
			admin_log($content = '添加新闻资讯-' . $_POST['title']);
			$this->success('添加成功', '/admin/news/index');
		}
		else
		{
			$this->error('添加失败', '/admin/news/index');
		}
	}
}
