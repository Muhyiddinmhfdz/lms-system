@extends('layouts.app_login')

@section('content')
<!--begin::Authentication - Sign-up -->
<div class="d-flex flex-column flex-lg-row flex-column-fluid">
    <!--begin::Aside-->
    <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10 bg-dark">
        <div class="d-flex flex-center flex-lg-start flex-column">
            <a href="{{ url('/') }}" class="mb-7">
                <img alt="Logo" src="{{ asset('assets/media/logos/custom-3.svg') }}" />
            </a>
            <h2 class="text-white fw-normal m-0">Sistem LMS untuk Pembelajaran</h2>
        </div>
    </div>
    <!--end::Aside-->

    <!--begin::Body-->
    <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center p-12 p-lg-20">
        <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
            <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">

                <!-- ✅ Flash message -->
                @if(session('success'))
                    <div class="alert alert-success w-100 text-center">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger w-100">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!--begin::Form-->
                <form class="form w-100" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="text-center mb-11">
                        <h1 class="text-gray-900 fw-bolder mb-3">Sign Up</h1>
                        <div class="text-gray-500 fw-semibold fs-6">Create an account to continue</div>
                    </div>

                    <!-- Nama -->
                    <div class="fv-row mb-8">
                        <input type="text" placeholder="Nama Lengkap" name="name" value="{{ old('name') }}" autocomplete="off" class="form-control bg-transparent" required />
                    </div>

                    <!-- Email -->
                    <div class="fv-row mb-8">
                        <input type="email" placeholder="Email" name="email" value="{{ old('email') }}" autocomplete="off" class="form-control bg-transparent" required />
                    </div>

                    <!-- Username -->
                    <div class="fv-row mb-8">
                        <input type="text" placeholder="Username" name="username" value="{{ old('username') }}" autocomplete="off" class="form-control bg-transparent" required />
                    </div>

                    <!-- Password -->
                    <div class="fv-row mb-8">
                        <input class="form-control bg-transparent" type="password" placeholder="Password" name="password" autocomplete="off" required />
                    </div>

                    <!-- Confirm Password -->
                    <div class="fv-row mb-8">
                        <input class="form-control bg-transparent" type="password" placeholder="Repeat Password" name="password_confirmation" autocomplete="off" required />
                    </div>

                    <!-- Tombol Submit -->
                    <div class="d-grid mb-10">
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Register</span>
                        </button>
                    </div>

                    <!-- Sudah punya akun -->
                    <div class="text-gray-500 text-center fw-semibold fs-6">
                        Already have an account?
                        <a href="{{ route('login') }}" class="link-primary">Login</a>
                    </div>
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
    <!--end::Body-->
</div>
<!--end::Authentication - Sign-up -->
@endsection

@section('script')
<script>
"use strict";

// Form validation (opsional, pakai plugin bootstrap5/formvalidation jika perlu)
var KTRegister = function () {
    var form, submitButton, validator;

    var handleForm = function(e) {
        validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'name': { validators: { notEmpty: { message: 'Nama wajib diisi' } } },
                    'username': { validators: { notEmpty: { message: 'Username wajib diisi' } } },
                    'email': { validators: { notEmpty: { message: 'Email wajib diisi' }, emailAddress: { message: 'Format email tidak valid' } } },
                    'password': { validators: { notEmpty: { message: 'Password wajib diisi' } } },
                    'password_confirmation': { validators: { notEmpty: { message: 'Konfirmasi password wajib diisi' }, identical: { compare: function() { return form.querySelector('[name="password"]').value; }, message: 'Password tidak sama' } } },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({ rowSelector: '.fv-row' })
                }
            }
        );

        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            validator.validate().then(function(status) {
                if (status == 'Valid') {
                    submitButton.setAttribute('data-kt-indicator', 'on');
                    submitButton.disabled = true;
                    form.submit();
                } else {
                    Swal.fire({
                        text: "Ada kesalahan, periksa kembali input Anda.",
                        icon: "error",
                        confirmButtonText: "Ok",
                        customClass: { confirmButton: "btn btn-primary" }
                    });
                }
            });
        });
    };

    return {
        init: function() {
            form = document.querySelector('#kt_sign_in_form') || document.querySelector('form');
            submitButton = form.querySelector('button[type="submit"]');
            handleForm();
        }
    };
}();

KTUtil.onDOMContentLoaded(function() { KTRegister.init(); });
</script>
@endsection