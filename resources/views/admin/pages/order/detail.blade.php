@extends('admin.layouts.index')
@section('css')
<link href="frontend/css/sweetalert.css" rel="stylesheet">
@endsection
@section('content')
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
                    <small class="float-right">Ngày đặt: <?php echo date_format($order_view->created_at, "d/m/Y") ?></small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-8 invoice-col">
                  Khách hàng
                  <address>
                    <strong>{{$order_view->shipping->shipping_name}}</strong><br>

                    SĐT : {{$order_view->shipping->shipping_phone}}<br>
                    Địa chỉ : {{$order_view->shipping->shipping_address}}
                  </address>
                </div>
                <!-- /.col -->

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
                      <tr>
                        @foreach($order_view->orderDetails as $od)
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
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              @if($order_view->order_status!="Đã giao"&&$order_view->order_status!="Hủy")
              <div class="row no-print">
                <div class="col-12">


                  <a href="admin/don-hang/xac-nhan/{{$order_view->id}}" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Xác nhận đơn hàng</a>
                </div>
              </div>
              @endif

              <div class="row no-print">
                <div class="col-12">
                  <!-- <a href="/admin/don-hang/in-hoa-don/{{$order_view->id}}" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i>In</a> -->
                  <a href="admin/pdfview/{{$order_view->id}}" target="_blank" class="btn btn-default"><i class="fas fa-print"></i>In</a>
                </div>
              </div>

              
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

</div>

@endsection
@section('script')


@endsection