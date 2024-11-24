@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-6">
                        <a href="{{URL('employee/')}}"><strong>Employee </strong></a>/
                        <strong>Edit</strong>
                    </div>
                </div>
            </div>
            <form action="{{URL('user/proccessedit/' . $user->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Name <b style="color:red;">*</b></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{Request::old('name') ? Request::old('name') : $user->name}}">
                        <div style="color:red;">{{$errors->first('name')}}</div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email <b style="color:red;">*</b></label>
                        <input type="text" class="form-control" id="email" name="email" value="{{Request::old('email') ? Request::old('email') : $user->email}}">
                        <div style="color:red;">{{$errors->first('email')}}</div>
                    </div>
                    <img src="{{$user->avatar}}" alt="">
                    <div class="form-group">
                        <label for="id_card_image">ID Card Image </label>
                        <input type="file" class="form-control" id="avatar" name="avatar">
                        <div style="color:red;">{{$errors->first('id_card_image')}}</div>
                    </div>
                </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                    <a href="/user" class="btn btn-sm btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection