<?php
namespace app\service\controller;
// 判断是否登录
use app\service\controller\Base;
use think\Db;
use think\Session;
use think\Request;

// 类继承自公共的类
class Plan extends Base
{
	protected function _initialize()
    {
        parent::_initialize();
    }

    /**
	* 添加方案
    */
	public function add(){
		//查询分类
        $cate = Db::table('cate')->where('parent_id','0')->select();
        foreach($cate as $k=>$vo){
            $cate[$k]['son'] = Db::table('cate')->where('parent_id',$vo['id'])->select();
            foreach($cate[$k]['son'] as $kk=>$voo){
                $cate[$k]['son'][$kk]['sun'] = Db::table('cate')->where('parent_id',$voo['id'])->select();
            }
        }
		return $this->fetch('plan/add',['cate'=>$cate]);
	}
	public function insert(){

		//判断是否有新图片上传
        $size = $_FILES['image']['size'];
        if($size == '0'){
            $this->error('图片未上传','/service/plan/add');
        }else{
            $file = $_FILES["image"]["tmp_name"];//获取的上传的临时文件
            $type = substr(strrchr($_FILES["image"]["name"], '.'), 1);  
            $name = time().rand(1,9999).".".$type;   
            $path=$_SERVER['DOCUMENT_ROOT'].'/image/service/'; 
            $res = move_uploaded_file($file ,$path.$name)? 'ok' : 'false';  
            if($res == 'ok'){
                $img = '/service/'.$name;
                $data['image'] = $img;
                $data['name'] = $_POST['name'];
		        $data['cate_id'] = $_POST['cate_id'];
		        $data['content'] = $_POST['content'];
		        //一级分类
		        $cate = Db::table('cate')->where('id',$_POST['cate_id'])->find();
		        $data['parent_cate_id'] = $cate['parent_id'];
		        $data['user_id'] = $_SESSION['think']['service_id'];
		        $result = Db::name('plan')->insert($data);
		        $plan_id = Db::name('plan')->getLastInsID();
		        if($result){
                    //分类参数
//                     foreach($_POST['param'] as $k => $param){
//                         $cate_name = Db::table('cate_param')->field('name')->where('id',$k)->find();
//                         $dd['name'] = $cate_name['name'];
//                         $dd['value'] = $param;
//                         $dd['plan_id'] = $plan_id;
//                         $dd['param_id'] = $k;
//                         Db::table('plan_param')->insert($dd);
//                     }



		            $this->success('添加成功','/service/plan/apply');
		        }else{
		            $this->error('添加失败','/service/plan/apply');
		        }
            }else{
                $this->error('文件上传失败','/service/plan/apply');
            }
        }
	}

    /**
    * ajax分类改变参数改变
    */
    public function changeparam(Request $request){
        $cate_id = $_POST['cate_id'];

        //当前分类找上级分类
        $ids = [];
        $cate = Db::table('cate')->where('id',$cate_id)->find();
        $ids[] = $cate['parent_id'];
        $ids[] = $cate_id;
        //判断是不是到头了
        $res = Db::table('cate')->where('id',$cate['parent_id'])->find();
        if($res['parent_id']!='0'){
            $ids[] = $res['parent_id'];
        }
        $ids = implode(',',$ids);
        $param = Db::table('cate_param')->field('id,name,type')->where('cate_id','in',$ids)->select();
        $param = json_encode($param);
        echo $param;
        exit;
    }

