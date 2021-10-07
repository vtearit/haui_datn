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
            <form method="POST" enctype="multipart/form-data" action="admin/nhom-san-pham/them">
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
                  <input type="text" class="form-control" name="name" id="name" placeholder="Nhập tên nhóm sản phẩm" value="{{ old('name') }}">
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
                  <label>Review<span style="color:red">*</span></label>
                  <div class="col-md-12">
                    <div class="card card-outline card-info">
                      <!-- /.card-header -->
                      <div class="card-body">
                        <textarea class="summernote" name="review" placeholder="Nhập review nhóm sản phẩm" value="{{ old('review') }}">

						              </textarea>
                      </div>
                    </div>
                  </div>
                </div>
                @if($errors->has('review'))
                <div class="alert alert-danger">
                  {{
	                                        $errors->first('review')
	                                    }}
                </div>
                @endif
                <div class="form-group">
                  <label>Mô tả<span style="color:red">*</span></label>
                  <div class="col-md-12">
                    <div class="card card-outline card-info">
                      <!-- /.card-header -->
                      <div class="card-body">
                        <textarea class="summernote" name="desc" placeholder="Nhập mô tả nhóm sản phẩm" value="{{ old('desc') }}">

						              </textarea>
                      </div>
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
                  <label>Trạng thái<span style="color:red">*</span></label>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" value="1" checked="">
                    <label class="form-check-label">Hiển thị</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" value="0">
                    <label class="form-check-label">Ẩn</label>
                  </div>
                </div>

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

          });
        </script>
        @endsection