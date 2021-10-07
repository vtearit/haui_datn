@extends('frontend.layouts.account')
@section('account')
<section id="cart_items">

	<div id="cart-content">
		<h2>Mã của bạn</h2>
	</div>
	<?php
	if (count($coupon) == 0) {
	?>

		<p class="text-center"><img src="frontend/images/gio_hang_trong.jpg" alt=""></p>
		<p class="text-center" style="">Rỗng</p>

	<?php
	} else {

	?>
		<div class="table-responsive cart_info">
			<table class="table table-condensed">
				<thead>
					<tr class="cart_menu">
						<td class="image">Mã của bạn</td>
						<td class="description">Hình thức giảm</td>
						<td class="price">Tiền giảm</td>
					</tr>
				</thead>
				<tbody>
					@foreach($coupon as $c)

					<tr>
						<td class="cart_product">
							{{$c->coupon_code}}
						</td>
						@if($c->coupon_condition==2)
						<td class="cart_description">Tiền mặt</td>
						@else
						<td class="cart_description">Theo phần trăm</td>
						@endif

						<td class="cart_price">
							{{number_format($c->coupon_number)}}đ
						</td>

					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	<?php
	}
	?>
</section>
<!--/#cart_items-->


</div>
@endsection