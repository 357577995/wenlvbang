<?php
namespace app\mobile\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use org\wechat\JSSDK;
use think\Config;

class News extends Controller
{

	/**
	 * 列表页
	 *
	 * @param Request $request        	
	 * @return mixed|string
	 */
	public function index (Request $request)
	{
		$type = $request->get('cate_id');
		
		$where = empty($type) ? [] : [
			'cate_id' => $type
		];
		$news = Db::table('news')->alias('n')
			->join('new_cate c', 'c.id = n.cate_id')
			->field('n.*,c.name')
			->where($where)
			->order('n.time desc')
			->limit(0, 16)
			->select();
		
		$recommend_1 = Db::table('news')->where('recommend', 1)->order('sort asc')->limit(1)->find();
		$recommend_2 = Db::table('news')->where('recommend', 1)->order('sort asc')->limit(1)->find();
		$recommend = Db::table('news')->alias('n')
			->join('new_cate c', 'c.id = n.cate_id')
			->where('n.recommend', 1)
			->order('n.time desc')
			->limit(2, 2)
			->select();
		
		$this->assign('news', $news);
		$this->assign('cate_id', $type);
		$this->assign('recommend1', $recommend_1);
		$this->assign('recommend2', $recommend_2);
		$this->assign('recommend', $recommend);
		$this->assign('limit', 1);
		$new_cate = Db::table('new_cate')->select();
		$this->assign('m_new_cate', $new_cate);
		$seo = Db::table('seo')->where('type = 0 and is_list=1')->find();
		$title = empty($seo['title']) ? '资讯' : $seo['title'];
		$keywords = empty($seo['keywords']) ? '资讯' : $seo['keywords'];
		$description = empty($seo['description']) ? '资讯' : $seo['description'];
		$this->assign('title', $title);
		$this->assign('keywords', $keywords);
		$this->assign('description', $description);
		$image = $news[0]['image'];
		$imgUrl = 'http://' . $_SERVER['HTTP_HOST'] . $image;
		$this->assign('imgUrl', $imgUrl);
		return $this->fetch('news/list');
	}

	/**
	 * 显示更多
	 *
	 * @param Request $request        	
	 */
	public function more (Request $request)
	{
		$limit = $request->get('limit');
		$cate_id = $request->get('cate_id');
		$limit = ($limit * 16);
		$where = empty($cate_id) ? [] : [
			'cate_id' => $cate_id
		];
		$news = Db::table('news')->alias('n')
			->join('new_cate c', 'c.id = n.cate_id')
			->field('n.*,c.name')
			->where($where)
			->order('n.time desc')
			->limit($limit, 6)
			->select();
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
			$res['data'] .= '<a title="" href="/index/news/info.html?id=' . $vo['id'] . '">';
			$res['data'] .= '<div>';
			$res['data'] .= '<h3>' . $vo['title'] . '</h3>';
			$res['data'] .= '<p>';
			$res['data'] .= '<span>' . $vo['name'] . '</span>';
			$res['data'] .= '<span>' . date('Y-m-d', $vo['time']) . '</span>';
			$res['data'] .= '</p>';
			$res['data'] .= '</div>';
			$res['data'] .= '<img src="' . '/image' . $vo['image'] . '">';
			$res['data'] .= '</a>';
			$res['data'] .= '</li>';
		}
		
		return $res;
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
		$news = Db::table('news')->where('id', $id)->find();
		$cate_info = DB::table('new_cate')->where('id', $news['cate_id'])->find();
		$tab_ids = Db::table('tab_map')->where('activity_id', $id)->column('tab_id');
		$tab = Db::table('tab')->where('id', 'in', $tab_ids)->select();
		
		$next = Db::table('news')->where('id', '>', $id)->find();
		$last = Db::table('news')->where('id', '<', $id)->order('id desc')->find();
		if($tab_ids)
		{
			$recomme_ids = Db::table('tab_map')->where('activity_id', 'neq', $id)->where('tab_id', 'in', $tab_ids)->limit(3)->column('activity_id');
			$recomme = Db::table('news')->where('id', 'in', $recomme_ids)->select();
		}
		else
		{
			$recomme = [];
		}
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
		
		$image = self::cut('src="', '" title', $news['content']);
		$imgUrl = 'http://' . $_SERVER['HTTP_HOST'] . $image;
		$this->assign('imgUrl', $imgUrl);
		$this->assign('news', $news);
		$this->assign('tab', $tab);
		$this->assign('cate_info', $cate_info);
		$this->assign('next', $next);
		$this->assign('last', $last);
		$this->assign('recomme', $recomme);
		$this->assign('user_id', $cate_info['id'] == 1 ? Session::get('user_id') : 1);
		$new_cate = Db::table('new_cate')->select();
		$this->assign('m_new_cate', $new_cate);
		$this->assign('title', $news['seo_title']);
		$this->assign('keywords', $news['seo_keywords']);
		$this->assign('description', $news['seo_description']);
		
		return $this->fetch('news/info');
	}

	public function getweixin (Request $request)
	{
		$url = $request->get('url');
		$jssdkObj = new \org\wechat\Jssdk("wxfeeee548bd3b12f9", "69f286e1b26561970a21e6d8f5836ff2", $url);
		$data = $jssdkObj->getSignPackage();
		
		return [
			'code' => 0, 
			'data' => $data
		];
	}

	function cut ($begin, $end, $str)
	{
		$b = mb_strpos($str, $begin) + mb_strlen($begin);
		$e = mb_strpos($str, $end) - $b;
		return mb_substr($str, $b, $e);
	}
}
