@extends('admin.layouts.index')
@section('css')
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- iCheck -->
<link rel="stylesheet" href="admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<!-- JQVMap -->
<link rel="stylesheet" href="admin/plugins/jqvmap/jqvmap.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="admin/dist/css/adminlte.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
<!-- Daterange picker -->
<link rel="stylesheet" href="admin/plugins/daterangepicker/daterangepicker.css">
<!-- summernote -->
<link rel="stylesheet" href="admin/plugins/summernote/summernote-bs4.min.css">
<!-- datepicker -->
<!-- <link rel="stylesheet" href="admin/datepicker/main.css">
  <link rel="stylesheet" href="admin/datepicker/base.css">
  <link rel="stylesheet" href="admin/datepicker/docsearch.min.css">
  <link rel="stylesheet" href="admin/datepicker/docsearch.css"> -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!--  <link rel="stylesheet" href="/resources/demos/style.css"> -->
<!-- morris chart -->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
@endsection
@section('content')

<div class="content-wrapper">

  <section class="content">


    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->




      <div class="row">

        <?php ?>
      </div>


      <div class="card-body pad table-responsive">
        <h3 class="text-center"><code>Thống kê</code></h3>
        <table class="table  text-center">
          <tr>
            <form action="javascript:void(0);">
              @csrf
              <th><span>Ngày bắt đầu:</span> </th>
              <th><input type="text" name="begin" id="begin" value="{{ old('begin') }}"></th>
              <th>Ngày kết thúc:</th>
              <th><input type="text" name="end" id="end" value="{{ old('end') }}"></th>
              <th><input type="submit" value="Lọc" class="filter btn-btn-success"></th>
              @for($i=0;$i<12;$i++) <th>
                </th>
                @endfor

            </form>
          </tr>
        </table>
      </div>

      <div class="row filter-box">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <p>Tháng {{$month}}</p>
              <h3>{{count($order)}}</h3>

              <p>Đơn đặt hàng hoàn thành</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <p>Tháng {{$month}}</p>
              <!-- <h3>53<sup style="font-size: 20px">%</sup></h3> -->
              <h3>{{count($order_total)}}</h3>
              <p>Tổng đơn hàng</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <p>Tháng {{$month}}</p>
              <h3>{{count($user)}}</h3>

              <p>Khách hàng mới</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <p>Tháng {{$month}}</p>
              <h3>{{count($cancel_order)}}</h3>
              <p>Đơn hàng hủy</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->




      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-lg-12 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-chart-pie mr-1"></i>
                Doanh số
              </h3>
              <div class="card-tools">
                <ul class="nav nav-pills ml-auto">
                  <li class="nav-item">
                    <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Bar</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#sales-chart" data-toggle="tab">Line</a>
                  </li>
                </ul>
              </div>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content p-0">
                <!-- Morris chart - Sales -->
                <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;">
                  <div id="myfirstchart" style="height: 250px;"></div>
                </div>
                <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                  <div id="chartLine" style="height: 250px;"></div>
                </div>
              </div>
            </div><!-- /.card-body -->
          </div>
          <!-- /.card -->

          <!-- DIRECT CHAT -->

          <!--/.direct-chat -->

          <!-- TO DO List -->

        </div>
        <!-- /.card -->
      </div>
      <!-- /.Left col -->
      <!-- right col (We are only adding the ID to make the widgets sortable)-->

      <!-- right col -->
    </div>
    <div class="card-body pad table-responsive filter-sell-product" id="filter-sell-product">
      <h5>Sản phẩm đã bán trong tháng {{$month}}</h5>
      <table class="table table-bordered  text-center">
        <tr>
          <th>ID</th>
          <th>Ảnh</th>
          <th>Tên sản phẩm</th>
          <th>Số lượng bán</th>
        </tr>
        @foreach($sell_product as $sp)
        <tr>
          <td>{{$sp->id}}</td>
          <td><img width="50px" height="50px" src="img/product/{{$sp->product_image}}" alt=""></td>
          <td>{{$sp->product_name}}</td>
          <td>{{$sp->total_sales}}</td>
        </tr>
        @endforeach
      </table>
    </div>
    <div class="card-body pad table-responsive">
      <h5>Sản phẩm được xem nhiều nhất</h5>
      <table class="table table-bordered  text-center">
        <tr>
          <th>ID</th>
          <th>Ảnh</th>
          <th>Tên sản phẩm</th>
          <th>Lượt xem</th>
        </tr>
        @foreach($most_view as $mv)
        <tr>
          <td>{{$mv->id}}</td>
          <td><img width="50px" height="50px" src="img/product/{{$mv->product_image}}" alt=""></td>
          <td>{{$mv->product_name}}</td>
          <td>{{$mv->product_view}}</td>
        </tr>
        @endforeach
      </table>
    </div>
    <div class="card-body pad table-responsive">
      <h5>Kho tháng {{$month}}</h5>
      <table class="table table-bordered  text-center">
        <tr>
          <th>Sản phẩm mới</th>
          <th>Sản phẩm đã bán</th>
          <th>Tồn kho</th>
        </tr>
        <tr>
          <td>{{$new_product}}</td>
          <td>{{$product_sell}}</td>
          <td>{{$product_in_store}}</td>
        </tr>
      </table>
    </div>
    <!-- /.row (main row) -->
