<?php
namespace app\project\controller;
// 判断是否登录
use app\project\controller\Base;

use think\Db;
// 类继承自公共的类
class Index extends Base
{


	protected function _initialize()
    {
        parent::_initialize();
    }

    public function index()
    {
    	
    	return $this->fetch('index/index');
    }
}
