<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Db;
use think\Controller;
use app\admin\controller\Base;
// 应用公共文件

/**
 * 系统邮件发送函数
 * @param string $tomail 接收邮件者邮箱
 * @param string $name 接收邮件者名称
 * @param string $subject 邮件主题
 * @param string $body 邮件内容
 * @param array  $config smtp设置数组
 * @param string $attachment 附件列表
 * @return boolean
 * @author static7 <static7@qq.com>
 */
function send_mail($tomail, $name, $subject = '', $body = '', $attachment = null) {
    $config = [
            'server_address' => 'smtp.163.com',
            'email_port'=>'465',                // SMTP服务器的端口号
            'email_username'=>'15753102773@163.com',   // SMTP服务器用户名
            'email_password'=>'zxc123456',
            'email_name'=>'文旅帮'
    ];

    $mail = new \PHPMailer\PHPMailer\PHPMailer();           //实例化PHPMailer对象
    $mail->CharSet = 'UTF-8';           //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
    $mail->IsSMTP();                    // 设定使用SMTP服务
    $mail->SMTPDebug = 0;               // SMTP调试功能 0=关闭 1 = 错误和消息 2 = 消息
    $mail->SMTPAuth = true;             // 启用 SMTP 验证功能
    $mail->SMTPSecure = 'ssl';          // 使用安全协议
    $mail->Host = $config['server_address']; // SMTP 服务器
    $mail->Port = $config['email_port'];                  // SMTP服务器的端口号
    $mail->Username = $config['email_username'];    // SMTP服务器用户名
    $mail->Password = $config['email_password'];     // SMTP服务器密码
    $mail->SetFrom($config['email_username'], $config['email_name']);
    $replyEmail = '';                   //留空则为发件人EMAIL
    $replyName = '';                    //回复名称（留空则为发件人名称）
    $mail->AddReplyTo($replyEmail, $replyName);
    $mail->Subject = $subject;
    $mail->MsgHTML($body);
    $mail->AddAddress($tomail, $name);
    if (is_array($attachment)) { // 添加附件
        foreach ($attachment as $file) {
            is_file($file) && $mail->AddAttachment($file);
        }
    }
    return $mail->Send() ? true : $mail->ErrorInfo;
}
/**
 * 添加管理员日志
 * @param string $content 内容
 */
function admin_log($content = '') {
    $data['name'] = $_SESSION['think']['admin_username'];
    $data['admin_id'] = $_SESSION['think']['admin_id'];
    $data['content'] = $content;
    $data['time'] = time();
    Db::table('admin_log')->insert($data);
}

/**
 * 检查权限
 * @param string $role 权限名字
 */
function admin_role($role='') {
    $admin_id = $_SESSION['think']['admin_id'];
    $role_id = Db::table('admin_user')->field('role_id')->where('admin_id',$admin_id)->find();
    $rolelist = Db::table('admin_role')->field('role')->where('id',$role_id['role_id'])->find();
    $arr = explode(',',$rolelist['role']);
    if(!in_array($role,$arr)){
        echo "<script>alert('对不起，您没有此操作的权限！');window.history.go(-1);</script>";
        exit;
    }
}

/**
 * 方案收藏数的变动
 * @param string $plan_id 方案名字
 * @param string $num 变动值:正数-加;负数-减
 */
function collect_num($plan_id='',$num=''){
    $plan = Db::table('plan')->field('collect_num')->where('id',$plan_id)->find();
    $new['collect_num'] = $plan['collect_num'] + $num;
    Db::table('plan')->where('id',$plan_id)->update($new);
}



