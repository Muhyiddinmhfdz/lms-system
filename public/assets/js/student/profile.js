// Inisialisasi date picker
$("#date_of_birth").flatpickr();

// Pastikan script dijalankan saat DOM siap
$(document).ready(function(){

    // ====== 1️⃣ Select2 ======
    $('#education_id').select2({ placeholder: 'Pilih Pendidikan' });
    
    // User departement_id dari data attribute atau global variable
    let userDeptId = $('#education_id').data('user-dept') || null;
    let userDeptName = $('#education_id').data('user-dept-name') || null;

    // Inisialisasi Select2 untuk departement_id kosong
    $('#departement_id').select2({ placeholder: 'Pilih Jurusan' });

    // ====== 2️⃣ Load departement jika ada pendidikan terpilih ======
    if($('#education_id').val()){
        change_departement(userDeptId);
    }

    // ====== 3️⃣ Saat education_id berubah ======
    $('#education_id').on('change', function(){
        change_departement(null); // reset jurusan
    });

});

// ====== 4️⃣ Fungsi change_departement ======
function change_departement(selectedId = null)
{
    var education_id = $('#education_id').val();

    // Jika tidak ada pendidikan, kosongkan dropdown
    if(!education_id) {
        $('#departement_id').empty().append('<option></option>').trigger('change');
        return;
    }

    $.ajax({
        type: "GET",
        url: base_url+'/student/get_education/'+education_id,
        success: function(response){
            if(response.status==true){

                // Kosongkan dropdown dulu
                $('#departement_id').empty().append('<option></option>');

                // Tambahkan semua option
                $.each(response.data, function(index, item) {
                    $('#departement_id').append(
                        $('<option>', { value: item.id, text: item.name })
                    );
                });

                // Init / refresh Select2
                $('#departement_id').select2({ placeholder: 'Pilih Jurusan' });

                // Set default selected jika ada
                if(selectedId){
                    $('#departement_id').val(selectedId).trigger('change');
                }

            } else {
                Swal.fire('Oops...', 'Something went wrong!', 'error');
            }
        },
        error: function(xhr){
            let msg = xhr.responseJSON?.data || 'Something went wrong';
            Swal.fire('Oops...', msg, 'error');
        }
    });
}

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
                    'name': {
                        validators: {
                            notEmpty: {
                                message: 'Nama wajib diisi'
                            },
                        }
                    },		 	
                    'username': {
                        validators: {
                            notEmpty: {
                                message: 'Username wajib diisi'
                            },
                        }
                    },		 
                    'email': {
                        validators: {
                            notEmpty: {
                                message: 'Email wajib diisi'
                            },
                        }
                    },		 
                    'place_of_birth': {
                        validators: {
                            notEmpty: {
                                message: 'Tempat Lahir wajib diisi'
                            },
                        }
                    },		 
                    'date_of_birth': {
                        validators: {
                            notEmpty: {
                                message: 'Tanggal Lahir wajib diisi'
                            },
                        }
                    },	 
                    'number_phone': {
                        validators: {
                            notEmpty: {
                                message: 'No.HP wajib diisi'
                            },
                        }
                    },	 
                    'gender': {
                        validators: {
                            notEmpty: {
                                message: 'Gender wajib diisi'
                            },
                        }
                    },	 
                    'address': {
                        validators: {
                            notEmpty: {
                                message: 'Alamat wajib diisi'
                            },
                        }
                    },
                    'education_id': {
                        validators: {
                            notEmpty: {
                                message: 'Pendidikan wajib diisi'
                            },
                        }
                    },
                    'password_confirmation': {
                        validators: {
                            identical: {
                                compare: function () {
                                    return form.querySelector('[name="password"]').value;
                                },
                                message: 'Password dan konfirmasi tidak sama'
                            }
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
                    var formData = new FormData(document.querySelector('#kt_docs_formvalidation_input_student_detail'));
    
                    $.ajax({
                        type: "POST",
                        url: base_url+"/student/update/"+$('#user_id').val(),
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
                                    window.location.replace(base_url+"/student/profile/"+$('#user_id').val());
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
                            // swal.fire('Oops...','Something when wrong', 'error')
                            swal.fire('Oops...', response.data, 'error')
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
            form = document.querySelector('#kt_docs_formvalidation_input_student_detail');
            submitButton = document.querySelector('#kt_docs_formvalidation_select2_submit');
            handleForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTInsertUser.init();
});