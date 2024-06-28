<!DOCTYPE HTML>
<html>

<head>
    <title>HAVANA</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-logged-in" content="{{ Session::has('customer') ? 'true' : 'false' }}">

    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Rokkitt:100,300,400,700" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="{{ asset('frontend/css/animate.css') }}">
    <!-- Icomoon Icon Fonts-->
    <link rel="stylesheet" href="{{ asset('frontend/css/icomoon.css') }}">
    <!-- Ion Icon Fonts-->
    <link rel="stylesheet" href="{{ asset('frontend/css/ionicons.min.css') }}">
    <!-- Bootstrap  -->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">

    <!-- Magnific Popup -->
    <link rel="stylesheet" href="{{ asset('frontend/css/magnific-popup.css') }}">

    <!-- Flexslider  -->
    <link rel="stylesheet" href="{{ asset('frontend/css/flexslider.css') }}">

    <!-- Owl Carousel -->
    <link rel="stylesheet" href="{{ asset('frontend/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/owl.theme.default.min.css') }}">

    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap-datepicker.css') }}">
    <!-- Flaticons  -->
    <link rel="stylesheet" href="{{ asset('frontend/css/flaticon.css') }}">

    <!-- Theme style  -->
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">

    <!-- Theme my style  -->
    <link rel="stylesheet" href="{{ asset('frontend/css/my-style.css') }}">

</head>

