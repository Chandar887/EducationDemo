<?php
session_start();
include_once("../database.php");


if (basename($_SERVER['PHP_SELF']) == "user_start_quiz.php") {
//    echo basename($_SERVER['PHP_SELF']);die;
    if (!(isset($_SESSION['stop_back']) && $_SESSION['stop_back'] == 1)) {
        $db->redirect($db->site . "quizpanel/index.php");
    }
}
include_once("controller/userClass.php");

if (isset($_SESSION['uToken'])) {
    $token = $_SESSION['uToken'];
//    echo "select * from w_users where uToken = '$token' and isDisabled='0'";
    $data = mysqli_query($db->con, "select * from w_users where uToken = '$token' and isDisabled='0'");
    $userData = mysqli_fetch_assoc($data);
    $_SESSION['ludouser'] = $userData;
} else if (!isset($_SESSION['ludouser']) && basename($_SERVER['PHP_SELF']) != 'page-payment-response.php') {
    echo"<p style='color:white;background-color:#D32F2F;padding:12px;text-align:center;margin:40px;font-size:26px;font-weight:bold;'>Invalid Request</p>";
    die;
}



$userClass = new userClass();
$id = $_SESSION["ludouser"]["ID"];
$query = mysqli_query($db->con, "SELECT * FROM `w_users` WHERE ID='$id'");
$userData = mysqli_fetch_assoc($query);
?>


<!doctype html>
<html class="no-js" lang="">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Quiz Panel</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <!--<link rel="shortcut icon" type="image/x-icon" href="img/logo/favicon.png">-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/jquery-confirm.min.css">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="css/responsive.css">
        <meta property="og:type" content="Webcyst Demo" />
        <meta property="og:title" content="Webcyst Demo" />
        <meta property="og:description" content="Webcyst Demo" />
    </head>
    
    <body>

        <!-- Start Header Top Area -->
        <div class="header-top-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-6 col-sm-8">
                      
                        <a href="index.php" style="font-size: 20px; background-color: #007bff;padding: 8px 8px 6px 8px;color: white;"><b>Quiz</b></a>

                        <a href="../home.php" class="ml-2"><span style="font-size:25px;"><i class="fa fa-home"></i></span></a>

                    </div> 

                    <div class="col-6 col-sm-4"> 

                        <!--                         Example single danger button -->
                        <div class="btn-group pull-right">
                            <button type="button" class="btn dropdown-toggle signout" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user-circle text-primary"></i>
                            </button> 
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" title="Quiz History" href="user_quiz_history.php"><i class="fa fa-history text-primary mr-2"></i>Quiz History</a>
                                <!--<a class="dropdown-item" title="Exam Quiz History" href="exam_quiz_history.php"><i class="fa fa-history text-primary mr-2"></i>Exam History</a>-->

                            </div>
                        </div> 
                    </div> 
                </div>
            </div>
        </div>
        <!-- End Header Top Area -->





        <!-- Main Menu area start-->
        <div class="main-menu-area mg-tb-40">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <ul class="nav nav-tabs notika-menu-wrap menu-it-icon-pro">
                            <li class="active"><a href="index.php"><i class="fa fa-home icons"></i> Home</a>
                            </li>


                            <li><a data-toggle="tab" href="#Forms"><i class="fa fa-history icons"></i> Quiz History</a>
                            </li>
                             
                        </ul>
                        <div class="tab-content custom-menu-content">
                            <div id="Home" class="tab-pane in active notika-tab-menu-bg animated flipInX">
                                <ul class="notika-main-menu-dropdown">
                                 
                                </ul>
                            </div>
                            <div id="mailbox" class="tab-pane notika-tab-menu-bg animated flipInX">
                                <ul class="notika-main-menu-dropdown">
                                    <li><a href="user_create_quiz.php">Add New Quiz</a>
                                    </li>
                                    <!--<li><a href="user_show_quiz.php">Play Quiz</a>-->
                                    </li>
                                    <li><a href="user_view_quiz.php">View Quiz</a>
                                    </li>
                                </ul>
                            </div>
                            
                            <div id="Forms" class="tab-pane notika-tab-menu-bg animated flipInX">
                                <ul class="notika-main-menu-dropdown">
                                    <li><a href="user_quiz_history.php">View Quiz History</a>
                                    </li>
                                   
                                </ul>
                            </div> 
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main Menu area End-->