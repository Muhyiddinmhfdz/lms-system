"use strict";

var KTDatatablesServerSide = function () {
    // Shared variables
    var table;
    var dt;
    var filterPayment;

    // Private functions
    var initDatatable = function () {
        dt = $("#kt_datatable_course").DataTable({
            responsive: !0,
            searchDelay: 500,
            processing: !0,
            serverSide: !0,
            ajax: {
                url: base_url+"/course/data",
                type: "GET",
                data:function(data){
                    data.name = $('#search_category_course').val();
                }
            },
            columns: [
                { data: 'id' },
                { data: 'title' },
                { data: 'category.name' },
                { data: 'is_publish' },
                { data: 'created_at' },
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
                    targets: -2,
                    render: function(data, type, full, meta){
                        return moment(data).format('D MMMM YYYY');
                    }
                },
                {
                    targets: -3,
                    render: function (data, type, row) {
                        var s = {
                            0: {
                                title: "Draft",
                                class: " badge badge-light-danger"
                            },
                            1: {
                                title: "Publish",
                                class: " badge badge-light-primary"
                                
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

                        if (row.is_publish == 1) {
                            statusButton = `
                                <a href="javascript:void(0)" onclick="changeStatus(${data});">
                                    <button id="button_delete_user" class="btn p-1">
                                        <i class="las la-trash fs-2"></i>
                                    </button>
                                </a>`;
                        } else if (row.is_publish == 0) {
                            statusButton = `
                                <a href="javascript:void(0)" onclick="changeStatus(${data});">
                                    <button id="button_delete_user" class="btn p-1">
                                        <i class="las la-check-circle fs-2"></i>
                                    </button>
                                </a>`;
                        }

                        return `
                            <div class="d-flex flex-row align-items-center">
                                <a href="course/edit/${row['id']}" onclick="editPlatform(${data});">
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

jQuery(document).ready((function() {
    KTDatatablesServerSide.init();
}));

function changeStatus(id_course)
{
    swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data Course akan dirubah statusnya!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, rubah!',
        showLoaderOnConfirm: true,
            
        preConfirm: function() {
            return new Promise(function(resolve) {
                $.ajax({
                    url: base_url+'/course/changeStatus/'+id_course,
                    type: 'POST',
                    data : {'_method' : 'POST', '_token' :csrf_token},
                    dataType: 'json'
                }).done(function(response){
                    swal.fire({
                        title: "Sukses",
                        text: "Data Course berhasil dirubah statusnya!",
                        timer: 1500,
                        showConfirmButton: false,
                        icon: 'success'
                    }).then(function(){ 
                            $('#kt_datatable_education').DataTable().ajax.reload();
                        }
                    );
                }).fail(function(){
                        swal.fire('Oops...', 'Something went wrong, please try again !', 'error');
                    });
            });
        },allowOutsideClick: false			  
    });	
}