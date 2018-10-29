<?php
namespace app\admin\controller;
// 判断是否登录
use app\admin\controller\Base;
use think\Db;
use think\Session;
use think\Request;

// 类继承自公共的类
class Plan extends Base
{

	protected function _initialize ()
	{
		parent::_initialize();
	}

	/**
	 * 方案库列表
	 */
	public function index (Request $request)
	{
		
		// 检查权限
		admin_role('plan_list');
		
		$where = '';
		// 名称搜索
		$name = "'%" . $request->param('name') . "%'";
		$where .= 'name like ' . $name . '';
		// 分类搜索
		if(! empty($request->param('cate_id')))
		{
			$cate_id = $request->param('cate_id');
			// 如果是二级的
			$cate = Db::table('cate')->where('parent_id', $cate_id)->select();
			if(! empty($cate))
			{
				$str = [];
				foreach($cate as $k => $vo)
				{
					$str[] = $vo['id'];
				}
				$str = implode(',', $str);
				$where .= ' and cate_id in (' . $str . ')';
			}
			else
			{
				$where .= ' and cate_id = ' . $request->param('cate_id');
			}
		}
		// 状态搜索
		$status = $request->param('status');
		if(! empty($status))
		{
			$where .= ' and status = ' . $status;
		}
		
		$list = Db::table('plan')->where($where)->paginate(5, false, [
			'query' => request()->param()
		]);
		$page = $list->render();
		$plan = [];
		foreach($list as $k => $vo)
		{
			$plan[] = $vo;
			// 分类名称
			$cate2 = Db::table('cate')->where('id', $vo['cate_id'])->find();
			$plan[$k]['cate2'] = $cate2['name'];
			// 上级分类
			$cate1 = Db::table('cate')->where('id', $vo['parent_cate_id'])->find();
			$plan[$k]['cate1'] = $cate1['name'];
			
			// 参数
			$plan[$k]['param'] = Db::table('plan_param')->where('plan_id', $vo['id'])->select();
		}
		// 总个数
		$total = Db::table('plan')->where($where)->field('COUNT(*) as total')->select();
		$this->assign('total', $total[0]['total']);
		// 查询分类
		$cate = Db::table('cate')->where('parent_id', '0')->select();
		foreach($cate as $k => $vo)
		{
			$cate[$k]['son'] = Db::table('cate')->where('parent_id', $vo['id'])->select();
			foreach($cate[$k]['son'] as $kk => $voo)
			{
				$cate[$k]['son'][$kk]['sun'] = Db::table('cate')->where('parent_id', $voo['id'])->select();
			}
		}
		$this->assign('cate', $cate);
		return $this->fetch('plan/index', [
			'page' => $page, 
			'plan' => $plan
		]);
	}

	/**
	 * 删除方案
	 */
	public function del ()
	{
		// 检查权限
		admin_role('plan_del');
		
		$id = $_GET['id'];
		$plan = Db::table('plan')->where('id', $id)->find();
		// 判断该方案是否已经添加到订单中-不能删除
		$order_detail = Db::table('order_detail')->where('plan_id', $id)->find();
		if(empty($order_detail))
		{
			$image = Db::table('plan')->field('image')->where('id', $id)->find();
			$res = Db::table('plan')->where('id', $id)->delete();
			if($res)
			{
				// 删除下面的参数
				Db::table('plan_param')->where('plan_id', $id)->delete();
				// 删除存储的相应图片
				$oldimg = $_SERVER['DOCUMENT_ROOT'] . '/image' . $image['image'];
				unlink($oldimg);
				// 添加管理员日志
				admin_log($content = '删除方案-' . $plan['name']);
				$this->success('删除成功', '/admin/plan/index');
			}
			else
			{
				$this->error('删除失败', '/admin/plan/index');
			}
		}
		else
		{
			$this->error('该方案已经加入订单，请先删除相关订单再重试', '/admin/plan/index');
		}
	}

