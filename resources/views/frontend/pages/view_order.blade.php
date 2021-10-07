@extends('frontend.layouts.index')
@section('css')
<link href="frontend/css/sweetalert.css" rel="stylesheet">
@endsection
@section('content')

<section id="cart_items">
	<div class="container">

		<?php
		if (count($order) == 0) {
		?>

			<p class="text-center"><img src="frontend/images/gio_hang_trong.jpg" alt=""></p>
			<p class="text-center" style="">Đơn hàng trống</p>
			<div class="text-center"><a href="#">Mua sắm ngay</a></div>

		<?php
		} else {

		?>
			<div class="review-payment">
				<h2>Đơn hàng của bạn</h2>
			</div>
			@foreach($order as $o)

			<button type="button" data-toggle="colapse" class="col-sm-12 order_dis_hid btn btn-warning" data-id_order="{{$o->id}}">

				<div class="col-sm-8 text-left">
					<h3>Mã đơn hàng:{{$o->order_code}}</h3>
				</div>
				<div class="col-sm-4 text-right">
					<h3>Trạng thái:{{$o->order_status}}</h3>
				</div>
			</button>
			<div class="table-responsive cart_info order_id_{{$o->id}}" style="display: none" data-id="1">
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Sản phẩm</td>
							<td class="description">Tên</td>
							<td class="price">Giá</td>
							<td class="quantity">Số lượng</td>
							<td class="total">Thành tiền</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						@if(count($o->orderDetails)>0)
						@foreach($o->orderDetails as $od)
						<tr>
							<td class="cart_product">
								<img src=" img/product/{{$od->product->product_image}}" width="50" alt="">
							</td>
							<td class="cart_description">
								<h4>{{$od->product->product_name}}</h4>
							</td>
							<td class="cart_price">
								<p id="money">{{number_format($od->product_price).' VNĐ'}}</p>
							</td>
							<td class="cart_quantity">
								<p>{{$od->product_sales_quantity}}</p>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">{{number_format($od->product_price*$od->product_sales_quantity).' VNĐ'}}</p>
							</td>

						</tr>
						@endforeach
						@endif
						<tr id="payment">
							<td colspan="4">
								<h3>Thông tin giao hàng</h3>
								<table class="table table-condensed total-result">
									<tr>
										<td>Tên người nhận</td>
										<td>{{$o->shipping->shipping_name}}</td>
									</tr>
									<tr class="shipping-cost">
										<td>SĐT</td>
										<td>{{$o->shipping->shipping_phone}}</td>
									</tr>
									<tr>
										<td>Địa chỉ</td>
										<td>{{$o->shipping->shipping_address}}</td>
									</tr>

								</table>
							</td>
							<td colspan="2">
								<h3>Tính tiền</h3>
								<table class="table table-condensed total-result">
									<tr>
										<td>Thành tiền</td>
										<td>{{number_format($o->order_total).' VNĐ'}}</td>
									</tr>
									<tr class="shipping-cost">
										<td>Phí ship</td>
										<td>{{number_format($o->order_feeship).' VNĐ'}}</td>
									</tr>
									@if($o->order_coupon!=0)
									<tr class="shipping-cost">
										<td>Mã giảm giá</td>
										<td>{{number_format($o->order_coupon).' VNĐ'}}</td>
									</tr>
									@endif
									<tr>
										<td>Tổng</td>
										<td><span>{{number_format($o->order_payment).' VNĐ'}}</span></td>
									</tr>
									@if($o->order_status=="Đang xử lí")
									<tr>
										<td></td>
										<td><button data-id_order="{{$o->id}}" class="btn btn-danger cancel-order">Hủy đơn hàng</button></td>
									</tr>
									@endif
								</table>
							</td>
						</tr>
					</tbody>

				</table>
			</div>
			@csrf
			@endforeach
		<?php
		}
		?>

	</div>

</section>
<!--/#cart_items-->
<br />
@endsection
@section('script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
	$(document).ready(function() {
		//alert('ss');
		$(".order_dis_hid").click(function() {
			var id = $(this).data('id_order');
			$(".order_id_" + id + "").toggle();
			// $(this).removeAttr('data-check');
		});
		$(".cancel-order").click(function() {
			swal("Lý do bạn hủy đơn hàng:", {
					content: "input",
				})
				.then((value) => {
					var id = parseInt($(this).data('id_order'));
					var token = $('input[name="_token"]').val();
					var order_note = value;
					$.ajax({
						method: 'POST',
						url: 'huy-don-hang',
						data: {
							id: id,
							_token: token,
							order_note: order_note
						},
						success: function(data) {
							var message = "Hủy đơn hàng " + data + " thành công";
							//swal(message, "", "success");
							alert(message);
							location.reload();
						}
					});
				});



		});

	});
</script>
@endsection