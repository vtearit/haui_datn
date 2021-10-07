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
                                <h1><span>VU</span>-BEAUTY</h1>
                                <h2>Shop mỹ phẩm số 1 Việt Nam</h2>
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

<!-- product -->
<section>
    <div class="container">
        @foreach($category as $c)

        <div class="row">
            <div class="col-sm-12">

                <div class="features_items">
                    <div>
                        <div class="col-sm-11">
                            <br />
                            <h2 class="title text-center">{{$c->category_name}}</h2>
                        </div>
                        <div class="col-sm-1">
                            <a class="title text-right" href="danh-muc/{{$c->slug_category}}">Xem thêm</a>
                        </div>
                    </div>
                    @foreach($c->groupProduct as $key=>$gp)
                    <!-- xac dinh group product co tren 3 nhom san pham -->
                    @if(count($c->groupProduct)>0)
                    <!-- xac dinh trang thai cua group product -->
                    @if($gp->status==1)
                    <!-- lay 3 san pham dau tien cua nhom -->
                    @if($key<3) <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <a href="chi-tiet/{{$gp->group_product_slug}}">
                                        <img src="img/product/{{$gp->group_product_image}}" alt="" />

                                        <br />
                                        <h2>{{number_format(minPrice($gp->id)).' đ'}}</h2>
                                        <p>{{$gp->group_product_name}}</p>
                                    </a>
                                    <a href="chi-tiet/{{$gp->group_product_slug}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                    <?php
                                    $discount = discount($gp);
                                    $percent = $discount . ' %';
                                    if ($discount < 0) {

                                    ?>

                                        <div class="action-product">
                                            {{$percent}}
                                        </div>
                                    <?php } ?>

                                    <?php
                                    $action = actionProduct($gp);
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
                                    <?php } ?>
                                </div>

                            </div>
                        </div>
                        <div class="choose">
                            <ul class="nav nav-pills nav-justified">
                                <li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích</a></li>
                                <li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li>
                            </ul>
                        </div>
                </div>
                @endif
                @endif
                @endif
                @endforeach
            </div>


        </div>
    </div>

    @endforeach
    </div>

</section>


</div>
<!--features_items-->
<!-- /product -->

