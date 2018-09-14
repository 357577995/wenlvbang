<?php
namespace app\admin\controller;
// 判断是否登录
use app\admin\controller\Base;
use think\Db;
use think\Request;

// 类继承自公共的类
class Settled extends Base
{

	protected function _initialize ()
	{
		parent::_initialize();
	}

	/**
	 * 项目方列表-审核通过的
	 */
	public function index (Request $request)
	{
		// 检查权限
		admin_role('project_user_list');
		
		$where = '';
		// 用户名搜索
		// $username = "'%" . $request->param('name') . "%'";
		// if(! empty($username))
		// {
		// $where .= 'name like ' . $username;
		// }
		// 状态搜索
		$status = $request->param('status');
		if(! empty($status))
		{
			$where .= ' and status = ' . $status;
		}
		
		$list = Db::table('settled_expert')->where($where)->paginate(5, false, [
			'query' => request()->param()
		]);
		$page = $list->render();
		$project = [];
		// foreach($list as $k => $vo)
		// {
		// $project[] = $vo;
		// }
		// 总个数
		$total = Db::table('settled_expert')->where($where)->field('COUNT(*) as total')->select();
		$this->assign('total', $total[0]['total']);
		return $this->fetch('settled/index', [
			'page' => $page, 
			'project' => $list
		]);
	}

	/**
	 * 审核不通过
	 */
	public function refuse ()
	{
		// 检查权限
		admin_role('project_user_do');
		
		$id = $_GET['id'];
		$result = Db::table('settled_expert')->where('id', $id)->update([
			'status' => 3
		]);
		if($result)
		{
			// 添加管理员日志
			$this->success('审核成功', '/admin/settled/index');
		}
		else
		{
			$this->error('审核失败', '/admin/settled/index');
		}
	}

	/**
	 * 审核通过
	 */
	public function pass ()
	{
		// 检查权限
		// admin_role('project_user_do');
		$id = $_GET['id'];
		$result = Db::table('settled_expert')->where('id', $id)->update([
			'status' => 2
		]);
		if($result)
		{
			// 添加管理员日志
			admin_log($content = '审核专家[' . $id . ']通过');
			$this->success('审核成功', '/admin/settled/index');
		}
		else
		{
			$this->error('审核失败', '/admin/settled/index');
		}
	}

	/**
	 * 删除项目方
	 */
	public function del ()
	{
		// 检查权限
		admin_role('project_user_del');
		
		$id = $_GET['id'];
		$res = Db::table('settled_expert')->where('id', $id)->delete();
		if($res)
		{
			// 删除营业执照
			// 添加管理员日志
			$this->success('删除成功', '/admin/settled/index');
		}
		else
		{
			$this->error('删除失败', '/admin/settled/index');
		}
	}

	/**
	 * 查看详情-修改
	 */
	public function edit ()
	{
		// 检查权限
		// admin_role('project_user_list');
		$id = $_GET['id'];
		$list = Db::table('settled_expert')->where('id', $id)->find();
		
		return $this->fetch('settled/edit', [
			'list' => $list
		]);
	}

