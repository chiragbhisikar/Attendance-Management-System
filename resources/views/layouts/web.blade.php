<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('web/css/index.css')}}">
    <link rel="stylesheet" href="{{asset('web/css/responsive.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">

    <title>Home</title>
</head>

<body>
    <header class="fixed-top header-scrolled">
        <div class="container">
            <div class="menubar">
                <div class="logo">
                    <img src="{{asset('web/img/ezryder.svg')}}" alt="">
                </div>
                <nav class="navbar">
                    <ul id="menu">
                        <li><a href="">Home</a></li>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#services">Services</a></li>
                        <li><a href="#contact">Contact Us</a></li>
                        <li><a href="#" class="btn">Register</a></li>
                    </ul>
                </nav>
            </div>
            <div class="toggle-nav" onclick="toggleNav()">
                <span class="bar sec-bg"></span>
                <span class="bar sec-bg"></span>
                <span class="bar sec-bg"></span>
            </div>
        </div>
    </header>

    @yield('content')

    <footer>
        <div class="container">
            <section class="footer_section">
                <div class="footer_logo footer_services">
                    <img src="{{asset('web/img/ezryder.svg')}}" alt="">
                    <p>
                        Our friendly team would love
                        to hear from you!
                    </p>
                    <div class="social-icn">
                        <img src="{{asset('web/img/facebook.svg')}}" alt="">
                        <img src="{{asset('web/img/instagram.svg')}}" alt="">
                        <img src="{{asset('web/img/twitter.svg')}}" alt="">
                        <img src="{{asset('web/img/linkedin.svg')}}" alt="">
                    </div>
                </div>
                <div class="footer_services">
                    <h3>Services</h3>
                    <ul>
                        <li><a href="#">Book A Ride</a></li>
                        <li><a href="#">Car Rentals</a></li>
                        <li><a href="#">Package Delivery</a></li>
                        <li><a href="#">Order Grocery</a></li>
                        <li><a href="#">Order Food</a></li>
                        <li><a href="#">Order Medicine</a></li>
                    </ul>
                </div>
                <div class="footer_services">
                    <h3>Information</h3>
                    <ul>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#">Privacy policy</a></li>
                        <li><a href="{{route('web.terms')}}">Term & Condition</a></li>
                    </ul>
                </div>
                <div class="footer_services">
                    <h3>Contact us</h3>
                    <div class="box_icon">
                        <img src="{{asset('web/img/phone.svg')}}" alt="">
                        <p>+91 98765 XXXXX</p>
                    </div>
                    <div class="box_icon">
                        <img src="{{asset('web/img/location.svg')}}" alt="">
                        <p>5-D, Sector 76- Australia</p>
                    </div>
                    <div class="box_icon">
                        <img src="{{asset('web/img/email_..svg')}}" alt="">
                        <a href="mailto:info@ezdyder.co.in" style="color: white;">info@ezdyder.co.in</a>
                    </div>
                    <div class="box_icon">
                        <img src="{{asset('web/img/web.svg')}}" alt="">
                        <a href="https://www.ezryder.com" style="color: white;">https://www.ezryder.com</a>
                    </div>
                </div>
            </section>
        </div>
    </footer>
    <section class=" box_copy">Copyright @ <b>EZRYDER</b>. All Rights Reserved.
    </section>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.slick/1.4.1/slick.min.js"></script>
    <script src="{{asset('web/js/main.js')}}"></script>
</body>

</html>