@extends('layouts.main_layout',['title'=>'Detail Student' ,'breadcrum'=>['Student - '.$user->name]])
@section('css')
<style>
    .image-input-placeholder {
        background-image: url("{{ asset('assets/media/svg/avatars/blank.svg') }}");
    }

    [data-bs-theme="dark"] .image-input-placeholder {
        background-image: url("{{ asset('assets/media/svg/avatars/blank.svg') }}");
    }
</style>
@endsection
@section('content')
<form id="kt_docs_formvalidation_input_student_detail" class="form" autocomplete="off">
@csrf
    <input type="hidden" name="user_id" id="user_id" value="{{ $user->id}}">
    {{-- Data Akun --}}
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <div class="card-title">
                <h3 class="fw-bold">Informasi Akun</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <!--begin::Image input-->
                    <div class="image-input image-input-outline mb-3" data-kt-image-input="true" style="width:120px; height:160px; background-image: url({{ asset('assets/media/svg/avatars/blank.svg') }})">
                        <!--begin::Image preview wrapper-->
                        <div class="image-input-wrapper" 
                            style="width:120px; height:160px; background-image: url({{ asset($user->student_detail->path_profile ?? 'assets/media/svg/avatars/blank.svg') }})">
                        </div>
                        <!--end::Image preview wrapper-->
                        <!--begin::Edit button-->
                        <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Change avatar">
                            <i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span class="path2"></span></i>
                            <!--begin::Inputs-->
                            <input type="file" name="profile_path" id="profile_path" accept=".png, .jpg, .jpeg" />
                            <input type="hidden" name="avatar_remove" />
                            <!--end::Inputs-->
                        </label>
                        <!--end::Edit button-->

                        <!--begin::Cancel button-->
                        <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Cancel avatar">
                            <i class="ki-outline ki-cross fs-3"></i>
                        </span>
                        <!--end::Cancel button-->

                        <!--begin::Remove button-->
                        <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Remove avatar">
                            <i class="ki-outline ki-cross fs-3"></i>
                        </span>
                        <!--end::Remove button-->
                    </div>
                    <!--end::Image input-->

                </div>
                <div class="col-md-10">
                    <div class="row mb-6">
                        <div class="col-lg-6 mb-5 fv-row">
                            <label class="required fw-semibold fs-6 mb-2">Nama</label>
                            <input type="text" name="name" id="name" class="form-control form-control-solid" placeholder="Nama" value="{{ $user->name ?? '' }}" />
                        </div>
                        <div class="col-lg-6 mb-5 fv-row">
                            <label class="required fw-semibold fs-6 mb-2">Username</label>
                            <input type="text" name="username" id="username" class="form-control form-control-solid" placeholder="Username" value="{{ $user->username ?? '' }}" />
                        </div>
                        <div class="col-lg-4 mb-5 fv-row">
                            <label class="required fw-semibold fs-6 mb-2">Email</label>
                            <input type="text" name="email" id="email" class="form-control form-control-solid" placeholder="Email" value="{{ $user->email ?? '' }}" />
                        </div>
                        <div class="col-lg-4 mb-5 fv-row">
                            <label class="required fw-semibold fs-6 mb-2">Password</label>
                            <input type="password" name="password" id="password" class="form-control form-control-solid" placeholder="Password Login" value="" />
                        </div>
                        <div class="col-lg-4 mb-5 fv-row">
                            <label class="required fw-semibold fs-6 mb-2">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-solid" placeholder="Konfirmasi Password Login" value="" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Data Pribadi --}}
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <div class="card-title">
                <h3 class="fw-bold">Informasi Pribadi</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-6">
                <div class="col-lg-6 mb-5 fv-row">
                    <label class="required fw-semibold fs-6 mb-2">Tempat Lahir</label>
                    <input type="text" name="place_of_birth" id="place_of_birth" class="form-control form-control-solid" placeholder="Tempat Lahir" value="{{ $user->student_detail->place_of_birth ?? '' }}" />
                </div>
                <div class="col-lg-6 mb-5 fv-row">
                    <label class="required fw-semibold fs-6 mb-2">Tanggal Lahir</label>
                    <input type="text" name="date_of_birth" id="date_of_birth" class="form-control form-control-solid" placeholder="Tanggal Lahir" value="{{ $user->student_detail->date_of_birth ?? '' }}" />            
                </div>
                <div class="col-lg-4 mb-5 fv-row">
                    <label class="required fw-semibold fs-6 mb-2">Alamat</label>
                    <input type="text" name="address" id="address" class="form-control form-control-solid" placeholder="Alamat" value="{{ $user->student_detail->address ?? '' }}" />
                </div>
                <div class="col-lg-4 mb-5 fv-row">
                    <label class="required fw-semibold fs-6 mb-2">No.HP</label>
                    <input type="text" name="number_phone" id="number_phone" class="form-control form-control-solid" placeholder="No.HP" value="{{ $user->student_detail->number_phone ?? '' }}" />            
                </div>
                <div class="col-lg-4 mb-5 fv-row">
                    <label class="required fw-semibold fs-6 mb-2">Jenis Kelamin</label>
                    <select class="form-select" data-control="select2" name="gender" id="gender" data-placeholder="Pilih Jenis Kelamin">
                        <option></option>
                        <option value="L" @if(($user->student_detail->gender ?? '')=='L') selected @endif>Laki-Laki</option>
                        <option value="P" @if(($user->student_detail->gender ?? '')=='P') selected @endif>Perempuan</option>
                    </select>                    
                </div>
                <hr class="mt-2 mb-2">
                <div class="col-lg-6 mb-5 fv-row">
                    <label class="required fw-semibold fs-6 mb-2">Pendidikan</label>
                    <select class="form-select" id="education_id" name="education_id"
                            data-user-dept="{{ $user->student_detail->departement_id ?? '' }}"
                            data-user-dept-name="{{ $user->student_detail->departement->name ?? '' }}">
                        <option></option>
                        @foreach ($education as $educations)
                            <option value="{{ $educations->id }}" 
                                {{ isset($user->student_detail->education_id) && $user->student_detail->education_id == $educations->id ? 'selected' : '' }}>
                                {{ $educations->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-6 mb-5 fv-row">
                    <label class="required fw-semibold fs-6 mb-2">Jurusan</label>
                    <select class="form-select" id="departement_id" name="departement_id">
                        <option></option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-5 mb-xl-10 p-3">
        <div class="text-center">
            <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
            <button id="kt_docs_formvalidation_select2_submit" type="submit" class="btn btn-primary">
                <span class="indicator-label">Simpan</span>
                <span class="indicator-progress">
                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
        </div>
    </div>
</form>
@endsection

@section('script')
    <script src="{{ asset('assets/js/student/profile.js') }}"></script>
@endsection