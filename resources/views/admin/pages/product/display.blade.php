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
          <h1>DataTables</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">DataTables</li>
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
                  <th>Tên sản phẩm</th>
                  <th>Ảnh</th>
                  <th>Danh mục</th>
                  <th>Nhóm sản phẩm</th>
                  <th>Mô tả</th>
                  <th>Số lượng</th>
                  <th>Review</th>
                  <th>Giá bán</th>
                  <th>Giá nhập</th>
                  <th>Giá khuyến mãi</th>
                  <th>Ngày bắt đầu khuyến mãi</th>
                  <th>Ngày kết thúc khuyến mãi</th>
                  <th>Trạng thái</th>
                  <th>Lượt xem</th>
                  <th>Sửa</th>
                  <th>Ẩn</th>
                </tr>
              </thead>
              <tbody>
                @foreach($product as $p)
                <tr>
                  <td>{{$p->id}}</td>
                  <td>{{$p->product_name}}</td>
                  <td><img width="50px" height="80px" src="img/product/{{$p->product_image}}" alt=""></td>
                  <td>{{$p->groupProduct->category->category_name}}</td>
                  <td>{{$p->groupProduct->group_product_name}}</td>
                  <td>{{$p->product_desc}}</td>
                  <td>{{$p->product_qty}}</td>
                  <td>{{$p->product_review}}</td>
                  <td>{{$p->product_price}}</td>
                  <td>{{$p->product_import}}</td>
                  <td>{{$p->product_promotion}}</td>
                  <td>{{$p->begin_promotion}}</td>
                  <td>{{$p->end_promotion}}</td>
                  <td>

                    @if($p->product_status==1)
                    <span class="badge badge-success">
                      {!! "Hiển thị" !!}
                    </span>

                    @elseif ($p->product_status==0)
                    <span class="badge badge-danger">
                      {{"Ẩn"}}
                    </span>
                    @else
                    <span class="badge badge-warning">
                      {{"Đặt trước"}}
                    </span>
                    @endif

                  </td>
                  <td>{{$p->product_view}}</td>
                  <td class="center"><a class="btn btn-info btn-sm" href="admin/san-pham/sua/{{$p->id}}"><i class="fas fa-pencil-alt"></i></a></td>
                  <td class="center"><a href="admin/san-pham/xoa/{{$p->id}}" class="btn btn-danger"><i class="fas fa-trash"></i></a></td>
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