<?php
namespace app\mobile\controller;

use think\Controller;
use think\Db;
use think\Request;

class Search extends Controller
{

	/**
	 * 搜索结果
	 *
	 * @param Request $request        	
	 * @return mixed|string
	 */
	public function index (Request $request)
	{
		$name = $request->get('kws');
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
		if($name)
		{
			$where['name'] = $name;
		}
		
		$plan = Db::table('plan')->where($where)->select();
		$this->assign('plan', $plan);
		$this->assign('cate', $cate);
		$seo = Db::table('seo')->where('type = 8 and is_list=0')->find();
		$title = empty($seo['title'])?'资讯':$seo['title'];
		$keywords = empty($seo['keywords'])?'资讯':$seo['keywords'];
		$description = empty($seo['description'])?'资讯':$seo['description'];
		$this->assign('title', $title);
		$this->assign('keywords', $keywords);
		$this->assign('description', $description);
		return $this->fetch('search/list');
	}

	/**
	 * 详情页
	 *
	 * @param Request $request        	
	 */
	public function info (Request $request)
	{
		$id = $request->get('id');
		if(empty($id))
		{
			$this->error('参数错误！');
		}
		$project = Db::table('project')->where('id', $id)->find();
		$this->assign('project', $project);
		return $this->fetch('project/info');
	}
}
