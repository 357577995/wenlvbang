<?php
namespace app\mobile\controller;

use think\Controller;
// 判断是否登录
use app\index\controller\Base;
use think\Request;
use think\Db;
use think\Session;

class Register extends Controller
{

	/**
	 * 注册成为项目方/服务商
	 * $type=1项目方 2服务商
	 */
	public function index (Request $request)
	{
		return $this->fetch('register/index');
	}

	public function register (Request $request)
	{
		if($request->post('sms_code') != Session::get('mobile_code'))
		{
		echo '验证码不正确';
		}
		
		$data['mobile'] = $request->post('mobile');
		$data['username'] = $request->post('user_name');
		if (!isset($data['username'])){
			$data['username']=$data['mobile'];
		}
		$data['password'] = $request->post('password');
		$data['type'] = $request->post('type');
		Db::table('users')->insert($data);
		return $this->success("注册成功", "/mobile/index");
	}

	public function sendsms (Request $request)
	{
		if($request->post())
		{
			$code = $request->post('send_code');
			if(! captcha_check($code))
			{
				echo '验证码不正确';
			}
			else
			{
				// 短信接口地址
				$target = "http://106.ihuyi.cn/webservice/sms.php?method=Submit";
				// 获取手机号
				$mobile = $request->post('mobile');
				// 生成的随机数
				$mobile_code = static::random(4, 1);
				
				// 请将此APIID与APIKEY替换为正确的参数 参数地址 : http://user.ihuyi.com/nav/sms.html
				// 用户名是登录用户中心->验证码通知短信->产品总览->APIID
				// 查看密码请登录用户中心->验证码通知短信->产品总览->APIKEY
				$post_data = "account=C06246881&password=58c2be076f0fe7d19d94aa9c86d4628e&mobile=" . $mobile . "&content=" . rawurlencode("您的验证码是：" . $mobile_code . "。请不要把验证码泄露给其他人。");
				
				$gets = static::xml_to_array(static::Post($post_data, $target));
				if($gets['SubmitResult']['code'] == 2)
				{
					// $_SESSION['mobile'] = $mobile;
					Session::set('mobile_code', $mobile);
					Session::set('mobile_code', $mobile_code);
					// $_SESSION['mobile_code'] = $mobile_code;
				}
				echo $gets['SubmitResult']['msg'];
			}
		}
	}

	public function random ($length = 6, $numeric = 0)
	{
		PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
		if($numeric)
		{
			$hash = sprintf('%0' . $length . 'd', mt_rand(0, pow(10, $length) - 1));
		}
		else
		{
			$hash = '';
			$chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789abcdefghjkmnpqrstuvwxyz';
			$max = strlen($chars) - 1;
			for($i = 0; $i < $length; $i ++)
			{
				$hash .= $chars[mt_rand(0, $max)];
			}
		}
		return $hash;
	}

	public function xml_to_array ($xml)
	{
		$reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
		if(preg_match_all($reg, $xml, $matches))
		{
			$count = count($matches[0]);
			for($i = 0; $i < $count; $i ++)
			{
				$subxml = $matches[2][$i];
				$key = $matches[1][$i];
				if(preg_match($reg, $subxml))
				{
					$arr[$key] = static::xml_to_array($subxml);
				}
				else
				{
					$arr[$key] = $subxml;
				}
			}
		}
		return $arr;
	}

	public function Post ($curlPost, $url)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_NOBODY, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
		$return_str = curl_exec($curl);
		curl_close($curl);
		return $return_str;
	}
}
