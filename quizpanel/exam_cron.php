<?php

include_once(__DIR__ . "/../database.php");


$updateStatus = $db->selectQuery("SELECT * FROM `exam_contest` WHERE status = 1 AND checked = 0");
foreach ($updateStatus as $statuDt) {
    $examID = $statuDt['id'];
    $currrtime = date("Y-m-d H:i:s");
    $currrtime = strtotime($currrtime);
    $end_time = $statuDt['end_time'];
    $end_time = strtotime($end_time);
    if($currrtime > $end_time){
        $db->updateData("exam_contest", array("status" => 2), "id='{$examID}'");
    }
}


if ($contestData = $db->selectQuery("SELECT * FROM `exam_contest` WHERE status = 2 AND checked = 0")) {
//echo __DIR__."../database.php";
    foreach ($contestData as $data) {
//        echo "<pre>";
//            print_r($data);die;
        $entryfee = $data['amount'];
        $contest_id = $data['id'];

//    update users submit status
        $getUserdt = $db->selectQuery("SELECT * FROM `quiz_play_detail` WHERE exam_id = '$contest_id' and user_submit = 0");
        foreach ($getUserdt as $userdt) {
            $currrtimee = date("Y-m-d H:i:s");
            $currrtime = strtotime($currrtimee);
            $usertimee = $userdt['created_at'];
            $usertime = strtotime($usertimee);
            $start_timee = $data['play_time'];
            $start_time = strtotime($start_timee);
            $end_timee = $data['end_time'];
            $end_time = strtotime($end_timee);

            $quiztime = $end_time - $start_time;
            $totaltime = $usertime + $quiztime;

            if ($currrtime > $totaltime) {
                $db->updateData("quiz_play_detail", array("user_submit" => 1), "exam_id={$contest_id} and user_id={$userdt['user_id']}");
//                echo "status updated";
            }
        }
//        die;
        //        number of users who played quiz
        $plyq = mysqli_fetch_assoc(mysqli_query($db->con, "SELECT COUNT(id) AS users FROM quiz_play_detail where exam_id = '$contest_id' and user_submit = 1"));
        $no_of_users = $plyq['users'];
//            echo $no_of_users;die;
        //    echo $no_of_users;die;

        if ($no_of_users == 0) {
            mysqli_query($db->con, "update `exam_contest` set status = 3, checked = 1 where id = '$contest_id'");
        } else if ($no_of_users == 1) {
            $plyqq = mysqli_fetch_assoc(mysqli_query($db->con, "SELECT * FROM quiz_play_detail where exam_id = '$contest_id' order by id DESC"));
            $user_id = $plyqq['user_id'];
            //        echo "SELECT * FROM `w_users` where ID = '$user_id'";die;
            $coinqq = mysqli_fetch_assoc(mysqli_query($db->con, "SELECT * FROM `w_users` where ID = '$user_id'"));
            $umobilee = $coinqq['uMobile'];
            $beforeCoinn = $coinqq['uCoin'];
            $franchiseID = $coinqq['franchiseID'];
            $aftercoinn = $coinqq['uCoin'] + $entryfee;
            //        echo $aftercoinn;die;

            $insrtw_coinss = mysqli_query($db->con, "INSERT INTO `w_user_coins`(`uID`, `franchiseID`, `uMobile`, `uCoin`, `review`, `roomID`,`type`, `beforeCoin`, `afterCoin`, `isCredit`) VALUES ('$user_id','$franchiseID','$umobilee','$entryfee','examquiz_refund','$contest_id','examquiz', '$beforeCoinn','$aftercoinn',1)");

            if ($insrtw_coinss) {
                mysqli_query($db->con, "update w_users set uCoin = '$aftercoinn' where ID = '$user_id'");
                mysqli_query($db->con, "update `exam_contest` set status = 3, checked = 1 where id = '$contest_id'");
            }
        } else {
            $plyqqq = mysqli_fetch_assoc(mysqli_query($db->con, "SELECT * FROM quiz_play_detail WHERE exam_id = '$contest_id' and user_submit = 1 ORDER BY score DESC,complete_time ASC"));
//            echo "<pre>";
//            print_r($plyqqq);die;
            $user_idd = $plyqqq['user_id'];
            $contest_idd = $plyqqq['exam_id'];

            $total_amount = $entryfee * $no_of_users;
            $adminCharge = 20;
            //        if ($ttdata = $db->selectRow("w_settings", "value", "name='adminCharge'")) {
            //            $adminCharge = $ttdata['value'];
            //        }

            $admin_charge = ($adminCharge / 100) * $total_amount;
            $win_amount = $total_amount - $admin_charge;

            //        get before amount of user's ucoin
            $coinq = mysqli_fetch_assoc(mysqli_query($db->con, "SELECT * FROM `w_users` where ID = '$user_idd'"));

            $umobile = $coinq['uMobile'];
            $beforeCoin = $coinq['uCoin'];
            $franchiseID = $coinq['franchiseID'];
            $aftercoin = $coinq['uCoin'] + $win_amount;

            $insrtw_coins = mysqli_query($db->con, "INSERT INTO `w_user_coins`(`uID`, `franchiseID`, `uMobile`, `uCoin`, `review`, `roomID`, `type`, `beforeCoin`, `afterCoin`, `isCredit`) VALUES ('$user_idd','$franchiseID','$umobile','$win_amount','examquizwin','$contest_idd','examquiz', '$beforeCoin','$aftercoin',1)");

            if ($insrtw_coins) {
                mysqli_query($db->con, "update w_users set uCoin = '$aftercoin' where ID = '$user_idd'");
                mysqli_query($db->con, "update exam_contest set status = 3, checked = 1, winner_id = '$user_idd', winner_amount = '$win_amount' where id = '$contest_idd'");
            }

            /*             * Level Income */
            $uid = $user_idd;
            $roomID = $contest_idd;
            if ($db->countRows("w_user_coins", "fromID='{$uid}' and roomID='{$roomID}' and review='examquizprofit' and type='examquiz'") == 0) {
                ////////////
                $chargeAmount = ($total_amount * $adminCharge) / 100;
                $quizprofit = array(1 => 10, 2 => 7, 3 => 5, 4 => 3, 5 => 2, 6 => 2, 7 => 1);
                if ($downline = $db->selectRow("w_sponsor_downline", "downline", "userID='{$uid}'")) {
                    $spUsers = array_reverse(array_filter(explode("-", $downline['downline'])));
                    if (count($spUsers) > 0) {
                        $i = 1;
                        foreach ($spUsers as $suser) {
                            if (isset($quizprofit[$i])) {
                                $am = ($chargeAmount * $quizprofit[$i]) / 100;
                                $coinsData = array("uID" => $suser, "uCoin" => $am, "review" => "examquizprofit", "description" => "{$quizprofit[$i]}% of totalbet={$total_amount}", "isCredit" => 1, "fromID" => $uid, "roomID" => $roomID, "type" => "examquiz");
                                if ($coData = $db->selectRow("w_users", "uCoin", "ID='{$suser}'")) {
                                    $coinsData['beforeCoin'] = $coData['uCoin'];
                                    $coinsData['afterCoin'] = $coData['uCoin'] + $am;
                                }
                                $db->insertData("w_user_coins", $coinsData);
                                $db->con->query("update w_users set uCoin=uCoin+$am where ID='$suser'");
                            }
                            $i++;
                        }
                    }
                }
            }

            /* Franchise Income */

            if ($users = $db->selectRows("w_user_coins", "uID,franchiseID,uCoin", "roomID='{$roomID}' and review='examquizplay' and type='examquiz'")) {
                foreach ($users as $uuser) {
                    $franchiseID = $uuser['franchiseID'];
                    $uid = $uuser['uID'];
                    $profit_percent_fr = 5;
                    $profit_fr = $uuser['uCoin'] * $profit_percent_fr / 100;
                    if ($franchiseID != "" && $franchiseID != 0 && $uid != $franchiseID) {
                        $coinsData = array("uID" => $franchiseID, "uCoin" => $profit_fr, "review" => "examquizprofit_fr", "isCredit" => 1, "fromID" => $uid, "roomID" => $roomID, "type" => "examquiz");
                        if ($coData = $db->selectRow("w_users", "uCoin", "ID='{$franchiseID}'")) {
                            $coinsData['beforeCoin'] = $coData['uCoin'];
                            $coinsData['afterCoin'] = $coData['uCoin'] + $profit_fr;
                            $db->con->query("update w_users set uCoin=uCoin+{$profit_fr} where ID='{$franchiseID}'");
                        }
                        $db->insertData("w_user_coins", $coinsData);
                    }
                }
            }
        }
    }
    //    echo "cron file hits success";
}