	public function update ()
	{
		// 检查权限
		//admin_role('project_user_edit');
		
		$data['name'] = $_POST['name'];
		$data['mobile'] = $_POST['mobile'];
		$data['place'] = $_POST['place'];
		$data['content'] = $_POST['content'];
		// 判断是否有新图片上传
		$size = $_FILES['image']['size'];
		if($size == '0')
		{
			$result = Db::table('settled_expert')->where('id', $_POST['id'])->update($data);
			if($result)
			{
				// 添加管理员日志
				admin_log($content = '修改专家信息-' . $_POST['name']);
				$this->success('修改成功', '/admin/settled/edit?id=' . $_POST['id']);
			}
			else
			{
				$this->error('修改失败', '/admin/settled/edit?id=' . $_POST['id']);
			}
		}
		else
		{
			// 获取原图地址
			$image = Db::table('settled_expert')->field('image')->where('id', $_POST['id'])->find();
			
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
				$this->error('图片类型上传不正确，允许上传的图片类型：png,jpg,jpeg,gif', '/admin/settled/edit?id=' . $_POST['id']);
			}
			$name = time() . rand(1, 9999) . "." . $type;
			$path = $_SERVER['DOCUMENT_ROOT'] . '/image/admin/';
			$res = move_uploaded_file($file, $path . $name) ? 'ok' : 'false';
			if($res == 'ok')
			{
				$img = '/admin/' . $name;
				$data['image'] = $img;
				$result = Db::table('settled_expert')->where('id', $_POST['id'])->update($data);
				if($result)
				{
					// 删除原图
					$oldimg = $_SERVER['DOCUMENT_ROOT'] . '/image' . $image['image'];
					unlink($oldimg);
					
					// 添加管理员日志
					admin_log($content = '修改专家信息-' . $_POST['name']);
					$this->success('修改成功', '/admin/settled/edit?id=' . $_POST['id']);
				}
				else
				{
					$this->error('修改失败', '/admin/settled/edit?id=' . $_POST['id']);
				}
			}
			else
			{
				$this->error('文件上传失败', '/admin/settled/edit?id=' . $_POST['id']);
			}
		}
	}

	/**
	 * 帮空间-审核通过的
	 */
	public function project (Request $request)
	{
		// 检查权限
		admin_role('project_list');
		
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
		// 状态搜索
		$status = $request->param('status');
		if(! empty($status))
		{
			$where .= ' and status = ' . $status;
		}
		
		$list = Db::table('project')->where($where)->paginate(5, false, [
			'query' => request()->param()
		]);
		$page = $list->render();
		$project = [];
		foreach($list as $k => $vo)
		{
			$project[] = $vo;
			$project[$k]['time'] = date('Y-m-d H:i:s', $vo['time']);
			// 分类
			$cate = Db::table('project_cate')->where('id', $vo['cate_id'])->find();
			$project[$k]['cate'] = $cate['name'];
		}
		// 总个数
		$total = Db::table('project')->where($where)->field('COUNT(*) as total')->select();
		$this->assign('total', $total[0]['total']);
		// 搜索用分类
		$catelist = Db::table('project_cate')->select();
		$this->assign('catelist', $catelist);
		return $this->fetch('project/list', [
			'page' => $page, 
			'project' => $project
		]);
	}

	/**
	 * 帮空间-审核不通过
	 */
	public function project_refuse ()
	{
		$id = $_GET['id'];
		$name = Db::table('project')->where('id', $id)->find();
		$result = Db::table('project')->where('id', $id)->update([
			'status' => 3
		]);
		if($result)
		{
			// 添加管理员日志
			admin_log($content = '帮空间信息[' . $name['title'] . ']审核不通过');
			$this->success('审核成功', '/admin/project/project_apply');
		}
		else
		{
			$this->error('审核失败', '/admin/project/project_apply');
		}
	}

	/**
	 * 帮空间-审核通过
	 */
	public function project_pass ()
	{
		$id = $_GET['id'];
		$name = Db::table('project')->where('id', $id)->find();
		$result = Db::table('project')->where('id', $id)->update([
			'status' => 2
		]);
		if($result)
		{
			// 添加管理员日志
			admin_log($content = '帮空间信息[' . $name['title'] . ']审核通过');
			$this->success('审核成功', '/admin/project/project');
		}
		else
		{
			$this->error('审核失败', '/admin/project/project');
		}
	}

	/**
	 * 删除帮空间
	 */
	public function project_del ()
	{
		// 检查权限
		admin_role('project_del');
		
		$id = $_GET['id'];
		$name = Db::table('project')->where('id', $id)->find();
		$res = Db::table('project')->where('id', $id)->delete();
		if($res)
		{
			// 添加管理员日志
			admin_log($content = '删除帮空间信息-' . $name['title']);
			$this->success('删除成功', '/admin/project/project');
		}
		else
		{
			$this->error('删除失败', '/admin/project/project');
		}
	}

	/**
	 * 添加信息
	 */
	public function project_add ()
	{
		// 检查权限
		admin_role('project_add');
		
		// 读取分类
		$cate = Db::table('project_cate')->select();
		return $this->fetch('project/project_add', [
			'cate' => $cate
		]);
	}

	public function project_insert ()
	{
		$data['title'] = $_POST['title'];
		$data['fu_title'] = $_POST['fu_title'];
		$data['cate_id'] = $_POST['cate_id'];
		$data['content'] = $_POST['content'];
		$data['time'] = ! empty($_POST['time']) ? strtotime($_POST['time']) : time();
		$result = Db::name('project')->insert($data);
		if($result)
		{
			// 添加管理员日志
			admin_log($content = '添加帮空间信息-' . $_POST['title']);
			$this->success('添加成功', '/admin/project/project');
		}
		else
		{
			$this->error('添加失败', '/admin/project/project');
		}
	}

	/**
	 * 修改帮空间
	 */
	public function project_edit ()
	{
		// 检查权限
		admin_role('project_list');
		
		$id = $_GET['id'];
		$list = Db::table('project')->where('id', $id)->find();
		// 分类
		$catelist = Db::table('project_cate')->select();
		$this->assign('catelist', $catelist);
		return $this->fetch('project/project_edit', [
			'list' => $list
		]);
	}

	public function project_update ()
	{
		// 检查权限
		admin_role('project_edit');
		
		$data['title'] = $_POST['title'];
		$data['fu_title'] = $_POST['fu_title'];
		$data['cate_id'] = $_POST['cate_id'];
		$data['content'] = $_POST['content'];
		$data['time'] = ! empty($_POST['time']) ? strtotime($_POST['time']) : time();
		
		$result = Db::table('project')->where('id', $_POST['id'])->update($data);
		if($result)
		{
			// 添加管理员日志
			admin_log($content = '修改帮空间信息-' . $_POST['title']);
			$this->success('修改成功', '/admin/project/project');
		}
		else
		{
			$this->error('修改失败', '/admin/project/project');
		}
	}

	/**
	 * 帮空间分类
	 */
	public function cate ()
	{
		// 检查权限
		admin_role('project_cate');
		
		$project_cate = Db::table('project_cate')->paginate(5);
		$page = $project_cate->render();
		// 总个数
		$total = Db::table('project_cate')->field('COUNT(*) as total')->select();
		$this->assign('total', $total[0]['total']);
		
		return $this->fetch('project/cate', [
			'project_cate' => $project_cate, 
			'page' => $page
		]);
	}

	/**
	 * 添加帮空间分类
	 */
	public function cate_add ()
	{
		// 检查权限
		admin_role('project_cate');
		
		return $this->fetch('project/cate_add');
	}

	public function cate_insert ()
	{
		$data['name'] = $_POST['name'];
		// 判断该分类是否已存在
		$cate = Db::table('project_cate')->where('name', $_POST['name'])->find();
		if(! empty($cate))
		{
			$this->error('该分类名称已存在', '/admin/project/cate');
		}
		else
		{
			$result = Db::name('project_cate')->insert($data);
			if($result)
			{
				// 添加管理员日志
				admin_log($content = '添加帮空间分类-' . $_POST['name']);
				$this->success('添加成功', '/admin/project/cate');
			}
			else
			{
				$this->error('添加失败', '/admin/project/cate');
			}
		}
	}

	/**
	 * 删除帮空间分类
	 */
	public function cate_del ()
	{
		// 检查权限
		admin_role('project_cate');
		
		$id = $_GET['id'];
		$name = Db::table('project_cate')->where('id', $id)->find();
		$res = Db::table('project_cate')->where('id', $id)->delete();
		if($res)
		{
			// 添加管理员日志
			admin_log($content = '删除帮空间分类-' . $name['name']);
			$this->success('删除成功', '/admin/project/cate');
		}
		else
		{
			$this->error('删除失败', '/admin/project/cate');
		}
	}

	/**
	 * 修改帮空间分类
	 */
	public function cate_edit ()
	{
		// 检查权限
		admin_role('project_cate');
		
		$id = $_GET['id'];
		$list = Db::table('project_cate')->where('id', $id)->find();
		return $this->fetch('project/cate_edit', [
			'list' => $list
		]);
	}

	public function cate_update ()
	{
		$data['name'] = $_POST['name'];
		$result = Db::table('project_cate')->where('id', $_POST['id'])->update($data);
		if($result)
		{
			// 添加管理员日志
			admin_log($content = '修改帮空间分类-' . $_POST['name']);
			$this->success('修改成功', '/admin/project/cate');
		}
		else
		{
			$this->error('修改失败', '/admin/project/cate');
		}
	}
}
