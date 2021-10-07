<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Invoice Print</title>
  <base href="{{asset('')}}">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="admin/dist/css/adminlte.min.css">
</head>

<body>
  <div class="wrapper">
    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-12">
          <h2 class="page-header">
            <i class="fas fa-globe"></i> Vu Beauty, Inc.
            <small class="float-right">Ngày đặt: <?php echo date_format($order_view->created_at, "d/m/Y") ?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          From
          <address>
            <strong>Vu Beauty, Inc.</strong><br>
            Nhổn,Nam Từ Liêm,Hà Nội<br>

            Phone: 0123456789<br>
            Email: info@almasaeedstudio.com
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          Khách hàng
          <address>
            <strong>{{$order_view->shipping->shipping_name}}</strong><br>

            SĐT : {{$order_view->shipping->shipping_phone}}<br>
            Địa chỉ : {{$order_view->shipping->shipping_address}}
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Mã đặt hàng: {{$order_view->order_code}}</b><br>

          <b>ID:</b> {{$order_view->id}}<br>
          <b>Ghi chú:</b>{{$order_view->shipping->shipping_note}} <br>
          <b>Trạng thái:</b>{{$order_view->order_status}} <br>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-12 table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Sản phẩm</th>
                <th>Tên</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
              </tr>
            </thead>
            <tbody>
              @foreach($order_view->orderDetails as $od)
              <tr>

                <td><img src="img/product/{{$od->product->product_image}}" width="50" alt=""></td>
                <td>{{$od->product_name}}</td>
                <td>{{number_format($od->product_price).' VNĐ'}}</td>
                <td>{{$od->product_sales_quantity}}</td>
                <td>{{number_format($od->product_price*$od->product_sales_quantity).' VNĐ'}}</td>
              </tr>
              @endforeach



            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-6">
          <p class="lead">Phương thức thanh toán:</p>
          @if($order_view->shipping->shipping_method=="chuyển khoản")
          <img src="admin/dist/img/credit/chuyenkhoan.jpg" alt="chuyenkhoan">
          @elseif($order_view->shipping->shipping_method=="trực tiếp")
          <img src="admin/dist/img/credit/tructiep.jpg" alt="tructiep">
          @else
          <img src="admin/dist/img/credit/paypal2.png" alt="Paypal">
          @endif

        </div>
        <!-- /.col -->
        <div class="col-6">
          <h3>Tính tiền</h3>

          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%">Thành tiền:</th>
                <td>{{number_format($order_view->order_total).' VNĐ'}}</td>
              </tr>
              @if($order_view->order_coupon>0)
              <tr>
                <th>Mã giảm giá</th>
                <td>{{number_format($order_view->order_coupon).' VNĐ'}}</td>
              </tr>
              @endif
              <tr>
                <th>Phí ship:</th>
                <td>{{number_format($order_view->order_feeship).' VNĐ'}}</td>
              </tr>
              <tr>
                <th>Thanh toán:</th>
                <td>{{number_format($order_view->order_payment).' VNĐ'}}</td>
              </tr>
            </table>
          </div>
        </div>
        <!-- <a href="admin/pdfview/{{$order_view->id}}" target="_blank" class="btn btn-default"><i class="fas fa-print"></i>In</a> -->
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- ./wrapper -->
  <!-- Page specific script -->
  <script src="asset/jquery/jquery.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
    window.addEventListener("load", window.print());
    });
  </script>
</body>

</html>