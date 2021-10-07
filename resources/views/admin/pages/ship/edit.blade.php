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

            <form method="POST" action="admin/ship/sua/{{$fee->id}}">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="name">Địa chỉ<span style="color:red">*</span></label>
                  <input type="text" disabled class="form-control" name="name" id="name" value="{{$fee->xa->name_xaphuong}}-{{$fee->qh->name_quanhuyen}}-{{$fee->tp->name_city}}" placeholder="Nhập tên danh mục">
                </div>
                <div class="form-group">
                  <label for="fee">Phí<span style="color:red">*</span></label>
                  <input type="text" class="form-control" name="fee" id="fee" value="{{$fee->fee_feeship}}" placeholder="Nhập mô tả danh mục">
                </div>
                @if($errors->has('fee'))
                <div class="alert alert-danger">
                  {{
                                        $errors->first('fee')
                                    }}
                </div>
                @endif
                
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