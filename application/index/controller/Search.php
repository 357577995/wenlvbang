<?php
namespace app\index\controller;

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
		$f_id = $request->get('f_id');
		$s_id = $request->get('s_id');
		$s_cate = [];
		$where = [];
		if($name)
		{
			// $where['name'] = $name;
			$where['name'] = array(
				'like', 
				'%' . $name . '%'
			);
		}
		if($f_id)
		{
			$where['parent_cate_id'] = $f_id;
		}
		if($s_id)
		{
			$where['cate_id'] = $s_id;
		}
		
		$plan = Db::table('plan')->where($where)->limit(0, 16)->select();
		
		$f_cate = Db::table('cate')->where('parent_id', 0)->select();
		
		// $url = $request->path();
		$base_url = "?kws=" . $name;
		foreach($f_cate as &$item)
		{
			$item['url'] = $base_url . '&f_id=' . $item['id'];
			if($item['id'] == $f_id)
			{
				$item['selected'] = 1;
			}
			else
			{
				$item['selected'] = 0;
			}
			/*
			 * $s_cate = Db::table('cate')->where('parent_id', $item['id'])->select();
			 *
			 * foreach($s_cate as &$value)
			 * {
			 * $value['url'] = $url . '&s_id=' . $item['id'];
			 * if($value['id'] == $s_id)
			 * {
			 * $value['selected'] = 1;
			 * }
			 * else
			 * {
			 * $value['selected'] = 0;
			 * }
			 * }
			 */
		}
		if($f_id)
		{
			$s_cate = Db::table('cate')->where('parent_id', $f_id)->select();
			$url = $base_url . '&f_id=' . $f_id;
			foreach($s_cate as &$value)
			{
				$value['url'] = $base_url . '&s_id=' . $value['id'];
				if($value['id'] == $s_id)
				{
					$value['selected'] = 1;
				}
				else
				{
					$value['selected'] = 0;
				}
			}
			if(empty($s_id))
			{
				array_unshift($s_cate, [
					'name' => '全部', 
					'parent_id' => 0, 
					'selected' => 1, 
					'url' => $url
				]);
			}
			else
			{
				array_unshift($s_cate, [
					'name' => '全部', 
					'parent_id' => 0, 
					'selected' => 0, 
					'url' => $base_url
				]);
			}
		}
		
		if(empty($f_id))
		{
			array_unshift($f_cate, [
				'name' => '全部', 
				'parent_id' => 0, 
				'selected' => 1, 
				'url' => $base_url
			]);
		}
		else
		{
			array_unshift($f_cate, [
				'name' => '全部', 
				'parent_id' => 0, 
				'selected' => 0, 
				'url' => $base_url
			]);
		}
		
		$this->assign('plan', $plan);
		$this->assign('f_cate', $f_cate);
		$this->assign('s_cate', $s_cate);
		$this->assign('f_id', $f_id);
		$this->assign('s_id', $s_id);
		$this->assign('limit', 16);
		$this->assign('kws', $name);
		
		
		$seo = Db::table('seo')->where('type = 8 and is_list=0')->find();
		$title = empty($seo['title'])?'资讯':$seo['title'];
		$keywords = empty($seo['keywords'])?'资讯':$seo['keywords'];
		$description = empty($seo['description'])?'资讯':$seo['description'];
		$this->assign('title', $title);
		$this->assign('keywords', $keywords);
		$this->assign('description', $description);
		
		return $this->fetch('search/index');
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

	/**
	 * 显示更多
	 *
	 * @param Request $request        	
	 */
	public function more (Request $request)
	{
		$limit = $request->get('limit');
		$name = $request->get('kws');
		$f_id = $request->get('f_id');
		$s_id = $request->get('s_id');
		$s_cate = [];
		$where = [];
		if($name)
		{
			// $where['name'] = $name;
			$where['name'] = array(
				'like', 
				'%' . $name . '%'
			);
		}
		if($f_id)
		{
			$where['parent_cate_id'] = $f_id;
		}
		if($s_id)
		{
			$where['cate_id'] = $s_id;
		}
		
		$plan = Db::table('plan')->where($where)->limit($limit, 16)->select();
		
		if(empty($plan))
		{
			$res['code'] = 0;
		}
		else
		{
			$res['code'] = 1;
		}
		$res['data'] = '';
		foreach($plan as $vo)
		{
			
			$res['data'] .= '<li>';
			$res['data'] .= '<div class="pro_pic">';
			$res['data'] .= '<a href="" title="">';
			$res['data'] .= '<img src="' . '/image' . $vo['image'] . '" alt="" >';
			$res['data'] .= '</a>';
			$res['data'] .= '</div>';
			$res['data'] .= '<div class="pro_c">';
			$res['data'] .= '<a title="" href=""><h2>' . $vo['name'] . '</h2></a>';
			$res['data'] .= '<div>' . $vo['content'] . '</div>';
			$res['data'] .= '</div>';
			$res['data'] .= '<div class="pro_pic">';
			$res['data'] .= '<span>';
			$res['data'] .= '<img src="' . '/image' . '/index/ico_1.png" alt="收藏"> 收藏</span><span>';
			// $res['data'] .= '<a href="'/index/cart/add?plan_id=".$vo['id']."'"'>';
			$res['data'] .= '<a title="" href="/index/cart/add?plan_id=' . $vo['id'] . '">';
			$res['data'] .= '<img src="' . '/image' . '/index/ico_2.png" alt="加入购物车">';
			$res['data'] .= '</a></span></div></li>';
		}
		
		return $res;
	}
}
