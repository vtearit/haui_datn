@extends('frontend.layouts.account')
@section('account')
<div class="features_items">
	<!--features_items-->


	<div class="step-one">
		<h2 class="heading">Điểm thưởng của bạn là <?php echo number_format($user->user_point) ?></h2>
	</div>
	<div class="checkout-options">
		<h3>Bạn muốn đổi voucher mua hàng nào???</h3>
		<br />
		@if(isset($success))
		<div class="alert alert-success">
			{{$success}}
		</div>
		@endif
		@if(isset($error))
		<div class="alert alert-danger">
			{{
											$error
										}}
		</div>
		@endif
		<form action="doi-diem-thuong" method="post">
			@csrf
			<ul class="nav">
				<li>
					<label><input type="radio" name="coupon" value="100" checked> Voucher 1.000.000đ - 100 điểm </label>
				</li>
				<li>
					<label><input type="radio" name="coupon" value="500"> Voucher 5.000.000đ - 500 điểm</label>
				</li>
				<li>
					<label><input type="radio" name="coupon" value="1000"> Voucher 10.000.000đ - 1000 điểm</label>
				</li>
				<br />
			</ul>
			<input type="submit" value="Đổi" class="btn btn-default add-to-cart" />
		</form>
	</div>
	<!--/checkout-options-->


</div>
@endsection