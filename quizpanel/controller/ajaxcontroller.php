<?php

include_once('../../database.php');

// print_r($_POST);die();
if (isset($_POST['req_type']) && $_POST['req_type'] == "quiz_play_detail") {

    $contest_id = mysqli_real_escape_string($db->con, $_POST['contest_id']);
    $user_id = mysqli_real_escape_string($db->con, $_POST['user_id']);
//    $curnt_time = mysqli_real_escape_string($db->con, $_POST['curnt_time']);

    $getcoin = mysqli_fetch_assoc(mysqli_query($db->con, "SELECT * FROM `quiz_contest` where id = '$contest_id'"));
    $curnt = date("Y-m-d H:i:s");
    $curnt = strtotime($curnt);
    $playtimes = $getcoin['play_time'];
    $playtimes = strtotime($playtimes);
    $enddtimes = $getcoin['end_time'];
    $enddtimes = strtotime($enddtimes);
//***********check time of contest
    if ($curnt >= $playtimes && $curnt <= $enddtimes) {

        if (!$db->countRows("quiz_play_detail","contest_id = '$contest_id' and user_id = '$user_id'")) {
            $get_user_play_detail = mysqli_fetch_assoc(mysqli_query($db->con, "SELECT count(id) as countuser FROM `quiz_play_detail` where contest_id = '$contest_id'"));
            $countUsers = $get_user_play_detail['countuser'];
//        echo $countUserData;die;
//        check the user already played the quiz or not**************
            if ($countUsers < $getcoin['total_member']) {
                $status = $getcoin['status'];
                if ($status == 0) {
                    mysqli_query($db->con, "UPDATE `quiz_contest` SET `status`= 1 WHERE id = '$contest_id'");
                }

                $quizamount = $getcoin['amount'];

                $coinq = mysqli_fetch_assoc(mysqli_query($db->con, "SELECT * FROM `w_users` where ID = '$user_id'"));
                $umobile = $coinq['uMobile'];
                $beforeCoin = $coinq['uCoin'];
                $franchiseID = $coinq['franchiseID'];

                if ($quizamount < $beforeCoin) {
                    $q = "INSERT INTO `quiz_play_detail`(`contest_id`, `user_id`) VALUES ('$contest_id','$user_id')";
                    $reslt = mysqli_query($db->con, $q);
                    // echo $q;

                    $_SESSION['result'] = $reslt;
                    $aftercoin = $coinq['uCoin'] - $quizamount;
                    $insrtw_coins = mysqli_query($db->con, "INSERT INTO `w_user_coins`(`uID`, `franchiseID`, `uMobile`, `uCoin`, `review`, `roomID`, `type`, `beforeCoin`, `afterCoin`) VALUES ('$user_id','$franchiseID','$umobile','$quizamount','quizplay','$contest_id','educationquiz','$beforeCoin','$aftercoin')");
                    if ($insrtw_coins) {
                        mysqli_query($db->con, "update w_users set uCoin = $aftercoin where ID = '$user_id'");
                    }

                    /*                     * ***send amount to franchise id and sponser** */
                    // $adminCharge = 20;
                    // $profit_percent_fr = 20;
                    // $profit_percent_sp = 20;
//        if ($ttdata = $db->selectRow("w_settings", "value", "name='adminCharge'")) {
//            $adminCharge = $ttdata['value'];
//        }
                    // $chargeAmount = ($quizamount * $adminCharge) / 100;
                    // $profit_fr = $chargeAmount * $profit_percent_fr / 100;

                    // $profit_sp = $chargeAmount * $profit_percent_sp / 100;
                    // if ($coinq['underplaceID'] != "" && $coinq['underplaceID'] != 0) {
                    //     $coinsData = array("uID" => $coinq['underplaceID'], "uCoin" => $profit_sp, "review" => "quizprofit", "isCredit" => 1, "fromID" => $user_id, "roomID" => $contest_id);
                    //     if ($coData = $db->selectRow("w_users", "uCoin", "ID='{$coinq['underplaceID']}'")) {
                    //         $coinsData['beforeCoin'] = $coData['uCoin'];
                    //         $coinsData['afterCoin'] = $coData['uCoin'] + $profit_sp;
                    //         $db->con->query("update w_users set uCoin=uCoin+{$profit_sp} where ID='{$coinq['underplaceID']}'");
                    //     }
                    //     $db->insertData("w_user_coins", $coinsData);
                    // }

                    // if ($coinq['franchiseID'] != "" && $coinq['franchiseID'] != 0 && $user_id != $coinq['franchiseID']) {
                    //     $coinsData = array("uID" => $coinq['franchiseID'], "uCoin" => $profit_fr, "review" => "quizprofit_fr", "isCredit" => 1, "fromID" => $user_id, "roomID" => $contest_id);
                    //     if ($coData = $db->selectRow("w_users", "uCoin", "ID='{$coinq['franchiseID']}'")) {
                    //         $coinsData['beforeCoin'] = $coData['uCoin'];
                    //         $coinsData['afterCoin'] = $coData['uCoin'] + $profit_fr;
                    //         $db->con->query("update w_users set uCoin=uCoin+{$profit_fr} where ID='{$coinq['franchiseID']}'");
                    //     }
                    //     $db->insertData("w_user_coins", $coinsData);
                    // }

                    /*                     * ********** */

                    $_SESSION['stop_back'] = 1;
                    $response['data'] = 1;
                } else {
                    $response['data'] = 0;
                }
            } else {
                $response['data'] = 2;
            }
        }else {
             $response['data'] = 3;
        }
    } else {
        $response['data'] = 4;
    }


    echo json_encode($response);
}


