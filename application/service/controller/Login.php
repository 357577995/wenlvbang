<?php

namespace app\service\controller;
use think\Db;
use think\Controller;
use think\Request;
use think\Session;
use PHPMailer\PHPMailer\PHPMailer;


class Login extends Controller
{
    /**
     * 登录页面
     *
     * @return \think\Response
     */
    public function index()
    {
        //读取icon
        $config = Db::table('config')->where('id',1)->find();
        $this->assign('config',$config);
        return $this->fetch();
    }

    /**
     * 登陆验证
     *
     * @return \think\Response
     */
    public function login(Request $request)
    {
        //接收验证码来判断
        if($request->post()){
            $code = $request->post('code');
            if(!captcha_check($code)) {
                $this->error('验证码不正确');
            }else{
                $data['username'] = $_POST['username'];
                $data['password'] = md5($_POST['password']);
                // 获取用户数据信息
                $admin = Db::table('users')->field('id,username,status')->where($data)->where('type',2)->find();
                if (!empty($admin)) {
                    //判断审核是否通过
                    if($admin['status'] != '2'){
                        $this->error('审核还未通过，请耐心等待');
                    }else{
                        // 设置admin_id
                        Session::set('service_id', $admin['id']);
                        Session::set('service_username', $admin['username']);
                        $this->success('登录成功', 'service/index/index');
                    }
                } else {
                    $this->error('用户名或密码错误');
                }
            }
        }
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        Session::delete('service_id');
        Session::delete('service_username');
        $this->success('退出成功', 'service/login/index');
    }

    /**
     * 注册页面
     */
    public function register()
    {
        $area1 = Db::table('region')->where('parent_id',0)->select();
        $this->assign("area1",$area1);
        //读取icon
        $config = Db::table('config')->where('id',1)->find();
        $this->assign('config',$config);
        return $this->fetch('login/register');
    }
    public function register_do(Request $request){
        //判断用户名是否已存在
        $res1 = Db::table('users')->where('username',$_POST['username'])->where('type','2')->find();
        if(!empty($res1)){
            $this->error('用户名已存在','/service/login/register');
        }
        //判断公司名称是否已存在
        $res2 = Db::table('users')->where('company_name',$_POST['company_name'])->where('type','2')->find();
        if(!empty($res2)){
            $this->error('公司名称已存在','/service/login/register');
        }
        //判断邮箱是否已存在
        $res3 = Db::table('users')->where('email',$_POST['email'])->find();
        if(!empty($res3)){
            $this->error('邮箱已存在','/service/login/register');
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
            $this->error('图片未上传','/service/login/register');
        }else{
            $file = $_FILES["licence"]["tmp_name"];//获取的上传的临时文件
            $type = substr(strrchr($_FILES["licence"]["name"], '.'), 1);  
            $filetype = ['jpg', 'jpeg', 'gif', 'png'];
            if (!in_array($type, $filetype))
            {  
                $this->error('图片类型上传不正确，允许上传的图片类型：png,jpg,jpeg,gif','/service/login/register');
            }
            $name = time().rand(1,9999).".".$type;   
            $path=$_SERVER['DOCUMENT_ROOT'].'/image/service/users/'; 
            $res = move_uploaded_file($file ,$path.$name)? 'ok' : 'false';  
            if($res == 'ok'){
                $img = '/service/users/'.$name;
                $data['licence'] = $img;
                $result = Db::name('users')->insert($data);
                if($result){
                    $this->success('注册成功，已提交总管理后台进行审核，请等待审核通过后登录。','/service/login/index');
                }else{
                    $this->error('注册失败','/service/login/register');
                }
            }else{
                $this->error('文件上传失败','/service/login/register');
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
    * 邮箱找回密码页面
    */
    public function email(){
        //读取icon
        $config = Db::table('config')->where('id',1)->find();
        $this->assign('config',$config);
        return $this->fetch('login/email');
    }
    /**
    * 判断邮箱是否存在
    */
    public function isemail(Request $request){
        $email = $request->post('email');
        $email = trim($email,' ');
        $res = Db::table('users')->where('email',$email)->where('type','2')->find();
        if(!empty($res)){
            //存在
            echo 1;
        }else{
            //不存在
            echo 2;
        }
        exit;
    }
    /**
    * 发送邮件
    */
    public function sendmail(Request $request){
        //接收方
        $toemail = $request->get('email');
        $info = Db::table('users')->where('email',$toemail)->find();
        $token = md5($info['id'].$info['username']);
        $href = "'http://".$_SERVER['SERVER_NAME'].'/service/login/newpassword?id='.$info['id'].'&token='.$token."'";
        $name='文旅帮';
        $subject='服务商-找回密码';
        $content="亲爱的".$info['username']."，您正在进行找回密码操作，如果不是您本人操作，请忽略这条邮件。
        <a href=".$href." target='blank' >点我继续找回密码</a>";
        
        $res = send_mail($toemail,$name,$subject,$content);
        if($res){
            $this->success('发送邮件成功','/service/login/index');
        }else{
            $this->error('发送邮件失败');
        }
    }
    /**
    * 重设密码
    */
    public function newpassword(Request $request){
        $id = $request->get('id');
        $token = $request->get('token');
        $user = Db::table('users')->field('id,username')->where('id',$id)->find();
        if(!empty($user)){
            $token2 = md5($user['id'].$user['username']);
            if($token == $token2){
                $this->assign('id',$id);
                $this->assign('username',$user['username']);
                //读取icon
                $config = Db::table('config')->where('id',1)->find();
                $this->assign('config',$config);
                return $this->fetch('login/newpassword');
            }
        }
    }
    public function newpassword_do(Request $request){
        $password = md5($request->post('password'));
        $id = $request->post('id');
        $data['password'] = $password;
        $res = Db::table('users')->where('id',$id)->update($data);
        if($res){
            $this->success('修改密码成功','/service/login/index');
        }else{
            $this->error('修改密码失败','/service/login/index');
        }
    }

    
}
