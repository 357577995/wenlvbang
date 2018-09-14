<?php
namespace app\admin\controller;
// 判断是否登录
use app\admin\controller\Base;
use think\Db;
use think\Request;

// 类继承自公共的类
class Investment extends Base
{

	protected function _initialize ()
	{
		parent::_initialize();
	}

	/**
	 * 项目分类
	 */
	public function cate ()
	{
		// 检查权限
		admin_role('investment_cate');
		
		$investment_cate = Db::table('investment_cate')->paginate(5);
		$page = $investment_cate->render();
		// 总个数
		$total = Db::table('investment_cate')->field('COUNT(*) as total')->select();
		$this->assign('total', $total[0]['total']);
		
		return $this->fetch('investment/cate', [
			'investment_cate' => $investment_cate, 
			'page' => $page
		]);
	}

	/**
	 * 添加项目分类
	 */
	public function cate_add ()
	{
		// 检查权限
		admin_role('investment_cate');
		
		return $this->fetch('investment/cate_add');
	}

	public function cate_insert ()
	{
		$data['name'] = $_POST['name'];
		// 判断该分类是否已存在
		$cate = Db::table('investment_cate')->where('name', $_POST['name'])->find();
		if(! empty($cate))
		{
			$this->error('该分类名称已存在', '/admin/investment/cate');
		}
		else
		{
			$result = Db::name('investment_cate')->insert($data);
			if($result)
			{
				// 添加管理员日志
				admin_log($content = '添加投融项目分类-' . $_POST['name']);
				$this->success('添加成功', '/admin/investment/cate');
			}
			else
			{
				$this->error('添加失败', '/admin/investment/cate');
			}
		}
	}

	/**
	 * 删除项目分类
	 */
	public function cate_del ()
	{
		// 检查权限
		admin_role('investment_cate');
		
		$id = $_GET['id'];
		$name = Db::table('investment_cate')->where('id', $id)->find();
		$res = Db::table('investment_cate')->where('id', $id)->delete();
		if($res)
		{
			// 添加管理员日志
			admin_log($content = '删除投融项目分类-' . $name['name']);
			$this->success('删除成功', '/admin/investment/cate');
		}
		else
		{
			$this->error('删除失败', '/admin/investment/cate');
		}
	}

	/**
	 * 修改项目分类
	 */
	public function cate_edit ()
	{
		// 检查权限
		admin_role('investment_cate');
		
		$id = $_GET['id'];
		$list = Db::table('investment_cate')->where('id', $id)->find();
		return $this->fetch('investment/cate_edit', [
			'list' => $list
		]);
	}

	public function cate_update ()
	{
		$data['name'] = $_POST['name'];
		$result = Db::table('investment_cate')->where('id', $_POST['id'])->update($data);
		if($result)
		{
			// 添加管理员日志
			admin_log($content = '修改投融项目分类-' . $_POST['name']);
			$this->success('修改成功', '/admin/investment/cate');
		}
		else
		{
			$this->error('修改失败', '/admin/investment/cate');
		}
	}

	/**
	 * 投融项目列表
	 */
	public function index (Request $request)
	{
		// 检查权限
		admin_role('investment_list');
		
		$where = '';
		// 名称搜索
		$name = "'%" . $request->param('name') . "%'";
		if(! empty($name))
		{
			$where .= 'name like ' . $name;
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
		
		$list = Db::table('investment')->where($where)->paginate(5, false, [
			'query' => request()->param()
		]);
		$page = $list->render();
		$investment = [];
		foreach($list as $k => $vo)
		{
			$investment[] = $vo;
			$investment[$k]['time'] = date('Y-m-d H:i:s', $vo['time']);
			// 分类
			$cate = Db::table('investment_cate')->where('id', $vo['cate_id'])->find();
			$investment[$k]['cate'] = $cate['name'];
		}
		// 搜索用的分类
		$catelist = Db::table('investment_cate')->select();
		// 总个数
		$total = Db::table('investment')->where($where)->field('COUNT(*) as total')->select();
		$this->assign('total', $total[0]['total']);
		
		return $this->fetch('investment/index', [
			'investment' => $investment, 
			'page' => $page, 
			'catelist' => $catelist
		]);
	}

	/**
	 * 添加投融项目
	 */
	public function add ()
	{
		// 检查权限
		admin_role('investment_add');
		
		// 读取分类
		$cate = Db::table('investment_cate')->select();
		return $this->fetch('investment/add', [
			'cate' => $cate
		]);
	}

	public function insert ()
	{
		$data['name'] = $_POST['name'];
		$data['fu_title'] = $_POST['fu_title'];
		$data['cate_id'] = $_POST['cate_id'];
		$data['content'] = $_POST['content'];
		$data['recommend'] = $_POST['recommend'];
		$data['sort'] = ! empty($_POST['sort']) ? $_POST['sort'] : 255;
		$data['time'] = ! empty($_POST['time']) ? strtotime($_POST['time']) : time();
		$data['seo_title'] = $_POST['seo_title'];
		$data['seo_keywords'] = $_POST['seo_keywords'];
		$data['seo_description'] = $_POST['seo_description'];
		
		$result = Db::name('investment')->insert($data);
		if($result)
		{
			// 添加管理员日志
			admin_log($content = '添加投融项目-' . $_POST['name']);
			$this->success('添加成功', '/admin/investment/index');
		}
		else
		{
			$this->error('添加失败', '/admin/investment/index');
		}
	}

	/**
	 * 删除投融项目
	 */
	public function del ()
	{
		// 检查权限
		admin_role('investment_del');
		
		$id = $_GET['id'];
		$name = Db::table('investment')->where('id', $id)->find();
		$res = Db::table('investment')->where('id', $id)->delete();
		if($res)
		{
			// 添加管理员日志
			admin_log($content = '删除投融项目-' . $name['name']);
			$this->success('删除成功', '/admin/investment/index');
		}
		else
		{
			$this->error('删除失败', '/admin/investment/index');
		}
	}

	/**
	 * 修改投融项目
	 */
	public function edit ()
	{
		// 检查权限
		admin_role('investment_edit');
		
		$id = $_GET['id'];
		$investment = Db::table('investment')->where('id', $id)->find();
		// 类别
		$cate = Db::table('investment_cate')->select();
		return $this->fetch('investment/edit', [
			'investment' => $investment, 
			'cate' => $cate
		]);
	}

	public function update ()
	{
		$data['name'] = $_POST['name'];
		$data['fu_title'] = $_POST['fu_title'];
		$data['cate_id'] = $_POST['cate_id'];
		$data['content'] = $_POST['content'];
		$data['recommend'] = $_POST['recommend'];
		$data['sort'] = ! empty($_POST['sort']) ?$_POST['sort'] : 255;
		$data['time'] = ! empty($_POST['time']) ? strtotime($_POST['time']) : time();
		$data['seo_title'] = $_POST['seo_title'];
		$data['seo_keywords'] = $_POST['seo_keywords'];
		$data['seo_description'] = $_POST['seo_description'];
		
		$result = Db::table('investment')->where('id', $_POST['id'])->update($data);
		if($result)
		{
			// 添加管理员日志
			admin_log($content = '修改投融项目-' . $_POST['name']);
			$this->success('修改成功', '/admin/investment/edit?id=' . $_POST['id']);
		}
		else
		{
			$this->error('修改失败', '/admin/investment/edit?id=' . $_POST['id']);
		}
	}
}
