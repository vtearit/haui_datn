@extends('admin.layouts.index')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Thêm mã giảm giá</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Mã giảm giá</a></li>
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
              <h3 class="card-title">Mã giảm giá mới</h3>
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

            <form method="POST" action="admin/ma-giam-gia/them">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="desc">Mã giảm giá</label>
                  <input type="text" class="form-control" name="code" placeholder="Nhập mã giảm giá" value="{{ old('code') }}">
                </div>
                @if($errors->has('code'))
                <div class="alert alert-danger">
                  {{
		                                        $errors->first('code')
		                                    }}
                </div>
                @endif
                <div class="form-group">
                  <label for="name">Tên mã giảm giá</label>
                  <input type="text" class="form-control" name="name" placeholder="Nhập tên mã giảm giá" value="{{ old('name') }}">
                </div>
                @if($errors->has('name'))
                <div class="alert alert-danger">
                  {{
                                        $errors->first('name')
                                    }}
                </div>
                @endif
                <div class="form-group">
                  <label for="desc">Số lần sử dụng</label>
                  <input type="number" class="form-control" name="time" placeholder="Nhập mô tả danh mục" value="{{ old('time') }}">
                </div>
                @if($errors->has('time'))
                <div class="alert alert-danger">
                  {{
                                        $errors->first('time')
                                    }}
                </div>
                @endif
                <div class="form-group">
                  <label>Loại mã giảm giá</label>

                  <select name="condition" class="form-control">
                    <option value="1">Theo phần trăm</option>
                    <option value="2" selected="">Theo tiền</option>
                    option
                  </select>
                </div>
                @if($errors->has('condition'))
                <div class="alert alert-danger">
                  {{
                                        $errors->first('condition')
                                    }}
                </div>
                @endif
                <div class="form-group">
                  <label for="desc">Tiền giảm|Phần trăm giảm</label>
                  <input type="number" class="form-control" name="number" value="{{ old('number') }}">
                </div>
                @if($errors->has('number'))
                <div class="alert alert-danger">
                  {{
		                                        $errors->first('number')
		                                    }}
                </div>
                @endif


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