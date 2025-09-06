var KTDatatablesContent = {
    // region
    init_region: function() {
        $("#kt_datatable_role").DataTable({ 
            responsive: !0,
            searchDelay: 500,
            processing: !0,
            serverSide: !0,
            ajax: {
                url: base_url+"/master/role/data",
                type: "GET",
                data:function(data){
                    data.name = $('#search_role_name').val();
                }
            },
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'created_at' },
                { data: 'updated_at' },
                { data: 'id' },
            ],
            columnDefs: [
                {
                    targets: 0,
                    orderable: false,
                    render: function (data, type, row, meta) {
                        // console.log(meta.row+1);
                        return meta.row+1;
                    },
                },
                {
                    targets: [2,3],
                    render: function(data, type, full, meta){
                        return moment(data).format('D MMMM YYYY');
                    }
                },
                {
                    targets: -1,
                    width: "75px",
                    data: null,
                    orderable: false,
                    render: function (data, type, row) {
                        return `<div class="d-flex flex-row align-items-center">
                            <a href="javascript:void(0)" onclick="get_data_role(`+data+`);">
                                <button id="button_edit_category" class="btn p-1">
                                    <i class="las la-edit fs-2"></i>
                                </button>
                            </a>
                        </div>
                        `;
                    },
                },

            ]
        })
    }
};

jQuery(document).ready((function() {
    KTDatatablesContent.init_region();
}));

$('#search_role_name').keyup(delay(function (e) {
    $('#kt_datatable_role').DataTable().ajax.reload();
}, 500));

function get_data_role(id_role){
    $.ajax({
        type: "GET",
        url: base_url+'/master/role/detail/'+id_role,
        success: function(response){
            if(response.status==true){
                $('#role_id').val(response.data.detail_role.id);
                $('#name_edit').val(response.data.detail_role.name);
                $("#permission_edit").select2().val(response.data.role_permission).trigger('change.select2');
            
                $('#kt_modal_edit_role').modal('show');
            }
            else{
                swal.fire('Oops...', 'Ada yang salah, silakan coba lagi!', 'error')
                .then(() => {
                    // jQuery.noConflict();
                    // window.location.reload();
                })
            }
            
        }
    });
}

// Form Add
const form = document.getElementById('kt_docs_form_add_role');

var validator = FormValidation.formValidation(
    form,
    {
        fields: {
            'name': {
                validators: {
                    notEmpty: {
                        message: 'Nama Harus Diisi'
                    }
                }
            },
            'permission': {
                validators: {
                    notEmpty: {
                        message: 'Permission Harus Diisi'
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

// Revalidate Select2 input. For more info, plase visit the official plugin site: https://select2.org/
$(form.querySelector('[name="permission"]')).on('change', function () {
    // Revalidate the field when an option is chosen
    validator.revalidateField('permission');
});

const submitButton = document.getElementById('kt_docs_form_add_role_submit');
submitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (validator) {
        validator.validate().then(function (status) {
            if (status == 'Valid') {
                submitButton.setAttribute('data-kt-indicator', 'on');
                submitButton.disabled = true;

                $.ajax({
                    type: "POST",
                    url: base_url+'/master/role/store',
                    data : {
                        'name' : $('#name').val(),
                        'permission' : $('#permission').val(),
                        '_token' :csrf_token
                    },
                    success: function(response){
                        if(response.status==true){
                            swal.fire({
                                title: "Success",
                                text: "Data Role Berhasil Ditambahkan!",
                                timer: 1500,
                                showConfirmButton: false,
                                icon: 'success'
                            })
                            .then(() => {
                                $('#kt_datatable_role').DataTable().ajax.reload();
                                $('#kt_modal_add_role').modal('hide');
                                submitButton.setAttribute('data-kt-indicator', 'off');
                                submitButton.disabled = false;
                                $('#kt_docs_form_add_role')[0].reset();
                            })
                        }
                        else{
                            swal.fire('Oops...', response.data, 'error')
                            .then(() => {
                                submitButton.setAttribute('data-kt-indicator', 'off');
                                submitButton.disabled = false;
                            })
                        }
                        
                    }
                });
            }
            else{
                Swal.fire({
                    text: "Maaf, Mohon lengkapi form terlebih dahulu.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, Mengerti!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
            }
        });
    }
});

// Form Edit
const form_edit = document.getElementById('kt_docs_form_edit_role');

var validatorEdit = FormValidation.formValidation(
    form_edit,
    {
        fields: {
            'name_edit': {
                validators: {
                    notEmpty: {
                        message: 'Nama Harus Diisi'
                    }
                }
            },
            'permission_edit': {
                validators: {
                    notEmpty: {
                        message: 'Permission Harus Diisi'
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

// Revalidate Select2 input. For more info, plase visit the official plugin site: https://select2.org/
$(form.querySelector('[name="permission_edit"]')).on('change', function () {
    // Revalidate the field when an option is chosen
    validator.revalidateField('permission_edit');
});

const submitButtonEdit = document.getElementById('kt_docs_form_edit_role_submit');
submitButtonEdit.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (validatorEdit) {
        validatorEdit.validate().then(function (status) {
            if (status == 'Valid') {
                submitButtonEdit.setAttribute('data-kt-indicator', 'on');
                submitButtonEdit.disabled = true;

                $.ajax({
                    type: "POST",
                    url: base_url+'/master/role/update/'+$('#role_id').val(),
                    data : {
                        'name' : $('#name_edit').val(),
                        'permission' : $('#permission_edit').val(),
                        '_token' :csrf_token
                    },
                    success: function(response){
                        if(response.status==true){
                            swal.fire({
                                title: "Success",
                                text: "Data Role Berhasil Diupdate!",
                                timer: 1500,
                                showConfirmButton: false,
                                icon: 'success'
                            })
                            .then(() => {
                                $('#kt_datatable_role').DataTable().ajax.reload();
                                $('#kt_modal_edit_role').modal('hide');
                                submitButtonEdit.setAttribute('data-kt-indicator', 'off');
                                submitButtonEdit.disabled = false;
                                $('#kt_docs_form_edit_role').reset();
                            })
                        }
                        else{
                            swal.fire('Oops...', response.data, 'error')
                            .then(() => {
                                submitButtonEdit.setAttribute('data-kt-indicator', 'off');
                                submitButtonEdit.disabled = false;
                            })
                        }
                        
                    }
                });
            }
            else{
                Swal.fire({
                    text: "Maaf, Mohon lengkapi form terlebih dahulu.",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, Mengerti!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
            }
        });
    }
});