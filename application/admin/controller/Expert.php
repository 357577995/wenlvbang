<?php
namespace app\admin\controller;
// 判断是否登录
use app\admin\controller\Base;
use think\Db;
use think\Request;

// 类继承自公共的类
class Expert extends Base
{

	protected function _initialize ()
	{
		parent::_initialize();
	}

	/**
	 * 专家列表
	 */
	public function index (Request $request)
	{
		// 检查权限
		admin_role('expert_list');
		
		$where = '';
		// 名称搜索
		$name = "'%" . $request->param('name') . "%'";
		if(! empty($name))
		{
			$where .= 'name like ' . $name;
		}
		// 擅长领域搜索
		$place = "'%" . $request->param('place') . "%'";
		if(! empty($place))
		{
			$where .= ' and place like ' . $place;
		}
		
		$expert = Db::table('expert')->where($where)->paginate(5, false, [
			'query' => request()->param()
		]);
		$page = $expert->render();
		// 总个数
		$total = Db::table('expert')->where($where)->field('COUNT(*) as total')->select();
		$this->assign('total', $total[0]['total']);
		
		return $this->fetch('expert/index', [
			'expert' => $expert, 
			'page' => $page
		]);
	}

	/**
	 * 添加专家
	 */
	public function add ()
	{
		// 检查权限
		admin_role('expert_add');
		
		return $this->fetch('expert/add');
	}

	public function insert ()
	{
		$data['name'] = $_POST['name'];
		$data['place'] = $_POST['place'];
		$data['content'] = $_POST['content'];
		$data['time'] = ! empty($_POST['time']) ? strtotime($_POST['time']) : time();
		// 判断是否有新图片上传
		$size = $_FILES['image']['size'];
		if($size == '0')
		{
			// $this->error('图片未上传','/admin/expert/add');
			$img = '/admin/default.png';
			$data['image'] = $img;
			$result = Db::name('expert')->insert($data);
			if($result)
			{
				// 添加管理员日志
				admin_log($content = '添加专家-' . $_POST['name']);
				$this->success('添加成功', '/admin/expert/index');
			}
			else
			{
				$this->error('添加失败', '/admin/expert/index');
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
				$this->error('图片类型上传不正确，允许上传的图片类型：png,jpg,jpeg,gif', '/admin/expert/add');
			}
			$name = time() . rand(1, 9999) . "." . $type;
			$path = $_SERVER['DOCUMENT_ROOT'] . '/image/admin/expert/';
			$res = move_uploaded_file($file, $path . $name) ? 'ok' : 'false';
			if($res == 'ok')
			{
				$img = '/admin/expert/' . $name;
				$data['image'] = $img;
				$result = Db::name('expert')->insert($data);
				if($result)
				{
					// 添加管理员日志
					admin_log($content = '添加专家-' . $_POST['name']);
					$this->success('添加成功', '/admin/expert/index');
				}
				else
				{
					$this->error('添加失败', '/admin/expert/index');
				}
			}
			else
			{
				$this->error('文件上传失败', '/admin/expert/add');
			}
		}
	}

	/**
	 * 删除专家
	 */
	public function del ()
	{
		// 检查权限
		admin_role('expert_del');
		
		$id = $_GET['id'];
		$expert = Db::table('expert')->field('image,name')->where('id', $id)->find();
		$res = Db::table('expert')->where('id', $id)->delete();
		if($res)
		{
			// 删除图片
			$image = $_SERVER['DOCUMENT_ROOT'] . '/image' . $expert['image'];
			unlink($image);
			// 添加管理员日志
			admin_log($content = '删除专家-' . $expert['name']);
			$this->success('删除成功', '/admin/expert/index');
		}
		else
		{
			$this->error('删除失败', '/admin/expert/index');
		}
	}

	/**
	 * 修改专家
	 */
	public function edit ()
	{
		// 检查权限
		admin_role('expert_edit');
		
		$id = $_GET['id'];
		$expert = Db::table('expert')->where('id', $id)->find();
		return $this->fetch('expert/edit', [
			'expert' => $expert
		]);
	}

	public function update ()
	{
		$data['name'] = $_POST['name'];
		$data['place'] = $_POST['place'];
		$data['content'] = $_POST['content'];
		$data['time'] = ! empty($_POST['time']) ? strtotime($_POST['time']) : time();
		$oldimg = Db::table('expert')->field('image')->where('id', $_POST['id'])->find();
		// 判断是否有新图片上传
		$size = $_FILES['image']['size'];
		if($size == '0')
		{
			$result = Db::table('expert')->where('id', $_POST['id'])->update($data);
			if($result)
			{
				// 添加管理员日志
				admin_log($content = '修改专家-' . $_POST['name']);
				$this->success('修改成功', '/admin/expert/edit?id=' . $_POST['id']);
			}
			else
			{
				$this->error('修改失败', '/admin/expert/edit?id=' . $_POST['id']);
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
				$this->error('图片类型上传不正确，允许上传的图片类型：png,jpg,jpeg,gif', '/admin/expert/edit?id=' . $_POST['id']);
			}
			$name = time() . rand(1, 9999) . "." . $type;
			$path = $_SERVER['DOCUMENT_ROOT'] . '/image/admin/expert/';
			$res = move_uploaded_file($file, $path . $name) ? 'ok' : 'false';
			if($res == 'ok')
			{
				$img = '/admin/expert/' . $name;
				$data['image'] = $img;
				$result = Db::table('expert')->where('id', $_POST['id'])->update($data);
				if($result)
				{
					// 删掉原图
					$oldimg = $_SERVER['DOCUMENT_ROOT'] . '/image' . $oldimg['image'];
					unlink($oldimg);
					// 添加管理员日志
					admin_log($content = '修改专家-' . $_POST['name']);
					$this->success('修改成功', '/admin/expert/edit?id=' . $_POST['id']);
				}
				else
				{
					$this->error('修改失败', '/admin/expert/edit?id=' . $_POST['id']);
				}
			}
			else
			{
				$this->error('文件上传失败', '/admin/expert/edit?id=' . $_POST['id']);
			}
		}
	}
}
