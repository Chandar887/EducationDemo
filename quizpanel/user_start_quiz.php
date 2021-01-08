<?php
require_once('include/quiz_header.php');

//$_SESSION['stop_back'] = 1; 


if (isset($_GET['contest_id'])) {
    $contest_id = $_GET['contest_id'];
} else {
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
    exit;
}

    $selectCatname = $db->selectQuery("select * from quiz_contest where id = '$contest_id'");
    $cat_name = $selectCatname[0]['category_name'];
    $no_of_question = $selectCatname[0]['no_of_que'];
//    echo $cat_name;die;

$q = "SELECT * FROM `quiz_play_detail` WHERE contest_id = '$contest_id' order by id DESC";
$rslt = mysqli_query($db->con, $q);
$data = mysqli_fetch_assoc($rslt);
$quiz_play_id = $data['id'];
// echo $quiz_play_id;die;
?>


<div class="container">


  <!--<a href="index.php" class="btn btn-primary all_btn mt-4"><i class="fa fa-arrow-left"></i></a>--> 
    <div class="col-12">



        <?php
        // if(isset($_SESSION['edu_cat']))
        //  {
        //      $q = "SELECT * FROM `edu_quiz_data` WHERE quiz_id = '$contest_id'";
        //      $result = mysqli_query($db->con, $q);
        //      // echo "edu_quiz contest";
        //  }
        //  else
        //  {
        $q = "SELECT * FROM `contest_que` WHERE category_name = '$cat_name' order by RAND() LIMIT $no_of_question";
        $result = mysqli_query($db->con, $q);
       

        if (mysqli_num_rows($result) > 0) {
            ?>

            <div class="row">
                <h1 class="mt-2">Let's Start</h1>
                <div class="countdown ml-auto"></div>
            </div>



            <?php
//                $total_mem = $data['total_member'];
            $prog = mysqli_query($db->con, "SELECT * FROM `quiz_contest` WHERE id = '$contest_id'");
            $count = mysqli_fetch_assoc($prog);
            $no_of_ques = $count['no_of_que'];
            $quiz_time = $count['quiz_time'];
//               
            $val = 100 / $no_of_ques;

//                $cunt = $val * $count['count'];
//                $spots = $total_mem - $count['count'];
            ?>
            <div id="compque">0/<?php echo $no_of_ques; ?></div>

            <div class="progress">

                <div class="progress-bar progress-bar-striped bg-primary card-text" role="progressbar" style="width: 0%;" aria-valuenow="50" aria-valuemin="" aria-valuemax="100"></div>
            </div>



            <form id="submit_quiz1" action="controller/quiz_controller.php" method="post">
                <div class="row">
                    <?php
//                    $test = true;
                    $x = 1;

                    while ($data = mysqli_fetch_assoc($result)) {

                        $json = $data['suggestions'];
                        $dt = json_decode($json);
//                        $test = false;
                        ?>
                        <?php // echo"<br>x=$x ". ($x != 1 ? "d-none" : ""); ?>
                        <div class="col-lg-6 col-md-6 col-12 mt-3 question q<?php echo $x; ?> <?php echo ($x != 1 ? "d-none" : ""); ?>" data-question="<?php echo $x; ?>">
                            <div class="card" style="max-width: 100%; height: 100%;">
                                <h5 class="card-header" style="background-color: #248CEA; color: white;">
                                    <?php echo $data['questions']; ?>
                                </h5> 
                                <ul class="list-group list-group-flushs donate-now">
                                    <!--<input type="hidden" name="quiz_play_id" value="<?php echo $quiz_play_id; ?>">-->
                                    <input type="hidden" name="contest_id" value="<?php echo $contest_id; ?>">
                                    <input type="hidden" name="user_id" value="<?php echo $userData['ID']; ?>">
                                    <input type="hidden" name="question_no[]" value="<?php echo $data['id']; ?>">
                                    <input type="hidden" name="quiz_time" value="<?php echo $quiz_time; ?>">

                                    <li class="list-group-item"><label><input type="radio" name="question[<?php echo $data['id']; ?>]" value="A"> A) <?php echo $dt['0']; ?></label>
                                    </li>

                                    <li class="list-group-item"><label><input type="radio" name="question[<?php echo $data['id']; ?>]" value="B"> B) <?php echo $dt['1']; ?></label></li>

                                    <li class="list-group-item"><label><input type="radio" name="question[<?php echo $data['id']; ?>]" value="C"> C) <?php echo $dt['2']; ?></label></li>

                                    <li class="list-group-item"><label><input type="radio" name="question[<?php echo $data['id']; ?>]" value="D"> D) <?php echo $dt['3']; ?></label></li>
                                </ul>
                            </div>
                        </div>
                    <input type="hidden" name="time_diff[<?php echo $data['id']; ?>]" id="time_diff<?php echo $x; ?>" value="" />
                        <?php
                        $x++;
                    }
                    ?>
                </div>

                <input type="hidden" name="complete_time" id="complete_time" value="" />
                <input type="hidden" name="submit1" id='end_time' value="user_submit_quiz" />
                
                <!--<input type="hidden" name="next" onclick="countdowntimer();" value="next_que" />-->
                <button type="button" class="btn btn-success all_btn mt-4 change_btn" onclick="countdowntimer();" id="next_que">Next</button>  

                <!--<button type="submit" class="btn btn-success all_btn mt-4">Submit Quiz</button>-->  

            </form>


            <?php
        } else {
            ?>  
            <div class="card bg-light mt-5 mb-3" style="max-width: 100%;">
                <h5 class="card-header text-center text-danger">Sorry, Question Answers Are Not Available!</h5>
            </div>

            <?php
        }


        $q = "SELECT * FROM `quiz_contest` WHERE id = '$contest_id'";
        $rst = mysqli_query($db->con, $q);

        $dt = mysqli_fetch_assoc($rst);

        $no_of_que = $dt['no_of_que'];
        $quiz_time = $dt['quiz_time'];
        $time = $quiz_time / $no_of_que;
        ?>
    </div>
