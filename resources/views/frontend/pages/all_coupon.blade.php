@extends('frontend.layouts.index')

@section('content')
<div id="ajax">
	<section id="cart_items">
		<div class="container">

			<div id="cart-content">

			</div>
			<div class="table-responsive cart_info">
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Mã</td>
							<td class="name">Tiêu đề</td>
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
							<td class="cart_name">
								{{$c->coupon_name}}
							</td>
							@if($c->coupon_condition==2)
							<td class="cart_description">Tiền mặt</td>
							<td class="cart_price">
								{{number_format($c->coupon_number)}}đ
							</td>
							@else
							<td class="cart_description">Theo phần trăm</td>
							<td class="cart_price">
								{{number_format($c->coupon_number)}}% giá trị đơn hàng
							</td>
							@endif

						</tr>
						@endforeach
					</tbody>
				</table>
			</div>

		</div>
	</section>
	<!--/#cart_items-->


</div>
@endsection