<!-- slider -->
<section class="slider">
    <div class="container">
        <!-- introduce -->
        <header class="introduce">
            <div class="introduce--center">
                <p class="introduce__article">HOT</p>
                <p class="introduce__title">Tin tức & Sự kiện</p>
                <p class="introduce__underline"></p>
            </div>
        </header>
        <!-- introduce -->

        <!-- main-slider -->
        <section class="slider__main-slider">
            <div class="row">
                <div class="owl-carousel owl-theme">
                    <div class="item-slider">
                        <a href="#">
                            <div class="slider__main-slider__image">
                                <img src="img/slider/n1.jpg" class="slider__main-slider__image__main-image" alt="">
                                <div class="slider-date">
                                    <div class="slider-date__frame"></div>
                                    <p class="slider-date__month">Aug</p>
                                    <p class="slider-date__date">28</p>
                                </div>
                            </div>
                            <div class="slider__main-slider__infor">
                                <p class="slider__main-slider__title">Màu son môi nào đang lên ngôi trong mùa Thu năm nay</p>
                                <p class="slider__main-slider__desc">Những năm gần đây, son tông màu đất được hội chị em yêu thích bởi nét đẹp tây tây. Vậy đã  bao lâu rồi, bạn chưa tô điểm cho mình một vẻ ngoài trông quyến rũ và tự nhiên nhất? Mùa thu năm nay sẽ là thời điểm thích hợp cho bạn có một diện mạo mới mẻ với sắc son đỏ cổ điển, gam màu trầm ấm đầy chất thu và ánh nhũ gợi cảm.</p>
                                <div class="slider__main-slider__underline"></div>
                                <div class="slider__main-slider__social">
                                    <span class="slider__main-slider__social__comment">
                                        <i class="far fa-comment"></i><span class="span-slider">12</span>
                                    </span>
                                    <i class="far fa-heart"></i><span class="span-slider"></span>0</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="item-slider">
                        <div class="slider__main-slider__item">
                            <a href="#">
                                <div class="slider__main-slider__image">
                                    <img src="img/slider/n2.jpg" class="slider__main-slider__image__main-image" alt="">
                                    <div class="slider-date">
                                        <div class="slider-date__frame"></div>
                                        <p class="slider-date__month">Aug</p>
                                        <p class="slider-date__date">29</p>
                                    </div>
                                </div>
                                <div class="slider__main-slider__infor">
                                    <p class="slider__main-slider__title">Cách chọn kem chống nắng tốt phù hợp an toàn với từng loại da</p>
                                    <p class="slider__main-slider__desc">Những năm gần đây, son tông màu đất được hội chị em yêu thích bởi nét đẹp tây tây. Vậy đã  bao lâu rồi, bạn chưa tô điểm cho mình một vẻ ngoài trông quyến rũ và tự nhiên nhất? Mùa thu năm nay sẽ là thời điểm thích hợp cho bạn có một diện mạo mới mẻ với sắc son đỏ cổ điển, gam màu trầm ấm đầy chất thu và ánh nhũ gợi cảm.</p>
                                    <div class="slider__main-slider__underline"></div>
                                    <div class="slider__main-slider__social">
                                        <span class="slider__main-slider__social__comment">
                                            <i class="far fa-comment"></i><span class="span-slider">12</span>
                                        </span>
                                        <i class="far fa-heart"></i><span class="span-slider"></span>0</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="item-slider">
                        <a href="#">
                            <div class="slider__main-slider__image">
                                <img src="img/slider/n3.jpg" class="slider__main-slider__image__main-image" alt="">
                                <div class="slider-date">
                                    <div class="slider-date__frame"></div>
                                    <p class="slider-date__month">Aug</p>
                                    <p class="slider-date__date">28</p>
                                </div>
                            </div>
                            <div class="slider__main-slider__infor">
                                <p class="slider__main-slider__title">5 loại mỹ phẩm giúp giảm nếp nhăn, làm căng da mặt cực hiệu quả</p>
                                <p class="slider__main-slider__desc">Những năm gần đây, son tông màu đất được hội chị em yêu thích bởi nét đẹp tây tây. Vậy đã  bao lâu rồi, bạn chưa tô điểm cho mình một vẻ ngoài trông quyến rũ và tự nhiên nhất? Mùa thu năm nay sẽ là thời điểm thích hợp cho bạn có một diện mạo mới mẻ với sắc son đỏ cổ điển, gam màu trầm ấm đầy chất thu và ánh nhũ gợi cảm.</p>
                                <div class="slider__main-slider__underline"></div>
                                <div class="slider__main-slider__social">
                                    <span class="slider__main-slider__social__comment">
                                        <i class="far fa-comment"></i><span class="span-slider">12</span>
                                    </span>
                                    <i class="far fa-heart"></i><span class="span-slider"></span>0</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="item-slider">
                        <a href="#">
                            <div class="slider__main-slider__image">
                                <img src="img/slider/n1.jpg" class="slider__main-slider__image__main-image" alt="">
                                <div class="slider-date">
                                    <div class="slider-date__frame"></div>
                                    <p class="slider-date__month">Aug</p>
                                    <p class="slider-date__date">28</p>
                                </div>
                            </div>
                            <div class="slider__main-slider__infor">
                                <p class="slider__main-slider__title">Màu son môi nào đang lên ngôi trong mùa Thu năm nay</p>
                                <p class="slider__main-slider__desc">Những năm gần đây, son tông màu đất được hội chị em yêu thích bởi nét đẹp tây tây. Vậy đã  bao lâu rồi, bạn chưa tô điểm cho mình một vẻ ngoài trông quyến rũ và tự nhiên nhất? Mùa thu năm nay sẽ là thời điểm thích hợp cho bạn có một diện mạo mới mẻ với sắc son đỏ cổ điển, gam màu trầm ấm đầy chất thu và ánh nhũ gợi cảm.</p>
                                <div class="slider__main-slider__underline"></div>
                                <div class="slider__main-slider__social">
                                    <span class="slider__main-slider__social__comment">
                                        <i class="far fa-comment"></i><span class="span-slider">12</span>
                                    </span>
                                    <i class="far fa-heart"></i><span class="span-slider"></span>0</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="item-slider">
                        <div class="slider__main-slider__item">
                            <a href="#">
                                <div class="slider__main-slider__image">
                                    <img src="img/slider/n2.jpg" class="slider__main-slider__image__main-image" alt="">
                                    <div class="slider-date">
                                        <div class="slider-date__frame"></div>
                                        <p class="slider-date__month">Aug</p>
                                        <p class="slider-date__date">29</p>
                                    </div>
                                </div>
                                <div class="slider__main-slider__infor">
                                    <p class="slider__main-slider__title">Cách chọn kem chống nắng tốt phù hợp an toàn với từng loại da</p>
                                    <p class="slider__main-slider__desc">Những năm gần đây, son tông màu đất được hội chị em yêu thích bởi nét đẹp tây tây. Vậy đã  bao lâu rồi, bạn chưa tô điểm cho mình một vẻ ngoài trông quyến rũ và tự nhiên nhất? Mùa thu năm nay sẽ là thời điểm thích hợp cho bạn có một diện mạo mới mẻ với sắc son đỏ cổ điển, gam màu trầm ấm đầy chất thu và ánh nhũ gợi cảm.</p>
                                    <div class="slider__main-slider__underline"></div>
                                    <div class="slider__main-slider__social">
                                        <span class="slider__main-slider__social__comment">
                                            <i class="far fa-comment"></i><span class="span-slider">12</span>
                                        </span>
                                        <i class="far fa-heart"></i><span class="span-slider"></span>0</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="item-slider">
                        <a href="#">
                            <div class="slider__main-slider__image">
                                <img src="img/slider/n3.jpg" class="slider__main-slider__image__main-image" alt="">
                                <div class="slider-date">
                                    <div class="slider-date__frame"></div>
                                    <p class="slider-date__month">Aug</p>
                                    <p class="slider-date__date">28</p>
                                </div>
                            </div>
                            <div class="slider__main-slider__infor">
                                <p class="slider__main-slider__title">5 loại mỹ phẩm giúp giảm nếp nhăn, làm căng da mặt cực hiệu quả</p>
                                <p class="slider__main-slider__desc">Những năm gần đây, son tông màu đất được hội chị em yêu thích bởi nét đẹp tây tây. Vậy đã  bao lâu rồi, bạn chưa tô điểm cho mình một vẻ ngoài trông quyến rũ và tự nhiên nhất? Mùa thu năm nay sẽ là thời điểm thích hợp cho bạn có một diện mạo mới mẻ với sắc son đỏ cổ điển, gam màu trầm ấm đầy chất thu và ánh nhũ gợi cảm.</p>
                                <div class="slider__main-slider__underline"></div>
                                <div class="slider__main-slider__social">
                                    <span class="slider__main-slider__social__comment">
                                        <i class="far fa-comment"></i><span class="span-slider">12</span>
                                    </span>
                                    <i class="far fa-heart"></i><span class="span-slider"></span>0</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="item-slider">
                        <a href="#">
                            <div class="slider__main-slider__image">
                                <img src="img/slider/n1.jpg" class="slider__main-slider__image__main-image" alt="">
                                <div class="slider-date">
                                    <div class="slider-date__frame"></div>
                                    <p class="slider-date__month">Aug</p>
                                    <p class="slider-date__date">28</p>
                                </div>
                            </div>
                            <div class="slider__main-slider__infor">
                                <p class="slider__main-slider__title">Màu son môi nào đang lên ngôi trong mùa Thu năm nay</p>
                                <p class="slider__main-slider__desc">Những năm gần đây, son tông màu đất được hội chị em yêu thích bởi nét đẹp tây tây. Vậy đã  bao lâu rồi, bạn chưa tô điểm cho mình một vẻ ngoài trông quyến rũ và tự nhiên nhất? Mùa thu năm nay sẽ là thời điểm thích hợp cho bạn có một diện mạo mới mẻ với sắc son đỏ cổ điển, gam màu trầm ấm đầy chất thu và ánh nhũ gợi cảm.</p>
                                <div class="slider__main-slider__underline"></div>
                                <div class="slider__main-slider__social">
                                    <span class="slider__main-slider__social__comment">
                                        <i class="far fa-comment"></i><span class="span-slider">12</span>
                                    </span>
                                    <i class="far fa-heart"></i><span class="span-slider"></span>0</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="item-slider">
                        <div class="slider__main-slider__item">
                            <a href="#">
                                <div class="slider__main-slider__image">
                                    <img src="img/slider/n2.jpg" class="slider__main-slider__image__main-image" alt="">
                                    <div class="slider-date">
                                        <div class="slider-date__frame"></div>
                                        <p class="slider-date__month">Aug</p>
                                        <p class="slider-date__date">29</p>
                                    </div>
                                </div>
                                <div class="slider__main-slider__infor">
                                    <p class="slider__main-slider__title">Cách chọn kem chống nắng tốt phù hợp an toàn với từng loại da</p>
                                    <p class="slider__main-slider__desc">Những năm gần đây, son tông màu đất được hội chị em yêu thích bởi nét đẹp tây tây. Vậy đã  bao lâu rồi, bạn chưa tô điểm cho mình một vẻ ngoài trông quyến rũ và tự nhiên nhất? Mùa thu năm nay sẽ là thời điểm thích hợp cho bạn có một diện mạo mới mẻ với sắc son đỏ cổ điển, gam màu trầm ấm đầy chất thu và ánh nhũ gợi cảm.</p>
                                    <div class="slider__main-slider__underline"></div>
                                    <div class="slider__main-slider__social">
                                        <span class="slider__main-slider__social__comment">
                                            <i class="far fa-comment"></i><span class="span-slider">12</span>
                                        </span>
                                        <i class="far fa-heart"></i><span class="span-slider"></span>0</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="item-slider">
                        <a href="#">
                            <div class="slider__main-slider__image">
                                <img src="img/slider/n3.jpg" class="slider__main-slider__image__main-image" alt="">
                                <div class="slider-date">
                                    <div class="slider-date__frame"></div>
                                    <p class="slider-date__month">Aug</p>
                                    <p class="slider-date__date">28</p>
                                </div>
                            </div>
                            <div class="slider__main-slider__infor">
                                <p class="slider__main-slider__title">5 loại mỹ phẩm giúp giảm nếp nhăn, làm căng da mặt cực hiệu quả</p>
                                <p class="slider__main-slider__desc">Những năm gần đây, son tông màu đất được hội chị em yêu thích bởi nét đẹp tây tây. Vậy đã  bao lâu rồi, bạn chưa tô điểm cho mình một vẻ ngoài trông quyến rũ và tự nhiên nhất? Mùa thu năm nay sẽ là thời điểm thích hợp cho bạn có một diện mạo mới mẻ với sắc son đỏ cổ điển, gam màu trầm ấm đầy chất thu và ánh nhũ gợi cảm.</p>
                                <div class="slider__main-slider__underline"></div>
                                <div class="slider__main-slider__social">
                                    <span class="slider__main-slider__social__comment">
                                        <i class="far fa-comment"></i><span class="span-slider">12</span>
                                    </span>
                                    <i class="far fa-heart"></i><span class="span-slider"></span>0</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <!-- /main-slider-->
    </div>
</section>
<!-- /slider -->

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
                    swal("Đã thêm sản phẩm vào giỏ hàng!", "", "success");


                }

            });

        });


    });
</script>

@endsection