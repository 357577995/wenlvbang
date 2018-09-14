<?php
namespace app\admin\controller;
// 判断是否登录
use app\admin\controller\Base;
use think\Db;
use think\Request;

// 类继承自公共的类
class Cate extends Base
{
	protected function _initialize()
    {
        parent::_initialize();
    }

    /**
    * 业态分类列表
    */
    public function index(Request $request)
    {
        //检查权限
        admin_role('cate_list');

        $where = '';
        //搜索条件
        $name = "'%".$request->param('name')."%'";
        $where .= 'name like '.$name.'';

        //查询分类
        $list = Db::table('cate')->where($where)->where('parent_id','0')->paginate(1,false,['query'=>request()->param()]);
        $page = $list->render();
        $cate = [];
        foreach($list as $k=>$vo){
            $cate[] = $vo;
            $cate[$k]['son'] = Db::table('cate')->where('parent_id',$vo['id'])->select();
            foreach($cate[$k]['son'] as $kk=>$voo){
                $cate[$k]['son'][$kk]['sun'] = Db::table('cate')->where('parent_id',$voo['id'])->select();
            }
        }

        //总个数
        $total = Db::table('cate')->where($where)->field('COUNT(*) as total')->where('parent_id','0')->select();
        $this->assign('total',$total[0]['total']);
    	return $this->fetch('cate/index',['cate'=>$cate,'page'=>$page]);
    }

    /**
	* 添加业态分类
    */
    public function add()
    {
        //检查权限
        admin_role('cate_add');

        //查询分类
        $cate = Db::table('cate')->where('parent_id','0')->select();
        foreach($cate as $k=>$vo){
            $cate[$k]['son'] = Db::table('cate')->where('parent_id',$vo['id'])->select();
        }
    	return $this->fetch('cate/add',['cate'=>$cate]);
    }
    public function insert(){
        //分类是否已存在
        $cate = Db::table('cate')->where('name',$_POST['name'])->find();
        if(empty($cate)){
            $data['name'] = $_POST['name'];
            $data['parent_id'] = $_POST['parent_id'];
            $result = Db::name('cate')->insert($data);
            if($result){
                //添加管理员日志
                admin_log($content = '添加业态分类-'.$_POST['name']);
                $this->success('添加成功','/admin/cate/index');
            }else{
                $this->error('添加失败','/admin/cate/index');
            }
        }else{
            $this->error('分类已经存在','/admin/cate/index');
        }
    }

    /**
    * 删除业态分类
    */
    public function del(){
        //检查权限
        admin_role('cate_del');

        //判断下面是否还有子分类
        $id = $_GET['id'];
        $cates = Db::table('cate')->where('id',$id)->find();
        $cate = Db::table('cate')->where('parent_id',$id)->find();
        if(!empty($cate)){
            $this->error('请先删除该分类下面的子分类','/admin/cate/index');
        }else{
            //判断该分类下是否有方案
            $plan = Db::table('plan')->where('cate_id',$id)->select();
            if(!empty($plan)){
                $this->error('该分类下已有方案,不能删除','/admin/cate/index');
            }else{
                $res = Db::table('cate')->where('id',$id)->delete(); 
                if($res){
                    //删除下面的参数
                    Db::table('cate_param')->where('cate_id',$id)->delete();
                    //添加管理员日志
                    admin_log($content = '删除业态分类-'.$cates['name']);
                    $this->success('删除成功','/admin/cate/index');
                }else{
                    $this->error('删除失败','/admin/cate/index');
                }
            } 
        }
    }

