@extends('admin.layouts.index')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Sửa slider</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Slider</a></li>
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
              <h3 class="card-title">Slider mới</h3>
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

            <form method="POST" action="admin/slider/sua/{{$slider->id}}" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label>Hình ảnh</label>
                  <input type="file" name="image" />
                  <div>
                    <img src="img/slider/{{$slider->image}}" width="300px" height="100px" alt="" />
                  </div>


                </div>
                @if($errors->has('image'))
                <div class="alert alert-danger">
                  {{
                                        $errors->first('image')
                                    }}
                </div>
                @endif
                <div class="form-group">
                  <label>Trạng thái</label>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" value="2" @if($slider->status==2)
                    {{"checked"}}
                    @endif
                    />
                    <label class="form-check-label">Slider chính</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" value="1" @if($slider->status==1)
                    {{"checked"}}
                    @endif
                    />
                    <label class="form-check-label">Hiển thị</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" value="0" @if($slider->status==0)
                    {{"checked"}}
                    @endif
                    />
                    <label class="form-check-label">Ẩn</label>
                  </div>
                </div>

              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Sửa</button>
              </div>
            </form>
          </div>
          <!-- /.card -->
        </div>
        @endsection