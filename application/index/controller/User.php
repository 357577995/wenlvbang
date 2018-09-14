<?php
namespace app\index\controller;
use think\Controller;
// 判断是否登录
use app\index\controller\Base;

use think\Request;
use think\Session;
use think\Db;


class User extends Base
{
    /**
    * 认证成为项目方/服务商
    * $type=1项目方  2服务商
    */
    public function ident(Request $request)
    {
        //认证方式
        $type = $request->get('type');
        //用户信息
        $list = Db::table('users')->where('id',$_SESSION['think']['user_id'])->find();
        $oldtype = $list['type'];
        
        if($oldtype=='1'){
            $message = '您已经认证成为项目方了';
            $this->error($message);
        }elseif($oldtype=='2'){
            $message = '您已经认证成为服务商了';
            $this->error($message);
        }else{
            //地区表
            $area1 = Db::table('region')->where('parent_id',0)->select();
            //所在城市
            $country = Db::table('region')->field('region_name')->where('region_id',$list['country'])->find();
            $province = Db::table('region')->field('region_name')->where('region_id',$list['province'])->find();
            $city = Db::table('region')->field('region_name')->where('region_id',$list['city'])->find();
            $district = Db::table('region')->field('region_name')->where('region_id',$list['district'])->find();
            $address['country'] = $country['region_name'];
            $address['province'] = $province['region_name'];
            $address['city'] = $city['region_name'];
            $address['district'] = $district['region_name'];

            $this->assign('address',$address);
            $this->assign('list',$list);
            $this->assign("area1",$area1);
            $this->assign('type',$type);
            return $this->fetch('user/ident');
        }
    }
    public function ident_do(Request $request){
        $data['username'] = $_POST['username'];
        $data['email'] = $_POST['email'];
        $data['company_name'] = $_POST['company_name'];
        $data['contact'] = $_POST['contact'];
        $data['mobile'] = $_POST['mobile'];
        $data['country'] = $_POST['country'];
        $data['province'] = $_POST['province'];
        $data['city'] = $_POST['city'];
        $data['district'] = $_POST['district'];
        $data['address'] = $_POST['address'];
        $data['type'] = $_POST['type'];

        //判断是否有新图片上传
        $size = $_FILES['licence']['size'];
        if($size == '0'){
            $this->error('营业执照照片还未添加');
        }else{
            
            $file = $_FILES["licence"]["tmp_name"];//获取的上传的临时文件
            $type = substr(strrchr($_FILES["licence"]["name"], '.'), 1);  
            $filetype = ['jpg', 'jpeg', 'gif', 'png'];
            if (!in_array($type, $filetype))
            {  
                $this->error('图片类型上传不正确，允许上传的图片类型：png,jpg,jpeg,gif');
            }
            $name = time().rand(1,9999).".".$type;   
            $path=$_SERVER['DOCUMENT_ROOT'].'/image/admin/'; 
            $res = move_uploaded_file($file ,$path.$name)? 'ok' : 'false';  
            if($res == 'ok'){
                $img = '/admin/'.$name;
                $data['licence'] = $img;
                $result = Db::table('users')->where('id', $_POST['id'])->update($data);
                if($result){
                    $this->success('认证成功','/index/index/index');
                }else{
                    $this->error('认证失败','/index/index/index');
                }
            }else{
                $this->error('文件上传失败','/index/index/index');
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
    
}