    /**
	* 方案列表
    */
    public function apply(Request $request){

        $where = '';
        //名称搜索
        $name = "'%".$request->param('name')."%'";
        $where .= 'name like '.$name.'';
        //分类搜索
        if(!empty($request->param('cate_id'))){
            $cate_id = $request->param('cate_id');
            //如果是二级的
            $cate = Db::table('cate')->where('parent_id',$cate_id)->select();
            if(!empty($cate)){
                $str = [];
                foreach($cate as $k=>$vo){
                    $str[] = $vo['id'];
                }
                $str = implode(',',$str);
                $where .= ' and cate_id in ('.$str.')';
            }else{
                $where .= ' and cate_id = '.$request->param('cate_id');
            }
        }
        //状态搜索
        $status = $request->param('status');
        if(!empty($status)){
            $where .= ' and status = '.$status;
        }

    	$user_id = $_SESSION['think']['service_id'];
    	$list = Db::table('plan')->where('user_id',$user_id)->where($where)->paginate(5,false,['query'=>request()->param()]);
    	$page = $list->render();
    	$plan = [];
    	foreach($list as $k=>$vo){
    		$plan[] = $vo;
    		//分类名称
    		$cate2 = Db::table('cate')->where('id',$vo['cate_id'])->find();
    		$plan[$k]['cate2'] = $cate2['name'];
    		$cate1 = Db::table('cate')->where('id',$vo['parent_cate_id'])->find();
    		$plan[$k]['cate1'] = $cate1['name'];
    		//参数
    		$plan[$k]['param'] = Db::table('plan_param')->where('plan_id',$vo['id'])->select();
    	}
        //总个数
        $total = Db::table('plan')->field('COUNT(*) as total')->where($where)->where('user_id',$user_id)->select();
        $this->assign('total',$total[0]['total']);
        //查询分类
        $cate = Db::table('cate')->where('parent_id','0')->select();
        foreach($cate as $k=>$vo){
            $cate[$k]['son'] = Db::table('cate')->where('parent_id',$vo['id'])->select();
            foreach($cate[$k]['son'] as $kk=>$voo){
                $cate[$k]['son'][$kk]['sun'] = Db::table('cate')->where('parent_id',$voo['id'])->select();
            }
        }
        $this->assign('cate',$cate);

    	return $this->fetch('plan/apply',['page'=>$page,'plan'=>$plan]);
    }

    /**
	* 删除方案
    */
    public function del(){
    	$id = $_GET['id'];
        //判断该方案是否已经添加到订单中-不能删除
        $order_detail = Db::table('order_detail')->where('plan_id',$id)->find();
        if(empty($order_detail)){
            $image = Db::table('plan')->field('image')->where('id',$id)->find();
            $res = Db::table('plan')->where('id',$id)->delete();
            if($res){
                //删除下面的参数
                Db::table('plan_param')->where('plan_id',$id)->delete();
                //删除存储的相应图片
                $oldimg = $_SERVER['DOCUMENT_ROOT'].'/image'.$image['image'];
                unlink($oldimg);


                $this->success('删除成功','/service/plan/apply');
            }else{
                $this->error('删除失败','/service/plan/apply');
            }
        }else{
            $this->error('该方案已经加入订单，不能删除','/service/plan/apply');
        }
    }

