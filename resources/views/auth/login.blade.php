<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Agripunt Login</title>
        <!-- Bootstrap core CSS-->
        <link href="{{ asset('custom_style/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <!-- Custom fonts for this template-->
        <link href="{{ asset('custom_style/vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
        <!-- Custom styles for this template-->
        <link href="{{ asset('custom_style/css/sb-admin.css') }}" rel="stylesheet">
    </head>

    <body class="bg-dark">
        <div class="container login">
            <div class="card card-login mx-auto mt-5">
                <div class="card-header"><img src="{{ asset('custom_style/images/logo.png') }}"></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email">Email address</label>
                            <input class="form-control" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus aria-describedby="emailHelp" placeholder="Enter email">
                            @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input class="form-control{{ $errors->has('password') ? ' has-error' : '' }}" id="password" name="password" required type="password" placeholder="Password">
                            @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif  
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Password</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">
                            Login
                        </button>
                    </form>
                    <div class="text-center mt10">

                        <a class="d-block small" href="{{ route('password.request') }}">Forgot Password?</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bootstrap core JavaScript-->
        <script src="{{ asset('custom_style/vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('custom_style/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- Core plugin JavaScript-->
        <script src="{{ asset('custom_style/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    </body>

</html>
