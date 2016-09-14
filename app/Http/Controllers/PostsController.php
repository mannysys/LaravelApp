<?php

namespace App\Http\Controllers;

use App\Discussion;
use App\Markdown\Markdown;
use Illuminate\Http\Request;

use App\Http\Requests;
use EndaEditor;

class PostsController extends Controller
{

    protected $markdown;

    //
    //检查以下方法，是否用户登录过
    public function __construct(Markdown $markdown){
        $this->middleware('auth', ['only'=>['create','store','edit','update']]);

        $this->markdown = $markdown;
    }

    public function index(){
        //获取帖子数据以最新时间排序
        $discussions = Discussion::latest()->get();
        return view('forum.index', compact('discussions'));

    }

    public function show($id){

        $discussion = Discussion::findOrFail($id);
        //使用markdown解析内容
        $html = $this->markdown->markdown($discussion->body);

        return view('forum.show',compact('discussion', 'html'));

    }

    //发表帖子页视图
    public function create(){

        return view('forum.create');

    }
    //处理发表帖子提交的数据
    public function store(Requests\StoreBlogPostRequest $request){

        $data = [
            'user_id'=>\Auth::user()->id,
            'last_user_id'=>\Auth::user()->id,
        ];
        $discussion = Discussion::create(array_merge($request->all(), $data));

        // action 跳转控制器
        return redirect()->action('PostsController@show', ['id'=>$discussion->id]);

    }

    //显示修改帖子的数据视图
    public function edit($id){

        $discussion = Discussion::findOrFail($id);
        //如果该用户不是发帖者的用户就重定向首页
        if(\Auth::user()->id !== $discussion->user_id){
            return redirect('/');
        }

        return view('forum.edit', compact('discussion'));

    }
    //更新帖子内容
    public function update(Requests\StoreBlogPostRequest $request, $id){

        $discussion = Discussion::findOrFail($id);
        $discussion->update($request->all());

        return redirect()->action('PostsController@show', ['id'=>$discussion->id]);

    }

    //处理markdown上传图片
    public function upload(){

        // endaEdit 为你 public 下的目录
        $data = EndaEditor::uploadImgFile('uploads');

        return json_encode($data);

    }



}
















