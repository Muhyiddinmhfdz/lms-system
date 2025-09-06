@extends('layouts.app_login')

@section('content')
<!--begin::Page bg image-->
<style>
    body {
        background-image: url('{{ asset("assets/media/auth/bg4.jpg") }}');
    }
    [data-bs-theme="dark"] body {
        background-image: url('{{ asset("assets/media/auth/bg4-dark.jpg") }}');
    }
</style>
<!--end::Page bg image-->

<!--begin::Authentication - Sign-in -->
<div class="d-flex flex-column flex-column-fluid flex-lg-row">
    <!--begin::Aside-->
    <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
        <div class="d-flex flex-center flex-lg-start flex-column">
            <!--begin::Logo-->
            <a href="{{ url('/') }}" class="mb-7">
                <img alt="Logo" src="{{ asset('assets/media/lms_system.png') }}" />
            </a>
            <!--end::Logo-->
        </div>
    </div>
    <!--end::Aside-->

    <!--begin::Body-->
    <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
        <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
            <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">

                {{-- Alert Messages --}}
                @if (session('success'))
                    <div class="alert alert-success w-100 text-center mb-5">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger w-100 text-center mb-5">{{ session('error') }}</div>
                @endif

                <!--begin::Form-->
                <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="text-center mb-11">
                        <h1 class="text-gray-900 fw-bolder mb-3">Sign In</h1>
                        <div class="text-gray-500 fw-semibold fs-6">LMS System</div>
                    </div>

                    <!-- Username -->
                    <div class="fv-row mb-8">
                        <input type="text" placeholder="Username" name="username" id="username" autocomplete="off" class="form-control bg-transparent" />
                    </div>

                    <!-- Password -->
                    <div class="fv-row mb-3">
                        <input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent" />
                    </div>

                    <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                        <a href="{{ route('password.request') }}" class="link-primary">Forgot Password ?</a>
                    </div>

                    <div class="d-grid mb-10">
                        <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                            <span class="indicator-label">Sign In</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>

                    <div class="text-gray-500 text-center fw-semibold fs-6">
                        Not a Member yet?
                        <a href="{{ route('register') }}" class="link-primary">Sign up</a>
                    </div>
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
    <!--end::Body-->
</div>
<!--end::Authentication - Sign-in -->
@endsection

@section('script')

<script>
    "use strict";

    // Class definition
    var KTSigninGeneral = function() {
        // Elements
        var form;
        var submitButton;
        var validator;

        // Handle form
        var handleForm = function(e) {
            // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
            validator = FormValidation.formValidation(
                form,
                {
                    fields: {					
                        'username': {
                            validators: {
                                notEmpty: {
                                    message: 'Username is required'
                                },
                            }
                        },
                        'password': {
                            validators: {
                                notEmpty: {
                                    message: 'The password is required'
                                }
                            }
                        } 
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row'
                        })
                    }
                }
            );		

            // Handle form submit
            submitButton.addEventListener('click', function (e) {
                // Prevent button default action
                e.preventDefault();

                // Validate form
                validator.validate().then(function (status) {
                    if (status == 'Valid') {
                        // Show loading indication
                        submitButton.setAttribute('data-kt-indicator', 'on');

                        // Disable button to avoid multiple click 
                        submitButton.disabled = true;
                        form.submit(); // submit form				
                    } else {
                        // Show error popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                        Swal.fire({
                        	text: "Ada kesalahan, periksa kembali input Anda.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }
                });
            });
        }

        // Public functions
        return {
            // Initialization
            init: function() {
                form = document.querySelector('#kt_sign_in_form');
                submitButton = document.querySelector('#kt_sign_in_submit');
                
                handleForm();
            }
        };
    }();

     // On document ready
     KTUtil.onDOMContentLoaded(function() {
         KTSigninGeneral.init();
     });
</script>
@endsection