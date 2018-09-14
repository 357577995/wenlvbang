<?php
namespace app\service\controller;
// 判断是否登录
use app\service\controller\Base;

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
    	//统计
    	$service_id = $_SESSION['think']['service_id'];
    	$plan_total = Db::table('plan')->field('count(*) as total')->where('user_id',$service_id)->select();
    	$this->assign('plan_total',$plan_total[0]['total']);
    	return $this->fetch('index/index');
    }
}
