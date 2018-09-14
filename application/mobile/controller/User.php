<?php
namespace app\mobile\controller;

use think\Controller;
// 判断是否登录
use think\Session;
use think\Db;
use think\Request;

class User extends Controller
{

	public function index ()
	{
		if(! Session::has('user_id'))
		{
			$this->redirect('mobile/login/index');
		}
		
		$user = Db::table('users')->where('id', Session::get('user_id'))->find();
		$this->assign('user', $user);
		return $this->fetch('user/index');
	}

	public function set (Request $request)
	{
		if($request->get('edit'))
		{
			return $this->fetch('user/edit');
		}
		else
		{
			return $this->fetch('user/set');
		}
	}

	public function setPassword (Request $request)
	{
		$data['password'] = md5($request->get('password'));
		
		$result = Db::table('users')->where('id', Session::get('user_id'))->update($data);
		if($result)
		{
			$this->success('修改成功', '/mobile/user/index');
		}
		else
		{
			$this->error('修改失败', '/mobile/user/edit');
		}
	}

	public function collect ()
	{
		$cate = Db::table('cate')->where('parent_id', '=', 0)->select();
		foreach($cate as &$item)
		{
			$item['c_cate'] = Db::table('cate')->where('parent_id', '=', $item['id'])->select();
		}
		$this->assign('cate', $cate);
		
		$plan_ids = Db::table('collect')->where('project_user_id', Session::get('user_id'))->column('plan_id');
		$plans = Db::table('plan')->where('id', 'in', $plan_ids)->select();
		$this->assign('plans', $plans);
		return $this->fetch('user/collect');
	}
}
