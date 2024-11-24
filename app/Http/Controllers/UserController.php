<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Storage;

class UserController extends Controller
{
    public function index(Request $request) {
        $filters = [
            'search'         => $request->search ? $request->search : '',
            'delete'         => 0,
        ];

        $user = new User;

        $data['user_view'] = $user->filter($filters)
                                        ->orderBy('created_at', 'asc')
                                        ->paginate(10);

        $currentPage = $request->input('page', 1);
        $data['no'] = ($currentPage - 1) * 10;

        return view('user.view', $data);
    }
    public function edit($user) {
        $data['user'] = User::where('id', $user)->first();
        return view('user.edit', $data);
    }

    public function proccessedit(Request $request, $user) {
        $this->validate($request, [
            'name'              => 'required',
            'email'             => 'required',
        ]);

        $users = User::where('id', $user)->first();

        if ($request->hasFile('avatar')) {
            // Banner

            $path = str_replace('/storage', '', $users->avatar);
            $check = Storage::disk('public')->exists($path);
            if($check) {
                $delete = Storage::disk('public')->delete($path);
            }

            $filenameWithExt = $request->file('avatar')->getClientOriginalName();
            $fileName  = 'user';
            $extension = $request->file('avatar')->getClientOriginalExtension();
            $fileName_ = $fileName . '-' . str_replace(' ','-',$request->employee_id) . '-' . time();
            $store = $request->file('avatar')->storeAs('public/'. 'user/', $fileName_ . '.' . $extension);
            $banner_image = 'public/' . 'user/' . $fileName_ . '.' . $extension;
            $newPathBanner = '/storage/' . 'user/'.  $fileName_ . '.' . $extension;
        } else {
            $newPathBanner = $users->avatar;
        }

        $data = [
            'name'              => $request->name,
            'email'             => $request->email,
            'avatar'            => $newPathBanner,
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => NULL,
        ];

        User::where('id', $user)->update($data);

        toastify()->success('Successfully added Testimonial!');
        return redirect('user');
    } 
    public function delete($user) {
        $data = [
            'is_delete'     => 1,
            'deleted_at'    => date('Y-m-d H:i:s'),
        ];

        User::where('id', $user)->update($data);

        toastify()->success('Successfully deleted Banner event!');
        return redirect('user');
    }
    public function updateStatus(User $user, Request $request, $status)
    {
        if($status == 'active'){
            $user->is_active  = 1;
            $user->updated_at = date('Y-m-d H:i:s');
            $user->save();
            return redirect('user');
            
        } else {
            $user->is_active  = 0;
            $user->updated_at = date('Y-m-d H:i:s');
            $user->save();
            return redirect('user');

        }
    }
}
