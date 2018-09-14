<?php
namespace app\admin\controller;
// 判断是否登录
use app\admin\controller\Base;
use think\Db;
use think\Session;

// 类继承自公共的类
class Config extends Base
{
	protected function _initialize()
    {
        parent::_initialize();
    }

    /**
    * 系统设置
    */
    public function index()
    {
        //检查权限
        admin_role('config_list');

        $list = Db::table('config')->where('id',1)->find();
        return $this->fetch('config/index',['list'=>$list]);
    }

    public function update(){
        //检查权限
        admin_role('config_edit');

        //判断是否有新图片上传
        $size = $_FILES['logo']['size'];
        if($size == '0'){
            $icon_size = $_FILES['icon']['size'];
            if($icon_size == '0'){
                $result = Db::table('config')->where('id', 1)->update(['company_name' => $_POST['company_name'],'company_address'=>$_POST['company_address'],'company_mobile' => $_POST['company_mobile'],'tel' => $_POST['tel'],'email' => $_POST['email'],'html' => $_POST['html']]);
                if($result){
                    //添加管理员日志
                    admin_log($content = '修改系统设置');
                    $this->success('修改成功','/admin/config/index');
                }else{
                    $this->error('修改失败','/admin/config/index');
                }
            }else{
                $file = $_FILES["icon"]["tmp_name"];//获取的上传的临时文件
                $type = substr(strrchr($_FILES["icon"]["name"], '.'), 1);  
                $name = time().rand(1,9999).".".$type;   
                $path=$_SERVER['DOCUMENT_ROOT'].'/index/image/'; 
                $res = move_uploaded_file($file ,$path.$name)? 'ok' : 'false';  
                if($res == 'ok'){
                    $icon = '/image/'.$name;
                    $result = Db::table('config')->where('id', 1)->update(['company_name' => $_POST['company_name'],'company_address'=>$_POST['company_address'],'company_mobile' => $_POST['company_mobile'],'tel' => $_POST['tel'],'email' => $_POST['email'],'html' => $_POST['html'],'icon'=>$icon]);
                    if($result){
                        //添加管理员日志
                        admin_log($content = '修改系统设置');
                        $this->success('修改成功','/admin/config/index');
                    }else{
                        $this->error('修改失败','/admin/config/index');
                    }
                }else{
                    $this->error('文件上传失败','/admin/config/image');
                } 
            }
        }else{
            $file = $_FILES["logo"]["tmp_name"];//获取的上传的临时文件
            $type = substr(strrchr($_FILES["logo"]["name"], '.'), 1);  
            $name = time().rand(1,9999).".".$type;   
            $path=$_SERVER['DOCUMENT_ROOT'].'/index/image/'; 
            $res = move_uploaded_file($file ,$path.$name)? 'ok' : 'false';  
            if($res == 'ok'){
                $img = '/image/'.$name;
                //是否有icon图上传
                $icon_size = $_FILES['icon']['size'];
                if($icon_size=='0'){
                    $result = Db::table('config')->where('id', 1)->update(['company_name' => $_POST['company_name'],'company_address'=>$_POST['company_address'],'company_mobile' => $_POST['company_mobile'],'tel' => $_POST['tel'],'email' => $_POST['email'],'html' => $_POST['html'],'logo'=>$img]);
                    if($result){
                        //添加管理员日志
                        admin_log($content = '修改系统设置');
                        $this->success('修改成功','/admin/config/index');
                    }else{
                        $this->error('修改失败','/admin/config/index');
                    }
                }else{
                    $file = $_FILES["icon"]["tmp_name"];//获取的上传的临时文件
                    $type = substr(strrchr($_FILES["icon"]["name"], '.'), 1);  
                    $name = time().rand(1,9999).".".$type;   
                    $path=$_SERVER['DOCUMENT_ROOT'].'/index/image/'; 
                    $res = move_uploaded_file($file ,$path.$name)? 'ok' : 'false';
                    if($res == 'ok'){
                        $icon = '/image/'.$name;
                        $result = Db::table('config')->where('id', 1)->update(['company_name' => $_POST['company_name'],'company_address'=>$_POST['company_address'],'company_mobile' => $_POST['company_mobile'],'tel' => $_POST['tel'],'email' => $_POST['email'],'html' => $_POST['html'],'logo'=>$img,'icon'=>$icon]);
                        if($result){
                            //添加管理员日志
                            admin_log($content = '修改系统设置');
                            $this->success('修改成功','/admin/config/index');
                        }else{
                            $this->error('修改失败','/admin/config/index');
                        }
                    }
                }
            }else{
                $this->error('文件上传失败','/admin/config/image');
            } 
        }
    }
}
