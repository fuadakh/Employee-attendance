<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use Storage;

class EmployeeController extends Controller
{
    public function index(Request $request) {
        $filters = [
            'search'         => $request->search ? $request->search : '',
            'delete'         => 0,
        ];

        $employee = new Employee;

        $data['employee_view'] = $employee->filter($filters)
                                        ->orderBy('created_at', 'asc')
                                        ->paginate(10);

        $currentPage = $request->input('page', 1);
        $data['no'] = ($currentPage - 1) * 10;

        return view('employee.view', $data);
    }

    public function add() {
        return view('employee.add');
    }
    public function proccessadd(Request $request) {
        $this->validate($request, [
            'name'              => 'required',
            'email'             => 'required',
            'employee_id'       => 'required|unique:employee,employee_id',
            'id_card_image'        => 'mimes:png,jpg,jpeg',
        ]);

        if ($request->hasFile('id_card_image')) {
            // Banner
            $filenameWithExt = $request->file('id_card_image')->getClientOriginalName();
            $fileName  = 'employee';
            $extension = $request->file('id_card_image')->getClientOriginalExtension();
            $fileName_ = $fileName . '-' . str_replace(' ','-',$request->employee_id) . '-' . time();
            $store = $request->file('id_card_image')->storeAs('public/'. 'employee/', $fileName_ . '.' . $extension);
            $banner_image = 'public/' . 'employee/' . $fileName_ . '.' . $extension;
            $newPathBanner = '/storage/' . 'employee/'.  $fileName_ . '.' . $extension;
        }

        $data = [
            'name'              => $request->name,
            'email'             => $request->email,
            'employee_id'       => $request->employee_id,
            'birth_city'        => $request->birth_city,
            'birth'             => $request->birth,
            'phone'             => $request->phone,
            'gander'            => $request->gander,
            'address'           => $request->address,
            'id_card_number'    => $request->id_card_number,
            'id_card_image'     => $newPathBanner ?? '',
            'is_delete'         => 0,
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => NULL,
            'deleted_at'        => NULL,
        ];

        Employee::create($data);

        toastify()->success('Successfully added Testimonial!');
        return redirect('employee');
    }
    public function edit($employee) {
        $data['employee'] = Employee::where('id', $employee)->first();
        return view('employee.edit', $data);
    }

    public function proccessedit(Request $request, $employee) {
        $this->validate($request, [
            'name'              => 'required',
            'email'             => 'required',
            'employee_id'       => 'required',
        ]);

        $employees = Employee::where('id', $employee)->first();

        if ($request->hasFile('id_card_image')) {
            // Banner

            $path = str_replace('/storage', '', $employees->id_card_image);
            $check = Storage::disk('public')->exists($path);
            if($check) {
                $delete = Storage::disk('public')->delete($path);
            }

            $filenameWithExt = $request->file('id_card_image')->getClientOriginalName();
            $fileName  = 'employee';
            $extension = $request->file('id_card_image')->getClientOriginalExtension();
            $fileName_ = $fileName . '-' . str_replace(' ','-',$request->employee_id) . '-' . time();
            $store = $request->file('id_card_image')->storeAs('public/'. 'employee/', $fileName_ . '.' . $extension);
            $banner_image = 'public/' . 'employee/' . $fileName_ . '.' . $extension;
            $newPathBanner = '/storage/' . 'employee/'.  $fileName_ . '.' . $extension;
        } else {
            $newPathBanner = $employees->id_card_image;
        }

        $data = [
            'name'              => $request->name,
            'email'             => $request->email,
            'employee_id'       => $request->employee_id,
            'birth_city'        => $request->birth_city,
            'birth'             => $request->birth,
            'phone'             => $request->phone,
            'gander'            => $request->gander,
            'address'           => $request->address,
            'id_card_number'    => $request->id_card_number,
            'id_card_image'     => $newPathBanner,
            'is_delete'         => 0,
            'updated_at'        => date('Y-m-d H:i:s'),
        ];

        Employee::where('id', $employee)->update($data);

        toastify()->success('Successfully added Testimonial!');
        return redirect('employee');
    } 
    public function delete($employee) {
        $data = [
            'is_delete'     => 1,
            'deleted_at'    => date('Y-m-d H:i:s'),
        ];

        Employee::where('id', $employee)->update($data);

        toastify()->success('Successfully deleted Banner event!');
        return redirect('employee');
    }
}
