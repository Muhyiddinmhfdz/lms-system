@extends('layouts.main_layout',['title'=>'Dashboard' ,'breadcrum'=>[]])

@section('content')
<div class="row g-5 g-xl-10 mb-2 mb-xl-2">
    <!--begin::Alert-->
    <div class="alert alert-primary d-flex align-items-center p-5">
        <!--begin::Icon-->
        <i class="ki-duotone ki-notification-bing fs-2hx text-success me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
        <!--end::Icon-->
        <!--begin::Wrapper-->
        <div class="d-flex flex-column">
            <!--begin::Title-->
            <h4 class="mb-1 text-dark">Selamat Datang {{ Auth::user()->name }}</h4>
            <!--end::Title-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Alert-->
</div>
<div class="card">
</div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/dashboard/index.js') }}"></script>
   
@endsection
