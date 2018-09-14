<?php
namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Session;
use think\Db;

class Index extends Controller
{

	public function index ()
	{
		$cate = Db::table('cate')->where('parent_id', '=', 0)->select();
		$cate1 = Db::table('cate')->where('parent_id', '>', 0)->limit(0, 2)->select();
		$cate2 = Db::table('cate')->where('parent_id', '>', 0)->limit(2, 2)->select();
		$cate3 = Db::table('cate')->where('parent_id', '>', 0)->limit(4, 2)->select();
		
		foreach($cate1 as &$item)
		{
			
			$item['plan'] = Db::table('plan')->where('cate_id', $item['id'])->limit(8)->select();
		}
		foreach($cate2 as &$item)
		{
			
			$item['plan'] = Db::table('plan')->where('cate_id', $item['id'])->limit(8)->select();
		}
		foreach($cate3 as &$item)
		{
			
			$item['plan'] = Db::table('plan')->where('cate_id', $item['id'])->limit(8)->select();
		}
		foreach($cate as &$item)
		{
			
			$item['next_cate'] = Db::table('cate')->where('parent_id', $item['id'])->select();
		}
		// 投融信息
		$investment = Db::table('investment')->limit(2)->select();
		//大咖
		
		$daka = Db::table('dakashuo')->alias('n')
		->join('dakashuo_cate c', 'c.id = n.cate_id')
		->field('n.*,c.name')
		->limit(0, 3)
		->select();
		
		
		
		$this->assign('daka', $daka);
		
		$plan1 =  Db::table('plan')->limit(0,8)->select();
		$plan2 =  Db::table('plan')->limit(8,8)->select();
		$plan3 =  Db::table('plan')->limit(16,8)->select();
		$plan4 =  Db::table('plan')->limit(24,8)->select();
		$plan5 =  Db::table('plan')->limit(32,8)->select();
		$plan6 =  Db::table('plan')->limit(48,8)->select();
		$this->assign('plan1', $plan1);
		$this->assign('plan2', $plan2);
		$this->assign('plan3', $plan3);
		$this->assign('plan4', $plan4);
		$this->assign('plan5', $plan5);
		$this->assign('plan6', $plan6);
		$this->assign('cate', $cate);
		$this->assign('cate1', $cate1);
		$this->assign('cate2', $cate2);
		$this->assign('cate3', $cate3);
		$this->assign('investment', $investment);
		//$recommend = Db::table('recommend')->limit(0,2)->select();
		$recommend = Db::table('recommend')->select();
		$this->assign('recommend', $recommend);
		return $this->fetch('index/index');
	}
	// 文旅活动报名
	public function activity (Request $request)
	{
		$id = $request->get('id');
		$activity = Db::table('message')->where('id', $id)->find();
		// 表单内容
		$question = Db::table('form_question')->where('activity_id', $id)->select();
		foreach($question as $k => $vo)
		{
			$question[$k]['option'] = Db::table('form_option')->where('activity_id', $id)->where('question_id', $vo['id'])->select();
			if($vo['type'] == '0')
			{
				$dan = 'yes';
			}
			if($vo['type'] == '1')
			{
				$fu = 'yes';
			}
			if($vo['type'] == '2')
			{
				$wen = 'yes';
			}
		}
		if(! isset($dan))
		{
			$dan = '';
		}
		if(! isset($fu))
		{
			$fu = '';
		}
		if(! isset($wen))
		{
			$wen = '';
		}
		
		// 表单是否显示
		$show = $activity['form_show'];
		$this->assign('dan', $dan);
		$this->assign('fu', $fu);
		$this->assign('wen', $wen);
		$this->assign('show', $show);
		$this->assign('activity_id', $id);
		$this->assign('question', $question);
		$this->assign('activity', $activity);
		return $this->fetch('index/activity');
	}

	public function activity_form (Request $request)
	{
		$activity_id = $request->post('activity_id');
		$username = $request->post('username');
		$mobile = $request->post('mobile');
		if(! empty($activity_id) || $activity_id != '0')
		{
			// 验证手机号是否已存在
			$list = Db::table('form_user')->where('mobile', $mobile)->where('activity_id', $activity_id)->find();
			if(! empty($list))
			{
				$this->error('该手机号已经使用，请更换！', '/index/index/activity?id=' . $activity_id);
			}
			else
			{
				// 添加form_user表
				$userdata = array(
					'username' => $username, 
					'mobile' => $mobile, 
					'activity_id' => $activity_id, 
					'time' => time()
				);
				$res = Db::table('form_user')->insert($userdata);
				if($res)
				{
					$uid = Db::name('form_user')->getLastInsID();
					// 添加form_user_info表
					foreach($_POST['question'] as $key => $value)
					{
						if($key == '0')
						{
							// 单选
							foreach($value as $val)
							{
								$arr = explode('-*-', $val);
								$k = $arr[0];
								$qidres = Db::table('form_option')->field('question_id')->where('id', $k)->find();
								$question_id = $qidres['question_id'];
								$data = array(
									'question_id' => $question_id, 
									'option_id' => $k, 
									'type' => '0', 
									'activity_id' => $activity_id, 
									'uid' => $uid
								);
								$res = Db::table('form_user_info')->insert($data);
							}
						}
						elseif($key == '1')
						{
							// 复选
							foreach($value as $k => $val)
							{
								$question_id = $k;
								foreach($val as $kk => $vv)
								{
									$data = array(
										'question_id' => $question_id, 
										'option_id' => $kk, 
										'type' => '1', 
										'activity_id' => $activity_id, 
										'uid' => $uid
									);
									$res = Db::table('form_user_info')->insert($data);
								}
							}
						}
						elseif($key == '2')
						{
							// 文本
							foreach($value as $k => $val)
							{
								$data = array(
									'question_id' => $k, 
									'option_id' => $val, 
									'type' => '2', 
									'activity_id' => $activity_id, 
									'uid' => $uid
								);
								$res = Db::table('form_user_info')->insert($data);
							}
						}
					}
					Session::set('form_username', $username);
					Session::set('form_mobile', $mobile);
					$this->success('报名成功', '/index/index/activity?id=' . $activity_id);
				}
				else
				{
					$this->error('报名失败', '/index/index/activity?id=' . $activity_id);
				}
			}
		}
		else
		{
			$this->error('报名失败', '/index/index/activity?id=' . $activity_id);
		}
	}
}
