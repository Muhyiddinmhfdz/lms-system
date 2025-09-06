"use strict";

var KTDatatablesServerSide = function () {
    // Shared variables
    var table;
    var dt;
    var filterPayment;

    // Private functions
    var initDatatable = function () {
        dt = $("#kt_datatable_departement").DataTable({
            responsive: !0,
            searchDelay: 500,
            processing: !0,
            serverSide: !0,
            ajax: {
                url: base_url+"/master/departement/data",
                type: "GET",
                data:function(data){
                    data.name = $('#search_departement').val();
                }
            },
            columns: [
                { data: 'id' },
                { data: 'education.name' },
                { data: 'name' },
                { data: 'is_active' },
                { data: 'updated_at' },
                { data: 'id' },
            ],
            columnDefs: [
                {
                    targets: 0,
                    width: "10px",
                    orderable: false,
                    render: function (data, type, row, meta) {
                        // console.log(meta.row+1);
                        return meta.row+1;
                    },
                },
                {
                    targets: [1,2],
                    className: 'text-center',
                },
                {
                    targets: -2,
                    className: 'text-center',
                    render: function(data, type, full, meta){
                        return moment(data).format('D MMMM YYYY');
                    }
                },
                {
                    targets: -3,
                    className: 'text-center',
                    render: function (data, type, row) {
                        var s = {
                            0: {
                                title: "Tidak Aktif",
                                class: " badge badge-light-danger"
                            },
                            1: {
                                title: "Aktif",
                                class: " badge badge-light-success"
                                
                            }
                        };
                        return void 0 === s[data] ? data : '<span class="' + s[data].class + '">' + s[data].title + "</span>"
                    },
                },
                {
                    targets: -1,
                    width: "75px",
                    data: null,
                    orderable: false,
                    className: 'text-end',
                    render: function (data, type, row) {
                        let statusButton = ``;

                        if (row.is_active == 1) {
                            statusButton = `
                                <a href="javascript:void(0)" onclick="changeStatus(${data});">
                                    <button id="button_delete_user" class="btn p-1">
                                        <i class="las la-trash fs-2"></i>
                                    </button>
                                </a>`;
                        } else if (row.is_active == 0) {
                            statusButton = `
                                <a href="javascript:void(0)" onclick="changeStatus(${data});">
                                    <button id="button_delete_user" class="btn p-1">
                                        <i class="las la-check-circle fs-2"></i>
                                    </button>
                                </a>`;
                        }

                        return `
                            <div class="d-flex flex-row align-items-center">
                                <a href="javascript:void(0)" onclick="editPlatform(${data});">
                                    <button id="button_edit_category" class="btn p-1">
                                        <i class="las la-edit fs-2"></i>
                                    </button>
                                </a>
                                ${statusButton}
                            </div>
                        `;
                    },
                },

            ]
        });

    }

    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = function () {
        const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');
        filterSearch.addEventListener('keyup', delay(function (e) {
            dt.search(e.target.value).draw();
        },1000));
    }
    // Public methods
    return {
        init: function () {
            initDatatable();
            handleSearchDatatable();
        }
    }
}();

