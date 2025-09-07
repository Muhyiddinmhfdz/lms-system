@extends('layouts.main_layout',['title'=>'Course','breadcrum'=>['Create Course - List Create Course']])


@section('content')

<form id="kt_docs_formvalidation_input_course" class="form" autocomplete="off">
@csrf
    {{-- Data Akun --}}
    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <div class="card-title">
                <h3 class="fw-bold">Course</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 mb-5 fv-row">
                    <label class="required fw-semibold fs-6 mb-2">Judul</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Judul" value="" onkeyup="generateSlug()"/>
                </div>
                <div class="col-lg-6 mb-5 fv-row">
                    <label class="required fw-semibold fs-6 mb-2">Slug</label>
                    <input type="text" name="slug" id="slug" class="form-control form-control-solid" placeholder="Slug" value="" readonly/>
                </div>
                <div class="fv-row mb-5">
                    <label class="form-label">Thumbnail:</label>
                    <input type="file" name="path_thumbnail" id="path_thumbnail" class="form-control mb-2 mb-md-0" placeholder="File"/>
                </div>
                <div class="fv-row mb-5">
                    <label class="required fw-semibold fs-6 mb-2">Deskripsi</label>
                    <textarea class="form-control" data-kt-autosize="true" id="description" name="description"></textarea>
                </div>
                <div class="col-lg-6 mb-5 fv-row">
                    <label class="required fw-semibold fs-6 mb-2">Kategori</label>
                    <select class="form-select" data-control="select2" name="category_course_id" id="category_course_id" data-placeholder="Pilih Kategori">
                        <option></option>
                        @foreach ($category as $categorys)
                            <option value="{{ $categorys->id }}">{{ $categorys->name }} </option>
                        @endforeach
                    </select>            
                </div>
                <div class="col-lg-6 mb-5 fv-row">
                    <label class="required fw-semibold fs-6 mb-2">Bahasa</label>
                    <select class="form-select" data-control="select2" name="language_id" id="language_id" data-placeholder="Pilih Bahasa">
                        <option></option>
                        <option value="1">Indonesia</option>
                        <option value="2">Inggris</option>
                    </select>            
                </div>
                <div class="col-lg-6 mb-5 fv-row">
                    <label class="required fw-semibold fs-6 mb-2">Publish By</label>
                    <input type="text" name="publisher" id="publisher" class="form-control" placeholder="Publish By" value=""/>
                </div>
                <div class="col-lg-6 mb-5 fv-row">
                    <label class="required fw-semibold fs-6 mb-2">Working Publisher</label>
                    <input type="text" name="working_publisher" id="working_publisher" class="form-control" placeholder="Working Publisher" value=""/>
                </div>
                <div class="col-lg-6 mb-5 fv-row">
                    <label class="required fw-semibold fs-6 mb-2">Level</label>
                    <select class="form-select" data-control="select2" name="level_id" id="level_id" data-placeholder="Pilih Level">
                        <option></option>
                        <option value="1">Beginner</option>
                        <option value="2">Intermediate</option>
                        <option value="3">Advanced</option>
                    </select>            
                </div>
                <div class="col-lg-6 mb-5 fv-row">
                    <label class="required fw-semibold fs-6 mb-2">Duration (Hour)</label>
                    <input type="text" class="form-control" name="duration" id="duration" placeholder="Duration (Hour)" value="" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency"/>
                </div>
                <div class="col-lg-6 mb-5 fv-row">
                    <label class="required fw-semibold fs-6 mb-2">Price</label>
                    <input type="text" class="form-control" name="price" id="price" placeholder="Price" value="" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency"/>
                </div>
                <div class="col-lg-6 mb-5 fv-row">
                    <label class="required fw-semibold fs-6 mb-2">Discount Price</label>
                    <input type="text" name="discount_price" id="discount_price" class="form-control" placeholder="Discount Price" value="" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency"/>
                </div>
            </div>
            <hr>
            <p class="text-center">Detail Pembelajaran</p>
            <div class="mb-5">
                <!--begin::Repeater-->
                <div id="kt_docs_repeater_basic">
                    <!--begin::Form group-->
                    <div class="form-group">
                        <div data-repeater-list="kt_docs_repeater_basic">
                            <div data-repeater-item>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label class="form-label">Sub Title:</label>
                                        <input type="text" name="sub_title" id="sub_title" class="form-control" placeholder="Sub Title" value=""/>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Deskripsi:</label>
                                        <input type="text" name="sub_description" id="sub_description" class="form-control" placeholder="Deskripsi" value=""/>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">URL:</label>
                                        <input type="text" name="url" id="url" class="form-control" placeholder="URL" value=""/>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                            <i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                            Delete
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Form group-->

                    <!--begin::Form group-->
                    <div class="form-group mt-5">
                        <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                            <i class="ki-duotone ki-plus fs-3"></i>
                            Add
                        </a>
                    </div>
                    <!--end::Form group-->
                </div>
                <!--end::Repeater-->

            </div>

        <!--begin::Actions-->
            <div class="text-center">
                <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                <button id="kt_docs_formvalidation_select2_submit" type="submit" class="btn btn-primary">
                    <span class="indicator-label">
                        Simpan
                    </span>
                    <span class="indicator-progress">
                        Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
        <!--end::Actions-->
        </div>
    </div>
</div>

@endsection
@section('script')
    <script src="{{ asset('assets/js/currency-formatting.js') }}"></script>
    <script src="{{ asset('assets/js/course/create.js') }}"></script>
@endsection

