<?php

include_once('../database.php');

if (isset($_REQUEST['req_type']) && $_REQUEST['req_type'] == "logoutuser") {

    if (isset($_SESSION['w_user'])) {
        unset($_SESSION['w_user']);
        $response['data'] = 1;
    } else {
        $response['data'] = 0;
    }
    echo json_encode($response);
}
?>
