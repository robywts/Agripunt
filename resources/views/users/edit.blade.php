@extends('layouts.custom_app')

@section('content')

<div class="col-md-12 ">
    <div class="row">
        <div class="page-title">         
            Edit Users

        </div>
        <div class="bread-crumbs"><!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="manage_users.html">Manage Users</a>
                </li>
                <li class="breadcrumb-item active">
                    Edit Users
                </li>

            </ol>
        </div>
    </div>
</div>

<!-- if updation success, they will show here -->
@if ($message = Session::get('success'))
<div class="alert alert-success" id="successMessage">
    <p>{{ $message }}</p>
</div>
@endif

<!-- Example DataTables Card-->
<div class="card mb-3">
    <div class="card-body">


        <div class="col-md-12 ">
            <!-- if there are update errors, they will show here -->
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="row">

                <div class="container pr0 mb15 pb10 border-bottom">
                    <div class="col-sm-12 col-md-12 float-right text-right pr0">
                        <!--<a class="btn delete table-top-btn delete-item" href="{{ URL::to('web/user/delete/'.$user->id) }}">Delete User</a>-->
                        <form id ="deleteUser" action="{{ route('users.delete', $user->id) }}" method="POST">
                            {{ csrf_field() }}         
                            <button onclick="return confirm('Are you sure want to delete this User?');" type="submit" class="btn delete table-top-btn delete-item">
                                Delete User</button>
                        </form>


                    </div>

                </div>
                {!! Form::model($user, array('method' => 'PATCH', 'route' => array('users.update', $user->id), 'id' => 'editUsers')) !!}
                <div class="form-group">
                    {{ Form::label('name', 'Name of User',['class' => 'field-title']) }}
                    {{ Form::text('name', null, array('class' => 'common-input', 'placeholder' => 'User Name')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('email', 'User Email',['class' => 'field-title']) }}
                    {{ Form::text('email', null, array('class' => 'common-input', 'placeholder' => 'User Email')) }}
                </div>
                <div class="form-group">
                    <!--                    <label class="field-title">Status</label>
                                        <input type="text" name="status" value="{{ $user->status or old('status') }}" placeholder="User Status"  class="common-input" disabled>
                                        <select name="status" id="status" value="{{ $user->status or old('status') }}" placeholder="User Status" class="common-input">
                                            <option value="" >Choose a status</option>
                                            <option value="0" @if(($user->status or old('status')) == '0') selected="selected" @endif>In Active</option>
                                            <option value="1" @if(($user->status or old('status')) == '1') selected="selected" @endif>Active</option>
                                        </select>-->
                    {{ Form::label('status', 'Choose Status',['class' => 'field-title']) }}
                    {{ Form::select('status', array('' => 'Choose Status', '0' => 'Inactive', '1' => 'Active'), null, array('class' => 'common-input', 'placeholder' => 'User Status')) }}

                </div>

                <div class="">
                    <label class="field-title border-bottom pb10">Posts</label>
                    <div class="table-responsive">

                        <table class="table table-bordered" id="article-table" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Post Name</th>                 
                                    <th>Category/Subject</th>                 
                                    <th>Topic</th>
                                    <th>Companies</th>
                                    <th>Comments</th>
                                    <th>Actions</th>
                                </tr>

                            </thead>
                            <tfoot>
                                <tr class="table-search">
                                    <td></td>
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


                <div class="button-group">

                    <button type="submit" class="btn btn-primary btn-block inlline-block" href=""><span>Save</span></button>
                    <button type="reset" class="btn btn-warning cancel inlline-block" onclick="resetForm('editUsers'); return false;">

                        <span>Cancel</span>
                    </button>

                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('custom_style/datatable/jquery-1.12.3.js') }}"></script>
<script src="{{ asset('custom_style/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('custom_style/datatable/dataTables.bootstrap.min.js') }}"></script>
<script>
                        $(function () {
                            var oTable = $('#article-table').DataTable({
                                bProcessing: true,
                                serverSide: true,
                                /* sDom           : 'p', */
                                // dom            : 'Bfrtip',
                                ajax: {
                                    url: '{!! route("articles.data", $user->id) !!}',
                                    data: function (d) {

                                    }
                                },
                                columns: [
                                    {data: 'article_title', name: 'article_title'},
                                    {data: 'subject_name', name: 'subject_name'},
                                    {data: 'topic', name: 'topic'},
                                    {data: 'company_name', name: 'company_name'},
                                    {data: 'article_comment', name: 'article_comment'},
                                    {data: 'action', name: 'action', orderable: false, searchable: false}
                                ],
                                initComplete: function () {
                                    $('.dataTables_filter input[type="search"]').attr('placeholder', 'Search Posts').css(
                                            {}
                                    );
                                    var r = $('#article-table tfoot tr');

                                    $('#article-table thead').append(r);

                                    this.api().columns([0, 1, 2, 3]).every(function () {
                                        var column = this;
                                        var input = document.createElement("input");

                                        $(input).appendTo($(column.footer()).empty())
                                                .on('keyup', function () {
                                                    column.search($(this).val(), false, false, true).draw();
                                                });
                                    });
                                }
                            });
                        });
                        function resetForm(editUsers)
                        {
                            var editUsers = document.getElementById(editUsers);

                            for (var i = 0; i < editUsers.elements.length; i++)
                            {
                                if (editUsers.elements[i].type == 'text' || editUsers.elements[i].type == 'select-one')
                                {
                                    editUsers.elements[i].value = '';
                                }
                            }
                        }
                        setTimeout(function () {
                            $('#successMessage').fadeOut('slow');
                        }, 2000);
</script>


@endsection