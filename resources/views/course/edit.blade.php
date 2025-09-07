@extends('layouts.main_layout',['title'=>'Course','breadcrum'=>['Edit Course - List Course']])

@section('content')

<form id="kt_docs_formvalidation_input_course" class="form" autocomplete="off">
@csrf
<input type="hidden" name="course_id" id="course_id" value="{{ $course->id }}">

    <div class="card mb-5 mb-xl-10">
        <div class="card-header">
            <div class="card-title">
                <h3 class="fw-bold">Edit Course</h3>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Judul -->
                <div class="col-lg-6 mb-5 fv-row">
                    <label class="required fw-semibold fs-6 mb-2">Judul</label>
                    <input type="text" name="title" id="title" class="form-control" 
                        placeholder="Judul" value="{{ old('title',$course->title) }}" 
                        onkeyup="generateSlug()" />
                </div>
                <!-- Slug -->
                <div class="col-lg-6 mb-5 fv-row">
                    <label class="required fw-semibold fs-6 mb-2">Slug</label>
                    <input type="text" name="slug" id="slug" class="form-control form-control-solid" 
                        placeholder="Slug" value="{{ old('slug',$course->slug) }}" readonly/>
                </div>

                <!-- Thumbnail -->
                <div class="fv-row mb-5">
                    <label class="form-label">Thumbnail:</label>
                    @if($course->path_thumbnail)
                        <div class="mb-3">
                            <img src="{{ asset('storage/'.$course->path_thumbnail) }}" 
                                 alt="Thumbnail" width="200" class="rounded border">
                        </div>
                    @endif
                    <input type="file" name="path_thumbnail" id="path_thumbnail" 
                           class="form-control mb-2 mb-md-0" />
                </div>

                <!-- Deskripsi -->
                <div class="fv-row mb-5">
                    <label class="required fw-semibold fs-6 mb-2">Deskripsi</label>
                    <textarea class="form-control" id="description" 
                              name="description">{{ old('description',$course->description) }}</textarea>
                </div>

                <!-- Kategori -->
                <div class="col-lg-6 mb-5 fv-row">
                    <label class="required fw-semibold fs-6 mb-2">Kategori</label>
                    <select class="form-select" data-control="select2" name="category_course_id" id="category_course_id">
                        <option></option>
                        @foreach ($category as $categorys)
                            <option value="{{ $categorys->id }}" 
                                {{ $course->category_course_id == $categorys->id ? 'selected' : '' }}>
                                {{ $categorys->name }} 
                            </option>
                        @endforeach
                    </select>            
                </div>

                <!-- Bahasa -->
                <div class="col-lg-6 mb-5 fv-row">
                    <label class="required fw-semibold fs-6 mb-2">Bahasa</label>
                    <select class="form-select" data-control="select2" name="language_id" id="language_id">
                        <option></option>
                        <option value="1" {{ $course->language_id == 1 ? 'selected' : '' }}>Indonesia</option>
                        <option value="2" {{ $course->language_id == 2 ? 'selected' : '' }}>Inggris</option>
                    </select>            
                </div>

                <!-- Publisher -->
                <div class="col-lg-6 mb-5 fv-row">
                    <label class="required fw-semibold fs-6 mb-2">Publish By</label>
                    <input type="text" name="publisher" id="publisher" class="form-control" 
                           value="{{ old('publisher',$course->publisher) }}" />
                </div>

                <!-- Working Publisher -->
                <div class="col-lg-6 mb-5 fv-row">
                    <label class="required fw-semibold fs-6 mb-2">Working Publisher</label>
                    <input type="text" name="working_publisher" id="working_publisher" class="form-control" 
                           value="{{ old('working_publisher',$course->working_publisher) }}" />
                </div>

                <!-- Level -->
                <div class="col-lg-6 mb-5 fv-row">
                    <label class="required fw-semibold fs-6 mb-2">Level</label>
                    <select class="form-select" data-control="select2" name="level_id" id="level_id">
                        <option></option>
                        <option value="1" {{ $course->level_id == 1 ? 'selected' : '' }}>Beginner</option>
                        <option value="2" {{ $course->level_id == 2 ? 'selected' : '' }}>Intermediate</option>
                        <option value="3" {{ $course->level_id == 3 ? 'selected' : '' }}>Advanced</option>
                    </select>            
                </div>

                <!-- Duration -->
                <div class="col-lg-6 mb-5 fv-row">
                    <label class="required fw-semibold fs-6 mb-2">Duration (Hour)</label>
                    <input type="text" class="form-control" name="duration" id="duration" 
                           value="{{ old('duration',$course->duration) }}" data-type="currency"/>
                </div>

                <!-- Price -->
                <div class="col-lg-6 mb-5 fv-row">
                    <label class="required fw-semibold fs-6 mb-2">Price</label>
                    <input type="text" class="form-control" name="price" id="price" 
                           value="{{ old('price',$course->price) }}" data-type="currency"/>
                </div>

                <!-- Discount Price -->
                <div class="col-lg-6 mb-5 fv-row">
                    <label class="fw-semibold fs-6 mb-2">Discount Price</label>
                    <input type="text" name="discount_price" id="discount_price" class="form-control" 
                           value="{{ old('discount_price',$course->discount_price) }}" data-type="currency"/>
                </div>
            </div>

            <hr>
            <p class="text-center">Detail Pembelajaran</p>

            <div class="mb-5">
                <!--begin::Repeater-->
                <div id="kt_docs_repeater_basic">
                    <div class="form-group">
                        <div data-repeater-list="kt_docs_repeater_basic">
                            @foreach($course->details as $detail)
                            <div data-repeater-item>
                                <div class="form-group row">
                                    <input type="hidden" name="id" value="{{ $detail->id }}">
                                    <div class="col-md-4">
                                        <label class="form-label">Sub Title:</label>
                                        <input type="text" name="sub_title" class="form-control" 
                                               value="{{ $detail->sub_title }}" />
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Deskripsi:</label>
                                        <input type="text" name="sub_description" class="form-control" 
                                               value="{{ $detail->description }}" />
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">URL:</label>
                                        <input type="text" name="url" class="form-control" 
                                               value="{{ $detail->url }}" />
                                    </div>
                                    <div class="col-md-4">
                                        <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                            <i class="ki-duotone ki-trash fs-5"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group mt-5">
                        <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                            <i class="ki-duotone ki-plus fs-3"></i> Add
                        </a>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="text-center">
                <a href="{{ route('course.index') }}" class="btn btn-light me-3">Cancel</a>
                <button id="kt_docs_formvalidation_select2_submit" type="submit" class="btn btn-primary">
                    <span class="indicator-label">Update</span>
                    <span class="indicator-progress">
                        Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
</form>

@endsection

@section('script')
    <script src="{{ asset('assets/js/currency-formatting.js') }}"></script>
    <script src="{{ asset('assets/js/course/edit.js') }}"></script>
@endsection