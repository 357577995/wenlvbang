<?php
namespace app\mobile\controller;

use think\Controller;
// // 判断是否登录
// use app\index\controller\Base;
use think\Request;
use think\Session;
use think\Db;

class Cart extends Controller
{

	/**
	 * 加入购物车
	 */
	public function add (Request $request)
	{
		session_start();
		// 1.判断是否已登录
		if(Session::has('project_id'))
		{
			// 没有登录购物车内容先存入session
			$plan_id = $request->get('plan_id');
			$plan = Db::table('plan')->field('id,name')->where('id', $plan_id)->find();
			$_SESSION['plan'][] = $plan;
			$this->success('加入方案库成功', '/index/cart/index');
		}
		else
		{
			$this->redirect('/project/login/index');
			// 判断该用户是否是项目方
			$user = Db::table('users')->field('type')->where('id', $_SESSION['think']['user_id'])->find();
			if(! empty($user) && $user['type'] == '1')
			{
				$plan_id = $request->get('plan_id');
				$plan = Db::table('plan')->field('name')->where('id', $plan_id)->find();
				// 已经加入购物车的方案不能重复添加
				$cart = Db::table('cart')->where('plan_id', $plan_id)->where('user_id', $_SESSION['think']['user_id'])->find();
				if(! empty($cart))
				{
					$this->error('该方案已经加入购物车，请勿重复添加');
				}
				else
				{
					$data['plan_name'] = $plan['name'];
					$data['plan_id'] = $plan_id;
					$data['user_id'] = $_SESSION['think']['user_id'];
					$data['addtime'] = time();
					$res = Db::table('cart')->insert($data);
					if($res)
					{
						$this->success('加入方案库成功', '/index/cart/index');
					}
					else
					{
						$this->error('加入方案库失败');
					}
				}
			}
			elseif(! empty($user) && $user['type'] == '2')
			{
				$this->error('对不起，您这是服务商账号，请换成项目方账号再尝试下单');
			}
			else
			{
				$this->error('对不起，请您先认证成为项目方', '/index/user/ident');
			}
		}
	}

	/**
	 * 购物车列表
	 */
	public function index ()
	{
		
		// 1.判断是否已登录
		if(! Session::has('user_id'))
		{
			
			if(! empty($_SESSION['plan']))
			{
				$cart = $_SESSION['plan'];
				foreach($cart as $k => $vo)
				{
					$plan = Db::table('plan')->where('id', $vo['id'])->find();
					$cate = DB::table('cate')->field('name')->where('id', $plan['cate_id'])->find();
					$parent_cate = DB::table('cate')->field('name')->where('id', $plan['parent_cate_id'])->find();
					
					$cart[$k]['image'] = $plan['image'];
					$cart[$k]['cate_name'] = $cate['name'];
					$cart[$k]['parent_cate_name'] = $parent_cate['name'];
					$cart[$k]['plan_name'] = $vo['name'];
				}
				$this->assign('type', 1);
			}
			else
			{
				$cart = [];
				$this->assign('type', 2);
			}
			
			$this->assign('cart', $cart);
			$this->assign('count', count($cart));
			return $this->fetch('cart/list');
		}
		else
		{
			// 判断该用户是否是项目方
			$user = Db::table('users')->field('type')->where('id', $_SESSION['think']['user_id'])->find();
			if(! empty($user) && $user['type'] == '1')
			{
				$user_id = $_SESSION['think']['user_id'];
				$cart = Db::table('cart')->where('user_id', $user_id)->select();
				if(! empty($cart))
				{
					foreach($cart as $k => $vo)
					{
						$plan = Db::table('plan')->field('image')->where('id', $vo['plan_id'])->find();
						$cart[$k]['image'] = $plan['image'];
					}
					$this->assign('type', 1);
				}
				else
				{
					$this->assign('type', 2);
				}
				$this->assign('cart', $cart);
				return $this->fetch('cart/list');
			}
			elseif(! empty($user) && $user['type'] == '2')
			{
				$this->error('对不起，您这是服务商账号，没有方案库功能');
			}
			else
			{
				$this->error('对不起，请您先认证成为项目方', '/index/user/ident');
			}
		}
	}

	/**
	 * 删除购物车
	 */
	public function del (Request $request)
	{
		// 1.判断是否已登录
		if(! Session::has('user_id'))
		{
			
			$id = $request->get('id');
			foreach($_SESSION['plan'] as $k => $vo)
			{
				if($vo['id'] == $id)
				{
					// 清除掉这条session
					unset($_SESSION['plan'][$k]);
				}
			}
			
			$this->success('删除成功', '/index/cart/index');
		}
		else
		{
			$id = $request->get('id');
			$res = Db::table('cart')->where('id', $id)->delete();
			if($res)
			{
				$this->success('删除成功', '/index/cart/index');
			}
			else
			{
				$this->error('删除失败');
			}
		}
	}

	public function batchdel (Request $request)
	{
// 		$ids = $_POST['id'];
// 		foreach($ids as $key => $id)
// 		{
// 			foreach($_SESSION['plan'] as $k => $vo)
// 			{
// 				if($vo['id'] == $id)
// 				{
// 					// 清除掉这条session
// 					unset($_SESSION['plan'][$k]);
// 				}
// 			}
// 		}
		$result['code']=0;
		$result['message']='删除成功';
		return $result;
	}
}
