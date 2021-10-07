@extends('frontend.layouts.index')
@section('content')
<section>
	<div class="container">
		<div class="row">
			<div class="col-sm-3">
				<div class="left-sidebar">
					<h2>Category</h2>
					<div class="panel-group category-products" id="accordian">
						<!--category-productsr-->
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-parent="#accordian" href="cap-nhat-thong-tin">
										Cập nhật thông tin
									</a>
								</h4>
							</div>

						</div>
						@if($user->user_password!="")
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-parent="#accordian" href="doi-mat-khau">
										Đổi mật khẩu
									</a>
								</h4>
							</div>

						</div>
						@endif
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-parent="#accordian" href="doi-diem-thuong">
										Đổi điểm thưởng
									</a>
								</h4>
							</div>

						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-parent="#accordian" href="ma-giam-gia-cua-ban">
										Mã của bạn
									</a>
								</h4>
							</div>

						</div>

						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-parent="#accordian" href="dang-xuat">
										Đăng xuất
									</a>
								</h4>
							</div>

						</div>
					</div>



				</div>
				<!--/category-productsr-->
			</div>

			<div class="col-sm-9 padding-right">
				@yield('account')
			</div>
		</div>
	</div>
</section>
@endsection