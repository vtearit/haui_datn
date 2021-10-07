<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>VuBeauty</title>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Chi tiết đơn hàng</h1>
            </div>

          </div>
        </div><!-- /.container-fluid -->
      </section>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">



              <!-- Main content -->
              <div class="invoice p-3 mb-3">
                <!-- title row -->
                <div class="row">
                  <div class="col-12">
                    <h4>
                      <i class="fas fa-globe"></i> VuBeauty, Inc.
                      <small class="float-right">Ngày đặt: <?php echo date_format($order->created_at, "d/m/Y") ?></small>
                    </h4>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                  <div class="col-sm-8 invoice-col">
                    Khách hàng
                    <address>
                      <strong>{{$order->shipping->shipping_name}}</strong><br>

                      SĐT : {{$order->shipping->shipping_phone}}<br>
                      Địa chỉ : {{$order->shipping->shipping_address}}
                    </address>
                  </div>
                  <!-- /.col -->

                  <!-- /.col -->
                  <div class="col-sm-4 invoice-col">
                    <b>Mã đặt hàng: {{$order->order_code}}</b><br>

                    <b>ID:</b> {{$order->id}}<br>
                    <b>Ghi chú:</b>{{$order->shipping->shipping_note}} <br>
                    <b>Trạng thái:</b>{{$order->order_status}} <br>
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
                        <tr>
                          @foreach($order->orderDetails as $od)
                          <td><img src=" img/product/{{$od->product->product_image}}" width="50" alt=""></td>
                          <td>{{$od->product->product_name}}</td>
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
                    @if($order->shipping->shipping_method=="chuyển khoản")
                    <img src="admin/dist/img/credit/chuyenkhoan.jpg" alt="chuyenkhoan">
                    @elseif($order->shipping->shipping_method=="trực tiếp")
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
                          <td>{{number_format($order->order_total).' VNĐ'}}</td>
                        </tr>
                        @if($order->order_coupon>0)
                        <tr>
                          <th>Mã giảm giá</th>
                          <td>{{number_format($order->order_coupon).' VNĐ'}}</td>
                        </tr>
                        @endif
                        <tr>
                          <th>Phí ship:</th>
                          <td>{{number_format($order->order_feeship).' VNĐ'}}</td>
                        </tr>
                        <tr>
                          <th>Thanh toán:</th>
                          <td>{{number_format($order->order_payment).' VNĐ'}}</td>
                        </tr>
                      </table>
                    </div>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->


              </div>
              <!-- /.invoice -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>

  </div>
</body>