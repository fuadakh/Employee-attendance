@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-6">
                        <strong>User</strong>
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
                            <th class="nowrap align-midle text-center">Name</th>
                            <th class="nowrap align-midle text-center">Email</th>
                            <th class="nowrap align-midle text-center">Created Date</th>
                            <th class="nowrap align-midle text-center" width="200px">Status</th>
                            <th class="nowrap align-midle text-center" width="200px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($user_view))
                            @foreach($user_view as $user)
                                <tr>
                                    <td class="nowrap align-midle text-center">{{++$no}}</td>
                                    <td class="nowrap align-midle text-center">{{$user->name}}</td>
                                    <td class="nowrap align-midle text-center">{{$user->email}}</td>
                                    <td class="nowrap align-midle text-center">{{ App\Helpers\Custom::changeDBToDatetime($user->created_at) }}</td>
                                    <td class="nowrap align-middle">
												<div class="dropdown text-center">
													<?php
														$class = '';
														$data = '';
														if ($user->is_active == 1 ) {
															$class = 'btn-primary';
															$data = 'Active';
														} else {
															$class = 'btn-danger';
															$data = 'Inactive';
														}
													?>
													<button class="btn btn-sm btn-success dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                        {{$data}}
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                        <a class="dropdown-item {{($data == 'Active') ? 'd-none' : ''}}" href="{{URL('user/status/'.$user->id.'/active')}}">Active</a>
                                                        <a class="dropdown-item {{($data == 'Inactive') ? 'd-none' : ''}}" href="{{URL('user/status/'.$user->id.'/inactive')}}">Inactive</a>
                                                    </div>
												</div>
											</td>
                                    <td class="nowrap text-center align-middle">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-success dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <a class="dropdown-item" href="{{URL('user/' . $user->id)}}">Edit</a>
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
        {{ $user_view->appends(Request::except('page'))->links() }}
    </div>
</div>
<script type="text/javascript">
		$('.modalButton').on('click', function (e) {
			e.preventDefault()
			urlForm = $(this).data('link')
			status  = $(this).data('status')
			type    = $(this).data('type')
			icon    = $(this).data('icon')
			// console.log(urlForm)
			// console.log(status)
			// console.log(type)

			// $("#modalAction").attr('action', urlForm);
			$(".modalStatus").val(status);
			$(".updateBtn").html(type);

			$(".showModal").data('link', urlForm);
			$(".showModal").data('type', type);
			$(".showModal").data('icon', icon);

			if (type === 'Success') {
				$(".updateBtn").addClass('btn-success');
			} else {
				$(".updateBtn").addClass('btn-danger');
			}
		});

		$('.showModal').on('click', function (e) {
			e.preventDefault()
			urlForm = $(this).data('link')
			type    = $(this).data('type')
			icon    = $(this).data('icon')
			message = $("textarea#messageStatus").val()
			// console.log(urlForm)
			// console.log(message)

			Swal.fire({
				title:type + " it The Country",
				text: "Are you sure you want to " + type + " it this Country?",
				icon: icon,
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: "Yes, " + type + " it!"
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						method: 'POST',
						url: urlForm,
						dataType: 'json',
						data: {
							"_token": "{{ csrf_token() }}",
							"_method": "post",
							"message": message,
						},
						beforeSend: function(){
							// $("#btn-save").html(`<div class="alert alert-warning">Waiting...</div>`);
						},
						success: function(data,status,xhr){
							if (data.status) {
								Swal.fire({
									title: `Success!`,
									text: data.message,
									icon: `success`
								})
								.then((afterSuccess) => {
									$("#modalStatus").modal('hide');
									location.reload();
								});
							} else {
								Swal.fire({
									title: `Failed!`,
									text: data.message,
									icon: `error`
								})
								.then((afterSuccess) => {
									// location.reload();
								});
							}
						},
						error: function(data){
							// $("#btn-save").html(`<div class="alert alert-danger">Failed</div>`);
						}
					});
					// Swal.fire(
					//   'Deleted!',
					//   'Data has been deleted.',
					//   'success'
					// )
				}
			})
		})
	</script>
@endsection