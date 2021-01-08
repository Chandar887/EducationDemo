<?php

include_once('../../database.php');



//exam contest check time
if (isset($_REQUEST['req_type']) && $_REQUEST['req_type'] == "start_practice_test") {

    $test_id = $_REQUEST['test_id'];
    $user_id = $_REQUEST['user_id'];
    unset($_REQUEST['req_type']);
//    $curnt_time = mysqli_real_escape_string($db->con, $_POST['curnt_time']);

    if (!$db->countRows("quiz_play_detail", "test_id = '$test_id' and user_id = '$user_id'")) {

        $db->insertData("quiz_play_detail", $_REQUEST);
        $response['data'] = 1;
    } else {
        $response['data'] = 0;
    }

    echo json_encode($response);
}
?>