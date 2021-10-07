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
          <h1>Sửa sản phẩm</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Sản phẩm</a></li>
            <li class="breadcrumb-item active">Sửa</li>
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
              <h3 class="card-title">Sửa sản phẩm</h3>
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
            <form method="POST" enctype="multipart/form-data" action="admin/san-pham/sua/{{$product->id}}">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="name">Tên danh mục</label>
                  <select name="category" id="category" class="form-control">
                    @foreach($category as $c)
                    <option value="{{$c->id}}" @if($c->id==$product->category_id)
                      {{"selected"}}
                      @endif
                      >{{$c->category_name}}
                    </option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label for="name">Tên nhóm sản phẩm</label>
                  <select name="group_product" id="group_product" class="form-control">
                    <option value="{{$product->groupProduct->id}}">{{$product->groupProduct->group_product_name}}</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="name">Tên sản phẩm</label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Nhập tên danh mục" value="{{$product->product_name}}">
                </div>
                @if($errors->has('name'))
                <div class="alert alert-danger">
                  {{
	                                        $errors->first('name')
	                                    }}
                </div>
                @endif
                <div class="form-group">
                  <label>Hình ảnh</label>
                  <img width="100px" height="150px" src="img/product/{{$product->product_image}}" alt="">
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
                  <label>Mô tả</label>
                  <div class="col-md-12">
                    <div class="card card-outline card-info">
                      <!-- /.card-header -->
                      <div class="card-body">
                        <textarea class="summernote" name="desc" placeholder="Nhập mô tả sản phẩm" value="{{ old('desc') }}">
                        {{$product->product_desc}}
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
                    <label for="desc">Số lượng</label>
                    <input type="number" class="form-control" name="qty" placeholder="Nhập số lượng sản phẩm" value="{{$product->product_qty}}">
                  </div>
                  @if($errors->has('qty'))
                  <div class="alert alert-danger">
                    {{
	                                        $errors->first('qty')
	                                    }}
                  </div>
                  @endif
                  <div class="form-group">
                    <label for="desc">Giá nhập</label>
                    <input type="number" class="form-control" name="import" placeholder="Nhập giá nhập sản phẩm" value="{{$product->product_import}}">
                  </div>
                  @if($errors->has('import'))
                  <div class="alert alert-danger">
                    {{
	                                        $errors->first('import')
	                                    }}
                  </div>
                  @endif
                  <div class="form-group">
                    <label for="desc">Giá bán</label>
                    <input type="number" class="form-control" name="price" placeholder="Nhập giá bán sản phẩm" value="{{$product->product_price}}">
                  </div>
                  @if($errors->has('price'))
                  <div class="alert alert-danger">
                    {{
	                                        $errors->first('price')
	                                    }}
                  </div>
                  @endif
                  <div class="form-group">
                    <label>Trạng thái</label>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="status" value="1" @if($product->product_status==1)
                      {{"checked"}}
                      @endif
                      >
                      <label class="form-check-label">Hiển thị</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="status" value="0" @if($product->product_status==0)
                      {{"checked"}}
                      @endif
                      >
                      <label class="form-check-label">Ẩn</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="status" value="2" @if($product->product_status==2)
                      {{"checked"}}
                      @endif
                      >
                      <label class="form-check-label">Đặt trước</label>
                    </div>
                  </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Cập nhật</button>
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
            $("#category").change(function() {
              var id = $(this).val();
              $.get("ajax/group_product/" + id, function(data) {
                $("#group_product").html(data);
              });
            });

          });
        </script>
        @endsection