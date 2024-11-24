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
            <form action="{{URL('employee/proccessedit/' . $employee->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Name <b style="color:red;">*</b></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{Request::old('name') ? Request::old('name') : $employee->name}}">
                        <div style="color:red;">{{$errors->first('name')}}</div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email <b style="color:red;">*</b></label>
                        <input type="text" class="form-control" id="email" name="email" value="{{Request::old('email') ? Request::old('email') : $employee->email}}">
                        <div style="color:red;">{{$errors->first('email')}}</div>
                    </div>
                    <div class="form-group">
                        <label for="employee_id">Employee ID <b style="color:red;">*</b></label>
                        <input type="text" class="form-control" id="employee_id" name="employee_id" value="{{Request::old('employee_id') ? Request::old('employee_id') : $employee->employee_id}}">
                        <div style="color:red;">{{$errors->first('employee_id')}}</div>
                    </div>
                    <div class="form-group">
                        <label for="birth_city">Birth City </label>
                        <input type="text" class="form-control" id="birth_city" name="birth_city" value="{{Request::old('birth_city') ? Request::old('birth_city') : $employee->birth_city}}">
                        <div style="color:red;">{{$errors->first('birth_city')}}</div>
                    </div>
                    <div class="form-group">
                        <label for="birth">Birth</label>
                        <input type="date" style="width:250px" class="form-control" id="birth" name="birth" value="{{Request::old('birth') ? Request::old('birth') : $employee->birth}}">
                        <div style="color:red;">{{$errors->first('birth')}}</div>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{Request::old('phone') ? Request::old('phone') : $employee->phone}}">
                        <div style="color:red;">{{$errors->first('phone')}}</div>
                    </div>
                    <div class="form-group">
                        <label for="gander">Gander </label>
                        <select class="form-control border-0" style="background-color: #F1F2F4;" name="gander" id="gander">
                            <option value="">Choose Gender</option>
                            <option value="male" {{ (Request::old('gander') == 'male') || $employee->email ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ (Request::old('gander') == 'female') || $employee->email ? 'selected' : '' }}>Female</option>
                        </select>
                        <div style="color:red;">{{$errors->first('gander')}}</div>
                    </div>
                    <div class="form-group">
                        <label for="address">Address </label>
                        <input type="text" class="form-control" id="address" name="address" value="{{Request::old('address') ? Request::old('address') : $employee->address}}">
                        <div style="color:red;">{{$errors->first('address')}}</div>
                    </div>
                    <div class="form-group">
                        <label for="id_card_number">ID Card Number </label>
                        <input type="text" class="form-control" id="id_card_number" name="id_card_number" value="{{Request::old('id_card_number') ? Request::old('id_card_number') : $employee->id_card_number}}">
                        <div style="color:red;">{{$errors->first('id_card_number')}}</div>
                    </div>
                    <img src="{{$employee->id_card_image}}" alt="">
                    <div class="form-group">
                        <label for="id_card_image">ID Card Image </label>
                        <input type="file" class="form-control" id="id_card_image" name="id_card_image" value="{{Request::old('id_card_image') ? Request::old('id_card_image') : $employee->id_card_image}}">
                        <div style="color:red;">{{$errors->first('id_card_image')}}</div>
                    </div>
                </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                    <a href="/employee" class="btn btn-sm btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection