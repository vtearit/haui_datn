@extends('frontend.layouts.index')
@section('content')
<section>

	<div class="container">
		<div class="row">


			<div class="col-sm-12">
				<div class="features_items">
					<!--features_items-->

					<div class="contact-form">
						<h2 class="title text-center">Email</h2>
						@if(session('thongbao'))
						<div class="alert alert-success">
							{{
			                                        session('thongbao')
			                                    }}
						</div>
						@endif

						<div class="status alert alert-success" style="display: none"></div>
						<form class="contact-form row" method="post" action="nhap-email">
							@csrf
							<div class="form-group col-md-6">
								<h5>Email</h5>
								<input type="email" name="email" class="form-control">
								@if($errors->has('email'))
								<div class="alert alert-danger">
									{{
						                                        $errors->first('email')
						                                    }}
								</div>
								@endif
							</div>

							<div class="form-group col-md-12">
								<input type="submit" name="submit" class="btn btn-primary text-center" value="Xác nhận">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection