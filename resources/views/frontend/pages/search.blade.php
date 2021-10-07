@extends('frontend.layouts.index')
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
          <h2 class="title text-center">{{$name_page}}</h2>

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