//**************check time of contest************* 
if (isset($_POST['req_type']) && $_POST['req_type'] == "checktimeofquiz") {
    $contest_id = mysqli_real_escape_string($db->con, $_POST['contest_id']);

    $upcomigq = mysqli_fetch_assoc(mysqli_query($db->con, "SELECT * FROM `quiz_contest` where id = '$contest_id'"));

    $cur = date("Y-m-d H:i:s");
    $currrtime = strtotime($cur);
    $ee = $upcomigq['play_time'];
    $start_time = strtotime($ee);
    $eendd = $upcomigq['end_time'];
    $end_time = strtotime($eendd);

    $start = time_elapsed_string($upcomigq['play_time']);
    $enddtime = time_elapsed_string($upcomigq['end_time']);

    if ($currrtime < $start_time) {
        $response = array('data' => 0,
            'start_time' => $start);
    } else if ($currrtime >= $start_time && $currrtime <= $end_time) {

        $response = array('data' => 1,
            'end_time' => $enddtime);
    }
//    else if($currrtime >= $end_time){
//        $db->con->query("update quiz_contest set status = 2 where id ='$contest_id'");
//        $response = array('data' => 2,
//            'update_status' => $enddtime);
//    }

    echo json_encode($response);
}




//exam contest check time
if (isset($_POST['req_type']) && $_POST['req_type'] == "exam_contest_play") {

    $contest_id = mysqli_real_escape_string($db->con, $_POST['contest_id']);
    $user_id = mysqli_real_escape_string($db->con, $_POST['user_id']);
//    $curnt_time = mysqli_real_escape_string($db->con, $_POST['curnt_time']);

    $getcoin = mysqli_fetch_assoc(mysqli_query($db->con, "SELECT * FROM `exam_contest` where id = '$contest_id'"));
    $curnt = date("Y-m-d H:i:s");
    $curnt = strtotime($curnt);
    $playtimes = $getcoin['play_time'];
    $playtimes = strtotime($playtimes);
    $enddtimes = $getcoin['end_time'];
    $enddtimes = strtotime($enddtimes);
//***********check time of contest
    if ($curnt >= $playtimes && $curnt <= $enddtimes) {

        if (!$db->countRows("quiz_play_detail","exam_id = '$contest_id' and user_id = '$user_id'")) {
            $get_user_play_detail = mysqli_fetch_assoc(mysqli_query($db->con, "SELECT count(id) as countuser FROM `quiz_play_detail` where exam_id = '$contest_id'"));
            $countUsers = $get_user_play_detail['countuser'];
//        echo $countUserData;die;
//        check the user already played the quiz or not**************
            if ($countUsers < 100) {
                $status = $getcoin['status'];
                if ($status == 0) {
                    mysqli_query($db->con, "UPDATE `exam_contest` SET `status`= 1 WHERE id = '$contest_id'");
                }

                $quizamount = $getcoin['amount'];

                $coinq = mysqli_fetch_assoc(mysqli_query($db->con, "SELECT * FROM `w_users` where ID = '$user_id'"));
                $umobile = $coinq['uMobile'];
                $beforeCoin = $coinq['uCoin'];
                $franchiseID = $coinq['franchiseID'];

                if ($quizamount < $beforeCoin) {
                    $q = "INSERT INTO `quiz_play_detail`(`exam_id`, `user_id`) VALUES ('$contest_id','$user_id')";
                    $reslt = mysqli_query($db->con, $q);
                    // echo $q;

                    $_SESSION['result'] = $reslt;
                    $aftercoin = $coinq['uCoin'] - $quizamount;
                    $insrtw_coins = mysqli_query($db->con, "INSERT INTO `w_user_coins`(`uID`, `franchiseID`, `uMobile`, `uCoin`, `review`, `roomID`, `type`, `beforeCoin`, `afterCoin`) VALUES ('$user_id','$franchiseID','$umobile','$quizamount','examquizplay','$contest_id', 'examquiz', '$beforeCoin','$aftercoin')");
                    if ($insrtw_coins) {
                        mysqli_query($db->con, "update w_users set uCoin = $aftercoin where ID = '$user_id'");
                    }

                    /*                     * ***send amount to franchise id and sponser** */
                    // $adminCharge = 20;
                    // $profit_percent_fr = 20;
                    // $profit_percent_sp = 20;
//        if ($ttdata = $db->selectRow("w_settings", "value", "name='adminCharge'")) {
//            $adminCharge = $ttdata['value'];
//        }
                    // $chargeAmount = ($quizamount * $adminCharge) / 100;
                    // $profit_fr = $chargeAmount * $profit_percent_fr / 100;

                    // $profit_sp = $chargeAmount * $profit_percent_sp / 100;
                    // if ($coinq['underplaceID'] != "" && $coinq['underplaceID'] != 0) {
                    //     $coinsData = array("uID" => $coinq['underplaceID'], "uCoin" => $profit_sp, "review" => "quizprofit", "isCredit" => 1, "fromID" => $user_id, "roomID" => $contest_id);
                    //     if ($coData = $db->selectRow("w_users", "uCoin", "ID='{$coinq['underplaceID']}'")) {
                    //         $coinsData['beforeCoin'] = $coData['uCoin'];
                    //         $coinsData['afterCoin'] = $coData['uCoin'] + $profit_sp;
                    //         $db->con->query("update w_users set uCoin=uCoin+{$profit_sp} where ID='{$coinq['underplaceID']}'");
                    //     }
                    //     $db->insertData("w_user_coins", $coinsData);
                    // }

                    // if ($coinq['franchiseID'] != "" && $coinq['franchiseID'] != 0 && $user_id != $coinq['franchiseID']) {
                    //     $coinsData = array("uID" => $coinq['franchiseID'], "uCoin" => $profit_fr, "review" => "quizprofit_fr", "isCredit" => 1, "fromID" => $user_id, "roomID" => $contest_id);
                    //     if ($coData = $db->selectRow("w_users", "uCoin", "ID='{$coinq['franchiseID']}'")) {
                    //         $coinsData['beforeCoin'] = $coData['uCoin'];
                    //         $coinsData['afterCoin'] = $coData['uCoin'] + $profit_fr;
                    //         $db->con->query("update w_users set uCoin=uCoin+{$profit_fr} where ID='{$coinq['franchiseID']}'");
                    //     }
                    //     $db->insertData("w_user_coins", $coinsData);
                    // }

                    /*                     * ********** */

                    $_SESSION['stop_back'] = 1;
                    $response['data'] = 1;
                } else {
                    $response['data'] = 0;
                }
            } else {
                $response['data'] = 2;
            }
        }else {
             $response['data'] = 3;
        }
    } else {
        $response['data'] = 4;
    }


    echo json_encode($response);
}


//**************check time of contest************* 
if (isset($_POST['req_type']) && $_POST['req_type'] == "examContestTime") {
    $contest_id = mysqli_real_escape_string($db->con, $_POST['contest_id']);

    $upcomigq = mysqli_fetch_assoc(mysqli_query($db->con, "SELECT * FROM `exam_contest` where id = '$contest_id'"));

    $cur = date("Y-m-d H:i:s");
    $currrtime = strtotime($cur);
    $ee = $upcomigq['play_time'];
    $start_time = strtotime($ee);
    $eendd = $upcomigq['end_time'];
    $end_time = strtotime($eendd);

    $start = time_elapsed_string($upcomigq['play_time']);
    $enddtime = time_elapsed_string($upcomigq['end_time']);

    if ($currrtime < $start_time) {
        $response = array('data' => 0,
            'start_time' => $start);
    } else if ($currrtime >= $start_time && $currrtime <= $end_time) {

        $response = array('data' => 1,
            'end_time' => $enddtime);
    }
    else if($currrtime >= $end_time){
        $db->con->query("update exam_contest set status = 2 where id ='$contest_id'");
        $response = array('data' => 2, 'update_status' => $enddtime);
    }

    echo json_encode($response);
}
?>