@extends('frontend.layouts.account')
@section('account')
<div class="features_items">
	<!--features_items-->

	<div class="contact-form">
		<h2 class="title text-center">Đổi mật khẩu</h2>
		@if(isset($thongbao))
		<div class="alert alert-success">
			{{
                                        $thongbao
                                    }}
		</div>
		@endif

		<div class="status alert alert-success" style="display: none"></div>
		<form class="contact-form row" method="post" action="doi-mat-khau">
			@csrf
			<div class="form-group col-md-12">
				<h5>Mật khẩu cũ</h5>
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
				<h5>Mật khẩu mới</h5>
				<input type="password" name="new_pw" class="form-control">
				@if($errors->has('new_pw'))
				<div class="alert alert-danger">
					{{
			                                        $errors->first('new_pw')
			                                    }}
				</div>
				@endif
			</div>

			<div class="form-group col-md-12">
				<h5>Xác nhận mật khẩu mới</h5>
				<input type="password" name="confirm_pw" class="form-control">
				@if($errors->has('confirm_pw'))
				<div class="alert alert-danger">
					{{
			                                        $errors->first('confirm_pw')
			                                    }}
				</div>
				@endif
			</div>
			<div class="form-group col-md-12">
				<input type="submit" name="submit" class="btn btn-primary text-center" value="Đổi">
			</div>
		</form>
	</div>
</div>
@endsection