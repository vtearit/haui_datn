<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Khóa Học Lập Trình Laravel Framework 5.x Tại Khoa Phạm">
    <meta name="author" content="">

    <title>Đăng nhập</title>
    <base href="{{asset('')}}">
    <!-- Bootstrap Core CSS -->
    <link href="admin/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="admin/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="admin/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="admin/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">



</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Đăng nhập</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="dang-nhap" method="POST">
                            @csrf
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus value="{{ old('email') }}">
                                </div>
                                @if($errors->has('email'))
                                <div class="alert alert-danger">
                                    {{$errors->first('email')}}
                                </div>
                                @endif

                                <div class="form-group">
                                    <input class="form-control" placeholder="Mật khẩu" name="password" type="password" value="{{ old('password') }}">
                                </div>
                                @if($errors->has('password'))
                                <div class="alert alert-danger">
                                    {{$errors->first('password')}}
                                </div>
                                @endif

                                @if(session('thongbao'))
                                <div class="form-group alert alert-danger">
                                    {{session('thongbao')}}
                                </div>
                                @endif
                                <!-- <div class="g-recaptcha" data-sitekey="6LdlPOEZAAAAAIdiRxpFgEOv8iRhheBBeS2dR3Vs"></div>
                                <br/>
                                @if($errors->has('g-recaptcha-response'))
                                <span class="invalid-feedback" style="display:block">
                                    <div class="alert alert-danger">{{$errors->first('g-recaptcha-response')}}
                                    </div>
                                </span>
                                @endif -->

                                <button type="submit" class="btn btn-lg btn-success btn-block">Đăng nhập</button>

                                <div class="text-center" style="margin-top: 10px,margin-bottom: 10px">---------------------------Hoặc--------------------------- </div>

                                <a href="dang-ki" class="btn btn-lg btn-danger btn-block">Đăng kí</a>
                            </fieldset>
                        </form>
                        <br />
                        <a href="admin/login-google"><i class="fa fa-google-plus-square" style='font-size:30px' aria-hidden="true"></i>|</a>
                        <a href="admin/login-facebook"> <i class="fa fa-facebook-square" style='font-size:30px' aria-hidden="true"></i> </a>
                        <a href="quen-mat-khau" style="float: right"> Quên mật khẩu?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="admin/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="admin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="admin/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="admin/dist/js/sb-admin-2.js"></script>
    <!-- recaptcha-->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</body>

</html>