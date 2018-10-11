<?php
namespace app\mobile\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Dakashuo extends Controller
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
		$dakashuo = Db::table('dakashuo')->alias('d')
			->join('dakashuo_cate c', 'c.id = d.cate_id')
			->field('d.*,c.name')
			->where($where)
			->select();
		
		$this->assign('dakashuo', $dakashuo);
		$this->assign('cate_id', $cate_id);
		$this->assign('limit', 1);
		$dakashuo_cate = Db::table('dakashuo_cate')->select();
		$this->assign('m_dakashuo_cate', $dakashuo_cate);
		$seo = Db::table('seo')->where('type = 1 and is_list=1')->find();
		$title = empty($seo['title']) ? '大咖说' : $seo['title'];
		$keywords = empty($seo['keywords']) ? '大咖说' : $seo['keywords'];
		$description = empty($seo['description']) ? '大咖说' : $seo['description'];
		$this->assign('title', $title);
		$this->assign('keywords', $keywords);
		$this->assign('description', $description);
		
		$image = $dakashuo[0]['image'];
		$imgUrl = 'http://' . $_SERVER['HTTP_HOST'] . $image;
		$this->assign('imgUrl', $imgUrl);
		
		return $this->fetch('dakashuo/list');
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
		$result = Db::table('dakashuo')->where($where)->limit($limit, 16)->select();
		if(empty($result))
		{
			$res['code'] = 0;
		}
		else
		{
			$res['code'] = 1;
		}
		$res['data'] = '';
		foreach($result as $vo)
		{
			$res['data'] .= '<li>';
			$res['data'] .= '<a href="/index/dakashuo/info.html?id=' . $vo['id'] . '" title="">';
			$res['data'] .= '<img src="' . '/image' . $vo['image'] . '" alt="">';
			$res['data'] .= '<p>' . $vo['title'] . '</p>';
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
		$dakashuo = Db::table('dakashuo')->where('id', $id)->find();
		$cate_info = DB::table('dakashuo_cate')->where('id', $dakashuo['cate_id'])->find();
		$this->assign('cate_info', $cate_info);
		$this->assign('dakashuo', $dakashuo);
		$this->assign('user_id', Session::get('user_id'));
		
		$tab_ids = Db::table('tab_map')->where('activity_id', $id)->column('tab_id');
		$tab = Db::table('tab')->where('id', 'in', $tab_ids)->select();
		
		$next = Db::table('dakashuo')->where('id', '>', $id)->find();
		$last = Db::table('dakashuo')->where('id', '<', $id)->order('id desc')->find();
		if($tab_ids)
		{
			$recomme_ids = Db::table('tab_map')->where('activity_id', 'neq', $id)->where('tab_id', $tab_ids[0])->limit(3)->column('activity_id');
			$recomme = Db::table('dakashuo')->where('id', 'in', $recomme_ids)->select();
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
		$this->assign('next', $next);
		$this->assign('last', $last);
		$this->assign('recomme', $recomme);
		$dakashuo_cate = Db::table('dakashuo_cate')->select();
		$this->assign('m_dakashuo_cate', $dakashuo_cate);
		$this->assign('title', $dakashuo['seo_title']);
		$this->assign('keywords', $dakashuo['seo_keywords']);
		$this->assign('description', $dakashuo['seo_description']);
		$image = self::cut('src="', '" title', $dakashuo['content']);
		$imgUrl = 'http://' . $_SERVER['HTTP_HOST'] . $image;
		$this->assign('imgUrl', $imgUrl);
		return $this->fetch('dakashuo/info');
	}

	function cut ($begin, $end, $str)
	{
		$b = mb_strpos($str, $begin) + mb_strlen($begin);
		$e = mb_strpos($str, $end) - $b;
		return mb_substr($str, $b, $e);
	}
}
