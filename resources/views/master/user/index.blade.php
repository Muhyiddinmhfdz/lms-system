@extends('layouts.main_layout',['title'=>'Master','breadcrum'=>['User - List User']])

@section('content')
<div class="card mb-0 mb-xxl-0">
    <div class="card-body pt-0 pb-0">
        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
            <li class="nav-item mt-2">
                <a class="nav-link text-active-primary ms-0 me-10 py-5" href="{{ route('master.user.index') }}">
                    User                    </a>
            </li>
            <li class="nav-item mt-2">
                <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="{{ route('master.role.index') }}">
                    Role & Permission                    </a>
            </li>
        </ul>
    </div>
</div>
<!--begin::Col-->
<div class="col-xxl-12">
    <!--begin::Engage widget 10-->
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header mt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1 me-5">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor"></path>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <input type="text" id="search_user_name" data-kt-docs-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Cari User">
                </div>
                <!--end::Search-->
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Button-->
                <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
                <!--begin::Svg Icon | path: icons/duotune/general/gen035.svg-->
                <span class="svg-icon svg-icon-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="5" fill="currentColor"></rect>
                        <rect x="10.8891" y="17.8033" width="12" height="2" rx="1" transform="rotate(-90 10.8891 17.8033)" fill="currentColor"></rect>
                        <rect x="6.01041" y="10.9247" width="12" height="2" rx="1" fill="currentColor"></rect>
                    </svg>
                </span>
                <!--end::Svg Icon-->Tambah User</button>
                <!--end::Button-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Table-->
            <div id="kt_permissions_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="table-responsive">
                    <table id="kt_datatable_user" class="table align-middle table-row-dashed fs-6 gy-5">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th>#</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Diedit Terakhir</th>
                                <th class="text-end min-w-100px">Actions</th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="text-gray-600 fw-semibold">
                        </tbody>
                        <!--end::Table body-->
                    </table>
                </div>
            </div>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Engage widget 10-->
</div>
<!--end::Col-->
<div class="modal fade" tabindex="-1" id="kt_modal_add_user">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Tambah User</h3>
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"/>
                        <rect x="7" y="15.3137" width="12" height="2" rx="1" transform="rotate(-45 7 15.3137)" fill="currentColor"/>
                        <rect x="8.41422" y="7" width="12" height="2" rx="1" transform="rotate(45 8.41422 7)" fill="currentColor"/>
                        </svg>
                    </span>
                </div>
                <!--end::Close-->
            </div>

            <!--begin::Form-->
            <form id="kt_docs_form_add_user" class="form" action="#" autocomplete="off">
                <div class="modal-body">
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Nama user</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" name="name" id="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Nama User" value="" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Email</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="email" name="email" id="email" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Email" value="" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Username</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" name="username" id="username" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Username" value="" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Password</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="password" name="password" id="password" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Password" value="" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Konfirmasi Password</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Password" value="" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Role</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select class="form-select form-select-solid" name="role" id="role" data-control="select2" data-close-on-select="true" data-dropdown-parent="#kt_modal_add_user" data-placeholder="Select an option" data-allow-clear="true">
                            <option></option>
                            @foreach ($roles as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button id="kt_docs_form_add_user_submit" type="submit" class="btn btn-primary">
                        <span class="indicator-label">
                            Simpan
                        </span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>
            <!--end::Form-->
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" id="kt_modal_edit_user">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit User</h3>
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"/>
                        <rect x="7" y="15.3137" width="12" height="2" rx="1" transform="rotate(-45 7 15.3137)" fill="currentColor"/>
                        <rect x="8.41422" y="7" width="12" height="2" rx="1" transform="rotate(45 8.41422 7)" fill="currentColor"/>
                        </svg>
                    </span>
                </div>
                <!--end::Close-->
            </div>

            <!--begin::Form-->
            <form id="kt_docs_form_edit_user" class="form" action="#" autocomplete="off">
                <input type="hidden" name="user_id" id="user_id">
                <div class="modal-body">
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Nama User</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" name="name_edit" id="name_edit" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Nama User" value="" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Email</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="email" name="email_edit" id="email_edit" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Email" value="" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Username</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" name="username_edit" id="username_edit" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Password" value="" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Password</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="password" name="password_edit" id="password_edit" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Password" value="" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Konfirmasi Password</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="password" name="password_confirmation_edit" id="password_confirmation_edit" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Password" value="" />
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="required fw-semibold fs-6 mb-2">Role</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select class="form-select form-select-solid" name="role_edit" id="role_edit" data-control="select2" data-close-on-select="true" data-dropdown-parent="#kt_modal_edit_user" data-placeholder="Select an option" data-allow-clear="true">
                            @foreach ($roles as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button id="kt_docs_form_edit_user_submit" type="submit" class="btn btn-primary">
                        <span class="indicator-label">
                            Simpan
                        </span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>
            <!--end::Form-->
        </div>
    </div>
</div>
    
@endsection
@section('script')
    <script src="{{ asset('assets/js/master/user/index.js') }}"></script>
@endsection
