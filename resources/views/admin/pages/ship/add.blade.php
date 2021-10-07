@extends('admin.layouts.index')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Thêm phí</h1>
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
              <h3 class="card-title">Phí</h3>
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
            <form method="POST" action="admin/ship/them">
              @csrf
              <div class="card-body">
                <div class="form-group">
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
                  <label for="fee">Phí <span style="color:red">*</span></label>
                  <input type="text" class="form-control" name="fee" id="fee" placeholder="Nhập phí" value="{{ old('name') }}">
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