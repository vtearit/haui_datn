@extends('frontend.layouts.account')
@section('account')
<div class="features_items">
	<!--features_items-->

	<div class="contact-form">
		<h2 class="title text-center">Cập nhật thông tin</h2>
		@if(isset($thongbao))
		<div class="alert alert-success">
			{{
                                        $thongbao
                                    }}
		</div>
		@endif
		<div class="status alert alert-success" style="display: none"></div>
		<form class="contact-form row" method="post" action="cap-nhat-thong-tin/{{$user->id}}" enctype="multipart/form-data">
			@csrf
			<div class="form-group col-md-12">
				<h5>Tên khách hàng</h5>
				<input type="text" name="name" class="form-control" placeholder="Trống" value="{{$user->user_name}}">
				@if($errors->has('name'))
				<div class="alert alert-danger">
					{{
			                                        $errors->first('name')
			                                    }}
				</div>
				@endif
			</div>
			<div class="form-group col-md-12">
				<h5>SĐT</h5>
				<input type="text" name="phone" class="form-control" placeholder="Trống" value="{{$user->user_phone}}">
				@if($errors->has('phone'))
				<div class="alert alert-danger">
					{{
			                                        $errors->first('phone')
			                                    }}
				</div>
				@endif
			</div>
			<div class="form-group col-md-12">
				<label>Địa chỉ</label>
				<button type="button" id="change" class="btn btn-infor">Thay đổi</button>
				<input type="text" name="address" class="form-control" placeholder="Trống" @if($address!="" ) value="{{$address}}" @endif>


				<div style="display: none" id="address">
					<h5>Tỉnh|Thành phố</h5>
					<select id="tinhthanhpho" name="matp">
						<option disabled selected>-- Tỉnh/Thành phố --</option>
						@foreach($tp as $ttp)
						<option value="{{$ttp->matp}}">{{$ttp->name_city}}</option>
						@endforeach
					</select>
					@if($errors->has('matp'))
					<div class="alert alert-danger">
						{{
			                                        $errors->first('matp')
			                                    }}
					</div>
					@endif
					<h5>Quận|Huyện</h5>
					<select id="quanhuyen" name="maqh">
						<option disabled selected>-- Quận/huyện --</option>
					</select>
					@if($errors->has('maqh'))
					<div class="alert alert-danger">
						{{
			                                        $errors->first('maqh')
			                                    }}
					</div>
					@endif
					<h5>Xã|Phường|Thị trấn</h5>
					<select id="xaphuongthitran" name="xaid">
						<option disabled selected>-- Xã/Phường/Thị trấn --</option>
					</select>
					@if($errors->has('xaid'))
					<div class="alert alert-danger">
						{{
			                                        $errors->first('xaid')
			                                    }}
					</div>
					@endif
				</div>
			</div>
			<div class="form-group col-md-12">
				<h5>Email</h5>
				<input type="text" name="email" class="form-control" placeholder="Email" readonly value="{{$user->user_email}}">
			</div>
			<div class="form-group  col-md-12">
				<label>Hình ảnh</label>
				<button type="button" id="change_img" class="btn btn-infor">Thay đổi</button>
				<br />
				@if($user->user_avatar!="")
				<img src="img/avatar/{{$user->user_avatar}}" width="100px" height="100px" alt="" />
				@endif
				<br />

				<div style="display: none" id="image">
					<input type="file" name="image" value="{{ old('image') }}" />
				</div>
				@if($errors->has('image'))
				<div class="alert alert-danger">
					{{
			                                        $errors->first('image')
			                                    }}
				</div>
				@endif
			</div>

			<div class="form-group col-md-12">
				<input type="submit" name="submit" class="btn btn-primary text-center" value="Cập nhật">
			</div>
		</form>
	</div>
</div>
@endsection
@section('script')
<script src="frontend/js/sweetalert.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#change').click(function() {
			$('#address').toggle();
		});
		$('#change_img').click(function() {
			$('#image').toggle();
		});
		$("#tinhthanhpho").change(function() {
			var id = $(this).val();
			$.get("ajax/quan-huyen/" + id, function(data) {
				$("#quanhuyen").html(data);
				//alert("a");
			});
			//alert(id);
		});
		$("#quanhuyen").change(function() {
			var id = $(this).val();
			$.get("ajax/xa-phuong/" + id, function(data) {
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
		});
	});
</script>

@endsection