<?php
if (!isset($_SESSION['w_user'])) {
    header('location: home.php');
}
?>
<!DOCTYPE html>
<html lang="en">

    <!-- Mirrored from ngetemplates.com/mshop/mshop/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 17 Dec 2020 04:47:10 GMT -->
    <head>
        <meta charset="UTF-8">
        <title>Education Demo | Register</title>
        <meta name="viewport" content="width=device-width, initial-scale=1  maximum-scale=1 user-scalable=no">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-touch-fullscreen" content="yes">
        <meta name="HandheldFriendly" content="True">

        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,900" rel="stylesheet"> 
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i" rel="stylesheet"> 

        <link rel="stylesheet" href="assets/css/materialize.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/css/normalize.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="shortcut icon" href="assets/img/favicon.png">

    </head>
    <body>

        <!-- navbar top -->
        <div class="navbar-top">
            <div class="side-nav-panel-left"><a href="#" data-activates="slide-out-left" class="side-nav-left"><i class="fa fa-bars"></i></a></div>
            <div class="site-brand">
                <a href="home.php" class="das">
                    <h1><span>W</span>ebcyst <span>D</span>emo</h1>
                </a>
            </div>


            <div class="side-nav-panel-right"><a href="#" data-activates="slide-out-right" class="side-nav-right"><i class="fa fa-user"></i></a></div>
        </div>


        <div class="side-nav-panel-left">
            <ul id="slide-out-left" class="side-nav side-nav-panel">
                <li>
                    <a href="home.php">
                        <h1><span>W</span>ebcyst</h1>
                    </a>
                </li>
                <li><a href="index.php"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="about-us.php"><i class="fa fa-user"></i>About Us</a></li>
                <li><a href="contact.php"><i class="fa fa-envelope-o"></i>Contact Us</a></li>
<!--                <li><a href="login.php"><i class="fa fa-sign-in"></i>Login</a></li>
                <li><a href="register.php"><i class="fa fa-user-plus"></i>Register</a></li>-->
            </ul>
        </div>
        <div class="side-nav-panel-right">
            <ul id="slide-out-right" class="side-nav side-nav-cart">
                <li>
                    <div class="button-cart">
                        <a href="#" class="btn button-default"><i class="fa fa-user mr-3 text-white"></i>Profile</a>
                        <a href="#" class="btn button-default logout"><i class="fa fa-sign-out mr-3 text-white"></i>Logout</a>
                    </div>
                </li>
            </ul>
        </div>
        <!-- end side nav right -->


        <!-- about us -->
        <div class="about-us pages section-padding">
            <div class="container">
                <div class="pages-head">
                    <h2>ABOUT US</h2>
                </div>
                <div class="about-content">
                    <img src="assets/img/about.jpg" alt="">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore consequuntur praesentium dignissimos voluptatum esse, perspiciatis mollitia repellendus rerum magni aspernatur ipsam maxime dolorem iure laudantium at veritatis doloribus, numquam, dicta?</p>
                </div>
            </div>
        </div>
        <!-- end about us -->


        <!-- footer -->
        <div class="footer">
            <div class="container">
                <div class="about-us-foot">
                    <h6><span>W</span>ebcyst</h6>
                    <p>is a lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                </div>
                <div class="social-media"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-google"></i></a><a href="#"><i class="fa fa-linkedin"></i></a><a href="#"><i class="fa fa-instagram"></i></a></div>
                <div class="payment">
                    <ul>
                        <li><img src="assets/img/paypal.png" alt=""></li>
                        <li><img src="assets/img/mastercard.png" alt=""></li>
                        <li><img src="assets/img/americanexpress.png" alt=""></li>
                        <li><img src="assets/img/visaelectron.png" alt=""></li>
                    </ul>
                </div>
                <div class="copyright"><span>© 2016 All Right Reserved</span></div>
            </div>
        </div>
        <!-- end footer -->

        <!-- scripts -->
        <script src="assets/js/jquery-3.1.0.min.js"></script>
        <script src="assets/js/materialize.min.js"></script>
        <script src="assets/js/main.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    </body>
    <!-- Mirrored from ngetemplates.com/mshop/mshop/about-us.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 17 Dec 2020 04:47:10 GMT -->
</html>