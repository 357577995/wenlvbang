<?php
namespace app\mobile\controller;

use think\Controller;
use think\Db;
use think\Request;

class Category extends Controller
{

	public function index ()
	{
		$cate = Db::table('cate')->where('parent_id', '=', 0)->select();
		foreach($cate as &$item)
		{
			$item['c_cate'] = Db::table('cate')->where('parent_id', '=', $item['id'])->select();
		}
		$this->assign('cate', $cate);
		return $this->fetch('category/index');
	}

	public function catlist (Request $request)
	{
		$cate_id = $request->get('id');
		$pid = $request->get('pid');
		if(isset($pid))
		{
			$plan = Db::table('plan')->where('parent_cate_id', $pid)->select();
		}
		else
		{
			$plan = Db::table('plan')->where('cate_id', $cate_id)->select();
			$pid_temp = Db::table('cate')->field('parent_id')->where('id', $cate_id)->find();
			$pid =$pid_temp['parent_id'];
		}
		
		$cate = Db::table('cate')->where('parent_id', '=', 0)->select();
		
		foreach($cate as &$item)
		{
			if(isset($pid) && $pid == $item['id'])
			{
				$item['selected'] = 1;
			}
			else
			{
				$item['selected'] = 0;
			}
			$item['c_cate'] = Db::table('cate')->where('parent_id', '=', $item['id'])->select();
			foreach($item['c_cate'] as &$citem)
			{
				if($citem['id'] == $cate_id)
				{
					$citem['selected'] = 1;
				}
				else
				{
					$citem['selected'] = 0;
				}
			}
		}
		
		$this->assign('plan', $plan);
		$this->assign('cate', $cate);
		return $this->fetch('category/list');
	}

	public function info (Request $request)
	{
		$id = $request->get('id');
		
		$plan = Db::table('plan')->where('id', $id)->find();
		$cate = Db::table('cate')->where('parent_id', '=', 0)->select();
		foreach($cate as &$item)
		{
			$item['c_cate'] = Db::table('cate')->where('parent_id', '=', $item['id'])->select();
		}
		
		$next = Db::table('plan')->where('id', '>', $id)->find();
		$last = Db::table('plan')->where('id', '<', $id)->order('id desc')->find();
		if(empty($next))
		{
			$next['id'] = $id;
			$next['title'] = '没有了';
		}
		if(empty($last))
		{
			$last['id'] = $id;
			$last['title'] = '没有了';
		}
		$this->assign('cate', $cate);
		$this->assign('plan', $plan);
		$this->assign('next', $next);
		$this->assign('last', $last);
		
		return $this->fetch('category/info');
	}
}
