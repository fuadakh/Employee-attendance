@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-6">
                        <strong>Employee</strong>
                    </div>
                    <div class="col-sm-6 d-flex justify-content-end">
                        <div class="right-align">
                            <a class="btn btn-sm btn-success" href="{{URL('employee/add')}}">Add</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="">
                    <div class="input-group">
                        <input type="text" name='search' class="form-control" placeholder="search" value="{{Request()->search}}">
                        <span class="input-group-append">
							<button class="btn btn-primary" type="submit"> Search</button>
						</span>
                    </div>
                </form>
                <br>
                <table class="table table-responsive-sm table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th class="nowrap align-midle text-center">No</th>
                            <th class="nowrap align-midle text-center">ID</th>
                            <th class="nowrap align-midle text-center">Name</th>
                            <th class="nowrap align-midle text-center">Email</th>
                            <th class="nowrap align-midle text-center">DoB</th>
                            <th class="nowrap align-midle text-center">City</th>
                            <th class="nowrap align-midle text-center">Created At</th>
                            <th class="nowrap align-midle text-center" width="200px">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($employee_view))
                            @foreach($employee_view as $employee)
                                <tr>
                                    <td class="nowrap align-midle text-center">{{++$no}}</td>
                                    <td class="nowrap align-midle text-center">{{$employee->employee_id}}</td>
                                    <td class="nowrap align-midle text-center">{{$employee->name}}</td>
                                    <td class="nowrap align-midle text-center">{{$employee->email}}</td>
                                    <td class="nowrap align-midle text-center">{{$employee->birth}}</td>
                                    <td class="nowrap align-midle text-center">{{$employee->birth_city}}</td>
                                    <td class="nowrap align-midle text-center">{{ App\Helpers\Custom::changeDBToDatetime($employee->created_at) }}</td>
                                    <td class="nowrap text-center align-middle">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-success dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <a class="dropdown-item" href="{{URL('employee/' . $employee->id)}}">Edit</a>
                                                <a class="dropdown-item" href="{{URL('employee/delete/' . $employee->id)}}">Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="px-3 py-6 text-center">
                                    No Data Available
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <br/>
        {{ $employee_view->appends(Request::except('page'))->links() }}
    </div>
</div>
@endsection