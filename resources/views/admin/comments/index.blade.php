@extends('layouts.admin')
@section('content')

@if(count($comments) > 0)
<h1>Comments</h1>
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
        @foreach($comments as $comment)       
        <tr>
            <td>{{$comment->id}}</td>
            <td><a href="{{route('home.post', $comment->post->slug)}}">{{$comment->post->title}}</a></td>
            <td>{{$comment->author}}</td>
            <td>{{$comment->email}}</td>
            <td>{{$comment->body}}</td>
            <td>
                @if($comment->is_active == 1)
                {!! Form::open(['method'=>'PATCH', 'action'=>['PostCommentsController@update', $comment->id]]) !!}
                <input type="hidden" name='is_active'value="0">
                <div class="form-group">
                    {!! Form::submit('Bann',['class'=>'btn btn-warning']) !!}
                </div> 
                {!! Form::close() !!}
                @else
                {!! Form::open(['method'=>'PATCH', 'action'=>['PostCommentsController@update', $comment->id]]) !!}
                <input type="hidden" name='is_active'value="1">
                <div class="form-group">
                    {!! Form::submit('Show',['class'=>'btn btn-success']) !!}
                </div> 
                {!! Form::close() !!}
                @endif
            </td>
            <td>
                {!! Form::open(['method'=>'DELETE', 'action'=>['PostCommentsController@destroy', $comment->id]]) !!}
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
<h1 class="text-center">No comments</h1>
@endif

@stop