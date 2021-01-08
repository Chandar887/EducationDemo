<?php
require_once('include/quiz_header.php');

if (isset($_GET['test_id']) && isset($_GET['test_type'])) {
    $test_id = $_GET['test_id'];
    $test_type = $_GET['test_type'];
//    echo $test_id;die;
} else {
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
    exit;
}
//echo "select * from practice_test where ID = '$test_id'";die;
$testData = $db->selectQuery("select * from practice_test where ID = '$test_id'");
//echo "<pre>";
//print_r($testData);die;
$cats = json_decode($testData[0]['cat_que'], true);
//echo "<pre>";
//print_r($cats);die;


$limit = array();
$questions = array();
foreach ($cats as $k1 => $cat1) {
    if (is_array($cat1)) {
        foreach ($cat1 as $k2 => $cat2) {
            if (is_array($cat2)) {
                foreach ($cat2 as $k3 => $cat3) {
                    if (is_array($cat3)) {
                        foreach ($cat3 as $k4 => $cat4) {
                            if (is_array($cat4)) {
                                
                            } else {
                                $limit[] = $cat4;
                                $questions[] = $db->selectQuery("select * from test_questions where cat_1='$k1' && cat_2='$k2' && cat_3='$k3' && cat_4='$k4' ORDER BY RAND() limit $cat4");
                            }
                        }
                    } else {
                        $limit[] = $cat3;
                        $questions[] = $db->selectQuery("select * from test_questions where cat_1='$k1' && cat_2='$k2' && cat_3='$k3' ORDER BY RAND() limit $cat3");
                    }
                }
            } else {
                $limit[] = $cat2;
                $questions[] = $db->selectQuery("select * from test_questions where cat_1='$k1' && cat_2='$k2' ORDER BY RAND() limit $cat2");
            }
        }
    } else {
        $limit[] = $cat1;
        $questions[] = $db->selectQuery("select * from test_questions where cat_1='$k1' ORDER BY RAND() limit $cat1");
    }
}
// print_r(end($questions));
//echo "<pre>";
//print_r($questions);
//die;
?>

<div class="container">
    <div class="col-12">
        <div class="row">
            <h1 class="mt-2">Let's Start</h1>
            <div class="countdown ml-auto"></div>
        </div>

        <form id="submit_quiz1" action="controller/test_controller.php" method="post">
            <div class="row">
                <?php
                $x = 1;
                foreach ($questions as $que) {
                    foreach ($que as $ques) {
//                        echo "<pre>";
//                        print_r($ques);die;
                        $json = $ques['suggestions'];
                        $dt = json_decode($json, true);
                        ?>
                        <div class="col-lg-6 col-md-6 col-12 mt-3 <?php echo ($test_type == 'modeltest') ? '' : 'question q'; ?><?php echo $x; ?><?php echo ($x != 1 ? "d-none" : ""); ?>" data-question="<?php echo $x; ?>">
                            <div class="card" style="max-width: 100%; height: 100%;">
                                <h5 class="card-header" style="background-color: #248CEA; color: white;">
                                    <?php echo ($test_type == 'modeltest') ? $x . '.' . $ques['questions'] : $ques['questions']; ?>
                                </h5> 
                                <ul class="list-group list-group-flushs donate-now">
                                    <input type="hidden" name="test_id" value="<?php echo $test_id; ?>">
                                    <input type="hidden" name="user_id" value="<?php echo $userData['ID']; ?>">
                                    <input type="hidden" name="total_que[]" value="<?php echo $ques['ID']; ?>">
                                    <input type="hidden" name="test_duration" value="<?php echo $testData[0]['duration']; ?>">
                                    <?php
                                    if ($ques['que_image'] != "") {
                                        ?>
                                        <li class="list-group-item"><label><img src='<?php echo $ques["que_image"]; ?>' style='height:100px!important;'></label>
                                        </li>
                                        <?php
                                    }
                                    ?>

                                    <li class="list-group-item"><label><input type="radio" name="answer[<?php echo $ques['ID']; ?>]" value="A"> A) <?php
                                            if (filter_var($dt['A'], FILTER_VALIDATE_URL)) {
                                                echo "<img src='$dt[A]' style='height:100px!important;'>";
                                            } else {
                                                echo $dt['A'];
                                            }
                                            ?></label>
                                    </li>

                                    <li class="list-group-item"><label><input type="radio" name="answer[<?php echo $ques['ID']; ?>]" value="B"> B) <?php
                                            if (filter_var($dt['B'], FILTER_VALIDATE_URL)) {
                                                echo "<img src='$dt[B]' style='height:100px!important;'>";
                                            } else {
                                                echo $dt['B'];
                                            }
                                            ?></label></li>

                                    <li class="list-group-item"><label><input type="radio" name="answer[<?php echo $ques['ID']; ?>]" value="C"> C) <?php
                                            if (filter_var($dt['C'], FILTER_VALIDATE_URL)) {
                                                echo "<img src='$dt[C]' style='height:100px!important;'>";
                                            } else {
                                                echo $dt['C'];
                                            }
                                            ?></label></li>

                                    <li class="list-group-item"><label><input type="radio" name="answer[<?php echo $ques['ID']; ?>]" value="D"> D) <?php
                                            if (filter_var($dt['D'], FILTER_VALIDATE_URL)) {
                                                echo "<img src='$dt[D]' style='height:100px!important;'>";
                                            } else {
                                                echo $dt['D'];
                                            }
                                            ?></label></li>
                                </ul>
                            </div>
                        </div>

                        <input type="hidden" name="time_diff[<?php echo $ques['ID']; ?>]" id="time_diff<?php echo $x; ?>" value="" />
                        <?php
                        $x++;
                    }
                }
                ?>
            </div>

            <input type="hidden" name="complete_time" id="complete_time" value="" />
            <input type="hidden" name="submit1" id='end_time' value="submit_practice_test" />
            <input type="hidden" name="next" onclick="countdowntimer();" value="next_que" />
            <button type="button" class="btn btn-success all_btn mt-2 mb-2 change_btn" onclick="countdowntimer();" id="next_que">Next</button>  
        </form>
    </div>
