@extends('layouts.blog-post')

@section('content')

<!-- Blog Post -->

<!-- Title -->
<h1>{{$post->title}}</h1>

<!-- Author -->
<p class="lead">
    by <a href="#title">{{$post->user->name}}</a>
</p>

<hr>

<!-- Date/Time -->
<p><span class="glyphicon glyphicon-time"></span>Posted {{$post->created_at->diffForHumans()}}</p>

<hr>

<!-- Preview Image -->
<img class="img-responsive" src="{{$post->photo ? $post->photo->file: $post->photoPlacehoder}}" alt="">

<hr>

<!-- Post Content -->
<p>{!! $post->body !!}</p>
<hr>

<!-- Blog Comments -->

@if(Session::has('comment_message'))
<p class="bg-warning"> {{session('comment_message')}}</p>
@endif

@if(Auth::check())

<!-- Comments Form -->
<div class="well">
    <h4>Leave a Comment:</h4>

    {!! Form::open(['method'=>'POST', 'action'=>'PostCommentsController@store']) !!}

    <input type="hidden" name='post_id'value="{{$post->id}}">

    <div class="form-group">
        {!! Form::label('body', 'Comment:')!!}
        {!! Form::textarea('body', null, ['class'=>'form-control', 'rows'=>'3']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Submit',['class'=>'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}

</div>

@endif

<hr>

<!-- Posted Comments -->

@if(count($post->comments) > 0 )

@foreach ($post->comments as $comment)
@if ($comment->is_active == "1")
<!-- Comment -->
<div class="media">
    <a class="pull-left" href="#">
        <img height="64" class="media-object" src="{{Auth::user()->gravatar}}" alt="">
    </a>
    <div class="media-body">
        <h4 class="media-heading">{{$comment->author}}
            <small>{{$comment->created_at->diffForHumans()}}</small>
        </h4>
        {{$comment->body}}

        @if( count($comment->replies) > 0 )
        @foreach($comment->replies as $reply)
        @if ($reply->is_active == "1")
        <div id="nested-comment" class="media">
            <a class="pull-left" href="#">
                <img height="64" class="media-object" src="{{$reply->photo}}" alt="">
            </a>
            <div class="media-body">
                <h4 class="media-heading">{{$reply->author}}
                    <small>{{$reply->created_at->diffForHumans()}}</small>
                </h4>
                <p>{{$reply->body}}</p>
            </div>
        </div>
        @endif
        @endforeach
        @endif

        @if(Session::has('comment'.$comment->id.'reply_message'))
        <p class="bg-warning"> {{session('comment'.$comment->id.'reply_message')}}</p>
        @endif

        <div class="comment-reply-container">

            <button class="toggle-reply btn btn-primary pull-right">Show reply form</button>

            <div class="comment-reply-form col-sm-9">

                {!! Form::open(['method'=>'POST', 'action'=>'CommentRepliesController@createReply']) !!}
                <input type="hidden" name='comment_id'value="{{$comment->id}}">
                <div class="form-group">
                    {!! Form::label('body', 'Reply:')!!}
                    {!! Form::textarea('body', null, ['class'=>'form-control', 'rows'=>'1']) !!}
                </div>

                <div class="form-group">
                    {!! Form::submit('Submit',['class'=>'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}

            </div>

        </div>


    </div>
</div>
@endif
@endforeach

<!-- Comment 
<div class="media">
    <a class="pull-left" href="#">
        <img class="media-object" src="http://placehold.it/64x64" alt="">
    </a>
    <div class="media-body">
        <h4 class="media-heading">Start Bootstrap
            <small>August 25, 2014 at 9:30 PM</small>
        </h4>
        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
         Nested Comment 


         var $ = minhaFuncao

         $(this).next()

        <div class="media">
            <a class="pull-left" href="#">
                <img class="media-object" src="http://placehold.it/64x64" alt="">
            </a>
            <div class="media-body">
                <h4 class="media-heading">Nested Start Bootstrap
                    <small>August 25, 2014 at 9:30 PM</small>
                </h4>
                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
            </div>
        </div>
         End Nested Comment 
    </div>
</div>-->

@endif



@stop

@section('scripts')
<script>
    $(".comment-reply-container .toggle-reply").click(function(){
        $(this).next().slideToggle("slow");
    });
</script>

@stop