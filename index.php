<?php
include_once('database.php');

if (isset($_SESSION['w_user'])) {
    header('location: home.php');
}
?>

<!DOCTYPE html>
<html lang="en">

    <!-- Mirrored from ngetemplates.com/mshop/mshop/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 17 Dec 2020 04:47:10 GMT -->
    <head>
        <meta charset="UTF-8">
        <title>Webcyst Demo | Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1  maximum-scale=1 user-scalable=no">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-touch-fullscreen" content="yes">
        <meta name="HandheldFriendly" content="True">

        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,900" rel="stylesheet"> 
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i" rel="stylesheet"> 
        <!-- CSS only -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="assets/css/materialize.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/css/normalize.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="shortcut icon" href="assets/img/favicon.png">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    </head>
    <style>
        body{
            background: url('assets/img/bg1.jpg');
        }

       

        .btn:hover {
            color: white;
        }

        a:hover {
            color: #0056b3;
            text-decoration: none;
        }

        .alert-danger {
            color: white;
            background-color: #c52735;
            /* border-color: white; */
        }

        @media only screen and (max-width: 600px) {
            .pages {
                margin-top: 45px!important;
            }
        }
    </style>
    <body>


<div class="container-fluid h-100">
        <div class="row align-items-center h-100">
            <div class="col-lg-6 col-md-6 col-sm-12 mx-auto">
        <!-- login -->
       <!--  <div class="login pages section-padding">
            <div class="container">
                <div class="pages-head"> -->
                

                <?php
                if (isset($_SESSION['loginfail'])) {
                    ?>
                    <p class="alert alert-danger mt-5"><?php echo $_SESSION['loginfail']; ?></p>
                    <?php
                }
                ?>
                
                    <form action="controller/controller.php" method="post" class="border p-4 bg-white rounded <?php echo isset($_SESSION['loginfail']) ? '' : 'mt-5'; ?>" id="form-login">
                    <!-- <div class="text-center"><img src="img/logo.png" class="text-center" style="width: 30%; margin-bottom: 14px;">
                    </div -->
                    <h2 class="text-center mb-5">Login</h2>
                    <div class="form-group">
                        <!--<label for="exampleInputEmail1">Email address</label>-->
                        <input type="email" name="uEmail" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter Email">
                    </div>
                    <div class="form-group">
                        <!--<label for="exampleInputEmail1">Password</label>-->
                        <input type="password" name="uPassword" id="password" class="form-control" aria-describedby="emailHelp" placeholder="Enter Password">
                    </div>

                    <div class="form-group">
                        <button type="submit" name="submit" class=" btn btn-block mybtn btn-primary tx-tfm" value="login">Login</button>
                    </div>

                    <a href="register.php" class="mb-3"><span style="color: #007bff;">Don't have an Account</span> Register!</a>
                </form>
                </div>
            </div>
        </div>
        <!-- end login -->



        <!-- scripts -->
        <script src="assets/js/jquery-3.1.0.min.js"></script>
        <script src="assets/js/materialize.min.js"></script>
        <script src="assets/js/main.js"></script>
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    </body>

    <!-- Mirrored from ngetemplates.com/mshop/mshop/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 17 Dec 2020 04:47:10 GMT -->
</html>

<?php
if (isset($_SESSION['loginfail'])) {
    unset($_SESSION['loginfail']);
}
?> 