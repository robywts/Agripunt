@extends('layouts.custom_app')

@section('content')

<div class="col-md-12 ">
    <div class="row">
        <div class="page-title">
            Manage Users
        </div>
        <div class="bread-crumbs"><!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Manage Users</li>
            </ol>
        </div>
    </div>
</div>

<!-- Example DataTables Card-->
<div class="card mb-3">

    <div class="card-body">
        <div class="table-responsive">     

            <div class="col-md-6 float-right pr0 mb15">
                <!--                <div class="col-sm-12 col-md-12 float-right text-right pr0">
                                    <div id="dataTables-example_filter" class="dataTables_filter table-top-search"><input type="search" class="form-control form-control-sm" placeholder="Search Users" aria-controls="dataTables-example"></div><a class="btn btn-primary table-top-btn" href="invite_users.html">Invite Users</a>
                                </div>-->

            </div>

            <table class="table table-bordered" id="users-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Posts</th>
                        <th>Action</th>

                    </tr>

                </thead>
                <tfoot>
                    <tr class="table-search">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>


<script src="{{ asset('custom_style/datatable/jquery-1.12.3.js') }}"></script>
<script src="{{ asset('custom_style/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('custom_style/datatable/dataTables.bootstrap.min.js') }}"></script>
<script>
$(function () {
    var oTable = $('#users-table').DataTable({
        bProcessing: true,
        serverSide: true,
        /* sDom           : 'p', */
        // dom            : 'Bfrtip',
        ajax: {
            url: '{!! route("users.data") !!}',
            data: function (d) {

            }
        },
        columns: [
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'status', name: 'status', render: function (data, type, full, meta) {
                    return data == 1 ? "Active" : "In Active";
                }},
            {data: 'posts', name: 'posts'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        initComplete: function () {
            $('.dataTables_filter input[type="search"]').attr('placeholder', 'Search Users').css(
                    {}
            );
            var r = $('#users-table tfoot tr');

            $('#users-table thead').append(r);

            this.api().columns([0, 1, 2]).every(function () {
                var column = this;
                var input = document.createElement("input");
//                    $('input').each(
//                            function (index) {
//                                alert();
////                                if (index == 2)
////                                    $('input').attr('placeholder', '0 for Active and 1 for in');
//                            }
//                    )

                $(input).appendTo($(column.footer()).empty())
                        .on('change', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });
            });
        }
    });
});
</script>

@endsection

