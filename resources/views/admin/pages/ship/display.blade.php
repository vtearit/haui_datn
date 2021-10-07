@extends('admin.layouts.index')
@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<!-- sweetalert2 -->
<link rel="stylesheet" href="admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<!-- Toastr -->
<link rel="stylesheet" href="admin/plugins/toastr/toastr.min.css">
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
                  <th>Địa chỉ</th>
                  <th>Phí</th>
                  <th>Sửa</th>
                </tr>
              </thead>
              <tbody>
                @foreach($fee as $f)
                <tr>
                  <td>{{$f->id}}</td>
                  <td>{{$f->xa->name_xaphuong}}-{{$f->qh->name_quanhuyen}}-{{$f->tp->name_city}}</td>
                  <td>
                   {{$f->fee_feeship}}
                  </td>
                  <td class="center"><a class="btn btn-info btn-sm" href="admin/ship/sua/{{$f->id}}"><i class="fas fa-pencil-alt"></i></a></td>
                  
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

<!-- SweetAlert2 -->
<script src="admin/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="admin/plugins/toastr/toastr.min.js"></script>
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
<script type="text/javascript">
  $(document).ready(function() {
    $('.message').click(function() {
      var id = $(this).data('id');
      var category = $('.name_' + id).val();
      var token = $('input[name="_token"]').val();
      Swal.fire({
        title: 'Bạn có chắc chắn xóa danh mục ' + category + ' và tất cả dữ liệu liên quan',
        //text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            method: 'POST',
            url: 'admin/danh-muc/xoa',
            data: {
              id: id,
              category: category,
              _token: token
            },
            success: function(data) {
              if (data == "none") {
                alert('Vui lòng xóa hết các dữ liệu liên quan trước khi xóa danh mục');
              } else {
                alert('Xóa danh mục ' + category + ' thành công');
              }

            }

          });

          location.reload();

        }
      })

    });
    $('.status').click(function() {
      var id = parseInt($(this).data('id'));
      var status = $('.status_' + id).val();
      var token = $('input[name="_token"]').val();
      $.ajax({
        method: 'POST',
        url: 'admin/danh-muc/cap-nhat-trang-thai',
        data: {
          id: id,
          status: status,
          _token: token
        },
        success: function() {
          // alert('Cập nhật danh mục '+category+' thành công');
        }

      });
      location.reload();
    });


  });
</script>

<!-- $("#my_image").attr("src","second.jpg"); -->
@endsection