</div><!-- /.container-fluid -->
</section>
</div>
@endsection
@section('script')
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

<!-- ChartJS -->
<script src="admin/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline
<script src="admin/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->

<!-- jQuery Knob Chart -->
<script src="admin/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="admin/plugins/moment/moment.min.js"></script>
<script src="admin/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="admin/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="admin/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="admin/dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="admin/dist/js/pages/dashboard.js"></script> -->

<!-- datepicker -->
<script src="admin/datepicker/modernizr.custom.2.8.3.min.js"></script>
<script src="admin/datepicker/plugin.js"></script>
<script src="admin/datepicker/main.js"></script>
<!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->

<!-- morris chart -->

<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script>
  $(function() {
    $("#begin").datepicker({
      dateFormat: 'yy/mm/dd',

    });
    $("#end").datepicker({
      dateFormat: 'yy/mm/dd',

    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    sortMonth();

    function sortMonth() {

      var token = $('input[name="_token"]').val();

      $.ajax({
        method: 'POST',
        url: 'admin/thang',

        //datatype: 'JSON',
        dataType: 'json',
        data: {
          _token: token
        },
        success: function(data) {
          // alert(data);
          // //$('#data').val(data);
          // // chart.setData(data);
          // console.log(data);
          // console.log("test");
          chart.setData(data);
          chartLine.setData(data);
          //chart.update(); 
        },
        error: function(msg) {
          alert("Không có dữ liệu");
        }
      });
    }
    var chart = new Morris.Bar({

      element: 'myfirstchart',

      parseTime: false,


      xkey: 'date',

      ykeys: ['order_qty', 'sales', 'coupon', 'profit'],

      hideHover: 'auto',

      labels: ['Số đơn', 'Tổng tiền', 'Mã giảm giá', 'Lợi nhuận']

    });
    var chartLine = new Morris.Line({

      element: 'chartLine',

      parseTime: false,


      xkey: 'date',

      ykeys: ['order_qty', 'sales', 'coupon', 'profit'],

      hideHover: 'auto',

      labels: ['Số đơn', 'Tổng tiền', 'Mã giảm giá', 'Lợi nhuận']

    });
    $('.filter').click(function() {
      var begin = $('#begin').val();
      var end = $('#end').val();
      var token = $('input[name="_token"]').val();


      $.ajax({
        method: 'POST',
        url: 'admin/loc',

        //datatype: 'JSON',
        dataType: 'json',
        data: {
          begin: begin,
          end: end,
          _token: token
        },
        success: function(data) {
          // alert(data);
          // //$('#data').val(data);
          // // chart.setData(data);
          // console.log(data);
          // console.log("test");
          chart.setData(data);
          chartLine.setData(data);
          //chart.update(); 
        },
        error: function(msg) {
          alert("Không có dữ liệu");
        }
      });
      $.ajax({
        method: 'POST',
        url: 'admin/box',
        data: {
          begin: begin,
          end: end,
          _token: token
        },
        success: function(data) {
          $('.filter-box').html(data);
        }

      });
      $.ajax({
        method: 'POST',
        url: 'admin/sell-product',
        data: {
          begin: begin,
          end: end,
          _token: token
        },
        success: function(data) {
          $('.filter-sell-product').html(data);
        }

      });

    });

  });
</script>

@endsection