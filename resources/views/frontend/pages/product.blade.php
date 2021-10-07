@extends('frontend.layouts.index')
@section('css')
<link href="frontend/css/sweetalert.css" rel="stylesheet">
@endsection
@section('content')
<section id="slider">
  <!--slider-->
  <div class="container">
    <div class="row">

      <!-- <div class="col-sm-12">
          <span>Chọn mức giá</span>
          
            <input type="text" name="" id="price"/>
            

        </div> -->
      <div class="col-sm-12">
        <div id="slider-carousel" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
            <li data-target="#slider-carousel" data-slide-to="1"></li>
            <li data-target="#slider-carousel" data-slide-to="2"></li>
          </ol>

          <div class="carousel-inner">
            <div class="item active">
              <div class="col-sm-6">
                <h1><span>E</span>-SHOP</h1>
                <h2>Shop điện tử số 1 Việt Nam</h2>
                <p>Địa chỉ:Nhổn-Nam Từ Liêm-Hà Nội </p>
                <p>SĐT:0123456789</p>
                <a type="button" href="#" class="btn btn-default get">Mua sắm ngay</a>
              </div>
              <div class="col-sm-6">
                <img src="img/slider/{{$slider_active->image}}" class="girl img-responsive" alt="" />
              </div>
            </div>
            @foreach($slider as $s)
            <div class="item">
              <div class="col-sm-12">
                <img src="img/slider/{{$s->image}}" width="950px" height="441px" class="girl img-responsive" alt="" />
              </div>
            </div>
            @endforeach


          </div>

          <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
            <i class="fa fa-angle-left"></i>
          </a>
          <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
            <i class="fa fa-angle-right"></i>
          </a>
        </div>

      </div>
    </div>
  </div>
</section>
<!--/slider-->

<section>
  <div class="container">
    <div class="row">
      <div class="col-sm-12 padding-right">
        <div class="features_items">
          <!--features_items-->
          <h2 class="title text-center">{{$name_page}} nổi bật</h2>
          <form method="post" action="san-pham/sort">
            @csrf
            <div class="col-sm-9"></div>
            <div class="col-sm-2">
              <input type="hidden" name="category_id" value="{{$category_id}}" />
              <select name="sort" class="text-right" id="sort" value="{{ old('sort') }}">
                <option value="0" selected="">Mới nhất</option>
                <option value="1">Giá từ thấp đến cao</option>
                <option value="2">Giá từ cao đến thấp</option>
              </select>

            </div>
            <div class="col-sm-1">
              <input type="submit" name="" value="Lọc">
            </div>
          </form>
          <br />
          @foreach($product as $p)
          <div class="col-sm-3">
            <div class="product-image-wrapper">
              <div class="single-products">
                <div class="productinfo text-center">
                  <img src="img/product/{{$p->group_product_image}}" alt="" />
                </div>
                <div class="product-overlay">
                  <div class="overlay-content">
                    {!!$p->group_product_desc!!}
                  </div>
                </div>
                <?php
                $discount = discount($p);
                $percent = $discount . ' %';
                if ($discount < 0) {

                ?>

                  <div class="action-product">
                    {{$percent}}
                  </div>
                <?php } ?>

                <?php
                $action = actionProduct($p);
                if ($action == 1) {

                ?>
                  <div class="action-product-new">
                    Mới
                  </div>
                <?php } elseif ($action == 2) {

                ?>
                  <div class="action-product-pre">
                    Đặt trước
                  </div>
                <?php }
                ?>
              </div>
              <div class="choose">
                <ul class="nav nav-pills nav-justified text-center productinfo">
                  <a href="chi-tiet/{{$p->group_product_slug}}">
                    <h2>{{number_format(minPrice($p->id)).' đ'}}</h2>
                    <p>{{$p->group_product_name}}</p>
                  </a>
                  <a href="chi-tiet/{{$p->group_product_slug}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                  <li><a href=""><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
                  <li><a href=""><i class="fa fa-plus-square"></i>Add to compare</a></li>
                </ul>
              </div>
            </div>
          </div>
          @endforeach
          <div class="col-sm-12">
            <div class="col-sm-5"></div>
            <div class="col-sm-7 padding-right">{{$product->links()}}</div>
          </div>
        </div>
        <!--features_items-->
      </div>
    </div>
  </div>
</section>

@endsection
@section('script')
<script src="frontend/js/sweetalert.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('.add-to-cart').click(function() {
      var id = $(this).data('id_product');
      var product_name = $('.cart_product_name_' + id).val();
      var product_image = $('.cart_product_image_' + id).val();
      var product_price = $('.cart_product_price_' + id).val();
      var product_qty = $('.cart_product_qty_' + id).val();
      var token = $('input[name="_token"]').val();
      //swal("Hello world!");
      //alert(product_name);

      $.ajax({
        method: 'POST',
        url: '/them-gio-hang',
        data: {
          product_id: id,
          product_name: product_name,
          product_image: product_image,
          product_price: product_price,
          product_qty: product_qty,
          _token: token
        },
        success: function() {
          //alert(data);
          swal("", "Đã thêm sản phẩm vào giỏ hàng!", "success");

          // swal({
          //         title: "Đã thêm sản phẩm vào giỏ hàng",

          //         showCancelButton: true,
          //         cancelButtonText: "Xem tiếp",
          //         cancelButtonClass: "btn-danger",
          //         confirmButtonClass: "btn-success",
          //         confirmButtonText: "Đi đến giỏ hàng",
          //         closeOnConfirm: false
          //     },
          //     function() {
          //         window.location.href = "{{url('/gio-hang')}}";
          //     });

        }

      });

    });
    $('#price').keyup(function() {
      var price = $(this).val();
      $.get("ajax/keyup/" + price, function(data) {
        $("#price").val(data);
        // //alert(data);
        // location.reload();
        //alert(data);
      });
    });
    $('#sort').change(function() {
      var pathname = window.location.pathname;
      var i = 0;
      var j = pathname.indexOf("/");
      pathname = pathname.slice(j + 1, pathname.length);
      var j = pathname.indexOf("/");
      pathname = pathname.slice(j + 1, pathname.length);
      var val = $(this).val();
      if (pathname.indexOf('/') > 0) {
        $.get("san-pham/" + pathname + "/" + val, function(data) {
          alert(data);
        });

      } else {
        $.get("san-pham/" + pathname + "/" + val, function(data) {
          alert(data);
        });
      }
      // for(i;i<pathname.length;i++)
      // {

      // }

      //alert(pathname);
    });
  });
</script>

@endsection