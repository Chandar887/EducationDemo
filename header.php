<?php
include_once('database.php');

if (isset($_SESSION['w_user']) && $_SESSION['w_user'] != "") {
    $token = $_SESSION['w_user'];

//    echo $token;
//    echo "select * from w_users where uToken = '$token' and isDisabled='0'";
    $data = mysqli_query($db->con, "select * from w_users where uToken = '$token' and isDisabled='0'");
    $userData = mysqli_fetch_assoc($data);
    $_SESSION['ludouser'] = $userData;
} else {
//    if (!isset($_SESSION['w_user']) && basename($_SERVER['PHP_SELF']) != 'page-payment-response.php') {
//    echo"<p style='color:white;background-color:#D32F2F;padding:12px;text-align:center;margin:40px;font-size:26px;font-weight:bold;'>Invalid Request</p>";
//    die;
    header('location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
    <!-- Mirrored from ngetemplates.com/mshop/mshop/index.php by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 17 Dec 2020 04:45:51 GMT -->
    <head>
        <meta charset="UTF-8">
        <title>Webcyst Demo</title>
        <meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1 user-scalable=no">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-touch-fullscreen" content="yes">
        <meta name="HandheldFriendly" content="True">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,900" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/materialize.css">
        <link rel="stylesheet" href="adminpanel/assets/css/jquery-confirm.min.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/css/normalize.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <!--<link rel="shortcut icon" href="assets/img/favicon.png">-->
    </head>

    <style>
        a:hover {
            color: #0056b3;
            text-decoration: none;
        }

        .slides{
            height: 250px;
        }

        .h-75 {
            height: 100%!important;
        }

        .new-best-product-content, .product-content {
            border: 5px solid #007bff;
            border-radius: 33px;
            padding: 0px 10px 44px 10px;
            background-color: #f1f1f1;
        }

        @media screen and (max-width: 600px) {
            .h-75 {
                height: 62%!important;
            }

            .site-brand {
                display: inline-block;
                float: left;
            }

            .slider .slides li .caption {
                color: #fff;
                position: absolute;
                top: -6%;
                left: 15%;
                width: 70%;
                opacity: 0;
            }

            .new-best-product-content, .product-content {
                border: 5px solid #007bff;
                border-radius: 33px;
                padding: 0px 10px 11px 10px;
                background-color: #f1f1f1;
            }

            .product-details {
                padding: 0px 10px 30px 10px;
                text-align: center;
                margin-top: 10px;
            }

            .new-best-product-shop {
                padding: 0;
                margin-top: 64px;
            }

            .slider {
                margin-top: 64px;
                height: 400px!important;
                display: none;
            }

            .footer {
                background: #111;
                padding: 35px 0;
                display: none;
            }

            .side-nav-panel-left {
                display: none;
                float: left;
            }
        }
    </style>

    <body>
<!--<a href="#" data-activates="slide-out-left" class="side-nav-left"><i class="fa fa-bars"></i></a>-->
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