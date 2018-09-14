<?php

namespace app\admin\controller;
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
                $admin = Db::table('admin_user')->field('admin_id,username')->where($data)->find();
                if (!empty($admin)) {
                    // 设置admin_id
                    Session::set('admin_id', $admin['admin_id']);
                    Session::set('admin_username', $admin['username']);
                    //添加管理员日志
                    admin_log($content = '登录后台');
                    $this->success('登录成功', 'admin/index/index');
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
        
        Session::delete('admin_id');
        Session::delete('admin_username');
        $this->success('退出成功', 'admin/login/index');
    }
}
