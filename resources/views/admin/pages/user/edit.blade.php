@extends('admin.layouts.index')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Sửa thông tin khách hàng</h1>
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
              <h3 class="card-title">Thông tin khách hàng</h3>
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

            <form method="POST" action="admin/khach-hang/sua/{{$user->id}}" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="name">Tên khách hàng<span style="color:red">*</span></label>
                  <input type="text" class="form-control" name="name" id="name" value="{{$user->user_name}}">
                </div>
                @if($errors->has('name'))
                <div class="alert alert-danger">
                  {{
                                        $errors->first('name')
                                    }}
                </div>
                @endif
                <div class="form-group">
                  <label>Avatar</label>
                  @if($user->user_avatar!="")
                  <img width="100px" height="150px" src="img/avatar/{{$user->user_avatar}}" alt="">
                  @endif
                  <br />
                  <input type="file" name="avatar" value="{{ old('avatar') }}" />
                </div>
                @if($errors->has('avatar'))
                <div class="alert alert-danger">
                  {{
	                                        $errors->first('avatar')
	                                    }}
                </div>
                @endif
                <div class="form-group">
                  <label for="desc">Email<span style="color:red">*</span></label>
                  <input type="email" disabled class="form-control" name="email" id="email" value="{{$user->user_email}}">
                </div>
                @if($errors->has('email'))
                <div class="alert alert-danger">
                  {{
                                        $errors->first('email')
                                    }}
                </div>
                @endif
                <div class="form-group">
                  <label for="desc">Password</label>
                  <button type="button" class="change-pw" data-toggle="colapse">Thay đổi</button>
                  <input style="display:none" type="password" class="form-control pw" name="pw" id="pw" />
                </div>
                @if($errors->has('pw'))
                <div class="alert alert-danger">
                  {{
                                        $errors->first('pw')
                                    }}
                </div>
                @endif
                <div class="form-group">
                  <label for="name">SĐT</label>
                  <input type="text" class="form-control" name="phone" value="{{$user->user_phone}}">
                </div>
                <div class="form-group">
                  <label for="name">Địa chỉ</label>
                  <button type="button" id="change" class="btn btn-infor">Thay đổi</button>
                  @if($user->xaid!="")
                  <input type="text" disabled class="form-control" value="{{$user->xa->name_xaphuong}}-{{$user->qh->name_quanhuyen}}-{{$user->tp->name_city}}" />
                  <br />
                  @endif


                  <div id="change_address" style="display: none">
                    <select id="tinhthanhpho" name="matp" class="form-control">
                      <option disabled selected>-- Tỉnh/Thành phố --</option>
                      @foreach($tinh_thanh_pho as $ttp)
                      <option value="{{$ttp->matp}}">{{$ttp->name_city}}</option>
                      @endforeach
                    </select>
                    @if($errors->has('matp'))
                    <div class="alert alert-danger">
                      {{$errors->first('matp')}}
                    </div>
                    @endif
                    <br />
                    <select id="quanhuyen" name="maqh" class="form-control">
                      <option disabled selected>-- Quận/huyện --</option>
                    </select>
                    @if($errors->has('maqh'))
                    <div class="alert alert-danger">
                      {{$errors->first('maqh')}}
                    </div>
                    @endif
                    <br />
                    <select id="xaphuongthitran" name="xaid" class="form-control">
                      <option disabled selected>-- Xã/Phường/Thị trấn --</option>
                    </select>
                    @if($errors->has('xaid'))
                    <div class="alert alert-danger">
                      {{$errors->first('xaid')}}
                    </div>
                    @endif
                  </div>
                  <div class="form-group">
                    <label>Trạng thái</label>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="status" value="1" @if($user->status==1)
                      {{"checked"}}
                      @endif
                      >
                      <label class="form-check-label">Hiển thị</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="status" value="0" @if($user->status==0)
                      {{"checked"}}
                      @endif
                      >
                      <label class="form-check-label">Ẩn</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Verify</label>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="verify" value="1" @if($user->user_verify==1)
                      {{"checked"}}
                      @endif
                      >
                      <label class="form-check-label">Kích hoạt</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="verify" value="0" @if($user->user_verify==0)
                      {{"checked"}}
                      @endif
                      >
                      <label class="form-check-label">Ẩn</label>
                    </div>
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
        <script>
          $(document).ready(function() {
            $(".change-pw").click(function() {
              $(".change-pw").toggle();
              $("#pw").removeAttr('style');
            });

          });
        </script>
        <script>
          $(document).ready(function() {
            $('#change').click(function() {
              $('#change_address').toggle();
            });
            //alert('ss');
            $("#tinhthanhpho").change(function() {
              var id = $(this).val();
              $.get("thanh-toan/quan-huyen/" + id, function(data) {
                $("#quanhuyen").html(data);
                //alert("a");
              });
              //alert(id);
            });
            $("#quanhuyen").change(function() {
              var id = $(this).val();
              $.get("thanh-toan/xa-phuong/" + id, function(data) {
                $("#xaphuongthitran").html(data);
                //alert("a");
              });
              //alert(id);
            });
            $("#xaphuongthitran").change(function() {
              var xaid = $(this).val();
              var matp = $("#tinhthanhpho").val();

              var maqh = $("#quanhuyen").val();
              $.get("ajax/" + matp + "/" + maqh + "/" + xaid, function(data) {
                $("#payment").html(data);

                //alert(data);
              });
              /*alert(matp);
              alert(maqh);
              alert(xaid);
              */

            });
          });
        </script>
        @endsection