@extends('frontend.layouts.index')
@section('content')
<section id="form">
	<!--form-->
	<div class="container">
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-5">
				<div class="signup-form">
					<!--sign up form-->
					<h2>Đăng kí!</h2>
					<form action="dang-ki" method="post">
						@csrf
						@if(session('thongbao'))
						<div class="alert alert-success">
							{{
                                        session('thongbao')
                                    }}
						</div>
						@endif
						<input type="text" placeholder="Tên" / name="name" value="{{ old('name') }}">
						@if($errors->has('name'))
						<div class="alert alert-danger">
							{{$errors->first('name')}}
						</div>
						@endif
						<input type="text" placeholder="SĐT" / name="phone" value="{{ old('phone') }}">
						@if($errors->has('phone'))
						<div class="alert alert-danger">
							{{$errors->first('phone')}}
						</div>
						@endif
						<input type="email" placeholder="Email" / name="email" value="{{ old('email') }}">
						@if($errors->has('email'))
						<div class="alert alert-danger">
							{{$errors->first('email')}}
						</div>
						@endif
						<input type="password" placeholder="Mật khẩu" / name="password" value="{{ old('password') }}">
						@if($errors->has('password'))
						<div class="alert alert-danger">
							{{$errors->first('password')}}
						</div>
						@endif
						<button type="submit" class="btn btn-default">Đăng kí</button>
					</form>
				</div>
				<!--/sign up form-->
			</div>
		</div>
	</div>
</section>
<!--/form-->
@endsection