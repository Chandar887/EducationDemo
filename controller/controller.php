<?php

include_once('../database.php');


//login user
if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == "login") {
    
//    echo "<pre>";
//    print_r($_REQUEST);die;
    unset($_REQUEST['submit']);
    $_REQUEST['uPassword'] = md5($_REQUEST['uPassword']);
    
    if ($getdata=$db->selectQuery("select * from w_users where uEmail='{$_REQUEST['uEmail']}' and uPassword='{$_REQUEST['uPassword']}' and uRole='user'")) {
        $uToken = $getdata[0]['uToken'];    
        $_SESSION['w_user'] = $uToken;
         header('location: ../home.php');
    } else {
        $_SESSION['loginfail'] = "Something Went Wrong!";
        header('location:../index.php');
    }
}


//    register user
if (isset($_REQUEST['submit']) && $_REQUEST['submit'] == "register") {
    unset($_REQUEST['submit']);

    if ($db->countRows("w_users", "uEmail='{$_REQUEST['uEmail']}' OR uMobile='{$_REQUEST['uMobile']}'")) {
        $_SESSION['err'] = "Email Or Mobile Already Exists!";
        header('location: ../register.php');
    } else {
        $_REQUEST['uPassword'] = md5($_REQUEST['uPassword']);
        $_REQUEST['uToken'] = md5(uniqid($_REQUEST['uMobile'], true));
        $_REQUEST['uCoin'] = 2000;
        if ($db->insertData("w_users", $_REQUEST)) {
            $_SESSION['w_user'] = $_REQUEST['uToken'];
            header('location: ../home.php');
        }
    }
}
?>
