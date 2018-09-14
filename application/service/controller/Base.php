<?php

namespace app\service\controller;
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
     * 权限检查
     * @return bool
     */
    protected function checkAuth()
    {
        // 判断session是否存在id
        if (!Session::has('service_id')) {
            $this->redirect('service/login/index');
        }
        //读取icon
        $config = Db::table('config')->where('id',1)->find();
        $this->assign('config',$config);

    }




  
}
