<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;

class Project extends Controller
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
		
		$project = Db::table('project')->alias('p')
			->join('project_cate c', 'c.id = p.cate_id')
			//->where('p.status', 2)
			->where($where)
			->select();
		
		$this->assign('project', $project);
		$this->assign('cate_id', $cate_id);
		$this->assign('limit', 1);
		return $this->fetch('project/list');
	}

	/**
	 * 显示更多
	 *
	 * @param Request $request        	
	 */
	public function more (Request $request)
	{
		$limit = $request->get('limit');
		$limit = (3+1)+($limit-1)*6 ;//6为更多加载记录数，10为初始记录数，limit是加载次数
		$cate_id = $request->get('cate_id');
		$where = empty($cate_id) ? [] : [
			'cate_id' => $cate_id
		];
		$news = Db::table('project')->where($where)->limit($limit, 6)->select();
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
			$res['data'] .= '<div class="pro_pic">';
			$res['data'] .= '<a href="/index/project/info.html?id=' . $vo['id'] . '" title="">';
			$res['data'] .= '<img src="/image/index/bangkongjian1.png" alt="">';
			$res['data'] .= '</a>';
			$res['data'] .= '</div>';
			$res['data'] .= '<div class="pro_c">';
			$res['data'] .= '<a href="/index/project/info.html?id=' . $vo['id'] . '" title="">';
			$res['data'] .= '<h2>' . $vo['title'] . '</h2>';
			$res['data'] .= '</a>';
			$res['data'] .= '<div>' . $vo['fu_title'] . '</div>';
			$res['data'] .= '</div>';
			$res['data'] .= '<div class="pro_ico">';
			$res['data'] .= '<span>' . $vo['name'] . '</span>';
			$res['data'] .= '<span>';
			$res['data'] .= '<img src="/image/index/ico_3.png" alt="收藏">';
			$res['data'] .= $vo['name'];
			$res['data'] .= '</span>';
			$res['data'] .= '<span>' . date('Y-m-d', $vo['time']) . '</span>';
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
		$project = Db::table('project')->where('id', $id)->find();
		$cate_info = DB::table('project_cate')->where('id', $project['cate_id'])->find();
		$this->assign('cate_info', $cate_info);
		$this->assign('project', $project);
		return $this->fetch('project/info');
	}
}
