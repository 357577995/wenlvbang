<?php
namespace app\admin\controller;
// 判断是否登录
use app\admin\controller\Base;
use think\Db;
use think\Request;

// 类继承自公共的类
class Message extends Base
{
	protected function _initialize()
    {
        parent::_initialize();
    }

    /**
    * 实战营分类
    */
    public function cate()
    {
        //检查权限
        admin_role('message_cate');

        $type = $_GET['type'];
        $message_cate = Db::table('message_cate')->where('message_id',$type)->paginate(5);
        $page = $message_cate->render();
        //总个数
        $total = Db::table('message_cate')->field('COUNT(*) as total')->where('message_id',$type)->select();
        $this->assign('total',$total[0]['total']);
        $this->assign('type',$type);
    	return $this->fetch('message/cate',['message_cate'=>$message_cate,'page'=>$page]);
    }
    /**
    * 添加资讯分类
    */
    public function cate_add(){
        //检查权限
        admin_role('message_cate');

        $type = $_GET['type'];
        $this->assign('type',$type);
        return $this->fetch('message/cate_add');
    }
    public function cate_insert(){
        $type = $_POST['type'];
        $data['name'] = $_POST['name'];
        $data['message_id'] = $type;
        //判断该分类是否已存在
        $cate = Db::table('message_cate')->where('name',$_POST['name'])->where('message_id',$type)->find();
        if(!empty($cate)){
            $this->error('该分类名称已存在','/admin/message/cate?type='.$type);
        }else{
            $result = Db::name('message_cate')->insert($data);
            if($result){
                //添加管理员日志
                admin_log($content = '添加实战营分类-'.$_POST['name']);
                $this->success('添加成功','/admin/message/cate?type='.$type);
            }else{
                $this->error('添加失败','/admin/message/cate?type='.$type);
            }
        }
    }
    /**
    * 删除实战营分类
    */
    public function cate_del(){
        //检查权限
        admin_role('message_cate');

        $id = $_GET['id'];
        $type = $_GET['type'];
        $name = Db::table('message_cate')->where('id',$id)->find();
        $res = Db::table('message_cate')->where('id',$id)->delete();
        if($res){
            //添加管理员日志
            admin_log($content = '删除实战营分类-'.$name['name']);
            $this->success('删除成功','/admin/message/cate?type='.$type);
        }else{
            $this->error('删除失败','/admin/message/cate?type='.$type);
        }
    }
    /**
    * 修改实战营分类
    */
    public function cate_edit(){
        //检查权限
        admin_role('message_cate');

        $id = $_GET['id'];
        $type = $_GET['type'];
        $list = Db::table('message_cate')->where('id',$id)->find();
        $this->assign('type',$type);
        return $this->fetch('message/cate_edit',['list'=>$list]);
    }
    public function cate_update(){
        $type = $_POST['type'];
        $data['name'] = $_POST['name'];
        $result = Db::table('message_cate')->where('id', $_POST['id'])->update($data);
        if($result){
            //添加管理员日志
            admin_log($content = '修改实战营分类-'.$_POST['name']);
            $this->success('修改成功','/admin/message/cate?type='.$type);
        }else{
            $this->error('修改失败','/admin/message/cate?type='.$type);
        }
    }
    /**
    * 信息列表
    */
    public function index(Request $request){
        //检查权限
        admin_role('message_list');

        $type = $_GET['type'];
        $where = '';
        //标题搜索
        $title = "'%".$request->param('title')."%'";
        if(!empty($title)){
            $where .= 'title like '.$title;
        }
        //分类搜索
        $cate_id = $request->param('cate_id');
        if(!empty($cate_id)){
            $where .= ' and cate_id = '.$cate_id;
        }
        //发布时间搜索
        if( !empty($request->param('time1')) && !empty($request->param('time2')) ){
            $time1 = strtotime($request->param('time1'));
            $time2 = strtotime($request->param('time2')) + 86399;//截止到当天的23:59:59
            $where .= ' and time > '.$time1.' and time < '.$time2;
            $this->assign('time1',$time1);
            $this->assign('time2',$time2);
        }

        $list = Db::table('message')->where($where)->where('type',$type)->paginate(5,false,['query'=>request()->param()]);
        $page = $list->render();
        $message = [];
        foreach($list as $k=>$vo){
            $message[] = $vo;
            $message[$k]['time'] = date('Y-m-d H:i:s',$vo['time']);
            //分类
            $cate = Db::table('message_cate')->where('id',$vo['cate_id'])->find();
            $message[$k]['cate'] = $cate['name'];
        }
        //搜索用的分类
        $catelist = Db::table('message_cate')->where('message_id',$type)->select();
        //总个数
        $total = Db::table('message')->where($where)->where('type',$type)->field('COUNT(*) as total')->select();
        $this->assign('total',$total[0]['total']);
        $this->assign('type',$type);
        return $this->fetch('message/index',['message'=>$message,'page'=>$page,'catelist'=>$catelist]);
    }
    /**
    * 添加信息
    */
    public function add(){
        //检查权限
        admin_role('message_add');

        $type = $_GET['type'];
        //读取分类
        $cate = Db::table('message_cate')->where('message_id',$type)->select();
        $this->assign('type',$type);
        return $this->fetch('message/add',['cate'=>$cate]);
    }
    public function insert(){
        $type = $_POST['type'];
        $data['title'] = $_POST['title'];
        $data['fu_title'] = $_POST['fu_title'];
        if($type==1 || $type==4){
            $data['cate_id'] = $_POST['cate_id'];
        }
        $data['content'] = $_POST['content'];
        $data['time'] = time();
        $data['type'] = $_POST['type'];
        //判断是否有新图片上传
        $size = $_FILES['image']['size'];
        if($size == '0'){
            $this->error('资讯图片未上传','/admin/message/add?type'.$_POST['type']);
        }else{
            $file = $_FILES["image"]["tmp_name"];//获取的上传的临时文件
            $type = substr(strrchr($_FILES["image"]["name"], '.'), 1);  
            $filetype = ['jpg', 'jpeg', 'gif', 'png'];
            if (!in_array($type, $filetype))
            {  
                $this->error('图片类型上传不正确，允许上传的图片类型：png,jpg,jpeg,gif','/admin/message/add');
            }
            $name = time().rand(1,9999).".".$type;   
            $path=$_SERVER['DOCUMENT_ROOT'].'/image/admin/message/'; 
            $res = move_uploaded_file($file ,$path.$name)? 'ok' : 'false';  
            if($res == 'ok'){
                $img = '/admin/message/'.$name;
                $data['image'] = $img;
                $result = Db::name('message')->insert($data);
                if($result){
                    //添加管理员日志
                    admin_log($content = '修改实战营信息-'.$_POST['title']);
                    $this->success('添加成功','/admin/message/index?type='.$_POST['type']);
                }else{
                    $this->error('添加失败','/admin/message/index?type='.$_POST['type']);
                }
            }else{
                $this->error('文件上传失败','/admin/message/add?type='.$_POST['type']);
            }
        }
    }
    /**
    * 删除实战营信息
    */
    public function del(){
        //检查权限
        admin_role('message_del');

        $id = $_GET['id'];
        $type = $_GET['type'];
        $message = Db::table('message')->field('image,title')->where('id',$id)->find();
        $res = Db::table('message')->where('id',$id)->delete();
        if($res){
            //删除图片
            $image = $_SERVER['DOCUMENT_ROOT'].'/image'.$message['image'];
            unlink($image);
            //添加管理员日志
            admin_log($content = '删除实战营信息-'.$message['title']);
            $this->success('删除成功','/admin/message/index?type='.$type);
        }else{
            $this->error('删除失败','/admin/message/index?type='.$type);
        }
    }
    /**
    * 修改实战营信息
    */
    public function edit(){
        //检查权限
        admin_role('message_edit');

        $id = $_GET['id'];
        $type = $_GET['type'];
        $message = Db::table('message')->where('id',$id)->find();
        //类别
        $cate = Db::table('message_cate')->where('message_id',$type)->select();
        $this->assign('type',$type);
        return $this->fetch('message/edit',['message'=>$message,'cate'=>$cate]);
    }
    public function update(){
        $type = $_POST['type'];
        $data['title'] = $_POST['title'];
        $data['fu_title'] = $_POST['fu_title'];
        if($type==1 || $type==4){
            $data['cate_id'] = $_POST['cate_id'];
        }
        $data['content'] = $_POST['content'];
        $data['time'] = time();
        $oldimg = Db::table('message')->field('image')->where('id',$_POST['id'])->find();
        //判断是否有新图片上传
        $size = $_FILES['image']['size'];
        if($size == '0'){
            $result = Db::table('message')->where('id', $_POST['id'])->update($data);
            if($result){
                //添加管理员日志
                admin_log($content = '修改实战营信息-'.$_POST['title']);
                $this->success('修改成功','/admin/message/edit?type='.$type.'&id='.$_POST['id']);
            }else{
                $this->error('修改失败','/admin/message/edit?type='.$type.'&id='.$_POST['id']);
            }
        }else{
            $file = $_FILES["image"]["tmp_name"];//获取的上传的临时文件
            $type = substr(strrchr($_FILES["image"]["name"], '.'), 1);  
            $filetype = ['jpg', 'jpeg', 'gif', 'png'];
            if (!in_array($type, $filetype))
            {  
                $this->error('图片类型上传不正确，允许上传的图片类型：png,jpg,jpeg,gif','/admin/message/edit?id='.$_POST['id']);
            }
            $name = time().rand(1,9999).".".$type;   
            $path=$_SERVER['DOCUMENT_ROOT'].'/image/admin/message/'; 
            $res = move_uploaded_file($file ,$path.$name)? 'ok' : 'false';  
            if($res == 'ok'){
                $img = '/admin/message/'.$name;
                $data['image'] = $img;
                $result = Db::table('message')->where('id', $_POST['id'])->update($data);
                if($result){
                    //删掉原图
                    $oldimg = $_SERVER['DOCUMENT_ROOT'].'/image'.$oldimg['image'];
                    unlink($oldimg);
                    //添加管理员日志
                    admin_log($content = '修改实战营信息-'.$_POST['title']);
                    $this->success('修改成功','/admin/message/edit?type='.$type.'&id='.$_POST['id']);
                }else{
                    $this->error('修改失败','/admin/message/edit?type='.$type.'&id='.$_POST['id']);
                }
            }else{
                $this->error('文件上传失败','/admin/message/edit?type='.$type.'&id='.$_POST['id']);
            }
        }
    }
    /**
    * 活动报名表单-没有的添加，有的修改
    */
    public function form(Request $request){
        //检查权限
        admin_role('message_form');

        $id = $request->get('id');
        $this->assign('id',$id);
        //判断是否有表单-没有（添加）-有（显示到页面上）
        $question = Db::table('form_question')->where('activity_id',$id)->select();
        if(!empty($question)){
            $do = '1';
            foreach($question as $k => $qo){
                $question[$k]['option'] = Db::table('form_option')->where('question_id',$qo['id'])->select();
            }
        }else{
            $do = '2';
        }
        $this->assign('do',$do);
        
        
        $this->assign('question',$question);
        return $this->fetch('message/form');
    }
    public function form_update(Request $request){
        $id = $request->post('id');
        $name = Db::table('message')->field('title')->where('id',$id)->find();
        //1.判断是否已有表单-没有（添加）-有（先删掉原表单再添新的）
        $form = Db::table('form_question')->where('activity_id',$id)->select();
        if(!empty($form)){
            //删掉原来的
            $res = Db::table('form_question')->where('activity_id',$id)->delete();
            $res = Db::table('form_option')->where('activity_id',$id)->delete();
        }
        //添加操作
        if(isset($_POST['question']) && $_POST['question'][1]['name'] != '' ){
            foreach($_POST['question'] as $key => $value){
                $question_data = array('name' => $value['name'],'activity_id' => $id,'type'=> $value['type']);
                $q_res = Db::name('form_question')->insert($question_data);
                if($q_res){
                    $question_id = Db::name('form_question')->getLastInsID();
                    //如果不是文本题
                    if($value['type'] != '2'){
                        foreach($value['option'] as $vo){
                            $option = array('name'=>$vo,'activity_id'=>$id,'question_id'=>$question_id);
                            $res = Db::name('form_option')->insert($option);
                        }
                    }
                }
            }
        }
        //添加管理员日志
        admin_log($content = '修改文旅活动['.$name['title'].']下的表单');
        $this->success('添加表单成功','/admin/message/form?id='.$id);
    }
    //报名会员
    public function form_user(Request $request){
        //检查权限
        admin_role('message_user');

        $id = $request->get('id');
        $where = '';
        //姓名搜索
        $username = "'%".$request->param('username')."%'";
        if(!empty($username)){
            $where .= 'username like '.$username;
        }
        //手机号搜索
        $mobile = "'%".$request->param('mobile')."%'";
        if(!empty($mobile)){
            $where .= ' and mobile like '.$mobile;
        }
        //报名时间搜索
        if( !empty($request->param('time1')) && !empty($request->param('time2')) ){
            $time1 = strtotime($request->param('time1'));
            $time2 = strtotime($request->param('time2')) + 86399;//截止到当天的23:59:59
            $where .= ' and time > '.$time1.' and time < '.$time2;
            $this->assign('time1',$time1);
            $this->assign('time2',$time2);
        }

        $user = Db::table('form_user')->where($where)->where('activity_id',$id)->paginate(3,false,['query'=>request()->param()]);
        $page = $user->render();
        $list = [];
        foreach($user as $key=>$value){
            $list[] = $value;
            $ui = Db::table('form_user_info')->where('uid',$value['uid'])->select();
            foreach($ui as $k=>$val){
                $question = Db::table('form_question')->where('id',$val['question_id'])->find();
                $ui[$k]['question_name'] = $question['name'];
                if($val['type']=='2'){
                    $ui[$k]['option_name'] = $val['option_id'];
                }else{
                    $option = Db::table('form_option')->where('id',$val['option_id'])->find();
                    $ui[$k]['option_name'] = $option['name'];
                }
            }
            $list[$key]['user_info'] = $ui;
        }
        //统计
        $total = Db::table('form_user')->field('count(*) as total')->where($where)->where('activity_id',$id)->select();
        $this->assign('total',$total[0]['total']);
        $this->assign('list',$list);
        $this->assign('page',$page);
        return $this->fetch('message/form_user');
    }
    /**
    * 报名表单前台显示改为不显示
    */
    public function show(Request $request){
        //检查权限
        admin_role('message_form');

        $id = $request->get('id');
        $type = $request->get('type');
        $data['form_show'] = 0;
        $name = Db::table('message')->where('id',$id)->find();
        $result = Db::table('message')->where('id',$id)->update($data);
        if($result){
            //添加管理员日志
            admin_log($content = '报名页面前台显示改为不显示-'.$name['title']);
            $this->success('修改成功','/admin/message/index?type='.$type);
        }else{
            $this->error('修改失败','/admin/message/index?type='.$type);
        }
    }
    /**
    * 报名表单前台不显示改为显示
    */
    public function noshow(Request $request){
        //检查权限
        admin_role('message_form');
        
        $id = $request->get('id');
        $type = $request->get('type');
        $data['form_show'] = 1;
        $name = Db::table('message')->where('id',$id)->find();
        $result = Db::table('message')->where('id',$id)->update($data);
        if($result){
            //添加管理员日志
            admin_log($content = '报名页面前台显示改为不显示-'.$name['title']);
            $this->success('修改成功','/admin/message/index?type='.$type);
        }else{
            $this->error('修改失败','/admin/message/index?type='.$type);
        }
    }
}