</div>

<?php
require_once('include/quiz_footer.php');
?>



<script type="text/javascript">

    //window.onload = function () {
    var fiveMinutes = '<?php echo $time; ?>';
    var display = document.querySelector('.countdown');

//        startTimer(fiveMinutes, display);
//        alert(fiveMinutes);

    var duration = timer = <?php echo $time; ?>;
    var questionCount = <?php echo $no_of_que; ?>;
    var qq = 1;

    var seconds = parseInt(timer % 60, 10);
    seconds = seconds < 10 ? "0" + seconds : seconds;
    var startTimeM = (new Date).getTime();
    var endTimeM = 0;
    var timeDiff = {};
    var timeDiffTotal = 0;
//        var totalques = {};
    var total = 0;

    var percent_1 = <?php echo $val; ?>;
    var total_per = 0;
//        var qInterval = setInterval(
    function countdowntimer() {
        if (typeof timeDiff[qq] == "undefined") {
            endTimeM = (new Date).getTime();
            timeDiff[qq] = endTimeM - startTimeM;
        }
        total_per = qq * percent_1;
//        console.log(total_per);
        total = qq;
        
        $('#compque').text(total + "/" + questionCount);
        $('.progress-bar').css("width", total_per + '%');
        
//         show submit button on last question
           var remainq = questionCount - 1;
//           console.log(remainq);
        if( qq == remainq )
        {
            $('#next_que').html("Submit");
        }
        var timedifference = timeDiff[qq];
        console.log(timedifference);
        
        document.getElementById("time_diff"+qq).value = timedifference;
        
        
         totalDiff+= timeDiff[qq];
        timer = duration;
//            console.log("Inteval-",qq,duration);  
        if (qq == questionCount) {
             document.getElementById("complete_time").value = totalDiff;
//                clearInterval(qInterval);
//                clearInterval(timerInterval);
            $('#submit_quiz1').submit();
        }
        startTimeM = (new Date).getTime();
        $(".question").addClass("d-none");
        $(".q" + (qq + 1)).removeClass("d-none");

//            console.log(timeDiff);
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

    //};

</script>






















