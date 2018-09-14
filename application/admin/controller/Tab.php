<?php
namespace app\admin\controller;
// 判断是否登录
use app\admin\controller\Base;
use think\Db;
use think\Request;

// 类继承自公共的类
class Tab extends Base
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
		return $this->fetch('tab/cate', [
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
		
		return $this->fetch('tab/cate_add');
	}

	public function cate_insert ()
	{
		$data['name'] = $_POST['name'];
		// 判断该分类是否已存在
		$cate = Db::table('new_cate')->where('name', $_POST['name'])->find();
		if(! empty($cate))
		{
			$this->error('该分类名称已存在', '/admin/tab/cate');
		}
		else
		{
			$result = Db::name('new_cate')->insert($data);
			if($result)
			{
				// 添加管理员日志
				admin_log($content = '添加新闻资讯分类-' . $_POST['name']);
				$this->success('添加成功', '/admin/tab/cate');
			}
			else
			{
				$this->error('添加失败', '/admin/tab/cate');
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
			$this->success('删除成功', '/admin/tab/cate');
		}
		else
		{
			$this->error('删除失败', '/admin/tab/cate');
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
		return $this->fetch('tab/cate_edit', [
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
			$this->success('修改成功', '/admin/tab/cate');
		}
		else
		{
			$this->error('修改失败', '/admin/tab/cate');
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
		$title = "'%" . $request->param('name') . "%'";
		if(! empty($title))
		{
			$where .= 'name like ' . $title;
		}
		// 分类搜索
		$cate_id = $request->param('cate_id');
		if(! empty($cate_id))
		{
			$where .= ' and cate_id = ' . $cate_id;
		}
		
		$list = Db::table('tab')->where($where)->paginate(5, false, [
			'query' => request()->param()
		]);
		$page = $list->render();
		$tab = [];
		foreach($list as $k => $vo)
		{
			$tab[] = $vo;
		}
		// 搜索用的分类
		$catelist[] = [
			'id' => 1, 
			'name' => '文旅咨询'
		];
		$catelist[] = [
			'id' => 2, 
			'name' => '大咖说'
		];
		$catelist[] = [
			'id' => 3, 
			'name' => '文旅活动'
		];
		$catelist[] = [
			'id' => 4, 
			'name' => '文旅峰会'
		];
		// 总个数
		$total = Db::table('tab')->where($where)->field('COUNT(*) as total')->select();
		$this->assign('total', $total[0]['total']);
		$type[1] = '文旅咨询';
		$type[2] = '大咖说';
		$type[3] = '文旅活动';
		$type[4] = '文旅峰会';
		return $this->fetch('tab/index', [
			'tab' => $tab, 
			'type' => $type, 
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
		return $this->fetch('tab/add', []);
	}

	public function insert ()
	{
		$data['name'] = $_POST['name'];
		$data['type'] = $_POST['cate_id'];
		$result = Db::name('tab')->insert($data);
		if($result)
		{
			// 添加管理员日志
			admin_log($content = '添加标签-' . $_POST['name']);
			$this->success('添加成功', '/admin/tab/index');
		}
		else
		{
			$this->error('添加失败', '/admin/tab/index');
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
		$res = Db::table('tab')->where('id', $id)->delete();
		if($res)
		{
			// 添加管理员日志
			$this->success('删除成功', '/admin/tab/index');
		}
		else
		{
			$this->error('删除失败', '/admin/tab/index');
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
		$new = Db::table('tab')->where('id', $id)->find();
		// 类别
		$catelist[] = [
			'id' => 1, 
			'name' => '文旅咨询'
		];
		$catelist[] = [
			'id' => 2, 
			'name' => '大咖说'
		];
		$catelist[] = [
			'id' => 3, 
			'name' => '文旅活动'
		];
		$catelist[] = [
			'id' => 4, 
			'name' => '文旅峰会'
		];
		return $this->fetch('tab/edit', [
			'new' => $new, 
			'cate' => $catelist
		]);
	}

	public function update ()
	{
		$data['name'] = $_POST['name'];
		$data['type'] = $_POST['type'];
		$result = Db::table('tab')->where('id', $_POST['id'])->update($data);
		if($result)
		{
			// 添加管理员日志
			admin_log($content = '修改标签-' . $_POST['name']);
			$this->success('修改成功', '/admin/tab/edit?id=' . $_POST['id']);
		}
		else
		{
			$this->error('修改失败', '/admin/tab/edit?id=' . $_POST['id']);
		}
	}
}
