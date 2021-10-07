<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Home | Vu-Beauty</title>
  <base href="{{asset('')}}">
  @yield('css')
  <!-- fontawesome-->
  <link href="asset/fontawesome-free-5.15.1-web/css/all.min.css" rel="stylesheet" />
  <!-- Owl Stylesheets -->
  <link rel="stylesheet" href="asset/owlcarousel/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="asset/owlcarousel/assets/owl.theme.default.min.css">
  <!-- jquery-->
  <script src="asset/jquery/jquery.min.js"></script>
  <!-- Owl JS -->
  <script src="asset/owlcarousel/owl.carousel.js"></script>
  <!-- bootstrap-->
  <script src="asset/bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="asset/bootstrap/css/bootstrap.min.css" />
  <!-- Main JS -->
  <script src="asset/js/main.js"></script>
  <!-- less-->
  <link rel="stylesheet/less" type="text/css" href="asset/less/style.less">
  <script src="asset/js/less.js" type="text/javascript"></script>

  <link href="frontend/assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="frontend/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="frontend/css/bootstrap.min.css" rel="stylesheet">
  <link href="frontend/css/font-awesome.min.css" rel="stylesheet">
  <link href="frontend/css/prettyPhoto.css" rel="stylesheet">
  <link href="frontend/css/price-range.css" rel="stylesheet">
  <link href="frontend/css/animate.css" rel="stylesheet">
  <link href="frontend/css/main.css" rel="stylesheet">
  <link href="frontend/css/responsive.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="admin/plugins/fontawesome-free/css/all.min.css">
  <!-- less-->
  <link rel="stylesheet/less" type="text/css" href="asset/less/style.less">
  <script src="asset/js/less.js" type="text/javascript"></script>


  <!-- Owl JS -->
  <script src="asset/owlcarousel/owl.carousel.js"></script>
</head>
<!--/head-->

<body>
  <header id="header">
    <!--header-->


    @include('frontend.layouts.header')
    @include('frontend.layouts.menu')




  </header>
  <!--/header-->

  @yield('content')

  @include('frontend.layouts.footer')



  <script src="frontend/js/jquery.scrollUp.min.js"></script>
  <script src="frontend/js/price-range.js"></script>
  <script src="frontend/js/jquery.prettyPhoto.js"></script>
  <script src="frontend/js/main.js"></script>
  <script>
    window.fbAsyncInit = function() {
      FB.init({
        xfbml: true,
        version: 'v9.0'
      });
    };

    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s);
      js.id = id;
      js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
  </script>
  @yield('script')
</body>

</html>