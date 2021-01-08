<?php
include_once('database.php');

if (isset($_SESSION['w_user']) && $_SESSION['w_user'] != "") {
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
         <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


        <link rel="shortcut icon" href="assets/img/favicon.png">

    </head>
    <style>
        body{
            background: url('assets/img/bg1.jpg');
        }

       a:hover {
            color: #0056b3;
            text-decoration: none;
        }

        .alert {
            position: relative;
            padding: 1rem 1rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: .25rem;
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

        <!-- register -->
        <!-- <div class="register pages section-padding">
            <div class="container">
                <div class="pages-head"> -->
                    <div class="container-fluid h-100">
        <div class="row align-items-center h-100">
            <div class="col-lg-6 col-md-6 col-sm-12 mx-auto">
                   <!--  <h2>REGISTER</h2>
                </div> -->

                <?php
                if (isset($_SESSION['err'])) {
                    ?>
                    <p class="alert alert-danger mt-5"><?php echo $_SESSION['err']; ?></p>
                    <?php
                }
                ?>

                
                    <form action="controller/controller.php" method="post" class="border p-4 bg-white rounded <?php echo isset($_SESSION['err']) ? '' : 'mt-5'; ?>" id="form-login">
                        <h2 class="text-center mb-5">Register</h2>
                        <div class="form-group">
                            
                            <input type="text" name="uName" class="form-control" value="" required placeholder="Name*">
                        </div>
                        <div class="form-group">
                           
                            <input type="email" name="uEmail" value="" class="form-control" required placeholder="Email*">
                        </div>

                        <div class="form-group">
                            
                            <input type="text" class="form-control" name="uMobile" placeholder="Mobile*" required="">
                        </div>
                        <div class="form-group">
                           
                            <input type="password" name="uPassword" placeholder="Password*" value="" class="form-control" required>
                        </div>

                        <a href="index.php"><h6>Have an Account <span style="color: #007bff;">Login!</span></h6></a>

                        <button type="submit" name="submit" value="register" class="btn button-default w-100">REGISTER</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- end register -->




        <!-- scripts -->
        <script src="assets/js/jquery-3.1.0.min.js"></script>
        <script src="assets/js/materialize.min.js"></script>
        <script src="assets/js/main.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    </body>

    <!-- Mirrored from ngetemplates.com/mshop/mshop/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 17 Dec 2020 04:47:10 GMT -->
</html>

<?php
if (isset($_SESSION['err'])) {
    unset($_SESSION['err']);
}
?> 