    /**
    * 修改方案
    */
    public function edit($id){
        $id = $_GET['id'];
        $list = Db::table('plan')->where('id',$id)->find();
        //查询分类
        $cate = Db::table('cate')->where('parent_id','0')->select();
        foreach($cate as $k=>$vo){
            $cate[$k]['son'] = Db::table('cate')->where('parent_id',$vo['id'])->select();
            foreach($cate[$k]['son'] as $kk=>$voo){
                $cate[$k]['son'][$kk]['sun'] = Db::table('cate')->where('parent_id',$voo['id'])->select();
            }
        }
        $param = Db::table('plan_param')->where('plan_id',$id)->select();
        $this->assign('param',$param);
        return $this->fetch('plan/edit',['list'=>$list,'cate'=>$cate]);
    }
    public function update(){
    	//一级分类
        $cate = Db::table('cate')->where('id',$_POST['cate_id'])->find();
        
      
    	//删除原有参数
//     	DB::table('plan_param')->where('plan_id',$_POST['id'])->delete();
//     	//新增参数
//         foreach($_POST['param'] as $k => $param){
//             $cate_name = Db::table('cate_param')->field('name')->where('id',$k)->find();
//             $dd['name'] = $cate_name['name'];
//             $dd['value'] = $param;
//             $dd['plan_id'] = $_POST['id'];
//             $dd['param_id'] = $k;
//             Db::table('plan_param')->insert($dd);
//         }
        
        
    	//判断是否有新图片上传
        $size = $_FILES['image']['size'];
        if($size == '0'){
            $result = Db::table('plan')->where('id', $_POST['id'])->update(['name' => $_POST['name'],'parent_cate_id'=>$cate['parent_id'],'cate_id'=>$_POST['cate_id'],'content'=>$_POST['content'],'status'=>1]);
            
            $this->success('修改成功','/service/plan/apply');
            
        }else{
            $file = $_FILES["image"]["tmp_name"];//获取的上传的临时文件
            $type = substr(strrchr($_FILES["image"]["name"], '.'), 1);  
            $name = time().rand(1,9999).".".$type;   
            $path=$_SERVER['DOCUMENT_ROOT'].'/image/service/'; 
            $res = move_uploaded_file($file ,$path.$name)? 'ok' : 'false';  
            if($res == 'ok'){
                $img = '/service/'.$name;
                $result = Db::table('plan')->where('id', $_POST['id'])->update(['name' => $_POST['name'],'parent_cate_id'=>$cate['parent_id'],'cate_id'=>$_POST['cate_id'],'content'=>$_POST['content'],'image'=>$img,'status'=>1]);
                if($result){
                    $this->success('修改成功','/service/plan/apply');
                }else{
                    $this->error('修改失败','/service/plan/edit?id='.$_POST['id']);
                }
            }else{
                $this->error('文件上传失败','/service/plan/edit?id='.$_POST['id']);
            }
        }
    }

    /**
	* 修改参数
    */
    public function param(){
    	$plan_id = $_GET['plan_id'];
    	$cate_id = $_GET['cate_id'];
    	$plan_name = $_GET['plan_name'];
        //当前分类找上级分类
        $ids = [];
        $cate = Db::table('cate')->where('id',$cate_id)->find();
        $ids[] = $cate['parent_id'];
        $ids[] = $cate_id;
        //判断是不是到头了
        $res = Db::table('cate')->where('id',$cate['parent_id'])->find();
        if($res['parent_id']!='0'){
            $ids[] = $res['parent_id'];
        }
        $ids = implode(',',$ids);

    	//1.判断下面的参数是否已生成-没有的生成，有的显示出来
    	$param = Db::table('cate_param')->where('cate_id','in',$ids)->select();
    	//已经生成的参数
    	$old_param = Db::table('plan_param')->where('plan_id',$plan_id)->field('name')->select();
    	$arr = [];
    	foreach($old_param as $old){
    		$arr[] = $old['name'];
    	}
		foreach($param as $k => $vo){
			if (in_array($vo['name'], $arr)){
				//已生成，不做重复添加操作
			}else{
				$dd['name'] = $vo['name'];
				$dd['param_id'] = $vo['id'];
				$dd['plan_id'] = $plan_id;
				$res = Db::name('plan_param')->insert($dd);
			}
		}
    	//2.读取出所有的参数-修改
    	$param_list = Db::table('plan_param')->where('plan_id',$plan_id)->select();
    	return $this->fetch('plan/param',['param_list'=>$param_list,'plan_id'=>$plan_id,'plan_name'=>$plan_name]);
    }
    public function param_update(){
    	$param = $_POST['param'];
    	$plan_id = $_POST['plan_id'];
    	foreach($param as $k => $vo){
    		$result = Db::table('plan_param')->where('id', $k)->update(['value' => $vo]);
    	}
    	$this->success('修改成功','/service/plan/param?plan_id='.$plan_id.'&cate_id='.$_POST['cate_id'].'&plan_name='.$_POST['plan_name']);
    }
}
