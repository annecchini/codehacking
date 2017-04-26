@extends('layouts.admin')
@section('content')

@if(Session::has('deleted_media'))
<p class="bg-danger">{{session('deleted_media')}}</p>
@endif

<h1>Media</h1>

@if($photos)
<form action="delete/media" method="POST" class="form-inline">
    {{csrf_field()}}
    {{method_field('delete')}}
    <div class="form-group">
        <select name="checkBoxArray" id="">
            <option value="delete">Delete</option>
        </select>
    </div>
    <div class="form-group">
        <input type="submit" class="btn-primary" value="Vai!">
    </div>
    <table class="table">
        <thead>
            <tr>
                <th><input type="checkbox" id="options"></th>
                <th>Id</th>
                <th>Name</th>
                <th>Created</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($photos as $photo)
            <tr>
                <td><input class="checkBoxes" type="checkbox" name="checkBoxArray[]" value="{{$photo->id}}"></td>
                <td>{{$photo->id}}</td>
                <td><img  height="50" src="{{$photo->file}}" alt=""></td>
                <td>{{$photo->created_at ? $photo->created_at : 'no date'}}</td>
                <td>
                    {!! Form::open(['method'=>'DELETE', 'action'=>['AdminMediasController@destroy', $photo->id]]) !!}
                    {!! Form::submit('Delete',['class'=>'btn btn-danger']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</form>
@endif



@stop

@section('scripts')
<script>
    $(document).ready(function () {
        $('#options').click(function () {

            if (this.checked) {
                $('.checkBoxes').each(function () {
                    this.checked = true;
                });
            } else {
                $('.checkBoxes').each(function () {
                    this.checked = false;
                });
            }
            console.log('works');
        });
    });
</script>
@stop