<body>

    @if (session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger text-center">
            {{ session('error') }}
        </div>
    @endif

    <div id="page">
        <nav class="colorlib-nav" role="navigation">
            <div class="top-menu">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-7 col-md-9">
                            <div id="colorlib-logo"><a href="/">HAVANA SHOP</a></div>
                        </div>
                        <div class="col-sm-5 col-md-3">
                            <form action="{{ url('/search') }}" class="search-wrap" method="GET">
                                <div class="form-group">
                                    <input type="search" name="query" class="form-control search" placeholder="Search">
                                    <button class="btn btn-primary submit-search text-center" type="submit"><i
                                            class="icon-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 text-left menu-1">
                            <ul>
                                <li class="active"><a href="/">Trang Chủ</a></li>
                                <li class="has-dropdown">
                                    <a href="">Danh mục</a>
                                    <ul class="dropdown">
                                        @foreach ($categories as $category)
                                            <li><a href="/category/{{ $category->category_id }}">{{ $category->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li class="has-dropdown">
                                    <a href="">Thương hiệu</a>
                                    <ul class="dropdown">
                                        @foreach ($manufacturers as $manufacturer)
                                            <li><a href="/manufacturer/{{ $manufacturer->manufacturer_id }}">{{ $manufacturer->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li><a href="/contact">Liên hệ</a></li>
                                @php
                                    $cart = Session::get('cart', []);
                                    $cartCount = count($cart);
                                @endphp
                                <li class="cart"><a href="/cart"><i class="icon-shopping-cart"></i> [<span
                                            id="cart-count">{{ $cartCount }}</span>]</a>
                                </li>
                                <li class="cart has-dropdown mr-3">
                                    <i class="icon-user"></i>
                                    <ul class="dropdown" style="left: -20px;">
                                        @if (Session::has('customer'))
                                            <li><a href="#">{{ Session::get('customer')->fullname }}</a></li>
                                            <li><a href="/my-order">Đơn hàng của tôi</a></li>
                                            <li><a href="javascript:void(0)" onclick="logout()">Đăng xuất</a></li>
                                        @else
                                            <li><a id="login" onclick="showLoginModal()">Đăng nhập</a></li>
                                            <li><a id="register" onclick="showRegisterModal()">Đăng kí</a></li>
                                        @endif
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form đăng nhập -->
            <div id="loginModal" class="modal">
                <div class="modal-content">
                    <div class="close" onclick="closeLoginModal()">
                        <span>&times;</span>
                    </div>
                    <h2>ĐĂNG NHẬP</h2>
                    <div id="login-error-message" class="alert alert-danger" style="display: none;"></div>
                    <form class="form-login" onsubmit="return validateLogin()">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="account-login">Tên đăng nhập</label>
                                    <input type="text" id="account-login" name="account-login"
                                        class="form-control" />
                                    <small class="text-danger" id="account-login-error"></small>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="password-login">Mật khẩu</label>
                                    <input type="password" id="password-login" name=password-login"
                                        class="form-control" />
                                    <small class="text-danger" id="password-login-error"></small>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="submit" value="Đăng nhập" class="btn btn-primary">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group mb-1">
                                    <span>Bạn đã có tài khoản? <a class="text-primary" id="register-link">Đăng nhập
                                            ngay</a></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Form đăng ký -->
            <div id="registerModal" class="modal">
                <div class="modal-content">
                    <div class="close" onclick="closeRegisterModal()">
                        <span>&times;</span>
                    </div>
                    <h2>Đăng kí</h2>
                    <form method="POST" action="{{ route('register') }}" class="form-register"
                        onsubmit="return validateRegister()">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="fullname">Họ tên</label>
                                    <input type="text" id="fullname" name="fullname" class="form-control" />
                                    <small class="text-danger" id="fullnameError"></small>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="account">Tên đăng nhập</label>
                                    <input type="text" id="account" name="account" class="form-control" />
                                    <small class="text-danger" id="accountError"></small>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="password">Mật khẩu</label>
                                    <input type="password" id="password" name=password class="form-control" />
                                    <small class="text-danger" id="passwordError"></small>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input type="submit" value="Đăng kí" class="btn btn-primary">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group mb-1">
                                    <span>Bạn đã có tài khoản? <a class="text-primary" id="login-link">Đăng nhập
                                            ngay</a></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @yield('content')

            <footer id="colorlib-footer" role="contentinfo">
                <div class="container">
                    <div class="row row-pb-md">
                        <div class="col footer-col colorlib-widget">
                            <h4>About Footwear</h4>
                            <p>Even the all-powerful Pointing has no control about the blind texts it is an almost
                                unorthographic life</p>
                            <p>
                            <ul class="colorlib-social-icons">
                                <li><a href="#"><i class="icon-twitter"></i></a></li>
                                <li><a href="#"><i class="icon-facebook"></i></a></li>
                                <li><a href="#"><i class="icon-linkedin"></i></a></li>
                                <li><a href="#"><i class="icon-dribbble"></i></a></li>
                            </ul>
                            </p>
                        </div>
                        <div class="col footer-col colorlib-widget">
                            <h4>Customer Care</h4>
                            <p>
                            <ul class="colorlib-footer-links">
                                <li><a href="#">Contact</a></li>
                                <li><a href="#">Returns/Exchange</a></li>
                                <li><a href="#">Gift Voucher</a></li>
                                <li><a href="#">Wishlist</a></li>
                                <li><a href="#">Special</a></li>
                                <li><a href="#">Customer Services</a></li>
                                <li><a href="#">Site maps</a></li>
                            </ul>
                            </p>
                        </div>
                        <div class="col footer-col colorlib-widget">
                            <h4>Information</h4>
                            <p>
                            <ul class="colorlib-footer-links">
                                <li><a href="#">About us</a></li>
                                <li><a href="#">Delivery Information</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Support</a></li>
                                <li><a href="#">Order Tracking</a></li>
                            </ul>
                            </p>
                        </div>

                        <div class="col footer-col">
                            <h4>News</h4>
                            <ul class="colorlib-footer-links">
                                <li><a href="blog.html">Blog</a></li>
                                <li><a href="#">Press</a></li>
                                <li><a href="#">Exhibitions</a></li>
                            </ul>
                        </div>

                        <div class="col footer-col">
                            <h4>Contact Information</h4>
                            <ul class="colorlib-footer-links">
                                <li>291 South 21th Street, <br> Suite 721 New York NY 10016</li>
                                <li><a href="tel://1234567920">+ 1235 2355 98</a></li>
                                <li><a href="mailto:info@yoursite.com">info@yoursite.com</a></li>
                                <li><a href="#">yoursite.com</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="copy">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <p>
                                <span><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                    Copyright &copy;
                                    <script>
                                        document.write(new Date().getFullYear());
                                    </script> All rights reserved | This template is made with <i
                                        class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com"
                                        target="_blank">Colorlib</a>
                                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                </span>
                                <span class="block">Demo Images: <a href="http://unsplash.co/"
                                        target="_blank">Unsplash</a> , <a href="http://pexels.com/"
                                        target="_blank">Pexels.com</a></span>
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
    </div>

    <div class="gototop js-top">
        <a href="#" class="js-gotop"><i class="ion-ios-arrow-up"></i></a>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
    <!-- popper -->
    <script src="{{ asset('frontend/js/popper.min.js') }}"></script>
    <!-- bootstrap 4.1 -->
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <!-- jQuery easing -->
    <script src="{{ asset('frontend/js/jquery.easing.1.3.js') }}"></script>
    <!-- Waypoints -->
    <script src="{{ asset('frontend/js/jquery.waypoints.min.js') }}"></script>
    <!-- Flexslider -->
    <script src="{{ asset('frontend/js/jquery.flexslider-min.js') }}"></script>
    <!-- Owl carousel -->
    <script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
    <!-- Magnific Popup -->
    <script src="{{ asset('frontend/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('frontend/js/magnific-popup-options.js') }}"></script>
    <!-- Date Picker -->
    <script src="{{ asset('frontend/js/bootstrap-datepicker.js') }}"></script>
    <!-- Stellar Parallax -->
    <script src="{{ asset('frontend/js/jquery.stellar.min.js') }}"></script>
    <!-- Main -->
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    <!-- My Script -->
    <script src="{{ asset('frontend/js/my-script.js') }}"></script>
    <script src="{{ asset('frontend/js/my-cart.js') }}"></script>
    <script src="{{ asset('frontend/js/authenticate.js') }}"></script>
    <script src="{{ asset('frontend/js/validate.js') }}"></script>
    <script src="{{ asset('frontend/js/checkout.js') }}"></script>
    <script src="{{ asset('frontend/js/shipping.js') }}"></script>
    <script src="{{ asset('frontend/js/review.js') }}"></script>
    <script src="{{ asset('frontend/js/my-order.js') }}"></script>
    <script src="{{ asset('frontend/js/contact.js') }}"></script>
</body>

</html>
