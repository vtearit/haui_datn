@extends('admin.layouts.index')
@section('css')

<link rel="stylesheet" href="admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">


<!-- Toastr -->
<link rel="stylesheet" href="admin/plugins/toastr/toastr.min.css">
@endsection
@section('content')
<div class="content-wrapper">

  @if(session('success'))
  <div class="alert alert-success">
    {{
                                        session('success')
                                    }}
  </div>
  @endif
  <div class="card card-info">
    <div class="card-header">
      <h3 class="card-title">Đơn hàng đang giao</h3>

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

          @foreach($shipping_order as $no)
          <tr>

            <td>{{$no->order_code}}</td>

            <td>
              <div>Khách hàng :{{$no->shipping->shipping_name}}
              </div>
              <div>SĐT :{{$no->shipping->shipping_phone}}
              </div>
              <div>{{$no->shipping->shipping_address}}
              </div>
            </td>
            <td>{{number_format($no->order_payment).' VNĐ'}}</td>
            <td>{{$no->shipping->shipping_method}}</td>
            <td>{{$no->shipping->shipping_note}}</td>
            <td class="text-right py-0 align-middle">
              <div class="btn-group btn-group-sm">
                <a href="admin/don-hang/hoan-thanh/{{$no->id}}" class="btn btn-success"><i class="fas fa-edit fa-spin fa-lg"></i></a>
                <a href="admin/don-hang/chi-tiet/{{$no->id}}" class="btn btn-info"><i class="fas fa-eye"></i></a>


                <a href="admin/don-hang/huy-don-hang/{{$no->id}}/{{$no->order_status}}" class="btn btn-danger"><i class="fas fa-trash"></i></a>
              </div>
            </td>

          </tr>
          @endforeach



        </tbody>
      </table>

    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <div class="col-sm-3"></div>
      <div class="col-sm-9 padding-center">{{ $shipping_order->links() }}</div>
    </div>
  </div>

</div>
@endsection
@section('script')



@endsection