@extends('frontend.layouts.index')
@section('content')

<section id="cart_items">
	<div class="container">

		<div class="breadcrumbs">
			<ol class="breadcrumb">
				<li><a href="/thanh-toan">Thanh toán</a></li>

			</ol>
		</div>
		<!--/breadcrums-->


		<div class="shopper-informations">
			<div class="row">
				<div class="col-sm-3">

				</div>
				<div class="col-sm-8 clearfix">
					<div class="bill-to">
						<p>Thông tin giao hàng</p>
						<div class="form-one">
							<form action="xac-nhan-dia-chi" method="post">
								@csrf
								<input type="text" name="name" placeholder="Tên *" value="{{$user->user_name}}">
								@if($errors->has('name'))
								<div class="alert alert-danger">
									{{$errors->first('name')}}
								</div>
								@endif
								<input type="text" name="phone" placeholder="SĐT *" value="{{$user->user_phone}}">
								@if($errors->has('phone'))
								<div class="alert alert-danger">
									{{$errors->first('phone')}}
								</div>
								@endif
								<br />
								<p>Địa chỉ <span style="color: red">*</span></p>
								@if($user->xaid!=0|$user->maqh!=0|$user->matp!=0)
								<select name="matp_available">

									<option value="{{$user->tp->matp}}">{{$user->tp->name_city}}</option>

								</select>
								<br />
								<select name="maqh_available">
									<option value="{{$user->qh->maqh}}">{{$user->qh->name_quanhuyen}}</option>
								</select>
								<br />
								<select name="xaid_available">
									<option value="{{$user->xa->xaid}}">{{$user->xa->name_xaphuong}}</option>
								</select>
								<button type="button" id="change" class="btn btn-infor">Thay đổi</button>
								<div id="change_address" style="display: none">
									<select id="tinhthanhpho" name="matp">
										<option disabled selected>-- Tỉnh/Thành phố --</option>
										@foreach($tinh_thanh_pho as $ttp)
										<option value="{{$ttp->matp}}">{{$ttp->name_city}}</option>
										@endforeach
									</select>
									@if($errors->has('matp'))
									<div class="alert alert-danger">
										{{$errors->first('matp')}}
									</div>
									@endif
									<br />
									<select id="quanhuyen" name="maqh">
										<option disabled selected>-- Quận/huyện --</option>
									</select>
									@if($errors->has('maqh'))
									<div class="alert alert-danger">
										{{$errors->first('maqh')}}
									</div>
									@endif
									<br />
									<select id="xaphuongthitran" name="xaid">
										<option disabled selected>-- Xã/Phường/Thị trấn --</option>
									</select>
									@if($errors->has('xaid'))
									<div class="alert alert-danger">
										{{$errors->first('xaid')}}
									</div>
									@endif
									<br />
								</div>
								@else
								<select id="tinhthanhpho" name="matp">
									<option disabled selected>-- Tỉnh/Thành phố --</option>
									@foreach($tinh_thanh_pho as $ttp)
									<option value="{{$ttp->matp}}">{{$ttp->name_city}}</option>
									@endforeach
								</select>
								@if($errors->has('matp'))
								<div class="alert alert-danger">
									{{$errors->first('matp')}}
								</div>
								@endif
								<br />
								<select id="quanhuyen" name="maqh">
									<option disabled selected>-- Quận/huyện --</option>
								</select>
								@if($errors->has('maqh'))
								<div class="alert alert-danger">
									{{$errors->first('maqh')}}
								</div>
								@endif
								<br />
								<select id="xaphuongthitran" name="xaid">
									<option disabled selected>-- Xã/Phường/Thị trấn --</option>
								</select>
								@if($errors->has('xaid'))
								<div class="alert alert-danger">
									{{$errors->first('xaid')}}
								</div>
								@endif
								<br />
								@endif
								<div class="order-message">
									<p>Ghi chú</p>
									<textarea name="note" rows="16"></textarea>
								</div>
								<p>Phương thức thanh toán <span style="color: red">*</span></p>
								<br />
								<div class="payment-options">
									<span>
										<label><input type="radio" value="chuyển khoản" name="payment" checked=""> Chuyển khoản</label>
									</span>
									<span>
										<label><input type="radio" value="trực tiếp" name="payment"> Thanh toán khi nhận hàng</label>
									</span>
									<span>
										<label><input type="radio" value="paypal" name="payment"> Thanh toán qua Paypal</label>
									</span>
								</div>
								@if($errors->has('payment'))
								<div class="alert alert-danger">
									{{$errors->first('payment')}}
								</div>
								@endif
								<input type="submit" class="btn btn-default btn-sm" value="Thanh toán" />
							</form>









						</div>

					</div>

				</div>

			</div>
		</div>



	</div>
</section>
<!--/#cart_items-->
<br />
@endsection
@section('script')
<script>
	$(document).ready(function() {
		$('#change').click(function() {
			$('#change_address').toggle();
		});
		//alert('ss');
		$("#tinhthanhpho").change(function() {
			var id = $(this).val();
			$.get("thanh-toan/quan-huyen/" + id, function(data) {
				$("#quanhuyen").html(data);
				//alert("a");
			});
			//alert(id);
		});
		$("#quanhuyen").change(function() {
			var id = $(this).val();
			$.get("thanh-toan/xa-phuong/" + id, function(data) {
				$("#xaphuongthitran").html(data);
				//alert("a");
			});
			//alert(id);
		});
		$("#xaphuongthitran").change(function() {
			var xaid = $(this).val();
			var matp = $("#tinhthanhpho").val();

			var maqh = $("#quanhuyen").val();
			$.get("ajax/" + matp + "/" + maqh + "/" + xaid, function(data) {
				$("#payment").html(data);

				//alert(data);
			});
			/*alert(matp);
			alert(maqh);
			alert(xaid);
			*/

		});
	});
</script>
@endsection