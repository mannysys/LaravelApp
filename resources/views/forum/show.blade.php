@extends('app')


@section('content')

    <div class="jumbotron">
        <div class="container">
            <div class="media">
                <div class="media-left">
                    <a href="#">
                        <img class="media-object img-circle" src="{{ $discussion->user->avatar }}" alt="64x64" style="width: 64px;height: 64px;"/>
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading">
                        {{ $discussion->title }}

                        @if(Auth::check() && Auth::user()->id == $discussion->user_id)
                            <a class="btn btn-danger btn-lg pull-right" href="/discussions/{{$discussion->id}}/edit" role="button">修改帖子</a>
                        @endif

                    </h4>
                    {{ $discussion->user->name }}
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-9" role="main">
                <div class="blog-post">
                    {!! $html !!}
                </div>
                <hr>
                @foreach($discussion->comments as $comment)
                <div class="media">
                    <div class="media-left">
                        <a href="">
                            <img class="media-object img-circle" src="{{ $comment->user->avatar }}" alt="64x64" style="width: 64px; height: 64px;"/>
                        </a>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">{{ $comment->user->name }}</h4>
                        {{ $comment->body }}
                    </div>
                </div>
                @endforeach
                <hr>
                {{-- 检测用户是否登录--}}
                @if(Auth::check())
                {{-- 提交评论 --}}
                {!! Form::open(['url'=>'/comment']) !!}

                {!! Form::hidden('discussion_id',$discussion->id ) !!}
                <div class="form-group">
                    {!! Form::textarea('body', null, ['class'=>'form-control']) !!}
                </div>
                <div>
                    {!! Form::submit('发表评论',['class'=>'btn btn-success pull-right']) !!}
                </div>
                {!! Form::close() !!}
                @else
                    <a href="/user/login" class="btn btn-block btn-success">登录参与评论</a>
                @endif
            </div>
        </div>
    </div>

@stop