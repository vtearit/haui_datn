@extends('admin.layouts.index')
@section('css')
<!-- summernote -->
<link rel="stylesheet" href="admin/plugins/summernote/summernote-bs4.min.css">
<!-- CodeMirror -->
<link rel="stylesheet" href="admin/plugins/codemirror/codemirror.css">
<link rel="stylesheet" href="admin/plugins/codemirror/theme/monokai.css">
<!-- SimpleMDE -->
<link rel="stylesheet" href="admin/plugins/simplemde/simplemde.min.css">
@endsection
@section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Thêm sản phẩm</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Sản phẩm</a></li>
						<li class="breadcrumb-item active">Thêm</li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<!-- left column -->
				<div class="col-md-12">
					<!-- general form elements -->
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Sản phẩm mới</h3>
						</div>
						<!-- /.card-header -->
						<!-- form start -->
						@if(session('thongbao'))
						<div class="alert alert-success">
							{{
                                        session('thongbao')
                                    }}
						</div>
						@endif
						<form method="POST" enctype="multipart/form-data" action="admin/san-pham/them">
							@csrf
							<div class="card-body">
								<div class="form-group">
									<label for="name">Tên danh mục<span style="color:red">*</span></label>
									<select name="category" id="category" class="form-control">
										@foreach($category as $c)
										<option value="{{$c->id}}">{{$c->category_name}}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<label for="name">Tên nhóm sản phẩm<span style="color:red">*</span></label>
									<select name="group_product" id="group_product" class="form-control">
										@foreach($group_product as $g)
										<option value="{{$g->id}}">{{$g->group_product_name}}</option>
										@endforeach
									</select>
								</div>


								<div class="form-group">
									<label for="name">Tên sản phẩm<span style="color:red">*</span></label>
									<input type="text" class="form-control" name="name" id="name" placeholder="Nhập tên sản phẩm" value="{{ old('name') }}">
								</div>
								@if($errors->has('name'))
								<div class="alert alert-danger">
									{{
	                                        $errors->first('name')
	                                    }}
								</div>
								@endif
								<div class="form-group">
									<label>Hình ảnh<span style="color:red">*</span></label>
									<br />
									<input type="file" name="image" value="{{ old('image') }}" />
								</div>
								@if($errors->has('image'))
								<div class="alert alert-danger">
									{{
	                                        $errors->first('image')
	                                    }}
								</div>
								@endif
								<div class="form-group">
									<label>Mô tả<span style="color:red">*</span></label>
									<div class="col-md-12">
										<div class="card card-outline card-info">
											<!-- /.card-header -->
											<div class="card-body">
												<textarea class="summernote" name="desc" placeholder="Nhập mô tả sản phẩm" value="{{ old('desc') }}">

				              </textarea>
											</div>
										</div>
									</div>
									@if($errors->has('desc'))
									<div class="alert alert-danger">
										{{
	                                        $errors->first('desc')
	                                    }}
									</div>
									@endif
									<div class="form-group">
										<label for="desc">Số lượng<span style="color:red">*</span></label>
										<input type="number" class="form-control" name="qty" placeholder="Nhập số lượng sản phẩm" value="{{ old('desc') }}">
									</div>
									@if($errors->has('qty'))
									<div class="alert alert-danger">
										{{
	                                        $errors->first('qty')
	                                    }}
									</div>
									@endif
									<div class="form-group">
										<label for="desc">Giá nhập<span style="color:red">*</span></label>
										<input type="number" class="form-control" name="import" placeholder="Nhập giá nhập sản phẩm" value="{{ old('import') }}">
									</div>
									@if($errors->has('import'))
									<div class="alert alert-danger">
										{{
	                                        $errors->first('import')
	                                    }}
									</div>
									@endif
									<div class="form-group">
										<label for="desc">Giá bán<span style="color:red">*</span></label>
										<input type="number" class="form-control" name="price" placeholder="Nhập giá bán sản phẩm" value="{{ old('price') }}">
									</div>
									@if($errors->has('price'))
									<div class="alert alert-danger">
										{{
	                                        $errors->first('price')
	                                    }}
									</div>
									@endif
									<div class="form-group">
										<label for="desc">Mã hàng<span style="color:red">*</span></label>
										<input type="text" class="form-control" name="ram" placeholder="Nhập mã hàng" value="{{ old('ram') }}">
									</div>
									@if($errors->has('ram'))
									<div class="alert alert-danger">
										{{
	                                        $errors->first('ram')
	                                    }}
									</div>
									@endif
									<div class="form-group">
										<label for="desc">Màu sắc<span style="color:red">*</span></label>
										<input type="text" class="form-control" name="color" placeholder="Nhập màu sắc" value="{{ old('color') }}">
									</div>
									@if($errors->has('color'))
									<div class="alert alert-danger">
										{{
	                                        $errors->first('color')
	                                    }}
									</div>
									@endif
									<div class="form-group">
										<label for="desc">Mã sản phẩm<span style="color:red">*</span></label>
										<input type="text" class="form-control" name="screen" placeholder="Nhập mã sản phẩm" value="{{ old('screen') }}">
									</div>
									@if($errors->has('screen'))
									<div class="alert alert-danger">
										{{
	                                        $errors->first('screen')
	                                    }}
									</div>
									@endif

									<div class="form-group">
										<label for="desc">Kích thước<span style="color:red">*</span></label>
										<input type="text" class="form-control" name="rear_camera" placeholder="Nhập Kích thước" value="{{ old('rear_camera') }}">
									</div>
									@if($errors->has('rear_camera'))
									<div class="alert alert-danger">
										{{
	                                        $errors->first('rear_camera')
	                                    }}
									</div>
									@endif
									<div class="form-group">
										<label for="desc">Chiều cao<span style="color:red">*</span></label>
										<input type="text" class="form-control" name="camera_selfie" placeholder="Nhập chiều cao sản phẩm" value="{{ old('camera_selfie') }}">
									</div>
									@if($errors->has('camera_selfie'))
									<div class="alert alert-danger">
										{{
	                                        $errors->first('camera_selfie')
	                                    }}
									</div>
									@endif
									<div class="form-group">
										<label for="desc">Khối lượng<span style="color:red">*</span></label>
										<input type="text" class="form-control" name="memory" placeholder="Nhập khối lượng" value="{{ old('memory') }}">
									</div>
									@if($errors->has('memory'))
									<div class="alert alert-danger">
										{{
	                                        $errors->first('memory')
	                                    }}
									</div>
									@endif
									<div class="form-group">
										<label for="desc">Thành phần<span style="color:red">*</span></label>
										<input type="text" class="form-control" name="cpu" placeholder="Nhập thành phần" value="{{ old('cpu') }}">
									</div>
									@if($errors->has('cpu'))
									<div class="alert alert-danger">
										{{
	                                        $errors->first('cpu')
	                                    }}
									</div>
									@endif
									<div class="form-group">
										<label for="desc">Chứng nhận<span style="color:red">*</span></label>
										<input type="text" class="form-control" name="gpu" placeholder="Nhập chứng nhận" value="{{ old('gpu') }}">
									</div>
									@if($errors->has('gpu'))
									<div class="alert alert-danger">
										{{
	                                        $errors->first('gpu')
	                                    }}
									</div>
									@endif
									<div class="form-group">
										<label for="desc">Tác dụng phụ<span style="color:red">*</span></label>
										<input type="text" class="form-control" name="battery_capacity" placeholder="Nhập tác dụng phụ" value="{{ old('battery_capacity') }}">
									</div>
									@if($errors->has('battery_capacity'))
									<div class="alert alert-danger">
										{{
	                                        $errors->first('battery_capacity')
	                                    }}
									</div>
									@endif
									<div class="form-group">
										<label for="desc">Thông tin thêm<span style="color:red">*</span></label>
										<input type="text" class="form-control" name="sim" placeholder="Nhập thông tin thêm" value="{{ old('sim') }}">
									</div>
									@if($errors->has('sim'))
									<div class="alert alert-danger">
										{{
	                                        $errors->first('sim')
	                                    }}
									</div>
									@endif
									<div class="form-group">
										<label for="desc">Nhà cung cấp<span style="color:red">*</span></label>
										<input type="text" class="form-control" name="os" placeholder="Nhập nhà cung cấp" value="{{ old('os') }}">
									</div>
									@if($errors->has('os'))
									<div class="alert alert-danger">
										{{
	                                        $errors->first('os')
	                                    }}
									</div>
									@endif
									<div class="form-group">
										<label for="desc">Xuất xứ<span style="color:red">*</span></label>
										<input type="text" class="form-control" name="origin" placeholder="Nhập xuất xứ" value="{{ old('origin') }}">
									</div>
									@if($errors->has('origin'))
									<div class="alert alert-danger">
										{{
	                                        $errors->first('origin')
	                                    }}
									</div>
									@endif
									<div class="form-group">
										<label for="desc">Ngày sản xuất<span style="color:red">*</span></label>
										<input type="text" class="form-control" name="launch_time" placeholder="Nhập ngày sản xuất" value="{{ old('launch_time') }}">
									</div>
									@if($errors->has('launch_time'))
									<div class="alert alert-danger">
										{{
	                                        $errors->first('launch_time')
	                                    }}
									</div>
									@endif
									<div class="form-group">
										<label>Trạng thái<span style="color:red">*</span></label>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="status" value="1" checked="">
											<label class="form-check-label">Hiển thị</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="status" value="0">
											<label class="form-check-label">Ẩn</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="status" value="2">
											<label class="form-check-label">Đặt trước</label>
										</div>
									</div>

								</div>
								<div class="form-group">
									<fieldset id="buildyourform">
										<legend>Thêm thumbnail</legend>
									</fieldset>
									<input type="button" value="Thêm mới" class="add" id="add" />

								</div>
								<!-- /.card-body -->

								<div class="card-footer">
									<button type="submit" class="btn btn-primary">Thêm</button>
								</div>
						</form>
					</div>
					<!-- /.card -->
				</div>
				@endsection
				@section('script')
				<!-- Summernote -->
				<script src="admin/plugins/summernote/summernote-bs4.min.js"></script>
				<!-- CodeMirror -->
				<script src="admin/plugins/codemirror/codemirror.js"></script>
				<script src="admin/plugins/codemirror/mode/css/css.js"></script>
				<script src="admin/plugins/codemirror/mode/xml/xml.js"></script>
				<script src="admin/plugins/codemirror/mode/htmlmixed/htmlmixed.js"></script>
				<script>
					$(function() {
						// Summernote
						$('.summernote').summernote()

						// CodeMirror
						CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
							mode: "htmlmixed",
							theme: "monokai"
						});
					})
				</script>
				<script>
					$(document).ready(function() {
						//alert('ss');
						$("#category").change(function() {
							var id = $(this).val();
							$.get("ajax/group_product/" + id, function(data) {
								$("#group_product").html(data);
								//alert(data);
							});
							//alert(id);

						});
						$("#add").click(function() {
							var lastField = $("#buildyourform div:last");
							var intId = (lastField && lastField.length && lastField.data("idx") + 1) || 1;
							var fieldWrapper = $("<div class=\"fieldwrapper\" id=\"field" + intId + "\"/>");
							fieldWrapper.data("idx", intId);
							var fName = $("<input type=\"file\" class=\"fieldname\" name=\"file" + intId + "\"/> ");
							var removeButton = $("<input type=\"button\" class=\"remove\" value=\"Xóa\" />");
							removeButton.click(function() {
								$(this).parent().remove();
							});
							fieldWrapper.append(fName);
							fieldWrapper.append(removeButton);
							$("#buildyourform").append(fieldWrapper);
						});

					});
				</script>
				@endsection