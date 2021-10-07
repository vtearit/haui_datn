@extends('admin.layouts.index')
@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Mã giảm giá</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/admin">Mã giảm giá</a></li>
            <li class="breadcrumb-item active">Danh sách</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    @if(isset($thongbao))
    <div class="alert alert-success">
      <?php
      echo $thongbao;
      ?>
    </div>
    @endif
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Mã giảm giá</th>
                  <th>Tên mã giảm giá</th>
                  <th>Số lần sử dụng</th>
                  <th>Loại mã giảm giá</th>
                  <th>Tiền giảm|Phần trăm giảm</th>
                  <th>Khách hàng sở hữu</th>
                  <th>Sửa</th>
                  <th>Ẩn</th>
                </tr>
              </thead>
              <tbody>
                @foreach($coupon as $c)
                <tr>
                  <td>{{$c->id}}</td>
                  <td>{{$c->coupon_code}}</td>
                  <td>{{$c->coupon_name}}</td>
                  <td>{{$c->coupon_time}}</td>

                  <td>
                    @if($c->coupon_condition==1)
                    Theo phần trăm
                    @else
                    Theo số tiền
                    @endif</td>
                  <td>{{$c->coupon_number}}</td>
                  <td>
                    @if($c->user_id==0)
                    Admin
                    @else
                    {{$c->user->user_name}}
                    @endif
                  </td>
                  <td class="center"><a class="btn btn-info btn-sm" href="admin/ma-giam-gia/sua/{{$c->id}}"><i class="fas fa-pencil-alt"></i></a></td>
                  <td class="center"><a href="admin/ma-giam-gia/xoa/{{$c->id}}" class="btn btn-danger"><i class="fas fa-trash"></i></a></td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>

              </tfoot>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
@endsection
@section('script')
<!-- DataTables  & Plugins -->
<script src="admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="admin/plugins/jszip/jszip.min.js"></script>
<script src="admin/plugins/pdfmake/pdfmake.min.js"></script>
<script src="admin/plugins/pdfmake/vfs_fonts.js"></script>
<script src="admin/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="admin/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="admin/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- Page specific script -->
<script>
  $(function() {
    $("#example1").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
@endsection