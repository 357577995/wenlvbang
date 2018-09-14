<?php
namespace app\mobile\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Login extends Controller
{

	/**
	 * 登录页面
	 *
	 * @return \think\Response
	 */
	public function index ()
	{
		// 读取icon
		$config = Db::table('config')->where('id', 1)->find();
		$this->assign('config', $config);
		return $this->fetch('login/index');
	}

	/**
	 * 登陆验证
	 *
	 * @return \think\Response
	 */
	public function login (Request $request)
	{
		// 接收验证码来判断
		if($request->post())
		{
			$data['username'] = $_POST['username'];
			$data['password'] = md5($_POST['password']);
			$data['type'] = 1;
			// 获取用户数据信息
			$user = Db::table('users')->field('id,username,type')->where($data)->find();
			if(! empty($user))
			{
				// 设置user_id
				Session::set('user_id', $user['id']);
				Session::set('user_username', $user['username']);
				// 把session中存储的购物车信息存到数据库中-清除session
				if(isset($_SESSION['plan']))
				{
					// 判断该用户是否是项目方
					if($user['type'] == '1')
					{
						foreach($_SESSION['plan'] as $k => $plan)
						{
							$plan_id = $plan['id'];
							$plan_name = $plan['name'];
							// 已经加入购物车的方案不能重复添加
							$cart = Db::table('cart')->where('plan_id', $plan_id)->where('user_id', $user['id'])->find();
							if(empty($cart))
							{
								$dd['plan_name'] = $plan_name;
								$dd['plan_id'] = $plan_id;
								$dd['user_id'] = $user['id'];
								$dd['addtime'] = time();
								
								Db::table('cart')->insert($dd);
							}
						}
						// 使用完了清除session
						unset($_SESSION['plan']);
					}
				}
				
				$this->success('登录成功', 'mobile/index/index');
			}
			else
			{
				$this->error('用户名或密码错误');
			}
		}
	}

	/**
	 * 退出登录
	 */
	public function logout ()
	{
		Session::delete('user_id');
		Session::delete('user_username');
		Session::delete('plan');
		$this->success('退出成功', 'mobile/index/index');
	}

	public function check (Request $request)
	{
		$type = $request->post('type');
		$user_id = Session::get('user_id');
		
		// 未登录 跳转登陆页面
		if(empty($user_id))
		{
			$result['code'] = 1;
			$result['url'] = '/mobile/login/index';
			return $result;
		}
		$user = Db::table('users')->where('id', $user_id)->find();
		// 已登陆 判断是否是普通用户
		if(! empty($user_id) && $user['type'] == 0)
		{
			$result['code'] = 0;
			return $result;
		} //
		if($type == $user['type'])
		{
			
			if($type == 1)
			{
				$url = '/project/login/';
			}
			else
			{
				$url = '/service/login/';
			}
			$result['code'] = 1;
			$result['url'] = $url;
			return $result;
		}
		else
		{
			// if($type == 1)
			// {
			// $msg = '服务商不能登陆项目方平台！';
			// }
			// else
			// {
			// $msg = '项目方不能登陆服务商平台！';
			// }
			$result['msg'] = '无权访问！';
			return $result;
		}
		//
	}

	public function change (Request $request)
	{
		$type = $request->post('select');
		$user_id = Session::get('user_id');
		$data['type'] = $type;
		$res = Db::table('users')->where('id', $user_id)->update($data);
		if($res)
		{
			$result['code'] = 1;
			if($type == 1)
			{
				$url = '/project/login/';
			}
			else
			{
				$url = '/service/login/';
			}
			$result['url'] = $url;
			return $result;
		}
	}

	public function sms ()
	{
		return $this->fetch('login/sms');
	}

	public function smslogin (Request $request)
	{
		// 接收验证码来判断
		if($request->post())
		{
			
			if($request->post('sms_code') != Session::get('mobile_code'))
			{
				echo '验证码错误';
				return false;
			}
			$data['mobile'] = $_POST['mobile'];
			// 获取用户数据信息
			$user = Db::table('users')->field('id,username,type')->where($data)->find();
			if(! empty($user))
			{
				// 设置user_id
				Session::set('user_id', $user['id']);
				Session::set('user_username', $user['username']);
				// 把session中存储的购物车信息存到数据库中-清除session
				if(isset($_SESSION['plan']))
				{
					// 判断该用户是否是项目方
					if($user['type'] == '1')
					{
						foreach($_SESSION['plan'] as $k => $plan)
						{
							$plan_id = $plan['id'];
							$plan_name = $plan['name'];
							// 已经加入购物车的方案不能重复添加
							$cart = Db::table('cart')->where('plan_id', $plan_id)->where('user_id', $user['id'])->find();
							if(empty($cart))
							{
								$dd['plan_name'] = $plan_name;
								$dd['plan_id'] = $plan_id;
								$dd['user_id'] = $user['id'];
								$dd['addtime'] = time();
								
								Db::table('cart')->insert($dd);
							}
						}
						// 使用完了清除session
						unset($_SESSION['plan']);
					}
				}
				
				$this->success('登录成功', 'mobile/index/index');
			}
			else
			{
				$this->error('用户不存在','mobile/register/index');
			}
		}
	}
}
