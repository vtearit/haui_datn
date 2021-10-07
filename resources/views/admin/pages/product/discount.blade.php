@extends('admin.layouts.index')
@section('css')
<!-- Daterange picker -->
<link rel="stylesheet" href="admin/plugins/daterangepicker/daterangepicker.css">

<!-- datepicker -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

@endsection
@section('content')
<section class="content-wrapper">
  <div class="container-fluid">
    <div class="row">

      <div class="col-md-12">
        <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">Giảm giá sản phẩm</h3>
          </div>
        </div>
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#all" data-toggle="tab">Toàn bộ cửa hàng</a></li>
              <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Theo danh mục</a></li>
              <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Theo nhóm sản phẩm</a></li>
              <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Theo sản phẩm</a></li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="active tab-pane" id="all">
                @if(session('thongbao'))
                <div class="alert alert-success">
                  {{
                                        session('thongbao')
                                    }}
                </div>
                @endif
                <form class="form-horizontal" method="POST" action="admin/san-pham/giam-gia" autocomplete="off">
                  @csrf

                  <div class="form-group row">
                    <label for="inputEmail" class="col-sm-2 col-form-label">Loại hình giảm</label>
                    <div class="col-sm-10">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" checked="" value="0">
                        <label class="form-check-label">Tiền</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" value="1">
                        <label class="form-check-label">Theo phần trăm</label>
                      </div>
                    </div>
                    @if($errors->has('type'))
                    <div class="alert alert-danger">
                      {{
                                                  $errors->first('type')
                                              }}
                    </div>
                    @endif
                  </div>
                  <div class="form-group row">
                    <label for="inputName2" class="col-sm-2 col-form-label">Số tiền giảm|Phần trăm giảm</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="money" placeholder="Nhập số tiền giảm|phần trăm giảm" value="{{ old('money') }}" />
                    </div>
                  </div>
                  @if($errors->has('money'))
                  <div class="alert alert-danger">
                    {{
                                                $errors->first('money')
                                            }}
                  </div>
                  @endif
                  <div class="form-group row">
                    <label for="inputExperience" class="col-sm-2 col-form-label">Ngày bắt đầu:</label>
                    <div class="col-sm-10">
                      <input type="text" name="begin" class="begin" value="{{ old('begin') }}">
                    </div>
                  </div>
                  @if($errors->has('begin'))
                  <div class="alert alert-danger">
                    {{
                                                $errors->first('begin')
                                            }}
                  </div>
                  @endif
                  <div class="form-group row">
                    <label for="inputSkills" class="col-sm-2 col-form-label">Ngày kết thúc:</label>
                    <div class="col-sm-10">
                      <input type="text" name="end" class="end" value="{{ old('end') }}">
                    </div>
                  </div>
                  @if($errors->has('end'))
                  <div class="alert alert-danger">
                    {{
                                                $errors->first('end')
                                            }}
                  </div>
                  @endif

                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Áp dụng</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="activity">
                @if(session('thongbao'))
                <div class="alert alert-success">
                  {{
                                        session('thongbao')
                                    }}
                </div>
                @endif
                <form class="form-horizontal" method="POST" action="admin/san-pham/giam-gia" autocomplete="off">
                  @csrf
                  <div class="form-group row">
                    <label for="inputName" class="col-sm-2 col-form-label">Tên danh mục</label>
                    <div class="col-sm-10">
                      <select name="category" id="category" class="form-control">
                        @foreach($category as $c)
                        <option value="{{$c->id}}">{{$c->category_name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  @if($errors->has('category'))
                  <div class="alert alert-danger">
                    {{
                                                  $errors->first('category')
                                              }}
                  </div>
                  @endif

                  <div class="form-group row">
                    <label for="inputEmail" class="col-sm-2 col-form-label">Loại hình giảm</label>
                    <div class="col-sm-10">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" checked="" value="0">
                        <label class="form-check-label">Tiền</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" value="1">
                        <label class="form-check-label">Theo phần trăm</label>
                      </div>
                    </div>
                    @if($errors->has('type'))
                    <div class="alert alert-danger">
                      {{
                                                  $errors->first('type')
                                              }}
                    </div>
                    @endif
                  </div>
                  <div class="form-group row">
                    <label for="inputName2" class="col-sm-2 col-form-label">Số tiền giảm|Phần trăm giảm</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="money" placeholder="Nhập số tiền giảm|phần trăm giảm" value="{{ old('money') }}" />
                    </div>
                  </div>
                  @if($errors->has('money'))
                  <div class="alert alert-danger">
                    {{
                                                $errors->first('money')
                                            }}
                  </div>
                  @endif
                  <div class="form-group row">
                    <label for="inputExperience" class="col-sm-2 col-form-label">Ngày bắt đầu:</label>
                    <div class="col-sm-10">
                      <input type="text" name="begin" class="begin" value="{{ old('begin') }}">
                    </div>
                  </div>
                  @if($errors->has('begin'))
                  <div class="alert alert-danger">
                    {{
                                                $errors->first('begin')
                                            }}
                  </div>
                  @endif
                  <div class="form-group row">
                    <label for="inputSkills" class="col-sm-2 col-form-label">Ngày kết thúc:</label>
                    <div class="col-sm-10">
                      <input type="text" name="end" class="end" value="{{ old('end') }}">
                    </div>
                  </div>
                  @if($errors->has('end'))
                  <div class="alert alert-danger">
                    {{
                                                $errors->first('end')
                                            }}
                  </div>
                  @endif

                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Áp dụng</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">
                <form class="form-horizontal" method="POST" action="admin/san-pham/giam-gia" autocomplete="off">
                  @csrf
                  <div class="form-group row">
                    <label for="inputName" class="col-sm-2 col-form-label">Tên nhóm sản phẩm</label>
                    <div class="col-sm-10">
                      <select name="group_product" class="form-control">
                        @foreach($group_product as $gp)
                        <option value="{{$gp->id}}">{{$gp->group_product_name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  @if($errors->has('group_product'))
                  <div class="alert alert-danger">
                    {{
                                                  $errors->first('group_product')
                                              }}
                  </div>
                  @endif
                  <div class="form-group row">
                    <label for="inputEmail" class="col-sm-2 col-form-label">Loại hình giảm</label>
                    <div class="col-sm-10">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" checked="" value="0">
                        <label class="form-check-label">Tiền</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" value="1">
                        <label class="form-check-label">Theo phần trăm</label>
                      </div>
                    </div>
                    @if($errors->has('type'))
                    <div class="alert alert-danger">
                      {{
                                                  $errors->first('type')
                                              }}
                    </div>
                    @endif
                  </div>
                  <div class="form-group row">
                    <label for="inputName2" class="col-sm-2 col-form-label">Số tiền giảm|Phần trăm giảm</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="money" placeholder="Nhập số tiền giảm|phần trăm giảm" value="{{ old('money') }}" />
                    </div>
                  </div>
                  @if($errors->has('money'))
                  <div class="alert alert-danger">
                    {{
                                                $errors->first('money')
                                            }}
                  </div>
                  @endif
                  <div class="form-group row">
                    <label for="inputExperience" class="col-sm-2 col-form-label">Ngày bắt đầu:</label>
                    <div class="col-sm-10">
                      <input type="text" name="begin" class="begin" value="{{ old('begin') }}">
                    </div>
                  </div>
                  @if($errors->has('begin'))
                  <div class="alert alert-danger">
                    {{
                                                $errors->first('begin')
                                            }}
                  </div>
                  @endif
                  <div class="form-group row">
                    <label for="inputSkills" class="col-sm-2 col-form-label">Ngày kết thúc:</label>
                    <div class="col-sm-10">
                      <input type="text" name="end" class="end" value="{{ old('end') }}">
                    </div>
                  </div>
                  @if($errors->has('end'))
                  <div class="alert alert-danger">
                    {{
                                                $errors->first('end')
                                            }}
                  </div>
                  @endif

                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Áp dụng</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="settings">
                <form class="form-horizontal" method="POST" action="admin/san-pham/giam-gia" autocomplete="off">
                  @csrf
                  <div class="form-group row">
                    <label for="inputName" class="col-sm-2 col-form-label">Tên sản phẩm</label>
                    <div class="col-sm-10">
                      <select name="product" class="form-control">
                        @foreach($product as $p)
                        <option value="{{$p->id}}">{{$p->product_name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  @if($errors->has('product'))
                  <div class="alert alert-danger">
                    {{
                                                  $errors->first('product')
                                              }}
                  </div>
                  @endif
                  <div class="form-group row">
                    <label for="inputEmail" class="col-sm-2 col-form-label">Loại hình giảm</label>
                    <div class="col-sm-10">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" checked="" value="0">
                        <label class="form-check-label">Tiền</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" value="1">
                        <label class="form-check-label">Theo phần trăm</label>
                      </div>
                    </div>
                    @if($errors->has('type'))
                    <div class="alert alert-danger">
                      {{
                                                  $errors->first('type')
                                              }}
                    </div>
                    @endif
                  </div>
                  <div class="form-group row">
                    <label for="inputName2" class="col-sm-2 col-form-label">Số tiền giảm|Phần trăm giảm</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="money" placeholder="Nhập số tiền giảm|phần trăm giảm" value="{{ old('money') }}" />
                    </div>
                  </div>
                  @if($errors->has('money'))
                  <div class="alert alert-danger">
                    {{
                                                $errors->first('money')
                                            }}
                  </div>
                  @endif
                  <div class="form-group row">
                    <label for="inputExperience" class="col-sm-2 col-form-label">Ngày bắt đầu:</label>
                    <div class="col-sm-10">
                      <input type="text" name="begin" class="begin" value="{{ old('begin') }}">
                    </div>
                  </div>
                  @if($errors->has('begin'))
                  <div class="alert alert-danger">
                    {{
                                                $errors->first('begin')
                                            }}
                  </div>
                  @endif
                  <div class="form-group row">
                    <label for="inputSkills" class="col-sm-2 col-form-label">Ngày kết thúc:</label>
                    <div class="col-sm-10">
                      <input type="text" name="end" class="end" value="{{ old('end') }}">
                    </div>
                  </div>
                  @if($errors->has('end'))
                  <div class="alert alert-danger">
                    {{
                                                $errors->first('end')
                                            }}
                  </div>
                  @endif

                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Áp dụng</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->

</section>
@endsection
@section('script')
<!-- datepicker -->
<script src="admin/datepicker/modernizr.custom.2.8.3.min.js"></script>
<script src="admin/datepicker/plugin.js"></script>
<script src="admin/datepicker/main.js"></script>
<script>
  $(function() {
    $(".begin").datepicker({
      dateFormat: 'yy/mm/dd',

    });
    $(".end").datepicker({
      dateFormat: 'yy/mm/dd',

    });
  });
</script>
<script>
  $(document).ready(function() {
    //alert('ss');
    $("#category").change(function() {
      var id = $(this).val();
      $.get("/ajax/discount/" + id, function(data) {
        //$(".select_product").html(data);
        alert(data);
        $('#sub_category').html(data);
      });
      //alert(id);

    });

  });
</script>
@endsection