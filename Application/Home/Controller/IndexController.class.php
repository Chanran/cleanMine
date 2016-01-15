<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        	$this->display();
    }
    public function game(){
              $this->assign('user',session('user'));
    	$this->display();
    }

    public function registerNameCheck(){
              $user = M('user');
              $name = I('post.name',null,'htmlspecialchars');
              $user_id_number = $user->where(array('name' => $name))->count();
              if ($user_id_number != 0){
                $data['register_code'] = 0;
                $data['error_msg'] = '昵称已经被使用！';
              }else{
                $data['register_code'] = 1;
                $data['msg'] = '昵称未注册！';
              }

        $this->ajaxReturn($data);
    }

    public function registerCheck(){
    	$user = M('User');
              $name = I('post.name',null,'htmlspecialchars');
              $user_id_number = $user->where(array('name' => $name))->count();
              if ($user_id_number != 0){
                $data['register_code'] = 0;
                $data['error_msg'] = '昵称已经被使用！';
              }else{
                if ($action = $user->create()){
                            $data['register_code'] = 1;
                            $data['msg'] = '注册成功';
                            $data['url'] = 'index.php/Home/Index/game';
                            $user->cost_time = 0;
                            $user->mine_num = 0;
			    $user->create_time = date('YmdHis');
                            $user->register_time = date('YmdHis');
                            $user->pwd = md5(I('post.pwd',null,'htmlspecialchars'));
                            $user->add();
                            session('user',$name);
                 }else{
                            $data['register_code'] = 0;
                            $data['error_msg'] = $user->getError();
                }
              }
                        

    	$this->ajaxReturn($data);
    }


    public function loginNameCheck(){
              $user = M('user');
              $name = I('post.name',null,'htmlspecialchars');
              $user_id_number = $user->where(array('name' => $name))->count();
              if ($user_id_number != 0){
                $data['login_code'] = 1;
                $data['msg'] = "昵称存在";
              }else{
                $data['login_code'] = 0;
                $data['error_msg'] = '昵称不存在或者昵称错误！';
              }

        $this->ajaxReturn($data);
    }

    public function loginCheck(){
        $user = M('user');
        $name = I('post.name',null,'htmlspecialchars');
        $pwd = md5(I('post.pwd',null,'htmlspecialchars'));
        $user_id_number = $user->where(array('name' => $name,'pwd' => $pwd))->count();
        if ($user_id_number == 0){
            $data['login_code'] = 0;
            $data['error_msg'] = "密码错误！";

        }else{
            $data['login_code'] = 1;
            $data['msg'] = "登录成功！";
            $data['url'] = U('Home/Index/game');
            session('user',$name);
        }

        $this->ajaxReturn($data);
    }

    public function createRecord(){
        $user = M('user');
        if ($action = $user->create()){
            $user->create_time = date("Ymd");
            $result = $user->where(array('name' => I('post.name')))->save();
            if(false !== $result){
                $data['code'] = 1;
                $data['msg'] = '数据写入成功！';
            }else{
                $data['code'] = 0;
                $data['error_msg'] = '数据写入失败！';
            }
        }else{
            $data['code'] = 0;
            $data['error_msg'] = '数据写入失败！';
        }

        $this->ajaxReturn($data);
    }

    public function rank(){
        
        $user = M('user');
        $data = $user->field('name,cost_time,mine_num,create_time')->order('cost_time desc')->select();
        $this->assign('data',$data);
        $this->display();
    }
}
