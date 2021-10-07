<div class="container d-flex align-items-center">

  <nav class="nav-menu d-none d-lg-block">

    <ul>
      <li class="active"><a href="#">Trang chủ</a></li>
      @foreach($category as $c)

      <li><a href="danh-muc/{{$c->slug_category}}">{{$c->category_name}}</a>

      </li>


      @endforeach
      <li style="margin-left: 600px">
        <div>
          <div class="search_box pull-right">
            <form action="tim-kiem" method="post" autocomplete="off">
              @csrf
              <input type="text" name="search" placeholder="Tìm kiếm..." value="{{ old('search') }}" />
            </form>

          </div>
        </div>
      </li>
    </ul>

  </nav><!-- .nav-menu -->
</div>