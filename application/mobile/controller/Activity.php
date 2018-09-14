<?php
namespace app\mobile\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Activity extends Controller
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
		$activity = Db::table('activity')->where($where)->limit(0, 5)->select();
		
		foreach($activity as &$item)
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
		$this->assign('m_activity', $activity);
		$this->assign('cate_id', $cate_id);
		$this->assign('limit', 1);
		$activity_cate = Db::table('activity_cate')->select();
		$this->assign('m_activity_cate', $activity_cate);
		
		$seo = Db::table('seo')->where('type = 4 and is_list=1')->find();
		$title = empty($seo['title']) ? '文旅活动' : $seo['title'];
		$keywords = empty($seo['keywords']) ? '文旅活动' : $seo['keywords'];
		$description = empty($seo['description']) ? '文旅活动' : $seo['description'];
		$this->assign('title', $title);
		$this->assign('keywords', $keywords);
		$this->assign('description', $description);
		return $this->fetch('activity/list');
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
		$project = Db::table('activity')->where('id', $id)->find();
		$this->assign('project', $project);
		
		$cate_info = DB::table('activity_cate')->where('id', $project['cate_id'])->find();
		$tab_ids = Db::table('tab_map')->where('activity_id', $id)->column('tab_id');
		$tab = Db::table('tab')->where('id', 'in', $tab_ids)->select();
		
		$next = Db::table('activity')->where('id', '>', $id)->find();
		$last = Db::table('activity')->where('id', '<', $id)->order('id desc')->find();
		if($tab_ids)
		{
			$recomme_ids = Db::table('tab_map')->where('activity_id', 'neq', $id)->where('tab_id','in', $tab_ids)->limit(3)->column('activity_id');
			$recomme = Db::table('activity')->where('id', 'in', $recomme_ids)->select();
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
		$this->assign('tab', $tab);
		$this->assign('cate_info', $cate_info);
		$this->assign('next', $next);
		$this->assign('last', $last);
		$this->assign('recomme', $recomme);
		$activity_cate = Db::table('activity_cate')->select();
		$this->assign('m_activity_cate', $activity_cate);
		$this->assign('title', $project['seo_title']);
		$this->assign('keywords', $project['seo_keywords']);
		$this->assign('description', $project['seo_description']);
		return $this->fetch('activity/info');
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
		$news = Db::table('activity')->where($where)->limit($limit, 16)->select();
		
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
			$res['data'] .= '<a href="/index/activity/info.html?id=' . $vo['id'] . '" title="">';
			$res['data'] .= '<img src="' . '/image' . $vo['image'] . '" alt="">';
			$res['data'] .= '</div>';
			$res['data'] .= '<span>' . $vo['status_message'] . '</span>';
			$res['data'] .= '</div>';
			$res['data'] .= '<p>' . $vo['title'] . '</p>';
			$res['data'] .= '</a>';
			$res['data'] .= '</li>';
		}
		
		return $res;
	}

	public function sub (Request $request)
	{
		$data['user_name'] = $_POST['user_name'];
		$data['mobile'] = $_POST['mobile'];
		$data['activity_id'] = $_POST['activity_id'];
		
		$data['user_id'] = Session::get('user_id');
		$result = Db::name('activity_order')->insert($data);
		if($result)
		{
			$this->success('添加成功', '/mobile/activity/index');
		}
		else
		{
			$this->error('添加失败', '/mobile/activity/index');
		}
	}
}
