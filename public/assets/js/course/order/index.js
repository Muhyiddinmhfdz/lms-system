"use strict";

var KTDatatablesServerSide = function () {
    // Shared variables
    var table;
    var dt;
    var filterPayment;

    // Private functions
    var initDatatable = function () {
        dt = $("#kt_datatable_course_order").DataTable({
            responsive: !0,
            searchDelay: 500,
            processing: !0,
            serverSide: !0,
            ajax: {
                url: base_url+"/course/list/data_order",
                type: "GET",
                data:function(data){
                    data.name = $('#search_course_order').val();
                }
            },
            columns: [
                { data: 'id' },
                { data: 'order_code' },
                { data: 'status' },
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
                    targets: 3,
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
                                title: "Belum di Approve",
                                class: " badge badge-light-danger"
                            },
                            1: {
                                title: "Sudah di Approve",
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
						var btn="";
                        btn+=`<a href="${base_url}/course/order/pending/${data}" class="btn p-1"><i class="las la-eye text-danger fs-2"></i></a>`;
                        if (row['status'] == 0 && userRole == 'Super Admin' ) {
                            btn+=`<button onclick="update_order(`+data+`)" class="btn p-1"><i class="las la-check text-danger fs-2"></i></button>`;
                        }
                        return btn;
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


function update_order(order_id)
{
    swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data Order akan di Approve!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Approve!',
        showLoaderOnConfirm: true,
            
        preConfirm: function() {
            return new Promise(function(resolve) {
                $.ajax({
                    url: base_url+'/course/list/update_order/'+order_id,
                    type: 'POST',
                    data : {'_method' : 'POST', '_token' :csrf_token},
                    dataType: 'json'
                }).done(function(response){
                    swal.fire({
                        title: "Sukses",
                        text: "Data Order berhasil diapprove!",
                        timer: 1500,
                        showConfirmButton: false,
                        icon: 'success'
                    }).then(function(){ 
                            $('#kt_datatable_course_order').DataTable().ajax.reload();
                        }
                    );
                }).fail(function(){
                        swal.fire('Oops...', 'Something went wrong, please try again !', 'error');
                    });
            });
        },allowOutsideClick: false			  
    });	
}