<?php
namespace app\admin\controller;
// 判断是否登录
use app\admin\controller\Base;
use think\Db;
use think\Request;

// 类继承自公共的类
class Service extends Base
{
	protected function _initialize()
    {
        parent::_initialize();
    }

    /**
    * 服务商列表-审核通过的
    */
    public function index(Request $request)
    {
        //检查权限
        admin_role('service_user_list');

        $where = '';
        //用户名搜索
        $username = "'%".$request->param('username')."%'";
        if(!empty($username)){
            $where .= 'username like '.$username;
        }
        //公司名称搜索
        if(!empty($request->param('company_name'))){
            $company_name = "'%".$request->param('company_name')."%'";
            $where .= ' and company_name like '.$company_name;
        }
        //状态搜索
        $status = $request->param('status');
        if(!empty($status)){
            $where .= ' and status = '.$status;
        }

        $list = Db::table('users')->where($where)->where('status','2')->where('type','2')->paginate(5,false,['query'=>request()->param()]);
        $page = $list->render();
        $service = [];
        foreach($list as $k=>$vo){
            $service[] = $vo;
            //所在城市
            $country = Db::table('region')->field('region_name')->where('region_id',$vo['country'])->find();
            $province = Db::table('region')->field('region_name')->where('region_id',$vo['province'])->find();
            $city = Db::table('region')->field('region_name')->where('region_id',$vo['city'])->find();
            $district = Db::table('region')->field('region_name')->where('region_id',$vo['district'])->find();
            $service[$k]['name_country'] = $country['region_name'];
            $service[$k]['name_province'] = $province['region_name'];
            $service[$k]['name_city'] = $city['region_name'];
            $service[$k]['name_district'] = $district['region_name'];
        }
        //总个数
        $total = Db::table('users')->where($where)->field('COUNT(*) as total')->where('status',2)->where('type','2')->select();
        $this->assign('total',$total[0]['total']);

    	return $this->fetch('service/index',['page'=>$page,'service'=>$service]);
    }

    /**
    * 服务商列表-待审核列表
    */
    public function apply(Request $request)
    {
        //检查权限
        admin_role('service_user_list');

        $where = '';
        //用户名搜索
        $username = "'%".$request->param('username')."%'";
        if(!empty($username)){
            $where .= 'username like '.$username;
        }
        //公司名称搜索
        if(!empty($request->param('company_name'))){
            $company_name = "'%".$request->param('company_name')."%'";
            $where .= ' and company_name like '.$company_name;
        }
        //状态搜索
        $status = $request->param('status');
        if(!empty($status)){
            $where .= ' and status = '.$status;
        }
        
        $list = Db::table('users')->where($where)->where('status','in','1,3')->where('type','2')->paginate(5,false,['query'=>request()->param()]);
        $page = $list->render();
        $service = [];
        foreach($list as $k=>$vo){
            $service[] = $vo;
            //所在城市
            $country = Db::table('region')->field('region_name')->where('region_id',$vo['country'])->find();
            $province = Db::table('region')->field('region_name')->where('region_id',$vo['province'])->find();
            $city = Db::table('region')->field('region_name')->where('region_id',$vo['city'])->find();
            $district = Db::table('region')->field('region_name')->where('region_id',$vo['district'])->find();
            $service[$k]['name_country'] = $country['region_name'];
            $service[$k]['name_province'] = $province['region_name'];
            $service[$k]['name_city'] = $city['region_name'];
            $service[$k]['name_district'] = $district['region_name'];
        }
        //总个数
        $total = Db::table('users')->where($where)->field('COUNT(*) as total')->where('status','in','1,3')->where('type','2')->select();
        $this->assign('total',$total[0]['total']);

        return $this->fetch('service/apply',['page'=>$page,'service'=>$service]);
    }

    /**
    * 添加服务商
    */
    public function add(){
        //检查权限
        admin_role('service_user_add');

        $area1 = Db::table('region')->where('parent_id',0)->select();
        $this->assign("area1",$area1);
        return $this->fetch('service/add');
    }
    public function insert(){
        //判断用户名是否已存在
        $res1 = Db::table('users')->where('username',$_POST['username'])->where('type','2')->find();
        if(!empty($res1)){
            $this->error('用户名已存在','/admin/service/add');
        }
        //判断公司名称是否已存在
        $res2 = Db::table('users')->where('company_name',$_POST['company_name'])->where('type','2')->find();
        if(!empty($res2)){
            $this->error('公司名称已存在','/admin/service/add');
        }
        //判断邮箱是否已存在
        $res3 = Db::table('users')->where('email',$_POST['email'])->find();
        if(!empty($res3)){
            $this->error('邮箱已存在','/admin/service/add');
        }
        $data['username'] = $_POST['username'];
        $data['email'] = $_POST['email'];
        $data['password'] = md5($_POST['password']);
        $data['company_name'] = $_POST['company_name'];
        $data['contact'] = $_POST['contact'];
        $data['mobile'] = $_POST['mobile'];
        $data['country'] = $_POST['country'];
        $data['province'] = $_POST['province'];
        $data['city'] = $_POST['city'];
        $data['district'] = $_POST['district'];
        $data['address'] = $_POST['address'];
        $data['type'] = 2;
        //判断是否有新图片上传
        $size = $_FILES['licence']['size'];
        if($size == '0'){
            $this->error('图片未上传','/admin/service/add');
        }else{
            $file = $_FILES["licence"]["tmp_name"];//获取的上传的临时文件
            $type = substr(strrchr($_FILES["licence"]["name"], '.'), 1);  
            $filetype = ['jpg', 'jpeg', 'gif', 'png'];
            if (!in_array($type, $filetype))
            {  
                $this->error('图片类型上传不正确，允许上传的图片类型：png,jpg,jpeg,gif','/admin/service/add');
            }
            $name = time().rand(1,9999).".".$type;   
            $path=$_SERVER['DOCUMENT_ROOT'].'/image/admin/service/'; 
            $res = move_uploaded_file($file ,$path.$name)? 'ok' : 'false';  
            if($res == 'ok'){
                $img = '/admin/service/'.$name;
                $data['licence'] = $img;
                $result = Db::name('users')->insert($data);
                if($result){
                    //添加管理员日志
                    admin_log($content = '添加服务商信息-'.$_POST['username']);
                    $this->success('添加成功','/admin/service/apply');
                }else{
                    $this->error('添加失败','/admin/service/add');
                }
            }else{
                $this->error('文件上传失败','/admin/service/add');
            }
        }
    }

