<?php
namespace app\admin\controller;
// 判断是否登录
use app\admin\controller\Base;
use think\Db;
use think\Request;

// 类继承自公共的类
class Order extends Base
{
	protected function _initialize()
    {
        parent::_initialize();
    }

    /**
    * 方案订单
    */
    public function index(Request $request)
    {
        //检查权限
        admin_role('order_list');

        $where = '';
        //订单编号搜索
        $order_sn = "'%".$request->param('order_sn')."%'";
        $where .= 'order_sn like '.$order_sn;
        //标题搜索
        $title = "'%".$request->param('title')."%'";
        if(!empty($title)){
            $where .= ' and title like '.$title;
        }
        //公司名称搜索
        if(!empty($request->param('company_name'))){
            $user = Db::table('users')->field('id')->where("company_name like "."'%".$request->param('company_name')."%'")->where('type','1')->find();
            if(!empty($user)){
                $project_user_id = $user['id'];
                $where .= ' and project_user_id = '.$project_user_id;
            }else{
                $where .= ' and project_user_id = 0';
            }
        }
        //状态搜索
        $status = $request->param('status');
        if(!empty($status)){
            $where .= ' and status = '.$status;
        }
        //添加时间搜索
        if( !empty($request->param('addtime1')) && !empty($request->param('addtime2')) ){
            $addtime1 = strtotime($request->param('addtime1'));
            $addtime2 = strtotime($request->param('addtime2')) + 86399;//截止到当天的23:59:59
            $where .= ' and addtime > '.$addtime1.' and addtime < '.$addtime2;
            $this->assign('addtime1',$addtime1);
            $this->assign('addtime2',$addtime2);
        }

        $list = Db::table('order')->where($where)->paginate(5,false,['query'=>request()->param()]);
        $page = $list->render();
        $order = [];
        foreach($list as $k=>$vo){
            $order[] = $vo;
            $project_user = Db::table('users')->field('username,company_name')->where('id',$vo['project_user_id'])->find();
            $order[$k]['username'] = $project_user['username'];
            $order[$k]['company_name'] = $project_user['company_name'];
            $order[$k]['addtime'] = date('Y-m-d H:i:s',$vo['addtime']);
            if($vo['dotime'] == ''){
                $order[$k]['dotime'] = '';
            }else{
                $order[$k]['dotime'] = date('Y-m-d H:i:s',$vo['dotime']);
            }
        }
        //总个数
        $total = Db::table('order')->where($where)->field('COUNT(*) as total')->select();
        $this->assign('total',$total[0]['total']);

    	return $this->fetch('order/index',['page'=>$page,'order'=>$order]);
    }
    /**
    * 设为已查看
    */
    public function pass(){
        //检查权限
        admin_role('order_do');

        $id = $_GET['id'];
        $data['status'] = 2;
        $data['dotime'] = time();
        $order = Db::table('order')->where('id',$id)->find();
        $result = Db::table('order')->where('id',$id)->update($data);
        if($result){
            //添加管理员日志
            admin_log($content = '方案订单设为已查看-'.$order['order_sn']);
            $this->success('设置成功','/admin/order/detail?id='.$id);
        }else{
            $this->error('设置失败');
        }
    }
    /**
    * 设为未查看
    */
    public function refuse(){
        //检查权限
        admin_role('order_do');

        $id = $_GET['id'];
        $data['status'] = 1;
        $data['dotime'] = time();
        $result = Db::table('order')->where('id',$id)->update($data);
        if($result){
            //添加管理员日志
            admin_log($content = '方案订单设为未查看-'.$order['order_sn']);
            $this->success('设置成功','/admin/order/detail?id='.$id);
        }else{
            $this->error('设置失败');
        }
    }
    /**
    * 删除订单
    */
    public function del(){
        //检查权限
        admin_role('order_del');

        $id = $_GET['id'];
        $order = Db::table('order')->where('id',$id)->find();
        $result = Db::table('order')->where('id',$id)->delete();
        if($result){
            //删除下面对应的订单详情
            Db::table('order_detail')->where('order_id',$id)->delete();
            //添加管理员日志
            admin_log($content = '删除方案订单-'.$order['order_sn']);
            $this->success('删除成功','/admin/order/index');
        }else{
            $this->error('删除失败');
        }
    }
    /**
    * 查看详情
    */
    public function detail(){
        //检查权限
        admin_role('order_list');
        
        $id = $_GET['id'];
        //订单
        $order = Db::table('order')->where('id',$id)->find();
        $order['addtime'] = date('Y-m-d H:i:s',$order['addtime']);
        if($order['dotime'] == ''){
            $order['dotime'] = '';
        }else{
            $order['dotime'] = date('Y-m-d H:i:s',$order['dotime']);
        }
        $order['user'] = Db::table('users')->field('username,company_name')->where('id',$order['project_user_id'])->find();
        //订单详情
        $order_detail = Db::table('order_detail')->where('order_id',$id)->select();
        $num = [];
        foreach($order_detail as $k=>$detail){
            $plan = Db::table('plan')->where('id',$detail['plan_id'])->find();
            //方案分类
            $cate1 = Db::table('cate')->field('name')->where('id',$plan['parent_cate_id'])->find();
            $cate2 = Db::table('cate')->field('name')->where('id',$plan['cate_id'])->find();
            $plan['cate1'] = $cate1['name'];
            $plan['cate2'] = $cate2['name'];
            //方案参数
            $plan['param'] = Db::table('plan_param')->where('plan_id',$plan['id'])->select();
            $order_detail[$k]['plan'] = $plan;
            $num[] = $k;
        }
        $num = json_encode($num);
        return $this->fetch('order/detail',['order'=>$order,'order_detail'=>$order_detail,'num'=>$num]);
    }
}
