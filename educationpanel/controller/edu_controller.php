<?php

require_once("../../database.php");


//******************user submit quiz after seen the live video**************
if (isset($_POST['submit1']) && ($_POST['submit1']) == "user_submit_quiz") {


//    if (isset($_SESSION['stop_back'])) {
//        unset($_SESSION['stop_back']);
//    }
//    echo "<pre>";
//    print_r($_POST);die;

//    $quiz_play_detail_id = mysqli_real_escape_string($db->con, $_POST['quiz_play_detail_id']);
    $live_class_id = $_POST['contest_id'];
    $user_id = $_POST['user_id'];
    $question_no = $_POST['question_no'];
    $que_ans = json_encode($_POST['question']);
//    print_r($que_ans);die;


    $total_questions = count($_POST['question_no']);
    $attempted_que = count($_POST['question']);
    $complete_time = $_POST['complete_time'];
    $json_time = 
    $time_diff = json_encode($_POST['time_diff']);
    $time = json_decode($time_diff,true);
//    print_r($time);die;
    $quiz_time = $_POST['quiz_time'];


    $q = "UPDATE `quiz_play_detail` SET `answer`='$que_ans', `time_diff` = '$time_diff', `total_que`='$total_questions',`attempted_que`='$attempted_que' WHERE live_class_id = '$live_class_id' AND user_id = '$user_id'";
//     echo $q;die;


    $result = mysqli_query($db->con, $q);

    if ($result) {
    
//            compare results
//        $user_id = $userData['ID'];

        $qqq = "SELECT * FROM `quiz_play_detail` WHERE live_class_id = '$live_class_id' AND user_id = '$user_id'";
        $result = mysqli_query($db->con, $qqq);
        $row = mysqli_fetch_assoc($result);
//        $userrow = $row['user_id'];

        $totaltime_diff = 0;

        $json_decode_ans = json_decode($row['answer']);
        if ($json_decode_ans != '') {
            $x = 0;
            foreach ($json_decode_ans as $key => $value) {

                for ($i = 0; $i < count($json_decode_ans); $i++) {

                    $qry = "SELECT `answer` FROM `live_class_que` WHERE id = $key";
                    // echo $qry;  
                    $rslt = mysqli_query($db->con, $qry);
                    // }
                    $dt = mysqli_fetch_array($rslt);
                    $data[$i] = $dt['0'];

                    // echo $data[$i] .'=='. $value[$i].'<br>';
                    if ($data[$i] == $value[$i]) {
                        $totaltime_diff+=($time_for1_question*1000)- $time[$key];
                        
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

       

        $qry = "UPDATE `quiz_play_detail` SET `correct_answer` = '$x' WHERE live_class_id = '$live_class_id' AND user_id = '$user_id'";

        $rt = mysqli_query($db->con, $qry);



//        select data from quiz play detail for insert into quiz score
        $q = "SELECT * FROM `quiz_play_detail` WHERE live_class_id = '$live_class_id' AND user_id = '$user_id'";
        $rslt = mysqli_query($db->con, $q);
        $data = mysqli_fetch_array($rslt);


//        ***********calculate quiz score*******
//        $complete_time = mysqli_real_escape_string($db->con, $_POST['end_time']);
//        $json_decode_time = json_decode($data['time_diff']);

        $user_correct_ans = $data['correct_answer'];
        $tempscore = $user_correct_ans * 10;
        
        $time_profit = $totaltime_diff / 1000;
        
        $final_score = $time_profit + $tempscore;

//       ******* total score
        $tems = $total_questions * 10;
        $total_score = $tems + $quiz_time;

//        $userrow
//         $user_id = $userData['ID'];
        $q = "UPDATE `quiz_play_detail` SET `score`='$final_score', `complete_time`='$complete_time', `total_score`='$total_score' WHERE live_class_id = '$live_class_id' AND user_id = '$user_id'";
//        echo $q;die;
        $rsttt = mysqli_query($db->con, $q);


        $_SESSION['live_class_id'] = $live_class_id;
//        $_SESSION['question_no'] = $question_no;
//        $_SESSION['quiz_play_detail_id'] = $quiz_play_detail_id;
//        $_SESSION['quiz_success'] = 'Submit quiz successfully!';
        header("location:../user_quiz_score.php");
    }
}
?>		

