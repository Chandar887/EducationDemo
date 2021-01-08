<?php

require_once("../../database.php");
//        require_once("userClass.php");
//submit test quiz
if (isset($_REQUEST['submit1']) && ($_REQUEST['submit1']) == "submit_practice_test") {

//        echo "<pre>";
//        print_r($_REQUEST);
//        die;

    if (isset($_SESSION['stop_back'])) {
        unset($_SESSION['stop_back']);
    }

//    $quiz_play_detail_id = mysqli_real_escape_string($db->con, $_POST['quiz_play_detail_id']);

    $que_ans = json_encode($_REQUEST['answer']);
    $total_questions = count($_REQUEST['total_que']);
    $attempted_que = count($_REQUEST['answer']);
    $time_diff = $_REQUEST['time_diff'];
//    echo $time_diff;die;

    $complete_time = $_REQUEST['complete_time'];
//    $json_time = 
//    $time_diff = json_encode($_REQUEST['time_diff']);
//    print_r($time);die;
//    echo $_REQUEST['test_duration'];die;
    $time = $_REQUEST['test_duration'] * 60;
    $test_duration = $time * 1000;
//    echo $time;die;
    $db->updateData("quiz_play_detail", array("user_submit" => 1), "test_id={$_REQUEST['test_id']} and user_id={$_REQUEST['user_id']}");

    $time_for1_question = $time / $total_questions;

    if ($db->updateData("quiz_play_detail", array("answer" => $que_ans, "time_diff" => $time_diff, "total_que" => $total_questions, "attempted_que" => $attempted_que), "test_id={$_REQUEST['test_id']} and user_id={$_REQUEST['user_id']}")) {
//            compare results
//        $user_id = $userData['ID'];

        $row = $db->selectQuery("SELECT * FROM `quiz_play_detail` WHERE test_id = '{$_REQUEST['test_id']}' AND user_id = '{$_REQUEST['user_id']}'");
//        echo "<pre>";
//        print_r($row);die;
        $totaltime_diff = 0;

        $json_decode_ans = json_decode($row[0]['answer']);
//        echo "<pre>";
//        print_r($json_decode_ans);die;
        if ($json_decode_ans != '') {
            $x = 0;
            foreach ($json_decode_ans as $key => $value) {
                for ($i = 0; $i < count(array($json_decode_ans)); $i++) {

                    $qry = "SELECT `answer` FROM `test_questions` WHERE ID = $key";
                    // echo $qry;  
                    $rslt = mysqli_query($db->con, $qry);

                    $dt = mysqli_fetch_array($rslt);
                    $data[$i] = $dt['0'];

                    // echo $data[$i] .'=='. $value[$i].'<br>';
                    if ($data[$i] == $value[$i]) {
                        $totaltime_diff += ($time_for1_question * 1000) - $time_diff[$key];
                        $x++;
                    } else {
                        echo "";
                    }
                }
            }

            $x;
        } else {
            $x = 0;
        }
        $db->updateData("quiz_play_detail", array("correct_answer" => $x), "test_id={$_REQUEST['test_id']} and user_id={$_REQUEST['user_id']}");
//        $qry = "UPDATE `quiz_play_detail` SET `correct_answer` = '$x' WHERE test_id = '{$_REQUEST['test_id']}' AND user_id = '{$_REQUEST['user_id']}'";
//        select data from quiz play detail for insert into quiz score
//        $q = "SELECT * FROM `quiz_play_detail` WHERE exam_id = '$contest_id' AND user_id = '$user_id'";
        $data = $db->selectQuery("SELECT * FROM `quiz_play_detail` WHERE test_id = '{$_REQUEST['test_id']}' AND user_id = '{$_REQUEST['user_id']}");
//        echo "<pre>";
//        print_r($data);die;

        $user_correct_ans = $data[0]['correct_answer'];
        $tempscore = $user_correct_ans * 10;

        $time_profit = $totaltime_diff / 1000;

        $final_score = $time_profit + $tempscore;
//        echo $final_score;die;
//        echo "final score ".$final_score;die;
//       ******* total score
        $tems = $total_questions * 10;
        $total_score = $tems + $time;

        if ($db->updateData("quiz_play_detail", array("score" => $final_score, "complete_time" => $complete_time, "total_score" => $total_score), "test_id={$_REQUEST['test_id']} and user_id={$_REQUEST['user_id']}")) {
            $_SESSION['test_id'] = $_REQUEST['test_id'];
            header("location:../test_score.php");
        }
    }
}
?>		

