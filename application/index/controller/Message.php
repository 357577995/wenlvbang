<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;

class Message extends Controller
{


	/**
	 * 文旅峰会
	 *
	 * @param Request $request        	
	 * @return mixed|string
	 */
	public function meeting (Request $request)
	{
		$more = $request->get('more');
		
		$cate_id = $request->get('cate_id');
		
		if($cate_id)
		{
			$message = Db::table('meeting')->alias('m')->join('meeting_cate c', 'c.id = m.cate_id')->where('c.id', $cate_id)->select();
		}
		else
		{
			$message = Db::table('meeting')->select();
		}
		
		if(empty($more))
		{
			$message = array_slice($message, 0, 5);
		}
		
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
		return $this->fetch('message/meeting_list');
	}

	/**
	 * 详情页
	 *
	 * @param Request $request        	
	 */
	public function meetinginfo (Request $request)
	{
		$id = $request->get('id');
		if(empty($id))
		{
			$this->error('参数错误！');
		}
		$project = Db::table('meeting')->where('id', $id)->find();
		$this->assign('project', $project);
		return $this->fetch('message/meetinginfo');
	}
}
