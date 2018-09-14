<?php
namespace app\admin\controller;
// 判断是否登录
use app\admin\controller\Base;
use think\Db;
use think\Request;

// 类继承自公共的类
class Seo extends Base
{

	protected function _initialize ()
	{
		parent::_initialize();
	}

	public function index (Request $request)
	{
		$is_list = $request->get('is_list');
		$where = 'type = 7 and is_list =0';
		$model = Db::table('seo')->where($where)->find();
		$this->assign('model', empty($model) ? [
			'title' => '', 
			'keywords' => '', 
			'description' => ''
		] : $model);
		$this->assign('is_list', $is_list);
		return $this->fetch('seo/index_seo');
	}

	public function listseo (Request $request)
	{
		$is_list = $request->get('is_list');
		$where = 'type = 8 and is_list =0';
		$model = Db::table('seo')->where($where)->find();
		$this->assign('model', empty($model) ? [
			'title' => '', 
			'keywords' => '', 
			'description' => ''
		] : $model);
		$this->assign('is_list', $is_list);
		
		return $this->fetch('seo/list_seo');
	}

	public function dakashuoseo (Request $request)
	{
		$where = 'type = 1 and is_list =1';
		$model = Db::table('seo')->where($where)->find();
		$this->assign('model', empty($model) ? [
			'title' => '', 
			'keywords' => '', 
			'description' => ''
		] : $model);
		$this->assign('is_list', 1);
		$this->assign('type', 1);
		return $this->fetch('seo/seo');
	}

	public function expertseo (Request $request)
	{
		$where = 'type = 2 and is_list =1';
		$model = Db::table('seo')->where($where)->find();
		$this->assign('model', empty($model) ? [
			'title' => '', 
			'keywords' => '', 
			'description' => ''
		] : $model);
		$this->assign('is_list', 1);
		$this->assign('type', 2);
		return $this->fetch('seo/seo');
	}

	public function researchseo (Request $request)
	{
		$where = 'type = 3 and is_list =1';
		$model = Db::table('seo')->where($where)->find();
		$this->assign('model', empty($model) ? [
			'title' => '', 
			'keywords' => '', 
			'description' => ''
		] : $model);
		$this->assign('is_list', 1);
		$this->assign('type', 3);
		return $this->fetch('seo/seo');
	}

	public function activityeo (Request $request)
	{
		$where = 'type = 4 and is_list =1';
		$model = Db::table('seo')->where($where)->find();
		$this->assign('model', empty($model) ? [
			'title' => '', 
			'keywords' => '', 
			'description' => ''
		] : $model);
		$this->assign('is_list', 1);
		$this->assign('type', 4);
		return $this->fetch('seo/seo');
	}

	public function meetingseo (Request $request)
	{
		$where = 'type = 5 and is_list =1';
		$model = Db::table('seo')->where($where)->find();
		$this->assign('model', empty($model) ? [
			'title' => '', 
			'keywords' => '', 
			'description' => ''
		] : $model);
		$this->assign('is_list', 1);
		$this->assign('type', 5);
		return $this->fetch('seo/seo');
	}

	public function investmentseo (Request $request)
	{
		$where = 'type = 6 and is_list =1';
		$model = Db::table('seo')->where($where)->find();
		$this->assign('model', empty($model) ? [
			'title' => '', 
			'keywords' => '', 
			'description' => ''
		] : $model);
		$this->assign('is_list', 1);
		$this->assign('type', 6);
		return $this->fetch('seo/seo');
	}

	public function seoinsert ()
	{
		$data['title'] = $_POST['title'];
		$data['keywords'] = $_POST['keywords'];
		$data['description'] = $_POST['description'];
		$data['is_list'] = $_POST['is_list'];
		$data['type'] = $_POST['type'];
		$where = 'type = ' . $_POST['type'] . ' and is_list =' . $_POST['is_list'];
		$res = Db::table('seo')->where($where)->delete();
		$result = Db::name('seo')->insert($data);
		
		if($result)
		{
			// 添加管理员日志
			$this->success('添加成功', '/admin/seo/index');
		}
		else
		{
			$this->error('添加失败', '/admin/seo/index');
		}
	}
}
