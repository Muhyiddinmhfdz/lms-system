<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\User;
use Elegant\Sanitizer\Sanitizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    //
    public function index()
    {
        $roles=Role::get();
        $permissions=Permission::get();
        
        return view('master.user.index',compact('roles','permissions'));
    }

    public function data(Request $request)
    {
        $user = User::select(['id', 'name', 'username', 'email', 'created_at', 'updated_at'])
        ->whereHas('roles', function ($q) {
            $q->where('name', '!=', 'Student');
        });

    // Filter opsional by name
    if (!is_null($request->name)) {
        $user->where('name', 'like', '%' . $request->name . '%');
    }

    return DataTables::of($user)
        ->addColumn('role', function ($user) {
            return $user->roles->first()->name 
                ? ucfirst($user->roles->first()->name) 
                : '-';
        })
        ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required|unique:users,name',
            'email'=>'required|unique:users,email',
            'username'=>'required|unique:users,username',
            'password'=>'required|confirmed',
            'role'=>'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>false,'data'=>$this->validationErrorsToString($validator->errors())], 200);
        }

        $filters = [
            'name'=>'trim|escape|capitalize',
            'email'    =>  'trim|escape',
            'username'    =>  'trim|escape',
            'password'    =>  'trim|escape',
            'role'    =>  'trim|escape',
        ];
        $sanitizer  = new Sanitizer($request->all(), $filters);
        $attrclean=$sanitizer->sanitize();
        $attrclean['hash']=md5($attrclean['username']);
        $attrclean['password']=Hash::make($attrclean['password']);

        $user=User::create($attrclean);

        $user->assignRole($attrclean['role']);

        return response()->json(['status'=>true,'data'=>$user], 200);
    }

    public function show(User $user)
    {
        $user->load('roles');
        $permissions = $user->getPermissionNames();
        return response()->json(['status' => true, 'data' => $user,'permissions'=>$permissions], 200);
    }

    public function update(User $user, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>[
                'required',
                Rule::unique('users')->ignore($user->id)
            ],
            'username'=>[
                'required',
                Rule::unique('users')->ignore($user->id)
            ],
            'email'=>[
                'required',
                Rule::unique('users')->ignore($user->id)
            ],
            'role_id'=>'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>false,'data'=>$this->validationErrorsToString($validator->errors())], 200);
        }

        $filters = [
            'name'=>'trim|escape|capitalize',
            'username'    =>  'trim|escape',
            'email'    =>  'trim|escape',
            'password'    =>  'trim|escape',
            'role_id'    =>  'trim|escape',
            'regional_office'    =>  'trim|escape',
            'permission'    =>  'trim|escape',
        ];
        $sanitizer  = new Sanitizer($request->all(), $filters);
        $attrclean=$sanitizer->sanitize();
        if(!is_null($attrclean['password'])){
            $attrclean['password']=Hash::make($attrclean['password']);
        }

        $user->name=$attrclean['name'];
        $user->username=$attrclean['username'];
        $user->email=$attrclean['email'];
        (!is_null($attrclean['password']))?$user->password=$attrclean['password']:'';

        $user->save();
        $user->syncRoles($attrclean['role_id']);

        return response()->json(['status'=>true,'data'=>$user], 200);
    }

    public function delete(User $user)
    {
        $user->delete();
        return response()->json(['status' => true, 'data' => $user], 200);
    }
}
