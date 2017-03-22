@extends('layouts.admin')
@section('content')
<h1>Posts</h1>
<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Owner</th>
            <th>Photo</th>
            <th>title</th>
            <th>Category</th>
            <th>Created</th>
            <th>Updated</th>
        </tr>
    </thead>
    <tbody>
        @if($posts)
            @foreach($posts as $post)
            <tr>
                <td>{{$post->id}}</td>
                <td>{{$post->user->name}}</td>
                <td> <img height="30" src="{{$post->photo ? $post->photo->file : 'http://placehold.it/50x50'}}" alt=""></td>
                <td><a href="{{route('admin.posts.edit', $post->id)}}">{{$post->title}}</a></td>
                <td>{{$post->category != NULL ? $post->category->name : 'User has no category'}}</td>
                <td>{{$post->created_at->diffForHumans()}}</td>
                <td>{{$post->updated_at->diffForHumans()}}</td>
            </tr>
            @endforeach
        @endif
    </tbody>
</table>





@stop