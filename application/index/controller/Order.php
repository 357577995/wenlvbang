<?php
namespace app\index\controller;
use think\Controller;
// 判断是否登录
use app\index\controller\Base;

use think\Request;
use think\Session;
use think\Db;


class Order extends Base
{
	
    /**
    * 购物车选中修改状态
    */
    public function update(Request $request)
    {
        //判断该用户是否是项目方
        $user = Db::table('users')->field('type,status')->where('id',$_SESSION['think']['project_id'])->find();
        if(!empty($user) && $user['type'] == '1'){
            if($user['status']!='2'){
                $this->error('对不起，你的项目方身份还未审核通过');
            }else{
                //修改之前-把方案库所有数据恢复初始状态
                Db::table('cart')->where('user_id',$_SESSION['think']['project_id'])->where('status',2)->update(['status'=>1]);

                foreach($_POST['cart_id'] as $k=>$vo){
                    $data['status'] = 2;
                    Db::table('cart')->where('id',$vo)->update($data);
                }
//                 $result['code']=0;
//                 $result['message']='创建订单成功';
//                 return $result;

                $data['title'] = $request->post('title');
                $data['resume'] = $request->post('resume');
                //订单号
                $data['order_sn'] = date('YmdHi',time()).rand(1,99999);
                $data['project_user_id'] = $_SESSION['think']['project_id'];
                $data['status'] = 1;
                $data['addtime'] = time();
                //生成订单
                $res = Db::table('order')->insert($data);
                $order_id = Db::name('order')->getLastInsID();
                if($res){
                	//生成订单详情
                	$cart = Db::table('cart')->where('user_id',$_SESSION['think']['project_id'])->where('status',2)->select();
                	foreach($cart as $k=>$vo){
                		$dd['plan_id'] = $vo['plan_id'];
                		$dd['plan_name'] = $vo['plan_name'];
                		$dd['order_id'] = $order_id;
                		Db::table('order_detail')->insert($dd);
                	}
                	//清空购物车
                	Db::table('cart')->where('user_id',$_SESSION['think']['project_id'])->where('status',2)->delete();
                		
                	$result['code']=0;
                	$result['message']='创建订单成功';
                	return $result;
                	// $this->success('创建订单成功','/index/index/index');
                }else{
                	$result['code']=1;
                	$result['message']='创建订单失败';
                	return $result;
                	// $this->error('创建订单失败');
                }
                
//                 $this->redirect('/index/order/confirm');
            }
            
        }elseif(!empty($user) && $user['type']=='2'){
            $this->error('对不起，您这是服务商账号，请换成项目方账号再尝试下单');
        }else{
            $this->error('对不起，请您先认证成为项目方再下单','/index/user/ident');
        }
    }
    /**
    * 加载创建订单页面
    */
    public function create(){
    	
        $cart = Db::table('cart')->where('user_id',$_SESSION['think']['project_id'])->where('status',2)->select();
        foreach($cart as $k=>$vo){
            $plan = Db::table('plan')->field('image')->where('id',$vo['plan_id'])->find();
            $cart[$k]['image'] = $plan['image'];
        }  
        $this->assign('cart',$cart);
        return $this->fetch('order/create');
    }
    /**
    * 创建订单操作
    */
    public function confirm(Request $request){
        $data['title'] = $request->post('title');
        $data['resume'] = $request->post('resume');
        //订单号
        $data['order_sn'] = date('YmdHi',time()).rand(1,99999);
        $data['project_user_id'] = $_SESSION['think']['project_id'];
        $data['status'] = 1;
        $data['addtime'] = time();
        //生成订单
        $res = Db::table('order')->insert($data);
        $order_id = Db::name('order')->getLastInsID();
        if($res){
            //生成订单详情
            $cart = Db::table('cart')->where('user_id',$_SESSION['think']['project_id'])->where('status',2)->select();
            foreach($cart as $k=>$vo){
                $dd['plan_id'] = $vo['plan_id'];
                $dd['plan_name'] = $vo['plan_name'];
                $dd['order_id'] = $order_id;
                Db::table('order_detail')->insert($dd);
            }
            //清空购物车
            Db::table('cart')->where('user_id',$_SESSION['think']['project_id'])->where('status',2)->delete();
			
            $result['code']=0;
            $result['message']='创建订单成功';
            return $result;
           // $this->success('创建订单成功','/index/index/index');
        }else{
        	$result['code']=1;
        	$result['message']='创建订单失败';
        	return $result;
           // $this->error('创建订单失败');
        }
    }
    /**
    * 查看订单页面
    */
    public function index(){
        echo '订单页面';
    }
}