    /**
    * 城市三级联动ajax
    */
    public function changeArea3(){
        $area = Db::table('region')->where('parent_id',$_POST["region_id"])->select();
        $html = "";
        foreach($area as $v){
            $html .='<option value="'.$v['region_id'].'">'.$v['region_name'].'</option>';
        }
        return $html;
    }
    
    /**
    * 审核不通过
    */
    public function refuse(){
        //检查权限
        admin_role('service_user_do');

        $id = $_GET['id'];
        $name = Db::table('users')->where('id',$id)->find();
        $result = Db::table('users')->where('id', $id)->update(['status' => 3]);
        if($result){
            //添加管理员日志
            admin_log($content = '审核项目方['.$name['username'].']不通过');
            $this->success('审核成功','/admin/service/index');
        }else{
            $this->error('审核失败','/admin/service/index');
        }
    }

    /**
    * 审核通过
    */
    public function pass(){
        //检查权限
        admin_role('service_user_do');

        $id = $_GET['id'];
        $name = Db::table('users')->where('id',$id)->find();
        $result = Db::table('users')->where('id', $id)->update(['status' => 2]);
        if($result){
            //添加管理员日志
            admin_log($content = '审核项目方['.$name['username'].']通过');
            $this->success('审核成功','/admin/service/index');
        }else{
            $this->error('审核失败','/admin/service/index');
        }
    }

    /**
    * 删除服务商
    */
    public function del(){
        //检查权限
        admin_role('service_user_del');

        $id = $_GET['id'];
        $img = Db::table('users')->field('licence,username')->where('id',$id)->find();
        $res = Db::table('users')->where('id',$id)->delete();
        if($res){
            //删除营业执照
            $licence = $_SERVER['DOCUMENT_ROOT'].'/image'.$img['licence'];
            unlink($licence);
            //添加管理员日志
            admin_log($content = '删除服务商-'.$img['username']);
            $this->success('删除成功','/admin/service/index');
        }else{
            $this->error('删除失败','/admin/service/index');
        }
    }

    /**
    * 查看详情-修改
    */
    public function edit(){
        //检查权限
        admin_role('service_user_list');

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
        return $this->fetch('service/edit',['list'=>$list,'address'=>$address]);
    }
    public function update(){
        //检查权限
        admin_role('service_user_edit');

        $data['username'] = $_POST['username'];
        $data['email'] = $_POST['email'];
        if(!empty($_POST['password'])){
            $data['password'] = md5($_POST['password']);
        }
        $data['company_name'] = $_POST['company_name'];
        $data['contact'] = $_POST['contact'];
        $data['mobile'] = $_POST['mobile'];
        $data['country'] = $_POST['country'];
        $data['province'] = $_POST['province'];
        $data['city'] = $_POST['city'];
        $data['district'] = $_POST['district'];
        $data['address'] = $_POST['address'];

        //判断是否有新图片上传
        $size = $_FILES['licence']['size'];
        if($size == '0'){
            $result = Db::table('users')->where('id', $_POST['id'])->update($data);
            if($result){
                //添加管理员日志
                admin_log($content = '修改项目方信息-'.$_POST['username']);
                $this->success('修改成功','/admin/service/edit?id='.$_POST['id']);
            }else{
                $this->error('修改失败','/admin/service/edit?id='.$_POST['id']);
            }
        }else{
            //获取原图地址
            $image = Db::table('users')->field('licence')->where('id', $_POST['id'])->find();



            $file = $_FILES["licence"]["tmp_name"];//获取的上传的临时文件
            $type = substr(strrchr($_FILES["licence"]["name"], '.'), 1);  
            $filetype = ['jpg', 'jpeg', 'gif', 'png'];
            if (!in_array($type, $filetype))
            {  
                $this->error('图片类型上传不正确，允许上传的图片类型：png,jpg,jpeg,gif','/admin/service/edit?id='.$_POST['id']);
            }
            $name = time().rand(1,9999).".".$type;   
            $path=$_SERVER['DOCUMENT_ROOT'].'/image/admin/service/'; 
            $res = move_uploaded_file($file ,$path.$name)? 'ok' : 'false';  
            if($res == 'ok'){
                $img = '/admin/service/'.$name;
                $data['licence'] = $img;
                $result = Db::table('users')->where('id', $_POST['id'])->update($data);
                if($result){
                    //删除原图
                    $oldimg = $_SERVER['DOCUMENT_ROOT'].'/image'.$image['licence'];
                    unlink($oldimg);


                    //添加管理员日志
                    admin_log($content = '修改项目方信息-'.$_POST['username']);
                    $this->success('修改成功','/admin/service/edit?id='.$_POST['id']);
                }else{
                    $this->error('修改失败','/admin/service/edit?id='.$_POST['id']);
                }
            }else{
                $this->error('文件上传失败','/admin/service/edit?id='.$_POST['id']);
            }
        }
    }
}


