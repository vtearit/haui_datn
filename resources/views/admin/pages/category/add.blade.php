@extends('admin.layouts.index')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Thêm danh mục</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Danh mục</a></li>
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
              <h3 class="card-title">Danh mục mới</h3>
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
            @if($errors->has('name'))
            <div class="alert alert-danger">
              {{
                                        $errors->first('name')
                                    }}
            </div>
            @endif
            <form method="POST" action="admin/danh-muc/them">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="name">Tên danh mục <span style="color:red">*</span></label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Nhập tên danh mục" value="{{ old('name') }}">
                </div>
                <div class="form-group">
                  <label for="desc">Mô tả<span style="color:red">*</span></label>
                  <input type="text" class="form-control" name="desc" id="desc" placeholder="Nhập mô tả danh mục" value="{{ old('desc') }}">
                </div>
                @if($errors->has('desc'))
                <div class="alert alert-danger">
                  {{
                                        $errors->first('desc')
                                    }}
                </div>
                @endif
                <div class="form-group">
                  <label>Trạng thái</label>
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