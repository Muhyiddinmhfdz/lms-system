"use strict";

var KTDatatablesServerSide = function () {
    // Shared variables
    var table;
    var dt;
    var filterPayment;

    // Private functions
    var initDatatable = function () {
        dt = $("#kt_datatable_student").DataTable({
            responsive: !0,
            searchDelay: 500,
            processing: !0,
            serverSide: !0,
            ajax: {
                url: base_url+"/student/data",
                type: "GET",
                data:function(data){
                    data.education_id = $('#education_id').val();
                }
            },
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'student_detail.education.name' },
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
                    targets: -2,
                    className: 'text-center',
                    render: function(data, type, full, meta){
                        return moment(data).format('D MMMM YYYY');
                    }
                },
                {
                    targets: -3,
                    className: 'text-center',
                    render: function(data, type, full, meta){
                        if(data == null)
                        {
                            return '-';
                        }
                        else{
                            return data
                        }
                    }
                },
                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    className: 'text-end',
                    responsivePriority: 1,

                    render: function (data, type, row) {
						var btn="";
                        btn+=`<a href="${base_url}/student/profile/${data}" class="btn p-1"><i class="las la-eye text-danger fs-2"></i></a>`;
                        return btn;
                    },
                },

            ]
        });

    }


    var handleStatusFilter = () => {
        // const filterButton = document.querySelector('[data-kt-ecommerce-product-filter="status"]');
        $('#button_filter').on('click', e => {
            dt.ajax.reload();  //just reload table
        });
    }

    // Public methods
    return {
        init: function () {
            initDatatable();
            handleStatusFilter();
        }
    }
}();
jQuery(document).ready((function() {
    KTDatatablesServerSide.init();
}));
