@extends('frontend.layouts.index')
@section('content')

<section id="cart_items">
	<div class="container">

		<div class="breadcrumbs">
			<ol class="breadcrumb">
				<li><a href="/gio-hang">Quay lại</a></li>
				<li class="active">Xem lại & Thanh toán</li>
			</ol>
		</div>
		<!--/breadcrums-->
		<div class="review-payment">

		</div>
		<?php
		$content = Cart::content();
		$total = (int)(implode('', explode(',', Cart::subtotal())));
		//var_dump($product);
		/*$product_str="";
				foreach ($product as $p=>$val) {
					
					foreach ($val as $key1 => $val1) {
						$product_str.="$val1|";
						//echo($val1."</br>");
					}
				}*/
		//echo ($product_str);
		//var_dump($payment_method);

		?>
		<div class="table-responsive cart_info">
			<table class="table table-condensed">
				<thead>
					<tr class="cart_menu">
						<td class="image">Sản phẩm</td>
						<td class="description">Tên</td>
						<td class="price">Giá</td>
						<td class="quantity">Số lượng</td>
						<td class="total">Thành tiền</td>

					</tr>
				</thead>
				<tbody>
					@foreach($content as $ct)
					<tr>
						<td class="cart_product">
							<a href=""><img src=" img/product/{{$ct->options->image}}" width="50" alt=""></a>
						</td>
						<td class="cart_description" width="300px">
							<h4><a href="">{{$ct->name}}</a></h4>
						</td>
						<td class="cart_price">
							<p id="money">{{number_format($ct->price).' VNĐ'}}</p>
						</td>
						<td class="cart_quantity">
							<div class="cart_quantity_button">
								{{$ct->qty}}



							</div>
						</td>
						<td class="cart_total">
							<p class="cart_total_price">{{number_format($ct->price*$ct->qty).' VNĐ'}}</p>
						</td>

					</tr>
					@endforeach
					<tr id="payment">
						<td colspan="4">

						</td>
						<td colspan="2">
							<table class="table table-condensed total-result">
								<tr>
									<td>Thành tiền</td>
									<td>{{Cart::subtotal().' VNĐ'}}</td>
								</tr>
								@if(session('coupon'))
								<tr>
									<td>Mã giảm giá</td>
									<td>{{number_format(session('number_discount')).' VNĐ'}}</td>
								</tr>
								@endif
								<tr class="shipping-cost">
									<td>Phí ship</td>
									<td>{{number_format($fee_ship).' VNĐ'}}</td>
								</tr>
								<tr>
									<td>Tổng</td>
									<td><span>{{number_format($money).' VNĐ'}}</span></td>
								</tr>
								<tr>
									<td><button onclick="window.location.href = 'gio-hang';" class="btn btn-default">Xem lại giỏ hàng</button></td>
									<td>
										<form action="{{url('dat-mua')}}" method="post">
											@csrf
											<input type="hidden" name="fee_ship" value="{{$fee_ship}}" />
											<input type="hidden" name="money" value="{{$total}}" />
											<input type="hidden" name="payment_method" value="{{$payment_method}}" />
											<input type="hidden" name="note" value="{{$note}}" />
											<input type="hidden" name="province" value="{{$province}}" />
											<input type="hidden" name="district" value="{{$district}}" />
											<input type="hidden" name="wards" value="{{$wards}}" />
											<input type="hidden" name="name" value="{{$name}}" />
											<input type="hidden" name="phone" value="{{$phone}}" />
											<input type="hidden" name="payment" value="{{$money}}" />
											<input type="hidden" name="coupon" value="{{$coupon}}" />
											<input type="submit" value="Đặt mua" class="btn btn-primary btn-sm" />
									</td>
									</form>
								</tr>
							</table>
						</td>
					</tr>
				</tbody>

			</table>
		</div>
	</div>

</section>
<!--/#cart_items-->
<br />




@endsection
@section('script')
<script>
	$(document).ready(function() {
		//alert('ss');
		$("#tinhthanhpho").change(function() {
			var id = $(this).val();
			$.get("ajax/quan-huyen/" + id, function(data) {
				$("#quanhuyen").html(data);
				//alert("a");
			});
			//alert(id);
		});

	});
</script>
@endsection