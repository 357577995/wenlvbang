<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;

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
		$type = $request->get('type');
		
		$where = empty($type) ? [] : [
			'cate_id' => $type
		];
		$news = Db::table('news')->alias('n')
			->join('new_cate c', 'c.id = n.cate_id')
			->field('n.*,c.name')
			->where($where)
			->order('n.sort asc')
			->limit(0, 4)
			->select();
		
		$recommend_1 = Db::table('news')->where('recommend', 1)->order('sort asc')->limit(1)->find();
		$recommend_2 = Db::table('news')->where('recommend', 1)->order('sort asc')->limit(1)->find();
		$recommend = Db::table('news')->alias('n')
			->join('new_cate c', 'c.id = n.cate_id')
			->where('n.recommend', 1)
			->order('n.sort asc')
			->limit(2, 2)
			->select();
		
		$this->assign('news', $news);
		$this->assign('cate_id', $type);
		$this->assign('recommend1', $recommend_1);
		$this->assign('recommend2', $recommend_2);
		$this->assign('recommend', $recommend);
		$this->assign('limit', 1);
		$this->assign('cate_id', $type);
		
		$seo = Db::table('seo')->where('type = 0 and is_list=1')->find();
		$title = empty($seo['title'])?'资讯':$seo['title'];
		$keywords = empty($seo['keywords'])?'资讯':$seo['keywords'];
		$description = empty($seo['description'])?'资讯':$seo['description'];
		$this->assign('title', $title);
		$this->assign('keywords', $keywords);
		$this->assign('description', $description);
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
		$limit = ($limit * 6) - (6 - 4);
		$where = empty($cate_id) ? [] : [
			'cate_id' => $cate_id
		];
		$news = Db::table('news')->alias('n')
			->join('new_cate c', 'c.id = n.cate_id')
			->field('n.*,c.name')
			->where($where)
			->order('sort asc')
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
			$res['data'] .= '<div>';
			$res['data'] .= '<a title="" href="/index/news/info.html?id=' . $vo['id'] . '">';
			$res['data'] .= '<img src="' . '/image' . $vo['image'] . '" alt="" height="160" width="225">';
			$res['data'] .= '</a>';
			$res['data'] .= '</div>';
			$res['data'] .= '<div>';
			$res['data'] .= '<a title="" href="/index/news/info.html?id=' . $vo['id'] . '">' . $vo['title'] . '</a>';
			$res['data'] .= '<p>' . $vo['abstract'] . '</p>';
			$res['data'] .= '<p>';
			$res['data'] .= '<a>' . $vo['name'] . '</a>';
			$res['data'] .= '<a>' . $vo['author'] . '</a>';
			$res['data'] .= '<span>' . date('Y-m-d', $vo['time']) . '</span>';
			$res['data'] .= '</p>';
			$res['data'] .= '</div>';
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
			$recomme_ids = Db::table('tab_map')->where('activity_id', 'neq', $id)->where('tab_id','in', $tab_ids)->limit(3)->column('activity_id');
			$recomme = Db::table('news')->where('id', 'in', $recomme_ids)->select();
		}
		else
		{
			$recomme = [];
		}
		if(empty($next)){
			$next['id']=$id;
			$next['title']='没有了';
		}
		if(empty($last)){
			$last['id']=$id;
			$last['title']='没有了';
		}
		$this->assign('news', $news);
		$this->assign('tab', $tab);
		$this->assign('cate_info', $cate_info);
		$this->assign('next', $next);
		$this->assign('last', $last);
		$this->assign('recomme', $recomme);
		$this->assign('user_id', $cate_info['id']==1?Session::get('user_id'):1);
		
	
		$this->assign('title', $news['seo_title']);
		$this->assign('keywords', $news['seo_keywords']);
		$this->assign('description', $news['seo_description']);
		return $this->fetch('news/info');
	}
}
