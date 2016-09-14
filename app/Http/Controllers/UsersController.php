<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;

class UsersController extends Controller
{
    //

    public function register(){

        return view('users.register');
    }


    public function store(Requests\UserRegisterRequest $request){
        //dd($request->all());
        $data = [
            'confirm_code'=>str_random(48),
            'avatar'=>'/images/default-avatar.png'
        ];
        //合并数组，保存数据到数据库，重定向到首页
        $user = User::create(array_merge($request->all(),$data));
        //给注册新用户发送邮件
        $subject = 'Confirm Your Email';
        $view = 'email.register';
        $this->sendTo($user, $subject, $view, $data);

        return redirect('/');
    }

    // 用户收到验证邮箱的邮件时，点击邮件内连接就执行该方法
    public function confirmEmail($confirm_code){
        $user = User::where('confirm_code', $confirm_code)->first();
        if(is_null($user)){
            return redirect('/');
        }
        $user->is_confirmed = 1;
        $user->confirm_code = str_random(48);
        $user->save();
        return redirect('user/login');
    }
    //发送邮件方法
    public function sendTo($user, $subject, $view, $data=[]){
        // 发送邮件或者使用 \Mail::send
        Mail::queue($view, $data, function($message) use($user, $subject){

            $message->to($user->email)->subject($subject);

        });

    }

    public function login(){

        return view('users.login');

    }

    public function signin(Requests\UserLoginRequest $request){
        //使用验证方法Auth，邮箱验证才能登录
        if(\Auth::attempt([
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'is_confirmed' => 1
        ])){
            return redirect('/');
        }
        \Session::flash('user_login_failed', '密码不正确或邮箱没有验证');

        return redirect('/user/login')->withInput(); //用户输入的内容重新携带回去

    }

    //更换头像视图
    public function avatar(){

        return view('users.avatar');
    }
    //处理提交更换头像
    public function changeAvatar(Request $request){

        $file = $request->file('avatar'); //接收上传头像图片数据
        //检验图片，上传的图片格式必须是image类型
        $input = array('image' => $file);
        $rules = array(
            'image' => 'image'
        );
        //检验规则
        $validator = \Validator::make($input, $rules);
        if ( $validator->fails() ) {
            return \Response::json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }

        $destinationPath = 'uploads/';   //指定保存用户头像图片文件夹
        $filename = \Auth::user()->id.'_'.time().$file->getClientOriginalName(); //拿到上传图片名
        $file->move($destinationPath, $filename);  //将上传的图片移到指定的目录下
        Image::make($destinationPath.$filename)->fit(400)->save(); //裁剪图片200*200像素

        //返回json数据
        return \Response::json([
            'success' => true,
            'avatar' => asset($destinationPath.$filename),
            'image' => $destinationPath.$filename
        ]);

    }
    //处理裁剪头像
    public function cropAvatar(Request $request){
        //接收到图片裁剪后数据
        $photo = $request->get('photo');
        $width = (int) $request->get('w');
        $height = (int) $request->get('h');
        $xAlign = (int) $request->get('x');
        $yAlign = (int) $request->get('y');
        //裁剪图片，修改头像数据保存数据库里
        Image::make($photo)->crop($width,$height,$xAlign,$yAlign)->save();
        $user = \Auth::user();
        $user->avatar = asset($photo);
        $user->save();

        return redirect('/user/avatar');
    }




    //退出登录
    public function logout(){

        \Auth::logout();
        return redirect('/');

    }









}