var KTInsertItem = function() {
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
                    'education_id': {
                        validators: {
                            notEmpty: {
                                message: 'Pendidikan Tidak Boleh Kosong'
                            },
                        }
                    },		 		
                    'name': {
                        validators: {
                            notEmpty: {
                                message: 'Nama Tidak Boleh Kosong'
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
            validator.validate().then(function(status) {
                if (status == 'Valid') {
                    // Show loading indication
                    submitButton.setAttribute('data-kt-indicator', 'on');
                    // Disable button to avoid multiple click 
                    submitButton.disabled = true;
    
                    $.ajax({
                        type: "POST",
                        url: base_url+"/master/departement/insert",
                        data : {
                            'education_id' : $('#education_id').val(),
                            'name' : $('#name').val(),
                            '_token' :csrf_token
                        },
                        success: function(response){
                            if(response.status==true){
								swal.fire({
									text: "Jurusan berhasil disimpan!",
                                    icon: "success",
                                    buttonsStyling: false,
                                    timer: 1500,
									showConfirmButton: false,
								})
                                .then(() => {
                                    $('#kt_datatable_departement').DataTable().ajax.reload();
                                    $('#kt_modal_add_departement').modal('hide');
                                    submitButton.setAttribute('data-kt-indicator', 'off');
                                    submitButton.disabled = false;
                                    $('#kt_docs_form_add_departement')[0].reset();
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
                            .then(() => {
                                // Show loading indication
                                submitButton.setAttribute('data-kt-indicator', 'off');
                                // Disable button to avoid multiple click 
                                submitButton.disabled = false;
                            })
                        }
                    });		
                } else {
                    Swal.fire({
                        text: "Maaf, Lengkapi form terlebih dahulu",
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
            form = document.querySelector('#kt_docs_form_add_departement');
            submitButton = document.querySelector('#kt_docs_form_add_suppplier_submit');
            handleForm();
        }
    };
}();

var KTEditItem = function() {
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
                    'education_id_edit': {
                        validators: {
                            notEmpty: {
                                message: 'Pendidikan Tidak Boleh Kosong'
                            },
                        }
                    },		 
                    'name_edit': {
                        validators: {
                            notEmpty: {
                                message: 'Nama Tidak Boleh Kosong'
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
            validator.validate().then(function(status) {
                if (status == 'Valid') {
                    // Show loading indication
                    submitButton.setAttribute('data-kt-indicator', 'on');
                    // Disable button to avoid multiple click 
                    submitButton.disabled = true;
    
                    $.ajax({
                        type: "POST",
                        url: base_url+"/master/departement/update/"+$('#departement_id').val(),
                        data : {
                            'name' : $('#name_edit').val(),
                            'education_id' : $('#education_id_edit').val(),
                            '_token' :csrf_token
                        },
                        success: function(response){
                            if(response.status==true){
								swal.fire({
									text: "Jurusan berhasil disimpan!",
                                    icon: "success",
                                    buttonsStyling: false,
                                    timer: 1500,
									showConfirmButton: false,
								})
                                .then(() => {
                                    $('#kt_datatable_departement').DataTable().ajax.reload();
                                    $('#kt_modal_edit_departement').modal('hide');
                                    submitButton.setAttribute('data-kt-indicator', 'off');
                                    submitButton.disabled = false;
                                    $('#kt_docs_form_edit_departement')[0].reset();
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
                            .then(() => {
                                // Show loading indication
                                submitButton.setAttribute('data-kt-indicator', 'off');
                                // Disable button to avoid multiple click 
                                submitButton.disabled = false;
                            })
                        }
                    });		
                } else {
                    Swal.fire({
                        text: "Maaf, Lengkapi form terlebih dahulu",
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
            form = document.querySelector('#kt_docs_form_edit_departement');
            submitButton = document.querySelector('#kt_docs_form_edit_departement_submit');
            handleForm();
        }
    };
}();

jQuery(document).ready((function() {
    KTDatatablesServerSide.init();
    KTInsertItem.init();
    KTEditItem.init();
}));

function editPlatform(Id){
    $.ajax({
        type: "GET",
        url: base_url+'/master/departement/detail/'+Id,
        success: function(response){
            if(response.status==true){
                $('#departement_id').val(response.data.id);
                $('#name_edit').val(response.data.name);
                $("#education_id_edit").select2().val(response.data.education_id).trigger('change.select2');

                $('#kt_modal_edit_departement').modal('show');
            }
            else{
                swal.fire('Oops...', 'Something went wrong, please try again later!', 'error')
                .then(() => {
                    // jQuery.noConflict();
                    // window.location.reload();
                })
            }
            
        }
    });
}

function changeStatus(iddepartement)
{
    swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data Jurusan akan dirubah statusnya!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, rubah!',
        showLoaderOnConfirm: true,
            
        preConfirm: function() {
            return new Promise(function(resolve) {
                $.ajax({
                    url: base_url+'/master/departement/changeStatus/'+iddepartement,
                    type: 'POST',
                    data : {'_method' : 'POST', '_token' :csrf_token},
                    dataType: 'json'
                }).done(function(response){
                    swal.fire({
                        title: "Sukses",
                        text: "Data Jurusan berhasil dirubah statusnya!",
                        timer: 1500,
                        showConfirmButton: false,
                        icon: 'success'
                    }).then(function(){ 
                            $('#kt_datatable_departement').DataTable().ajax.reload();
                        }
                    );
                }).fail(function(){
                        swal.fire('Oops...', 'Something went wrong, please try again !', 'error');
                    });
            });
        },allowOutsideClick: false			  
    });	
}