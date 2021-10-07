@extends('frontend.layouts.account')
@section('account')
<div class="features_items">
	<!--features_items-->

	<div class="contact-form">
		<h2 class="title text-center">Kiểm tra</h2>
		@if(session('thongbao'))
		<div class="alert alert-success">
			{{
                                        session('thongbao')
                                    }}
		</div>
		@endif
		<div class="status alert alert-success" style="display: none"></div>
		<form class="contact-form row" method="post" action="kiem-tra">
			@csrf
			<div class="form-group col-md-12">
				<h5>Nhập mật khẩu để tiếp tục</h5>
				<input type="password" name="pw" class="form-control">
				@if($errors->has('pw'))
				<div class="alert alert-danger">
					{{
			                                        $errors->first('pw')
			                                    }}
				</div>
				@endif
			</div>
			<div class="form-group col-md-12">
				<input type="submit" name="submit" class="btn btn-primary text-center" value="Xác nhận">
			</div>
		</form>
	</div>
</div>
@endsection