	/**
	 * 查看方案详情
	 */
	public function detail ($id)
	{
		// 检查权限
		admin_role('plan_list');
		
		$id = $_GET['id'];
		$list = Db::table('plan')->where('id', $id)->find();
		// 查询分类
		$cate1 = Db::table('cate')->where('id', $list['parent_cate_id'])->find();
		$cate2 = Db::table('cate')->where('id', $list['cate_id'])->find();
		$cate_name = $cate1['name'] . '->' . $cate2['name'];
		// 判断是不是到头了
		if($cate1['parent_id'] != '0')
		{
			$cate3 = Db::table('cate')->where('id', $cate1['parent_id'])->find();
			$cate_name = $cate3['name'] . '->' . $cate_name;
		}
		$this->assign('cate_name', $cate_name);
		
		// 查询参数
		$param = Db::table('plan_param')->where('plan_id', $id)->select();
		return $this->fetch('plan/detail', [
			'list' => $list, 
			'param' => $param
		]);
	}

	/**
	 * 待审核方案库列表
	 */
	public function apply (Request $request)
	{
		// 检查权限
		admin_role('plan_list');
		
		$where = '';
		// 名称搜索
		$name = "'%" . $request->param('name') . "%'";
		$where .= 'name like ' . $name . '';
		// 分类搜索
		if(! empty($request->param('cate_id')))
		{
			$cate_id = $request->param('cate_id');
			// 如果是二级的
			$cate = Db::table('cate')->where('parent_id', $cate_id)->select();
			if(! empty($cate))
			{
				$str = [];
				foreach($cate as $k => $vo)
				{
					$str[] = $vo['id'];
				}
				$str = implode(',', $str);
				$where .= ' and cate_id in (' . $str . ')';
			}
			else
			{
				$where .= ' and cate_id = ' . $request->param('cate_id');
			}
		}
		
		$list = Db::table('plan')->where($where)->where('status', 1)->paginate(5, false, [
			'query' => request()->param()
		]);
		$page = $list->render();
		$plan = [];
		foreach($list as $k => $vo)
		{
			$plan[] = $vo;
			// 分类名称
			$cate2 = Db::table('cate')->where('id', $vo['cate_id'])->find();
			$plan[$k]['cate2'] = $cate2['name'];
			$cate1 = Db::table('cate')->where('id', $vo['parent_cate_id'])->find();
			$plan[$k]['cate1'] = $cate1['name'];
			// 参数
			$plan[$k]['param'] = Db::table('plan_param')->where('plan_id', $vo['id'])->select();
		}
		// 总个数
		$total = Db::table('plan')->where($where)->field('COUNT(*) as total')->where('status', 1)->select();
		$this->assign('total', $total[0]['total']);
		// 查询分类
		$cate = Db::table('cate')->where('parent_id', '0')->select();
		foreach($cate as $k => $vo)
		{
			$cate[$k]['son'] = Db::table('cate')->where('parent_id', $vo['id'])->select();
			foreach($cate[$k]['son'] as $kk => $voo)
			{
				$cate[$k]['son'][$kk]['sun'] = Db::table('cate')->where('parent_id', $voo['id'])->select();
			}
		}
		
		$this->assign('cate', $cate);
		return $this->fetch('plan/apply', [
			'page' => $page, 
			'plan' => $plan
		]);
	}

	/**
	 * 审核通过
	 */
	public function pass ()
	{
		// 检查权限
		admin_role('plan_do');
		
		$id = $_GET['id'];
		$name = Db::table('plan')->where('id', $id)->find();
		$result = Db::table('plan')->where('id', $id)->update([
			'status' => 2
		]);
		if($result)
		{
			// 添加管理员日志
			admin_log($content = '修改方案[' . $name['name'] . ']审核通过');
			$this->success('审核成功', '/admin/plan/index');
		}
		else
		{
			$this->error('审核失败', '/admin/plan/index');
		}
	}

	/**
	 * 审核拒绝
	 */
	public function refuse ()
	{
		// 检查权限
		admin_role('plan_do');
		
		$id = $_GET['id'];
		$name = Db::table('plan')->where('id', $id)->find();
		$result = Db::table('plan')->where('id', $id)->update([
			'status' => 3
		]);
		if($result)
		{
			// 添加管理员日志
			admin_log($content = '修改方案[' . $name['name'] . ']审核拒绝');
			$this->success('审核成功', '/admin/plan/index');
		}
		else
		{
			$this->error('审核失败', '/admin/plan/index');
		}
	}

	/**
	 * 添加方案
	 */
	public function add ()
	{
		// 读取分类
		$cate = Db::table('cate')->where('parent_id <> 0')->select();
		return $this->fetch('plan/add', [
			'cate' => $cate
		]);
	}

	public function insert ()
	{
		$data['name'] = $_POST['name'];
		$data['cate_id'] = $_POST['cate_id'];
		$data['content'] = $_POST['content'];
		$parent_cate_id = Db::name('cate')->field('parent_id')->where('id', $data['cate_id'])->find();
		$data['parent_cate_id'] = $parent_cate_id['parent_id'];
		// 判断是否有新图片上传
		$size = $_FILES['image']['size'];
		
		if($size == '0')
		{
			// $this->error('资讯图片未上传','/admin/news/add');
			$img = '/admin/default.png';
			$data['image'] = $img;
			
			$result = Db::name('plan')->insert($data);
			if($result)
			{
				// 添加管理员日志
				admin_log($content = '添加方案-' . $_POST['name']);
				$this->success('添加成功', '/admin/plan/index');
			}
			else
			{
				$this->error('添加失败', '/admin/plan/index');
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
				$this->error('图片类型上传不正确，允许上传的图片类型：png,jpg,jpeg,gif', '/admin/plan/add');
			}
			$name = time() . rand(1, 9999) . "." . $type;
			$path = $_SERVER['DOCUMENT_ROOT'] . '/image/admin/plan/';
			$res = move_uploaded_file($file, $path . $name) ? 'ok' : 'false';
			if($res == 'ok')
			{
				$img = '/admin/plan/' . $name;
				$data['image'] = $img;
				$result = Db::name('plan')->insert($data);
				if($result)
				{
					// 添加管理员日志
					admin_log($content = '添加方案-' . $_POST['name']);
					$this->success('添加成功', '/admin/plan/index');
				}
				else
				{
					$this->error('添加失败', '/admin/plan/index');
				}
			}
			else
			{
				$this->error('文件上传失败', '/admin/plan/add');
			}
		}
	}

	public function edit ()
	{
		// 检查权限
		$id = $_GET['id'];
		$new = Db::table('plan')->where('id', $id)->find();
		// 类别
		$cate = Db::table('cate')->where('parent_id <> 0')->select();
		return $this->fetch('plan/edit', [
			'new' => $new, 
			'cate' => $cate
		]);
	}

	public function update ()
	{
		$data['name'] = $_POST['name'];
		$data['cate_id'] = $_POST['cate_id'];
		$data['content'] = $_POST['content'];
		$parent_cate_id = Db::name('cate')->field('parent_id')->where('id', $data['cate_id'])->find();
		$data['parent_cate_id'] = $parent_cate_id['parent_id'];
		// 判断是否有新图片上传
		$size = $_FILES['image']['size'];
		if($size == '0')
		{
			$result = Db::table('plan')->where('id', $_POST['id'])->update($data);
			if($result)
			{
				// 添加管理员日志
				admin_log($content = '修改方案-' . $_POST['name']);
				$this->success('修改成功', '/admin/plan/edit?id=' . $_POST['id']);
			}
			else
			{
				$this->error('修改失败', '/admin/plan/edit?id=' . $_POST['id']);
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
				$this->error('图片类型上传不正确，允许上传的图片类型：png,jpg,jpeg,gif', '/admin/plan/edit?id=' . $_POST['id']);
			}
			$name = time() . rand(1, 9999) . "." . $type;
			$path = $_SERVER['DOCUMENT_ROOT'] . '/image/admin/plan/';
			$res = move_uploaded_file($file, $path . $name) ? 'ok' : 'false';
			if($res == 'ok')
			{
				$img = '/admin/plan/' . $name;
				$data['image'] = $img;
				$result = Db::table('plan')->where('id', $_POST['id'])->update($data);
				if($result)
				{
					// 添加管理员日志
					admin_log($content = '修改方案-' . $_POST['title']);
					$this->success('修改成功', '/admin/plan/edit?id=' . $_POST['id']);
				}
				else
				{
					$this->error('修改失败', '/admin/plan/edit?id=' . $_POST['id']);
				}
			}
			else
			{
				$this->error('文件上传失败', '/admin/plan/edit?id=' . $_POST['id']);
			}
		}
	}
}
