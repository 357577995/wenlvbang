<?php
namespace app\index\controller;
use think\Controller;
// 判断是否登录
use app\index\controller\Base;

use think\Request;
use think\Session;
use think\Db;


class Collect extends Base
{
    /**
    * 添加收藏
    */
    public function add(Request $request){
        echo 1;
        exit;
        //判断是不是已经收藏过了
        // $plan_id = $request->get('plan_id');
        // $user_id = $_SESSION['think']['user_id'];
        // $collect = Db::table('collect')->where('plan_id',$plan_id)->where('user_id',$user_id)->find();
        // if( !empty($collect) ){
        //     //未收藏过-改成收藏
        //     $data['project_user_id'] = $user_id;
        //     $data['plan_id'] = $plan_id;

        // }else{
        //     //收藏过-改成未收藏

        // }
    }
}
