<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Research extends Controller
{

	/**
	 * 文旅研究
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
		$message = Db::table('research')->alias('r')
			->join('research_cate c', 'c.id = r.cate_id')
			->where($where)
			->limit(0, 5)
			->select();
		$user_id = Session::get('user_id');
		$this->assign('message', $message);
		$this->assign('cate_id', $cate_id);
		$this->assign('limit', 1);
		$this->assign('user_id', $user_id);
		
		// if($cate_id == 1)
		// {
		$tpl = 'research/zhikan_list';
		// }
		// else
		// {
		// $tpl = 'research/research_list';
		// }
		$seo = Db::table('seo')->where('type = 3 and is_list=1')->find();
		$title = empty($seo['title']) ? '文旅研究' : $seo['title'];
		$keywords = empty($seo['keywords']) ? '文旅研究' : $seo['keywords'];
		$description = empty($seo['description']) ? '文旅研究' : $seo['description'];
		$this->assign('title', $title);
		$this->assign('keywords', $keywords);
		$this->assign('description', $description);
		return $this->fetch($tpl);
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
		$seo = Db::table('seo')->where('type = 3 and is_list=0')->find();
		$title = empty($seo['title'])?'文旅研究':$seo['title'];
		$keywords = empty($seo['keywords'])?'文旅研究':$seo['keywords'];
		$description = empty($seo['description'])?'文旅研究':$seo['description'];
		$this->assign('title', $title);
		$this->assign('keywords', $keywords);
		$this->assign('description', $description);
		return $this->fetch('research/info');
	}

	/**
	 * 显示更多
	 *
	 * @param Request $request        	
	 */
	public function more (Request $request)
	{
		$limit = $request->get('limit');
		$limit = ($limit * 6) - (6 - 5);
		$cate_id = $request->get('cate_id');
		
		$where = empty($cate_id) ? [] : [
			'cate_id' => $cate_id
		];
		$news = Db::table('research')->where($where)->limit($limit, 6)->select();
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
			$res['data'] .= '<a href="/index/research/info.html?id=' . $vo['id'] . '" title="">';
			$res['data'] .= '<img src="' . '/image' . $vo['image'] . '" alt="" height="195" width="135">';
			$res['data'] .= '</a>';
			$res['data'] .= '</div>';
			$res['data'] .= '<div>';
			$res['data'] .= '<a href="/index/research/info.html?id=' . $vo['id'] . '" title="">' . $vo['title'] . '</a>';
			$res['data'] .= '<p>' . $vo['content'] . '</p>';
			$res['data'] .= '</div><div>';
			$res['data'] .= '<p>';
			$res['data'] .= '<a href="/index/research/info.html?id=' . $vo['id'] . '" title="">查看详情</a>';
			$res['data'] .= '</p>';
			$res['data'] .= '</div>';
			$res['data'] .= '</li>';
		}
		
		return $res;
	}
}
