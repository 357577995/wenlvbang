<?php
namespace app\mobile\controller;

use think\Controller;
use think\Db;
use think\Request;

class Investment extends Controller
{

	/**
	 * 列表页
	 *
	 * @param Request $request        	
	 * @return mixed|string
	 */
	public function index (Request $request)
	{
		$more = $request->get('more');
		$cate_id = $request->get('cate_id');
		
		$where = empty($cate_id) ? [] : [
			'cate_id' => $cate_id
		];
		$investment = Db::table('investment')->where($where)->order('sort asc')->limit(0, 5)->select();
		
		if(empty($more))
		{
			$investment = array_slice($investment, 0, 5);
		}
		$recommend_1 = Db::table('investment')->where('recommend', 1)->order('sort asc')->limit(1)->find();
		$recommend_2 = Db::table('investment')->where('recommend', 1)->order('sort asc')->limit(1)->find();
		$recommend = Db::table('investment')->where('recommend', 1)->order('sort asc')->limit(2, 2)->select();
		$this->assign('cate_id', $cate_id);
		$this->assign('recommend1', $recommend_1);
		$this->assign('recommend2', $recommend_2);
		$this->assign('recommend', $recommend);
		$this->assign('investment', $investment);
		$this->assign('limit', 1);
		$investment_cate = Db::table('investment_cate')->select();
		$this->assign('m_investment_cate', $investment_cate);
		$seo = Db::table('seo')->where('type = 6 and is_list=1')->find();
		$title = empty($seo['title']) ? '投融项目' : $seo['title'];
		$keywords = empty($seo['keywords']) ? '投融项目' : $seo['keywords'];
		$description = empty($seo['description']) ? '投融项目' : $seo['description'];
		$this->assign('title', $title);
		$this->assign('keywords', $keywords);
		$this->assign('description', $description);
		return $this->fetch('investment/list');
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
		$investment = Db::table('investment')->where('id', $id)->find();
		$this->assign('investment', $investment);
		$this->assign('title', $investment['seo_title']);
		$this->assign('keywords', $investment['seo_keywords']);
		$this->assign('description', $investment['seo_description']);
		return $this->fetch('investment/info');
	}

	/**
	 * 显示更多
	 *
	 * @param Request $request        	
	 */
	public function more (Request $request)
	{
		$limit = $request->get('limit');
		$limit = ($limit * 16);
		$cate_id = $request->get('cate_id');
		
		$where = empty($cate_id) ? [] : [
			'cate_id' => $cate_id
		];
		$news = Db::table('investment')->where($where)->order('sort asc')->limit($limit, 16)->select();
		if(empty($news))
		{
			$res['code'] = 0;
		}
		else
		{
			$res['code'] = 1;
		}
		$res['data'] = '';
		
		foreach($news as $vo)
		{
			$res['data'] .= '<li>';
			$res['data'] .= '<a title="" href="/index/activity/info.html?id=' . $vo['id'] . '">';
			$res['data'] .= '<h2>';
			$res['data'] .= '<b>' . $vo['name'] . '</b>';
			$res['data'] .= '</h2>';
			$res['data'] .= '<p>';
			$res['data'] .= '<span>' . $vo['fu_title'] . '</span>';
			$res['data'] .= '</p>';
			$res['data'] .= '<p>';
			$res['data'] .= '<b>项目介绍</b>';
			$res['data'] .= $vo['content'];
			$res['data'] .= '</p>';
			$res['data'] .= '<p class="lr">';
			$res['data'] .= '<b>' . date('Y-m-d', $vo['time']) . '</b>';
			$res['data'] .= '</p>';
			$res['data'] .= '</a>';
			$res['data'] .= '</li>';
		}
		
		return $res;
	}
}
