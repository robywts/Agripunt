@extends('layouts.custom_app')

@section('content')


<div class="col-md-12 ">
    <div class="row">
        <div class="page-title">

            Invite Users

        </div>
        <div class="bread-crumbs"><!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('users') }}">Manage Users</a>
                </li>
                <li class="breadcrumb-item active">
                    Invite Users
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

                {!! Form::model(array('route' => array('users.store', 'method' => 'POST'), 'id' => 'addUsers')) !!}
                <div class="form-group">
                    {{ Form::label('name', 'Name of User',['class' => 'field-title']) }}
                    {{ Form::text('name', null, array('class' => 'common-input', 'placeholder' => 'User Name')) }}
                </div>
                <div class="form-group">
                    {{ Form::label('email', 'User Email',['class' => 'field-title']) }}
                    {{ Form::text('email', null, array('class' => 'common-input', 'placeholder' => 'User Email')) }}
                </div>

                <div class="button-group">

                    <button class="btn btn-primary btn-block inlline-block" type="submit" href=""><span>Invite</span></button>
                    <button type="reset" class="btn btn-warning cancel inlline-block" onclick="resetForm('editUsers'); return false;">

                        <span>Cancel</span>
                    </button>

                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function resetForm(addUsers)
    {
        var addUsers = document.getElementById(addUsers);

        for (var i = 0; i < addUsers.elements.length; i++)
        {
            if (addUsers.elements[i].type == 'text' || addUsers.elements[i].type == 'select-one')
            {
                addUsers.elements[i].value = '';
            }
        }
    }
    setTimeout(function () {
        $('#successMessage').fadeOut('slow');
    }, 2000);
</script>
@endsection