    /**
    * 修改业态分类
    */
    public function edit($id){
        //检查权限
        admin_role('cate_edit');

        $id = $_GET['id'];
        $list = Db::table('cate')->where('id',$id)->find();
        //查询分类
        $cate = Db::table('cate')->where('parent_id','0')->select();
        foreach($cate as $k=>$vo){
            $cate[$k]['son'] = Db::table('cate')->where('parent_id',$vo['id'])->select();
            foreach($cate[$k]['son'] as $kk=>$voo){
                $cate[$k]['son'][$kk]['sun'] = Db::table('cate')->where('parent_id',$voo['id'])->select();
            }
        }
        return $this->fetch('cate/edit',['list'=>$list,'cate'=>$cate]);
    }
    public function update(){
        $name = $_POST['name'];
        $parent_id = $_POST['parent_id'];
        $id = $_POST['id'];
        $result = Db::table('cate')->where('id', $id)->update(['name' => $name,'parent_id'=>$parent_id]);
        if($result){
            //添加管理员日志
            admin_log($content = '修改业态分类-'.$name);
            $this->success('修改成功','/admin/cate/index');
        }else{
            $this->error('修改失败','/admin/cate/index');
        }
    }

    /**
    * 业态参数管理列表
    */
    public function param(){
        //检查权限
        admin_role('cate_param');

        $cate_id = $_GET['cate_id'];
        $param = Db::table('cate_param')->where('cate_id',$cate_id)->paginate(5);
        $page = $param->render();
        //分类名
        $cate = Db::table('cate')->where('id',$cate_id)->find();
        return $this->fetch('cate/param',['page'=>$page,'cate'=>$cate,'param'=>$param]);
    }

    /**
    * 业态参数删除
    */
    public function param_del(){
        //检查权限
        admin_role('cate_param');

        $id = $_GET['id'];
        $cate_id = $_GET['cate_id'];
        $param = Db::table('cate_param')->where('id',$id)->find();
        $res = Db::table('cate_param')->where('id',$id)->delete();
        if($res){
            //添加管理员日志
            admin_log($content = '删除业态分类参数-'.$param['name']);
            $this->success('删除成功','/admin/cate/param?cate_id='.$cate_id);
        }else{
            $this->error('删除失败','/admin/cate/param?cate_id='.$cate_id);
        }
    }

    /**
    * 业态参数添加
    */
    public function param_add(){
        //检查权限
        admin_role('cate_param');

        $cate_id = $_GET['cate_id'];
        return $this->fetch('cate/param_add',['cate_id'=>$cate_id]);
    }
    public function param_insert(){
        //当前分类中该参数是否已存在
        $param = Db::table('cate_param')->where('name',$_POST['name'])->where('cate_id',$_POST['cate_id'])->find();
        if(empty($param)){
            $data['name'] = $_POST['name'];
            $data['cate_id'] = $_POST['cate_id'];
            $data['type'] = $_POST['type'];
            $result = Db::name('cate_param')->insert($data);
            if($result){
                //添加管理员日志
                admin_log($content = '添加业态分类参数-'.$_POST['name']);
                $this->success('添加成功','/admin/cate/param?cate_id='.$_POST['cate_id']);
            }else{
                $this->error('添加失败','/admin/cate/param?cate_id='.$_POST['cate_id']);
            }
        }else{
            $this->error('参数已经存在','/admin/cate/param?cate_id='.$_POST['cate_id']);
        }
    }

    /**
    * 修改业态参数
    */
    public function param_edit($id){
        //检查权限
        admin_role('cate_param');
        
        $id = $_GET['id'];
        $cate_id = $_GET['cate_id'];
        $list = Db::table('cate_param')->where('id',$id)->find();
        return $this->fetch('cate/param_edit',['list'=>$list,'cate_id'=>$cate_id]);
    }
    public function param_update(){
        $name = $_POST['name'];
        $id = $_POST['id'];
        $type = $_POST['type'];
        $result = Db::table('cate_param')->where('id', $id)->update(['name' => $name,'type'=>$type]);
        if($result){
            //添加管理员日志
            admin_log($content = '修改业态分类参数-'.$name);
            $this->success('修改成功','/admin/cate/param?cate_id='.$_POST['cate_id']);
        }else{
            $this->error('修改失败','/admin/cate/param?cate_id='.$_POST['cate_id']);
        }
    }
}
