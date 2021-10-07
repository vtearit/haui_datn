<div class="header-middle">
  <!--header-middle-->
  <div class="container">
    <div class="row">
      <div class="col-sm-4">
        <div class="logo pull-left">
          <a href="#"><img style="width:139px;height: 39px" src="img/shop/logo.png" alt="" /></a>
        </div>

      </div>
      <div class="col-sm-8">
        <div class="shop-menu pull-right ">
          <nav class="nav-menu d-none d-lg-block">
            <ul class="nav navbar-nav">
              <li><a href="ma-giam-gia"><i class="fa fa-star"></i> Mã giảm giá</a></li>
              <li><a href="don-hang"><i class="fa fa-crosshairs"></i> Đơn hàng</a></li>
              <li><a href="gio-hang"><i class="fa fa-shopping-cart"></i> Giỏ hàng</a></li>

              @if(session()->has('user_id'))
              <li><a href="cap-nhat-thong-tin"><i class="fa fa-user"></i> Tài khoản</a></li>
              @else
              <li><a href="dang-nhap"><i class="fa fa-lock"></i> Đăng nhập</a></li>
              @endif
              <!-- <div class="btn-group"> 
                    <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu">
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <a class="dropdown-item" href="#">Something else here</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Separated link</a>
                    </div>
                  </div> -->

              <!-- <li class=drop-down>dang nhap
                    <ul>
                      <li><a href="">a</a></li>
                      <li><a href="">dang xuat</a></li>
                    </ul>
                  </li> -->






        </div>

        </ul>
        </nav>
      </div>
    </div>
  </div>
</div>
</div>
<!--/header-middle-->