</div>

<?php
$no_of_que = 0;
foreach ($limit as $ques) {
    $no_of_que += $ques;
}

require_once('include/quiz_footer.php');
$testtime = $testData[0]['duration'] * 60;
$duration = $testtime * 1000;
?>

<script type="text/javascript">
    var fiveMinutes = '<?php echo ($test_type == "modeltest") ? $testtime : $duration; ?>';
//    console.log(fiveMinutes);
    var display = document.querySelector('.countdown');

    var duration = timer = fiveMinutes;
    var questionCount = <?php echo $no_of_que; ?>;
    var qq = 1;

    var seconds = parseInt(timer % 60, 10);
    seconds = seconds < 10 ? "0" + seconds : seconds;
    var startTimeM = (new Date).getTime();
    var endTimeM = 0;
    var timeDiff = {};
    var timeDiffTotal = 0;
    var total = 0;

    function countdowntimer() {
        if (typeof timeDiff[qq] == "undefined") {
            endTimeM = (new Date).getTime();
            timeDiff[qq] = endTimeM - startTimeM;
        }

        $('#compque').text(total + "/" + questionCount);
//         show submit button on last question
        var remainq = questionCount - 1;

        if (qq == remainq)
        {
            $('#next_que').html("Submit");
        }
        var timedifference = timeDiff[qq];
        console.log(timedifference);

        document.getElementById("time_diff" + qq).value = timedifference;

        totalDiff += timeDiff[qq];
        timer = duration;

        if (qq == questionCount) {
            document.getElementById("complete_time").value = totalDiff;
            $('#submit_quiz1').submit();
        }
        startTimeM = (new Date).getTime();

        $(".question").addClass("d-none");
        $(".q" + (qq + 1)).removeClass("d-none");

        qq++;
    }

    var timerInterval = setInterval(function () {
        if (--timer < 0) {
            timer = duration;
            $('#next_que').click();
        }
        seconds = parseInt(timer % 60, 10);
        seconds = seconds < 10 ? "0" + seconds : seconds;
        display.textContent = seconds;

    }, 1000);

    var totalDiff = 0;
    $('input[type="radio"]').on('change', function (e) {
        endTimeM = (new Date).getTime();
        var qno = $(this).closest(".question").attr("data-question");
        timeDiff[qno] = endTimeM - startTimeM;
//            console.log(endTimeM-startTimeM);
    });
</script> 
