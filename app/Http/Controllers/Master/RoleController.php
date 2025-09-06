<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Elegant\Sanitizer\Sanitizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    //
    public function index()
    {
        $permissions=Permission::all();
        return view('master.role.index',compact('permissions'));
    }

    public function data(Request $request)
    {
        $role = Role::select(['id', 'name', 'created_at', 'updated_at']);

        (!is_null($request->name)) ? $role->where('name','like','%'.$request->name.'%') : '';

        return DataTables::of($role)->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name',
            'permission'=>'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>false,'data'=>$this->validationErrorsToString($validator->errors())], 200);
        }

        $filters = [
            'name'    =>  'trim|escape',
            'permission'    =>  'trim|escape',
        ];

        $sanitizer  = new Sanitizer($request->all(), $filters);
        $attrclean=$sanitizer->sanitize();

        try{
            DB::beginTransaction();

            $role = Role::create([
                'name' => $attrclean['name'], 
            ]);
            
            $role->syncPermissions($attrclean['permission']);

            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            Log::error($e);
            return response()->json(['status'=>false,'data'=>'Cannot Proccess'], 200);
        }

        return response()->json(['status'=>true,'data'=>$role], 200);
    }

    public function detail(Role $role)
    {
        $permissions=$role->permissions->pluck('name');

        $data=array(
            'detail_role' =>$role->makeHidden(['permissions']),
            'role_permission'=>$permissions
        );
        return response()->json(['status'=>true,'data'=>$data], 200);
    }

    public function update(Request $request,Role $role)
    {
        $validator = Validator::make($request->all(), [
            'name'=>[
                'required',
                Rule::unique('roles')->ignore($role->id)
            ],
            'permission'=>'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>false,'data'=>$this->validationErrorsToString($validator->errors())], 200);
        }
        $filters = [
            'name'    =>  'trim|escape',
            'permission'    =>  'trim|escape',
        ];

        $sanitizer  = new Sanitizer($request->all(), $filters);
        $attrclean=$sanitizer->sanitize();

        try{
            DB::beginTransaction();

            $role->name=$attrclean['name'];

            $role->save();

            $role->syncPermissions($attrclean['permission']);

            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            Log::error($e);
            return response()->json(['status'=>false,'data'=>'Cannot Proccess'], 200);
        }

        $data=array(
            'detail_role' =>$role->makeHidden(['permissions']),
            'role_permission'=>$role->permissions->pluck('name')
        );
        
        return response()->json(['status'=>true,'data'=>$data], 200);
    }
}
