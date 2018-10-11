<?php
namespace app\mobile\controller;

use think\Controller;
use think\Db;
use think\Request;

class Meeting extends Controller
{

	/**
	 * 文旅活动
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
		$message = Db::table('meeting')->alias('a')
			->join('activity_cate c', 'c.id = a.cate_id')
			->field('a.*,c.name')
			->where($where)
			->limit(0, 5)
			->select();
		foreach($message as &$item)
		{
			$date = date("Y-m-d");
			if($item['start_time'] > $date)
			{
				$item['status'] = 0;
				$item['status_message'] = '未开始';
			}
			elseif($item['end_time'] < $date)
			{
				$item['status'] = 2;
				$item['status_message'] = '已结束';
			}
			else
			{
				$item['status'] = 1;
				$item['status_message'] = '进行中';
			}
		}
		$this->assign('message', $message);
		$this->assign('cate_id', $cate_id);
		$this->assign('limit', 1);
		
		$seo = Db::table('seo')->where('type = 5 and is_list=10')->find();
		$title = empty($seo['title'])?'文旅峰会':$seo['title'];
		$keywords = empty($seo['keywords'])?'文旅峰会':$seo['keywords'];
		$description = empty($seo['description'])?'文旅峰会':$seo['description'];
		$this->assign('title', $title);
		$this->assign('keywords', $keywords);
		$this->assign('description', $description);
		
		$image = $message[0]['image'];
		$imgUrl = 'http://' . $_SERVER['HTTP_HOST'] . $image;
		$this->assign('imgUrl', $imgUrl);
		return $this->fetch('meeting/meeting_list');
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
		$project = Db::table('meeting')->where('id', $id)->find();
		$this->assign('project', $project);
		
		$cate_info = DB::table('activity_cate')->where('id', $project['cate_id'])->find();
		$tab_ids = Db::table('tab_map')->where('activity_id', $id)->column('tab_id');
		$tab = Db::table('tab')->where('id', 'in', $tab_ids)->select();
		
		$next = Db::table('activity')->where('id', '>', $id)->find();
		$last = Db::table('activity')->where('id', '<', $id)->order('id desc')->find();
		if($tab_ids)
		{
			$recomme_ids = Db::table('tab_map')->where('activity_id', 'neq', $id)->where('tab_id','in', $tab_ids)->limit(3)->column('activity_id');
			$recomme = Db::table('meeting')->where('id', 'in', $recomme_ids)->select();
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
		$this->assign('tab', $tab);
		$this->assign('cate_info', $cate_info);
		$this->assign('next', $next);
		$this->assign('last', $last);
		$this->assign('recomme', $recomme);
		
		$this->assign('title', $project['seo_title']);
		$this->assign('keywords', $project['seo_keywords']);
		$this->assign('description', $project['seo_description']);
		
		$image = self::cut('src="', '" title', $project['content']);
		$imgUrl = 'http://' . $_SERVER['HTTP_HOST'] . $image;
		$this->assign('imgUrl', $imgUrl);
		return $this->fetch('meeting/info');
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
		$news = Db::table('meeting')->where($where)->limit($limit, 16)->select();
		if(empty($news))
		{
			$res['code'] = 0;
		}
		else
		{
			$res['code'] = 1;
		}
		$res['data'] = '';
		foreach($news as &$item)
		{
			$date = date("Y-m-d");
			if($item['start_time'] > $date)
			{
				$item['status'] = 0;
				$item['status_message'] = '未开始';
			}
			elseif($item['end_time'] < $date)
			{
				$item['status'] = 2;
				$item['status_message'] = '已结束';
			}
			else
			{
				$item['status'] = 1;
				$item['status_message'] = '进行中';
			}
		}
		foreach($news as $vo)
		{
			$res['data'] .= '<li>';
			$res['data'] .= '<div class="pro_pic">';
			$res['data'] .= '<a href="/index/activity/info.html?id=' . $vo['id'] . '" title="">';
			$res['data'] .= '<img src="' . '/image' . $vo['image'] . '" alt="">';
			$res['data'] .= '</a>';
			$res['data'] .= '<span>2018.夏</span>';
			$res['data'] .= '</div>';
			$res['data'] .= '	<div class="pro_c">';
			$res['data'] .= '<a href="/index/activity/info.html?id=' . $vo['id'] . '" title="">';
			$res['data'] .= '<h2>' . $vo['title'] . '</h2>';
			if($vo['status'] == 2)
			{
				$res['data'] .= '<span class="js">';
			}
			else
			{
				$res['data'] .= '<span>';
			}
			
			$res['data'] .= $vo['status_message'];
			$res['data'] .= '</span>';
			$res['data'] .= '</a>';
			$res['data'] .= '<div>' . $vo['content'] . '</div>';
			$res['data'] .= '</div>';
			$res['data'] .= '	<div class="pro_ico">';
			$res['data'] .= '<a href="/index/activity/info.html?id=' . $vo['id'] . '" title="">更多&gt;&gt;</a>';
			$res['data'] .= '</div>';
			$res['data'] .= '</li>';
		}
		
		return $res;
	}
	function cut ($begin, $end, $str)
	{
		$b = mb_strpos($str, $begin) + mb_strlen($begin);
		$e = mb_strpos($str, $end) - $b;
		return mb_substr($str, $b, $e);
	}
	
}
