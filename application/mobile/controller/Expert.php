<?php
namespace app\mobile\controller;

use think\Controller;
use think\Db;
use think\Request;

class Expert extends Controller
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
		
		$expert = Db::table('expert')->select();
		
		if(empty($more))
		{
			$expert = array_slice($expert, 0, 5);
		}
		$this->assign('expert', $expert);
		$this->assign('limit', 1);
		$image = $expert[0]['image'];
		$imgUrl = 'http://' . $_SERVER['HTTP_HOST'] . $image;
		$this->assign('imgUrl', $imgUrl);
		return $this->fetch('expert/list');
	}

	/**
	 * 显示更多
	 *
	 * @param Request $request        	
	 */
	public function more (Request $request)
	{
		$limit = $request->get('limit');
		$limit = ($limit * 6) - (6 - 4);
		// $news = Db::table('expert')->limit($limit, 6)->select();
		$news = Db::table('expert')->limit(5, 6)->select();
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
			$res['data'] .= '<a title="" href=" " style="display:block; width:140px; height:140px;background:url(/image' . $vo['image'] . ') no-repeat top center;border-radius: 50%;overflow: hidden; ">';
			$res['data'] .= '</a>';
			$res['data'] .= '</div>';
			$res['data'] .= '<div>';
			$res['data'] .= '<a title="" href=" ">' . $vo['name'] . '</a>';
			$res['data'] .= '<span>' . $vo['place'] . '</span>';
			$res['data'] .= '<p>' . $vo['content'] . '</p>';
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
		$expert = Db::table('expert')->where('id', $id)->find();
		$this->assign('expert', $expert);
		$image = self::cut('src="', '" title', $expert['content']);
		$imgUrl = 'http://' . $_SERVER['HTTP_HOST'] . $image;
		$this->assign('imgUrl', $imgUrl);
		return $this->fetch('expert/info');
	}

	/**
	 * 专家入驻
	 */
	public function insert ()
	{
		$data['name'] = $_POST['name'];
		$data['mobile'] = $_POST['mobile'];
		$data['place'] = $_POST['place'];
		$data['content'] = $_POST['content'];
		$data['time'] = ! empty($_POST['time']) ? strtotime($_POST['time']) : time();
		// 判断是否有新图片上传
		// $size = $_FILES['image']['size'];
		// if($size == '0')
		// {
		// // $this->error('资讯图片未上传','/admin/recommend/add');
		// $this->error('请上传图片', '/index/expert/index');
		// }
		// else
		// {
		// $file = $_FILES["image"]["tmp_name"]; // 获取的上传的临时文件
		// $type = substr(strrchr($_FILES["image"]["name"], '.'), 1);
		// $filetype = [
		// 'jpg',
		// 'jpeg',
		// 'gif',
		// 'png'
		// ];
		// if(! in_array($type, $filetype))
		// {
		// $this->error('图片类型上传不正确，允许上传的图片类型：png,jpg,jpeg,gif', '/admin/recommend/add');
		// }
		// $name = time() . rand(1, 9999) . "." . $type;
		// $path = $_SERVER['DOCUMENT_ROOT'] . '/image/imdex/expert/';
		// $res = move_uploaded_file($file, $path . $name) ? 'ok' : 'false';
		// if($res == 'ok')
		// {
		// $img = '/imdex/expert/' . $name;
		// $data['image'] = $img;
		$result = Db::name('settled_expert')->insert($data);
		if($result)
		{
			// 添加管理员日志
			$this->success('申请成功', '/index/expert/index');
		}
		else
		{
			$this->error('添加失败', '/index/expert/index');
		}
		// }
		// else
		// {
		// $this->error('文件上传失败', '/index/expert/add');
		// }
		// }
	}
	function cut ($begin, $end, $str)
	{
		$b = mb_strpos($str, $begin) + mb_strlen($begin);
		$e = mb_strpos($str, $end) - $b;
		return mb_substr($str, $b, $e);
	}
}
