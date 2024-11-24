@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-6">
                        <strong>Transaction</strong>
                    </div>
                    <div class="col-sm-6 d-flex justify-content-end">
                        <div class="right-align">
                            <a class="btn btn-sm btn-success" href="/transaction/add">Add</a>
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
                            <th class="nowrap align-midle text-center">User</th>
                            <th class="nowrap align-midle text-center">Amount</th>
                            <th class="nowrap align-midle text-center">Status</th>
                            <th class="nowrap align-midle text-center" width="200px"></th>
                            <th class="nowrap align-midle text-center" width="200px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($transaction))
                            @foreach($transaction as $trans)
                                <tr>
                                    <td class="nowrap align-midle text-center">{{++$i}}</td>
                                    <td class="nowrap align-midle text-center">{{isset($trans->user->name) ? $trans->user->name : ''}}</td>
                                    <td class="nowrap align-midle text-center">{{$trans->amount}}</td>
                                    <td class="nowrap align-midle text-center">{{$trans->status}}</td>
                                    <td class="nowrap align-midle text-center">
                                        <a class="btn btn-sm btn-primary" href="/transaction/edit/{{$trans->id}}">Edit</a>
                                    </td>
                                    <td class="nowrap align-midle text-center">
                                        <a class="btn btn-sm btn-danger" href="/transaction/delete/{{$trans->id}}">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <br/>
        {{ $transaction->appends(Request::except('page'))->links() }}
    </div>
</div>
@endsection