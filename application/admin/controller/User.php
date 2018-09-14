<?php
namespace app\admin\controller;
// 判断是否登录
use app\admin\controller\Base;
use think\Db;
use think\Request;

// 类继承自公共的类
class User extends Base
{
	protected function _initialize()
    {
        parent::_initialize();
    }

    /**
    * 管理员列表
    */
    public function index(Request $request){
        //权限判断
        admin_role('admin_user_list');

        $where = '';
        //搜索条件
        $username = "'%".$request->param('username')."%'";
        $where .= 'username like '.$username.'';
        
        $user = Db::table('admin_user')->where($where)->paginate(5,false,['query'=>request()->param()]);
        $page = $user->render();
        $list = [];
        foreach($user as $k => $vo){
            $list[] = $vo;
            $role = Db::table('admin_role')->field('name')->where('id',$vo['role_id'])->find();
            $list[$k]['role'] = $role['name'];
        }

        //总个数
        $total = Db::table('admin_user')->where($where)->field('COUNT(*) as total')->select();
        $this->assign('total',$total[0]['total']);

        return $this->fetch('user/index',['list'=>$list,'page'=>$page]);
    }
    /**
    * 添加管理员
    */
    public function add(){
        //权限判断
        admin_role('admin_user_add');
        //取出所有角色
        $role = Db::table('admin_role')->select();
        $this->assign('role',$role);
        return $this->fetch('user/add');
    }
    public function insert(){
        $data['username'] = $_POST['username'];
        $name = Db::table('admin_user')->where('username',$_POST['username'])->find();
        if(!empty($name)){
            $this->error('用户名已存在','/admin/user/index');
        }
        $data['password'] = md5($_POST['password']);
        $data['email'] = $_POST['email']; 
        $data['role_id'] = $_POST['role_id'];
        $result = Db::name('admin_user')->insert($data);
        if($result){
            //添加管理员日志
            admin_log($content = '添加管理员-'.$_POST['username']);
            $this->success('添加成功','/admin/user/index');
        }else{
            $this->error('添加失败','/admin/user/index');
        }
    }
    /**
    * 删除管理员
    */
    public function del(){
        //权限判断
        admin_role('admin_user_del');

        $id = $_GET['id'];
        $num = Db::table('admin_user')->field('count(*) as num')->select();
        //不能删除自己
        if( $id == $_SESSION['think']['admin_id'] ){
            $this->error('不能删除自己的管理员信息','/admin/user/index');
        }else{
            //不能都删除
            if($num[0]['num'] <= 1){
                $this->error('只剩一个管理员信息，不能删除，否则没有账号登录后台');
            }else{
                $name = Db::table('admin_user')->where('admin_id',$id)->find();
                $res = Db::table('admin_user')->where('admin_id',$id)->delete();
                if($res){
                    //同时删除该管理员下面的操作日志
                    Db::table('admin_log')->where('admin_id',$id)->delete();
                    //添加管理员日志
                    admin_log($content = '删除管理员-'.$name['username']);
                    $this->success('删除成功','/admin/user/index');
                }else{
                    $this->error('删除失败','/admin/user/index');
                }
            }
            
        }
    }
    /**
    * 修改管理员
    */
    public function edit(){
        //权限判断
        admin_role('admin_user_edit');

        $id = $_GET['id'];
        $list = Db::table('admin_user')->where('admin_id',$id)->find();
        //取出所有角色
        $role = Db::table('admin_role')->select();
        $this->assign('role',$role);
        return $this->fetch('user/edit',['list'=>$list]);
    }
    public function update(){
        $data['username'] = $_POST['username'];
        if(!empty($_POST['password'])){
            $data['password'] = md5($_POST['password']);
        }
        $data['email'] = $_POST['email'];
        $data['role_id'] = $_POST['role_id'];
        $result = Db::table('admin_user')->where('admin_id', $_POST['id'])->update($data);
        if($result){
            //添加管理员日志
            admin_log($content = '修改管理员信息-'.$_POST['username']);
            $this->success('修改成功','/admin/user/index');
        }else{
            $this->error('修改失败','/admin/user/index');
        }
    }
    /**
    * 添加普通会员
    */
    public function useradd(){
        //权限判断
        admin_role('user_add');

        $area1 = Db::table('region')->where('parent_id',0)->select();
        $this->assign("area1",$area1);
        return $this->fetch('user/useradd');
    }
    public function userinsert(){
        //判断用户名是否已存在
        $res1 = Db::table('users')->where('username',$_POST['username'])->find();
        if(!empty($res1)){
            $this->error('用户名已存在','/admin/user/useradd');
        }
        //判断邮箱是否已存在
        $res2 = Db::table('users')->where('email',$_POST['email'])->find();
        if(!empty($res2)){
            $this->error('邮箱已存在','/admin/user/useradd');
        }
        $data['username'] = $_POST['username'];
        $data['email'] = $_POST['email'];
        $data['password'] = md5($_POST['password']);
        $data['mobile'] = $_POST['mobile'];
        $data['country'] = $_POST['country'];
        $data['province'] = $_POST['province'];
        $data['city'] = $_POST['city'];
        $data['district'] = $_POST['district'];
        $data['address'] = $_POST['address'];
        $data['type'] = 0;       
        $result = Db::name('users')->insert($data);
        if($result){
            //添加管理员日志
            admin_log($content = '添加普通会员-'.$_POST['username']);
            $this->success('添加成功','/admin/user/userlist');
        }else{
            $this->error('添加失败','/admin/user/userlist');
        }
    }
    /**
    * 普通会员列表
    */
    public function userlist(Request $request)
    {
        //权限判断
        admin_role('user_list');

        $where = '';
        //用户名搜索
        $username = "'%".$request->param('username')."%'";
        if(!empty($username)){
            $where .= 'username like '.$username;
        }
        //邮箱搜索
        if(!empty($request->param('email'))){
            $email = "'%".$request->param('email')."%'";
            $where .= ' and email like '.$email;
        }
        //电话搜索
        if(!empty($request->param('mobile'))){
            $mobile = "'%".$request->param('mobile')."%'";
            $where .= ' and mobile like '.$mobile;
        } 

        $list = Db::table('users')->where($where)->where('type','0')->paginate(5,false,['query'=>request()->param()]);
        $page = $list->render();
        $user = [];
        foreach($list as $k=>$vo){
            $user[] = $vo;
            //所在城市
            $country = Db::table('region')->field('region_name')->where('region_id',$vo['country'])->find();
            $province = Db::table('region')->field('region_name')->where('region_id',$vo['province'])->find();
            $city = Db::table('region')->field('region_name')->where('region_id',$vo['city'])->find();
            $district = Db::table('region')->field('region_name')->where('region_id',$vo['district'])->find();
            $user[$k]['name_country'] = $country['region_name'];
            $user[$k]['name_province'] = $province['region_name'];
            $user[$k]['name_city'] = $city['region_name'];
            $user[$k]['name_district'] = $district['region_name'];
        }
        //总个数
        $total = Db::table('users')->where($where)->field('COUNT(*) as total')->where('type','0')->select();
        $this->assign('total',$total[0]['total']);

        return $this->fetch('user/list',['page'=>$page,'user'=>$user]);
    }
    /**
    * 删除普通会员
    */
    public function userdel(){
        //权限判断
        admin_role('user_del');

        $id = $_GET['id'];
        $name = Db::table('users')->where('id',$id)->find();
        $res = Db::table('users')->where('id',$id)->delete();
        if($res){
            //添加管理员日志
            admin_log($content = '删除普通会员-'.$name['username']);
            $this->success('删除成功','/admin/user/userlist');
        }else{
            $this->error('删除失败','/admin/user/userlist');
        }
    }
    /**
    * 查看普通会员详情-修改
    */
    public function useredit(){
        //权限判断
        admin_role('user_edit');

        $id = $_GET['id'];
        $list = Db::table('users')->where('id',$id)->find();
        //所在城市
        $country = Db::table('region')->field('region_name')->where('region_id',$list['country'])->find();
        $province = Db::table('region')->field('region_name')->where('region_id',$list['province'])->find();
        $city = Db::table('region')->field('region_name')->where('region_id',$list['city'])->find();
        $district = Db::table('region')->field('region_name')->where('region_id',$list['district'])->find();

        $address['country'] = $country['region_name'];
        $address['province'] = $province['region_name'];
        $address['city'] = $city['region_name'];
        $address['district'] = $district['region_name'];

        $area1 = Db::table('region')->where('parent_id',0)->select();
        $this->assign("area1",$area1);
        return $this->fetch('user/useredit',['list'=>$list,'address'=>$address]);
    }
    public function userupdate(){
        $data['username'] = $_POST['username'];
        $data['email'] = $_POST['email'];
        if(!empty($_POST['password'])){
            $data['password'] = md5($_POST['password']);
        }
        $data['mobile'] = $_POST['mobile'];
        $data['country'] = $_POST['country'];
        $data['province'] = $_POST['province'];
        $data['city'] = $_POST['city'];
        $data['district'] = $_POST['district'];
        $data['address'] = $_POST['address'];

       
        $result = Db::table('users')->where('id', $_POST['id'])->update($data);
        if($result){
            //添加管理员日志
            admin_log($content = '修改普通会员-'.$_POST['username']);
            $this->success('修改成功','/admin/user/userlist');
        }else{
            $this->error('修改失败','/admin/user/userlist');
        }
        
    }
    /**
    * 管理员日志
    */
    public function admin_log(Request $request){
        //权限判断
        admin_role('admin_log');

        $where = '';
        //用户名搜索
        $name = "'%".$request->param('name')."%'";
        if(!empty($name)){
            $where .= 'name like '.$name;
        }
        //发布时间搜索
        if( !empty($request->param('time1')) && !empty($request->param('time2')) ){
            $time1 = strtotime($request->param('time1'));
            $time2 = strtotime($request->param('time2')) + 86399;//截止到当天的23:59:59
            $where .= ' and time > '.$time1.' and time < '.$time2;
            $this->assign('time1',$time1);
            $this->assign('time2',$time2);
        }


        $list = Db::table('admin_log')->where($where)->paginate(10);
        $page = $list->render();
        $log = [];
        foreach($list as $k => $vo){
            $log[] = $vo;
            $log[$k]['time'] = date('Y-m-d H:i:s',$vo['time']);
        }
        //统计
        $total = Db::table('admin_log')->field('count(*) as total')->where($where)->select();
        $this->assign('page',$page);
        $this->assign('log',$log);
        $this->assign('total',$total[0]['total']);
        return $this->fetch('user/admin_log');
    }
    /**
    * 角色列表
    */
    public function role(Request $request){
        //权限判断
        admin_role('admin_role');

        $where = '';
        //用户名搜索
        $name = "'%".$request->param('name')."%'";
        if(!empty($name)){
            $where .= 'name like '.$name;
        }

        $list = Db::table('admin_role')->where($where)->paginate(5);
        $page = $list->render();
        $role = [];
        foreach($list as $k => $vo){
            $role[] = $vo;
            $role[$k]['user'] = Db::table('admin_user')->field('username')->where('role_id',$vo['id'])->select();
        }
        
        //统计
        $total = Db::table('admin_role')->field('count(*) as total')->where($where)->select();
        $this->assign('page',$page);
        $this->assign('role',$role);
        $this->assign('total',$total[0]['total']);
        return $this->fetch('user/role');
    }
    /**
    * 添加角色
    */
    public function roleadd(Request $request){
        //权限判断
        admin_role('admin_role');

        return $this->fetch('user/roleadd');
    }
    public function roleinsert(Request $request){
        $data['name'] = $_POST['name'];
        $data['content'] = $_POST['content'];
        $data['role'] = implode(",",$_POST['role']);
        $result = Db::table('admin_role')->insert($data);
        if($result){
            //添加管理员日志
            admin_log($content = '添加角色-'.$_POST['name']);
            $this->success('添加成功','/admin/user/role');
        }else{
            $this->error('添加失败','/admin/user/role');
        }
    }
    /**
    * 修改角色
    */
    public function roleedit(){
        //权限判断
        admin_role('admin_role');

        $id = $_GET['id'];
        $list = Db::table('admin_role')->where('id',$id)->find();
        $role = explode(',',$list['role']);
        $this->assign('list',$list);
        $this->assign('role',$role);
        return $this->fetch('user/roleedit');
    }
    public function roleupdate(){
        

        $id = $_POST['id'];
        $data['name'] = $_POST['name'];
        $data['content'] = $_POST['content'];
        $data['role'] = implode(",",$_POST['role']);
        $result = Db::table('admin_role')->where('id',$id)->update($data);
        if($result){
            //添加管理员日志
            admin_log($content = '修改角色-'.$_POST['name']);
            $this->success('修改成功','/admin/user/role');
        }else{
            $this->error('修改失败','/admin/user/role');
        }
    }
    /**
    * 删除角色
    */
    public function roledel(){
        //权限判断
        admin_role('admin_role');

        $id = $_GET['id'];
        //如果该角色下已经添加了管理员，那么不能删除
        $user = Db::table('admin_user')->where('role_id',$id)->select();
        if(!empty($user)){
            $this->error('该角色下已经添加了管理员，不能删除！','/admin/user/role');
        }else{
            $name = Db::table('admin_role')->where('id',$id)->find();
            $res = Db::table('admin_role')->where('id',$id)->delete();
            if($res){
                //添加管理员日志
                admin_log($content = '删除角色-'.$name['name']);
                $this->success('删除成功','/admin/user/role');
            }else{
                $this->error('删除失败','/admin/user/role');
            }
        }
    }
}
