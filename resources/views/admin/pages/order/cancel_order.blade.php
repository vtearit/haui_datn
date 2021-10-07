@extends('admin.layouts.index')
@section('css')

<link rel="stylesheet" href="admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">


<!-- Toastr -->
<link rel="stylesheet" href="admin/plugins/toastr/toastr.min.css">
@endsection
@section('content')
<div class="content-wrapper">
  <div class="card card-info">
    <div class="card-header">
      <h3 class="card-title">Đơn hàng hủy</h3>

      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
          <i class="fas fa-minus"></i>
        </button>
      </div>
    </div>
    <div class="card-body p-0">
      <table class="table">
        <thead>
          <tr>
            <th>Mã đơn hàng</th>
            <th>Thông tin khách hàng</th>
            <th>Tổng tiền</th>
            <th>Phương thức thanh toán</th>
            <th>Ghi chú</th>
            <th></th>
          </tr>
        </thead>
        <tbody>

          @foreach($order as $o)
          <tr>

            <td>{{$o->order_code}}</td>

            <td>
              <div>Khách hàng :{{$o->shipping->shipping_name}}
              </div>
              <div>SĐT :{{$o->shipping->shipping_phone}}
              </div>
              <div>{{$o->shipping->shipping_address}}
              </div>
            </td>
            <td>{{number_format($o->order_payment).' VNĐ'}}</td>
            <td>{{$o->shipping->shipping_method}}</td>
            <td>{{$o->order_note}}</td>
            <td class="text-right py-0 align-middle">
              <div class="btn-group btn-group-sm">

                <a href="admin/don-hang/chi-tiet/{{$o->id}}" class="btn btn-info"><i class="fas fa-eye"></i></a>


                <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a>
              </div>
            </td>

          </tr>
          @endforeach



        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <div class="col-sm-4"></div>
      <div class="col-sm-8 padding-center">{{ $order->links() }}</div>
    </div>
  </div>
</div>
@endsection
@section('script')

<!-- SweetAlert2 -->
<script src="admin/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="admin/plugins/toastr/toastr.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {

        $('.confirm-order').click(function() {
          var order_id = $(this).data('id_order');

          var token = $('input[name="_token"]').val();
          //swal("Hello world!");
          //alert(token);

          $.ajax({
            method: 'POST',
            url: 'admin/don-hang/xac-nhan',
            data: {
              order_id: order_id,
              _token: token
            },
            success: function() {
              const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true,
                didOpen: (toast) => {
                  toast.addEventListener('mouseenter', Swal.stopTimer)
                  toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
              })

              Toast.fire({
                icon: 'success',
                title: 'Xác nhận đơn hàng thành công'
              })




            }

          });

        });
</script>
<!-- Page specific script -->

@endsection