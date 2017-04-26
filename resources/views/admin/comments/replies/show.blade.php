@extends('layouts.admin')
@section('content')

@if(count($replies) > 0)
<h1>{{$comment->id}} - Comments</h1>
<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Post</th>
            <th>Author</th>
            <th>email</th>
            <th>Comment</th>
            <th>Action</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach($replies as $reply)       
        <tr>
            <td>{{$reply->id}}</td>
            <td><a href="{{route('home.post', $comment->post->id)}}">{{$comment->post->title}}</a></td>
            <td>{{$reply->author}}</td>
            <td>{{$reply->email}}</td>
            <td>{{$reply->body}}</td>
            <td>
                @if($reply->is_active == 1)
                {!! Form::open(['method'=>'PATCH', 'action'=>['CommentRepliesController@update', $reply->id]]) !!}
                <input type="hidden" name='is_active'value="0">
                <div class="form-group">
                    {!! Form::submit('Bann',['class'=>'btn btn-warning']) !!}
                </div> 
                {!! Form::close() !!}
                @else
                {!! Form::open(['method'=>'PATCH', 'action'=>['CommentRepliesController@update', $reply->id]]) !!}
                <input type="hidden" name='is_active'value="1">
                <div class="form-group">
                    {!! Form::submit('Show',['class'=>'btn btn-success']) !!}
                </div> 
                {!! Form::close() !!}
                @endif
            </td>
            <td>
                {!! Form::open(['method'=>'DELETE', 'action'=>['CommentRepliesController@destroy', $reply->id]]) !!}
                <div class="form-group">
                    {!! Form::submit('DELETE',['class'=>'btn btn-danger']) !!}
                </div> 
                {!! Form::close() !!}
            </td>

        </tr>
        @endforeach
    </tbody>
</table>
@else
<h1 class="text-center">No replies</h1>
@endif

@stop