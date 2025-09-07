
"use strict";

function generateSlug() {
    let title = document.getElementById("title").value;
    let slug = title
        .toLowerCase()                 // huruf kecil semua
        .replace(/[^a-z0-9\s-]/g, '')  // buang karakter aneh
        .trim()                        // hilangkan spasi depan & belakang
        .replace(/\s+/g, '-')          // ganti spasi dengan "-"
        .replace(/-+/g, '-');          // ganti double "--" jadi single "-"
    
    document.getElementById("slug").value = slug;
}

$(document).ready(function () {
    $('#kt_docs_repeater_basic').repeater({
        initEmpty: false,

        defaultValues: {
            'text-input': 'foo'
        },

        show: function () {
            $(this).slideDown();
        },

        hide: function (deleteElement) {
            $(this).slideUp(deleteElement);
        }
    });
});


var KTInsertUser = function() {
    // Elements
    var form;
    var submitButton;
    var validator;
    var passwordMeter;

    // Handle form
    var handleForm = function(e) {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator = FormValidation.formValidation(
            form,
            {
                fields: {		
                    'title': {
                        validators: {
                            notEmpty: {
                                message: 'Judul wajib diisi'
                            },
                        }
                    },
                    'path_thumbnail': {
                        validators: {
                            notEmpty: {
                                message: 'Thumbnail wajib diisi'
                            },
                            file: {
                                extension: 'jpg,jpeg',
                                type: 'image/jpeg',
                                maxSize: 2097152,
                                message: 'Thumbnail harus berupa JPG dan maksimal 2MB'
                            },
                            callback: {
                                message: 'Ukuran gambar harus 16:9',
                                callback: function(input) {
                                    if (!input.value) {
                                        return true;
                                    }
                                    return new Promise(function(resolve) {
                                        let file = input.files[0];
                                        if (!file) {
                                            resolve(false);
                                            return;
                                        }
                                        let img = new Image();
                                        img.onload = function() {
                                            let ratio = img.width / img.height;
                                            let expected = 16 / 9;
                                            resolve(Math.abs(ratio - expected) < 0.01);
                                        };
                                        img.onerror = function() { resolve(false); };
                                        img.src = URL.createObjectURL(file);
                                    });
                                }
                            }
                        }
                    },
                    'description': {
                        validators: {
                            notEmpty: {
                                message: 'Deskripsi wajib diisi'
                            },
                        }
                    },
                    'category_course_id': {
                        validators: {
                            notEmpty: {
                                message: 'Kategori wajib dipilih'
                            },
                        }
                    },
                    'language_id': {
                        validators: {
                            notEmpty: {
                                message: 'Bahasa wajib dipilih'
                            },
                        }
                    },
                    'publisher': {
                        validators: {
                            notEmpty: {
                                message: 'Publisher wajib diisi'
                            },
                        }
                    },
                    'working_publisher': {
                        validators: {
                            notEmpty: {
                                message: 'Working Publisher wajib diisi'
                            },
                        }
                    },
                    'level_id': {
                        validators: {
                            notEmpty: {
                                message: 'Level wajib dipilih'
                            },
                        }
                    },
                    'duration': {
                        validators: {
                            notEmpty: {
                                message: 'Durasi wajib diisi'
                            },
                        }
                    },
                    'price': {
                        validators: {
                            notEmpty: {
                                message: 'Harga wajib diisi'
                            },
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }			 
            }
        );

        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            // validator.revalidateField('password');

            validator.validate().then(function(status) {
                if (status == 'Valid') {
                    // Show loading indication
                    submitButton.setAttribute('data-kt-indicator', 'on');
                    // Disable button to avoid multiple click 
                    submitButton.disabled = true;
                    var formData = new FormData(document.querySelector('#kt_docs_formvalidation_input_course'));
    
                    $.ajax({
                        type: "POST",
                        url: base_url+"/course/insert/",
                        data: formData,
                        contentType : false,
                        processData : false,
                        success: function(response){
                            if(response.status==true){
								swal.fire({
									text: "Form has been successfully submitted!",
                                    icon: "success",
                                    buttonsStyling: false,
                                    timer: 1500,
									showConfirmButton: false,
								})
                                .then(() => {
                                    submitButton.setAttribute('data-kt-indicator', 'off');
                                    // Disable button to avoid multiple click 
                                    submitButton.disabled = false;
                                    window.location.replace(base_url+"/course/index");
                                })
                            }else{
                                swal.fire('Oops...', response.data, 'error')
                                .then(() => {
                                    // Show loading indication
                                    submitButton.setAttribute('data-kt-indicator', 'off');
                                    // Disable button to avoid multiple click 
                                    submitButton.disabled = false;

                                })
                            }
                        },
                        error: function(xhr, status, error) {
                            swal.fire('Oops...','Something when wrong', 'error')
                            // swal.fire('Oops...', response.data, 'error')
                            .then(() => {
                                // Show loading indication
                                submitButton.setAttribute('data-kt-indicator', 'off');
                                // Disable button to avoid multiple click 
                                submitButton.disabled = false;
                            })
                        }
                    });		
                } else {
                    // Show error popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                    Swal.fire({
                        text: "Maaf, mohon lengkapi form terlebih dahulu.",
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
            form = document.querySelector('#kt_docs_formvalidation_input_course');
            submitButton = document.querySelector('#kt_docs_formvalidation_select2_submit');
            handleForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTInsertUser.init();
});