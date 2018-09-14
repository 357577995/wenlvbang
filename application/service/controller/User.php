<?php
namespace app\service\controller;
// 判断是否登录
use app\service\controller\Base;
use think\Db;
use think\Session;
use think\Request;

// 类继承自公共的类
class User extends Base
{
	protected function _initialize()
    {
        parent::_initialize();
    }

    /**
	* 用户信息
    */
    public function index(Request $request){
        $id = $_SESSION['think']['service_id'];
        $list = Db::table('users')->where('id',$id)->find();
        //所在城市
        $country = Db::table('region')->field('region_name')->where('region_id',$list['country'])->find();
        $province = Db::table('region')->field('region_name')->where('region_id',$list['province'])->find();
        $city = Db::table('region')->field('region_name')->where('region_id',$list['city'])->find();
        $district = Db::table('region')->field('region_name')->where('region_id',$list['district'])->find();

        $address['country'] = $country['region_name'];
        $address['province'] = $province['region_name'];
        $address['city'] = $city['region_name'];
        $address['district'] = $district['region_name'];

        $area1 = Db::table('region')->where('parent_id',0)->select();
        $this->assign("area1",$area1);

        return $this->fetch('user/index',['list'=>$list,'address'=>$address]);
    }

    /**
    * 修改密码
    */
    public function edit(){
        $id = $_SESSION['think']['service_id'];
        $this->assign('id',$id);
        return $this->fetch('user/edit');
    }
    public function update(Request $request){
        $oldpassword = $request->post('oldpassword');
        $data['password'] = md5($request->post('password'));
        $id = $request->post('id');

        $user = Db::table('users')->field('password')->where('id',$id)->find();
        


        if(!empty($user)){
            if( $user['password'] == md5($oldpassword) ){
                $res = Db::table('users')->where('id',$id)->update($data);
                if($res){
                    $this->success('修改成功','/service/user/edit');
                }else{
                    $this->error('修改失败');
                }
            }else{
                $this->error('原密码输入不正确');
            }
        }

        
    }
}
