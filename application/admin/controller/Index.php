<?php
namespace app\admin\controller;
// 判断是否登录
use app\admin\controller\Base;

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
    	//统计业态分类数量
    	$catenum = Db::table('cate')->field('count(*) as num')->where('parent_id','0')->select();
    	$this->assign('catenum',$catenum[0]['num']);
    	//统计方案
    	$plannum = Db::table('plan')->field('count(*) as num')->select();
    	$this->assign('plannum',$plannum[0]['num']);
    	//统计订单
    	$ordernum = Db::table('order')->field('count(*) as num')->select();
    	$this->assign('ordernum',$ordernum[0]['num']);
    	//统计服务商
    	$servicenum = Db::table('users')->field('count(*) as num')->where('type','2')->select();
    	$this->assign('servicenum',$servicenum[0]['num']);
    	//统计项目方
    	$projectnum = Db::table('users')->field('count(*) as num')->where('type','1')->select();
    	$this->assign('projectnum',$projectnum[0]['num']);
    	//统计新闻
    	$newnum = Db::table('news')->field('count(*) as num')->select();
    	$this->assign('newnum',$newnum[0]['num']);
    	//统计专家
    	$expertnum = Db::table('expert')->field('count(*) as num')->select();
    	$this->assign('expertnum',$expertnum[0]['num']);
    	return $this->fetch('index/index');
    }
}
