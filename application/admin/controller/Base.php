<?php

namespace app\admin\controller;
use think\Paginator;
use think\Controller;
use think\Request;
use think\Session;
use think\Db;

class Base extends Controller
{

    protected function _initialize()
    {
        parent::_initialize();

        $this->checkAuth();
    }
    /**
     * 判断是否登录
     * @return bool
     */
    protected function checkAuth()
    {
        // 判断session是否存在id
        if (!Session::has('admin_id')) {
            $this->redirect('admin/login/index');
        }
        //读取icon
        $config = Db::table('config')->where('id',1)->find();
        $this->assign('config',$config);

    }




  
}
