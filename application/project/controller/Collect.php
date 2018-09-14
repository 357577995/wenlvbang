<?php
namespace app\project\controller;
// 判断是否登录
use app\project\controller\Base;
use think\Db;
use think\Request;

// 类继承自公共的类
class Collect extends Base
{
	protected function _initialize()
    {
        parent::_initialize();
    }

    /**
    * 收藏方案列表
    */
    public function index(Request $request)
    {
        $where = '';
        //名称搜索
        $name = "'%".$request->param('name')."%'";
        $plan_ids = Db::table('plan')->field('id')->where('name like '.$name)->select();
        $ids = [];
        if(!empty($plan_ids)){
            foreach($plan_ids as $k=>$plan_id){
                $ids[] = $plan_id['id'];
            }
        }
    
        $ids = implode(',',$ids);
        $where .= ' plan_id in ('.$ids.')';





        
        




        




        $project_user_id = $_SESSION['think']['project_id'];
        $collect = Db::table('collect')->where($where)->where('project_user_id',$project_user_id)->paginate(5,false,['query'=>request()->param()]);
        $page = $collect->render();
        $plan = [];
        foreach($collect as $k=>$vo){
            $info = Db::table('plan')->where('id',$vo['plan_id'])->find();
            //分类名称
            $cate2 = Db::table('cate')->where('id',$info['cate_id'])->find();
            $info['cate2'] = $cate2['name'];
            //上级分类
            $cate1 = Db::table('cate')->where('id',$info['parent_cate_id'])->find();
            $info['cate1'] = $cate1['name'];

            $plan[$k] = $info;
            $plan[$k]['param'] = Db::table('plan_param')->where('plan_id',$vo['plan_id'])->select();
        }
        //查询分类
        // $cate = Db::table('cate')->where('parent_id','0')->select();
        // foreach($cate as $k=>$vo){
        //     $cate[$k]['son'] = Db::table('cate')->where('parent_id',$vo['id'])->select();
        //     foreach($cate[$k]['son'] as $kk=>$voo){
        //         $cate[$k]['son'][$kk]['sun'] = Db::table('cate')->where('parent_id',$voo['id'])->select();
        //     }
        // }
        //总个数
        $total = Db::table('collect')->where($where)->where('project_user_id',$project_user_id)->field('COUNT(*) as total')->select();
        $this->assign('total',$total[0]['total']);

        // $this->assign('cate',$cate);
        $this->assign('plan',$plan);
        $this->assign('page',$page);
    	return $this->fetch('collect/index');
    }
    /**
    * 查看方案详情
    */
    public function detail($id){
        $id = $_GET['id'];
        $list = Db::table('plan')->where('id',$id)->find();
        //查询分类
        $cate1 = Db::table('cate')->where('id',$list['parent_cate_id'])->find();
        $cate2 = Db::table('cate')->where('id',$list['cate_id'])->find();
        $cate_name = $cate1['name'].'->'.$cate2['name'];
        //判断是不是到头了
        if($cate1['parent_id'] != '0'){
            $cate3 = Db::table('cate')->where('id',$cate1['parent_id'])->find();
            $cate_name = $cate3['name'].'->'.$cate_name;
        }
        $this->assign('cate_name',$cate_name);
        
        //查询参数
        $param = Db::table('plan_param')->where('plan_id',$id)->select();
        return $this->fetch('collect/detail',['list'=>$list,'param'=>$param]);
    }
    /**
    * 取消收藏
    */
    public function quxiao(Request $request){
        $plan_id = $request->get('id');
        $project_user_id = $_SESSION['think']['project_id'];
        $res = Db::table('collect')->where('plan_id',$plan_id)->where('project_user_id',$project_user_id)->delete();
        if($res){
            //收藏数变动
            collect_num($plan_id,'-1');
            $this->success('取消收藏成功','/project/collect/index');
        }else{
            $this->error('取消收藏失败');
        }
    } 
}
