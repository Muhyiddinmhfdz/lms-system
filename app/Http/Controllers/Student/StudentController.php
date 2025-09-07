<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Departement;
use App\Models\Education;
use App\Models\StudentDetail;
use App\Models\User;
use Elegant\Sanitizer\Sanitizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    //
    public function index()
    {
        $educations = Education::where('is_active',1)->get();
        return view('student.index',compact('educations'));
    }

    public function data(Request $request)
    {
        $education_id = $request->education_id;

        $data = User::with('student_detail.education')->whereHas('roles', function ($q) {
                $q->where('name', 'Student');
            })
            ->when($education_id, function ($query, $education_id) {
                $query->where('education_id', $education_id);
            });

        return DataTables::of($data)->make(true);
    }

    public function profile(User $user)
    {
        $user->load('student_detail.departement');
        $education = Education::where('is_active',1)->get();
        // return $user;
        return view('student.profile',compact('user','education'));
    }

    public function get_education(Education $education)
    {
        $data = Departement::where('education_id',$education->id)->where('is_active',1)->get();
        return response()->json(['status'=>true,'data'=>$data], 200);
    }

    public function update(User $user,Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'username' => [
                'required',
                Rule::unique('users')->ignore($user->id)
            ],
            'email' => [
                'required',
                Rule::unique('users')->ignore($user->id)
            ],
            'place_of_birth'=>'required',
            'date_of_birth'=>'required',
            'gender'=>'required',
            'number_phone'=>'required',
            'address'=>'required',
            'education_id'=>'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>false,'data'=>$this->validationErrorsToString($validator->errors())], 200);
        }

        $filters = [
            'customer_id'=>'trim|escape',
            'username'=>'trim|escape',
            'name'=>'trim|escape',
            'place_of_birth'=>'trim|escape',
            'date_of_birth'=>'trim|escape',
            'gender'=>'trim|escape',
            'number_phone'=>'trim|escape',
            'address'=>'trim|escape',
            'education_id'=>'trim|escape',
            'departement_id'=>'trim|escape',
        ];
        $sanitizer  = new Sanitizer($request->all(), $filters);
        $attrclean=$sanitizer->sanitize();

        try{
            DB::beginTransaction();
            $user->email=$attrclean['email'];
            $user->username=$attrclean['username'];

            if(!is_null($attrclean['password'])){
                $user->password=Hash::make($attrclean['password']);
            }

            $user->save();

            // profile picture
            if ($request->hasFile('profile_path')) {
                $pathProfile = 'profile_picture' . '/' . date("Y") . '/' . date("m") . '/' . date("d");
                $fileProfile=$request->profile_path;
                $filenamehash = Hash::make(pathinfo($fileProfile->getClientOriginalName(), PATHINFO_FILENAME));
                $extension = $fileProfile->getClientOriginalExtension();
                $path = $fileProfile->storeAs($pathProfile, $filenamehash . '.' . $extension, 'public');
                $profile_path = '/storage/'.$path;
            }


            // update or create student_detail
            StudentDetail::updateOrCreate(
                ['user_id' => $user->id], // kondisi
                [
                    'name'            => $attrclean['name'],
                    'place_of_birth'  => $attrclean['place_of_birth'],
                    'date_of_birth'   => $attrclean['date_of_birth'],
                    'gender'          => $attrclean['gender'],
                    'number_phone'    => $attrclean['number_phone'],
                    'address'         => $attrclean['address'],
                    'education_id'    => $attrclean['education_id'],
                    'departement_id'  => $attrclean['departement_id'],
                    'path_profile'   => $profile_path ?? ($user->student_detail->profile_path ?? null),
                ]
            );

            DB::commit();
        }catch(\Exception $e){
            Log::error($e);
            DB::rollback();
            dd($e);
            return response()->json(['status'=>false,'data'=>$e], 200);
        }
        return response()->json(['status'=>true,'data'=>$user], 200);

    }
}
