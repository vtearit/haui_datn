@extends('admin.layouts.index')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Thêm khách hàng</h1>
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
              <h3 class="card-title">Khách hàng mới mới</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            @if(isset($thongbao))
            <div class="alert alert-success">
              <?php
              echo $thongbao;
              ?>
            </div>
            @endif
            <form method="POST" action="admin/khach-hang/them">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="name">Tên khách hàng<span style="color:red">*</span></label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Nhập tên khách hàng" value="{{ old('name') }}">
                  @if($errors->has('name'))
                  <div class="alert alert-danger">
                    {{
                                        $errors->first('name')
                                    }}
                  </div>
                  @endif
                </div>
                <div class="form-group">
                  <label for="desc">Email<span style="color:red">*</span></label>
                  <input type="text" class="form-control" name="email" id="email" placeholder="Nhập email" value="{{ old('email') }}">
                </div>
                @if($errors->has('email'))
                <div class="alert alert-danger">
                  {{
                                        $errors->first('email')
                                    }}
                </div>
                @endif
                <div class="form-group">
                  <label for="desc">Password<span style="color:red">*</span></label>
                  <input type="password" class="form-control" name="pw" id="pw" placeholder="Nhập password" value="{{ old('pw') }}">
                </div>
                @if($errors->has('pw'))
                <div class="alert alert-danger">
                  {{
                                        $errors->first('pw')
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