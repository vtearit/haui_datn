@extends('frontend.layouts.index')

@section('content')
<div id="ajax">
	<section id="cart_items">
		<div class="container">

			<div class="breadcrumbs">
				<br />
				<ol class="breadcrumb">

					<!--  <li><a href="#">Giỏ hàng của bạn</a></li> -->

				</ol>
			</div>
			<!-- <div>
				<?php
				//var_dump(Cart::content());
				// foreach (Cart::content() as $c) {
				// 	echo $c->options['image'];
				// }
				?>
   			</div> -->
			<div id="cart-content">
				<?php
				if (Cart::count() > 0) {
					$content = Cart::content();
					//echo Cart::count();

				?>
			</div>
			<div class="table-responsive cart_info">
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
									<form action="/gio-hang/cap-nhat" method="post">
										@csrf
										<input type="hidden" name="rowId" value="{{$ct->rowId}}">


										<button type="button" class="btn btn-warning cart_quantity_up" data-qty_product="{{$ct->qty}}" data-id_product="{{$ct->id}}" data-row_id="{{$ct->rowId}}">+</button>

										<input class="cart_quantity_id_{{$ct->id}} btn btn-light" type="number" name="quantity" value="{{$ct->qty}}">

										<button type="button" class="cart_quantity_down btn btn-warning" data-qty_product="{{$ct->qty}}" data-id_product="{{$ct->id}}" data-row_id="{{$ct->rowId}}">-</button>

									</form>

								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">{{number_format($ct->price*$ct->qty).' VNĐ'}}</p>
							</td>
							<td class="cart_delete">
								<form action="gio-hang/xoa" method="post">
									@csrf
									<input type="hidden" name="rowId_delete" value="{{$ct->rowId}}">
									<input type="submit" value="Xoá" name="delete" class="btn btn-danger">
								</form>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		<?php
				} else {
		?>

			<p class="text-center"><img src="frontend/images/gio_hang_trong.jpg" alt=""></p>
			<p class="text-center" style="">Giỏ hàng trống</p>
			<div class="text-center"><a href="#">Mua sắm ngay</a></div>
		<?php
				}
		?>
		</div>
	</section>
	<!--/#cart_items-->

	<section id="do_action">
		<?php
		if (Cart::count() > 0) {
			$content = Cart::content();
			//echo Cart::count();
		?>
			<div class="container">
				<div class="heading">
					<h3>Bạn muốn làm gì tiếp theo?</h3>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="chose_area">

							<table>
								<thead class="thead-dark">
									<tr>
										<th>
											<h3><span class="label label-success">Mã giảm giá</span></h3>
										</th>
										<th scope="col"></th>
										<th scope="col"></th>

									</tr>
								</thead>
								<tr>

									<form action="ma-giam-gia" method="post">
										@csrf

										<td>
											<input type="text" name="coupon_code" class="form-control" />

										</td>
										<td><input type="submit" name="" value="Áp dụng" class="btn btn-danger form-control"></td>
										<td></td>
									</form>
									@if(session()->has('coupon_err'))
									<div class="alert alert-danger">
										{{Session('coupon_err')}}
									</div>
									@endif

									@if(session()->has('message'))
									<div class="alert alert-success">
										{{Session('message')}}
									</div>
									@endif


									</td>
								</tr>
							</table>
							<br />

							@if(session('coupon'))
							<h3><span class="label label-info">Mã giảm giá đã sử dụng</span></h3>
							<table class="table table-hover table-striped ">

								<thead class="thead-dark">
									<tr>
										<th scope="col">Mã giảm</th>
										<th scope="col">Tiền giảm</th>
										<th scope="col"></th>

									</tr>
								</thead>
								<tbody>
									@foreach(session('coupon') as $cp)
									@foreach($cp as $key=>$val)
									<tr>
										<td scope="row">{{$val['coupon_code']}}</td>
										<td scope="row">{{number_format($val['coupon_number']).' VNĐ'}}</td>
										<td scope="row"><span><a href="ma-giam-gia/{{$key}}">Hủy</a></span></td>

									</tr>
									@endforeach
									@endforeach
								</tbody>
							</table>
							@endif
						</div>
					</div>


					<div class="col-sm-6">
						<div class="total_area">
							<ul>
								<li>Thành tiền <span>{{Cart::subtotal().' VNĐ'}}</span></li>

								<li>Phí ship <span>Chưa tính</span></li>
								@if(session('coupon'))
								<li>Mã giảm giá <span>

										<span>
											{{
										number_format(session('number_discount')).' VNĐ'
									}}
											@endif
										</span></li>
								<li>Tổng <span>{{number_format((int)(implode('',explode(',', Cart::subtotal())))-session('number_discount')).' VNĐ'}}</span></li>
							</ul>
							<a class="btn btn-default update" href="">Cập nhật</a>
							<button onclick="window.location.href = 'thanh-toan';" id="checkout" class="btn btn-default check_out">Thanh toán</button>

						</div>
					</div>
				</div>
			</div>
		<?php
		}

		?>
</div>



</section>
<!--/#do_action-->
</div>
@endsection
@section('script')
<script src="frontend/js/jquery_min.js"></script>
<script>
	$(document).ready(function() {
		$(".cart_quantity_up").click(function() {
			var qty = parseInt($(this).data('qty_product'));
			var id = parseInt($(this).data('id_product'));
			var rowId = $(this).data('row_id');
			$.get("gio-hang/qty/up/" + rowId + "/" + id + "/" + qty, function(data) {
				$(".cart_quantity_id_" + id).val(data);
				location.reload();
			});

		});

		$(".cart_quantity_down").click(function() {
			var qty = parseInt($(this).data('qty_product'));
			var id = parseInt($(this).data('id_product'));
			var rowId = $(this).data('row_id');
			//alert(rowId);
			$.get("gio-hang/qty/down/" + rowId + "/" + id + "/" + qty, function(data) {
				$(".cart_quantity_id_" + id).val(data);
				//alert(data);
				location.reload();
			});
		});

		$("#checkout").click(function() {
			$.get("/session_checkout", function(data) {
				$("#session_checkout").html(data);
				//alert(data);
			});

		});


	});
</script>

@endsection