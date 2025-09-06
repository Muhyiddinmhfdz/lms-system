@extends('layouts.main_layout',['title'=>'Master','breadcrum'=>['Student - List Student']])

@section('content')
<!--begin::Col-->
<div class="col-xxl-12">
    <!--begin::Engage widget 10-->
    <div class="card card-flush">
        <div class="card-body">
            <div class="mb-0 ">
                @csrf
                <!--begin::Row-->
                <div class="row gx-10 mb-5">
                    <!--begin::Wrapper-->
                    <div class="mb-0">
                        <!--begin::Row-->
                        <div class="row mb-8">
                            <!--begin::Col-->
                            <div class="col-xl-3">
                                <div class="fs-6 fw-semibold mt-2 mb-3">Pendidikan</div>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-xl-9 fv-row fv-plugins-icon-container">
                                <select class="form-select form-control-solid" data-control="select2" data-placeholder="Pendidikan" name="education_id" id="education_id" data-allow-clear="true">
                                    <option value=""></option>
                                    @foreach ($educations as $education)
                                    <option value="{{$education->id}}">{{$education->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::Actions-->
                    <div class="text-end">

                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
                            <button type="button" class="btn btn-primary" id="button_filter">
                                <!--end::Svg Icon-->Filter
                            </button>

                            <!--end::Toolbar-->
                        </div>
                        <!--end::Toolbar-->
                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Row-->
            </div>
        </div>
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Table-->
            <div id="kt_permissions_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="table-responsive">
                    <table id="kt_datatable_student" class="table align-middle table-row-dashed fs-6 gy-5">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th>#</th>
                                <th>Nama</th>
                                <th>Pendidikan</th>
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
    
@endsection
@section('script')
    <script src="{{ asset('assets/js/student/index.js') }}"></script>
@endsection
