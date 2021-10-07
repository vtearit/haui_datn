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

            <form method="POST" action="admin/ma-giam-gia/sua/{{$coupon->id}}">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="desc">Mã giảm giá</label>
                  <input type="text" class="form-control" name="code" value="{{$coupon->coupon_code}}">
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
                  <input type="text" class="form-control" name="name" value="{{$coupon->coupon_name}}">
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
                  <input type="number" class="form-control" name="time" value="{{$coupon->coupon_time}}">
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
                    <option value="1" @if($coupon->coupon_condition==1)
                      {{"selected"}}
                      @endif
                      >Theo phần trăm
                    </option>
                    <option value="2" @if($coupon->coupon_condition==2)
                      {{"selected"}}
                      @endif>Theo tiền
                    </option>
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
                  <input type="number" class="form-control" name="number" value="{{$coupon->coupon_number}}">
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
                <button type="submit" class="btn btn-primary">Cập nhật</button>
              </div>
            </form>
          </div>
          <!-- /.card -->
        </div>
        @endsection