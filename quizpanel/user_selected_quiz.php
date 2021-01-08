<?php
include_once('include/quiz_header.php');
//    
?>

<style>
/*    .cardspan {
        background-color: white;
        padding: 1px 20px 1px 20px;
        border-radius: 6px;
    }*/
</style>

<div class="container-fluid">

    <?php
    if (isset($_GET['category_name'])) {
        $category_name = $_GET['category_name'];
//            $fetch = mysqli_fetch_array(mysqli_query($db->con,"select * from `quiz_categorgy` where id = '$category_name'"));
//            print_r($fetch);die;
    } else {
        echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
        exit;
    }

    $query = "SELECT * FROM `exam_contest` WHERE category_name = '$category_name' AND (status = 0 OR status = 1) order by id DESC";
//            echo $query;die;
    $quizq = mysqli_query($db->con, $query);

    if (mysqli_num_rows($quizq) > 0) {
        ?>
        <div class="rounded mt-3" style="border-left: 10px solid #007bff; background-color: #b5c1c145;">
            <h5 class="text-center my-auto p-1"><b><?php echo $category_name; ?></b></h5>
        </div>
        <div class="col-12 col-sm-12">

            <div class="row">
                <?php
                while ($data = mysqli_fetch_assoc($quizq)) {
//                    echo "<pre>";
//                    print_r($data);die;
                    $cur = date("Y-m-d H:i:s");
                    $currrtime = strtotime($cur);
                    $ee = $data['play_time'];
                    $start_time = strtotime($ee);
                    $end = $data['end_time'];
                    $end_time = strtotime($end);
                    $contest_id = $data['id'];

                    if ($currrtime >= $end_time) {
                        $updq = mysqli_query($db->con, "UPDATE `exam_contest` SET `status` = 2 WHERE id = '$contest_id'");
                    }

                    $user_id = $userData['ID'];
                    $contest_id = $data['id'];

                    $start_quiz = $currrtime >= $start_time && $currrtime <= $end_time;
                    // echo "UPDATE `exam_contest` SET `status`= 1 WHERE id = '$contest_id'";die;

                    $contest_id = $data['id'];
                    $user_id = $userData['ID'];

                    $qq = mysqli_query($db->con, "SELECT * FROM `quiz_play_detail` WHERE exam_id = '$contest_id' and user_id = $user_id");
                    $contest_play = mysqli_num_rows($qq) == 0;
                    ?>

                    <div class="col-lg-3 col-md-4 col-12 p-0 mt-3 mb-3">
                        <div class="card text-white bg-white timecomplete<?php echo $contest_id; ?>" style="max-width: 100%; height: 100%;">
                            <!-- <div class="card-header">Header</div> -->

                            <div class="card-body examContestTime <?php echo ($start_quiz) ? $contest_play ? 'exam_contest' : 'view_rank' : ''; ?>" contest-id="<?php echo $data['id']; ?>" user-id="<?php echo $user_id; ?>">
                                <div class="col-12">
                                    <div class="row">

                                        <p class="card-text text-secondary cardp"><?php echo $category_name; ?> Exam Contest</p>


                                        <p class="card-text ml-auto text-secondary cardp">#<?php echo $data['id']; ?></p>
                                    </div>
                                    <?php
                                    if ($contest_play) {
                                        if ($start_quiz) {
                                            ?>
                                            <div class="row">
                                                <p class="text-success startText"></p>
                                                <!--<p class="text-danger ml-auto showendtym"></p>/-->
                                            </div>

                                            <div class="row">
                                                <p class="text-success showupcom"></p>
                                             <!--<p class="text-success ml-auto showstarttym"></p>-->
                                            </div>
                                            <?php
                                        } else {
                                            ?>
                                            <div class="row">
                                                <p class="text-success showupcom"></p>


                                                                                                                                                                                                            <!--<p class="text-success ml-auto" id="showstarttime"></p>-->
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <p class="text-secondary"><b>Contest Already Played!</b></p>
                                        <?php
                                    }
                                    ?>


                                    <div class="row">  
                                        <p class="card-text text-secondary"><?php echo $data['contest_name']; ?></p>

                                        <p class="card-text text-white ml-auto"><span class="cardspan">&#8377;<?php echo $data['amount']; ?></span></p>
                                    </div>


                                 
                                        <?php
//                                        $total_mem = 10;
                                        $prog = mysqli_query($db->con, "SELECT count(id) as count FROM `quiz_play_detail` where exam_id = '$contest_id'");
                                        $count = mysqli_fetch_array($prog);
//                                    
                                        ?>
                                    
                                    <div>
                                        <p class="text-primary cardp"><b><?php echo $count['count']; ?> Time Played</b></p>
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </div> 
                    <?php
                }
            } else {
                ?>
                <div class="card bg-light mb-3 mt-5" style="max-width: 100%;">
                    <h5 class="card-header text-center">No Contest Available!</h5>
                </div>
            </div>
            <?php
        }
        ?></div>
    <!-- </table> -->

</div>

<?php
require_once('include/quiz_footer.php');
?>  


<script type="text/javascript">
    $(document).ready(function ()
    {
        $('body').on('click', '.exam_contest', function () //$('.quiz_entry').click(function ()
        {
            var ele = $(this);
            var contest_id = ele.attr('contest-id');
            var user_id = ele.attr('user-id');
            $.confirm({
                title: 'Are you Sure Want Play Quiz?',
                content: '<span class="text-danger">Note: </span><small>If not any opponent then your amount will be refund.</small><br><span class="text-danger">Note: </span><small>Winning amount depends on number of participants.</small>',
                buttons: {
                    yes: function () {
//                            after confirm
                        var d = new Date();
                        var curnt_time = d.getTime();
//                         console.log(n);
//                        console.log(contest_id);
                        // alert(user_id);         

                        $.ajax({
                            type: "post",
                            url: "controller/ajaxcontroller.php",
                            data: {contest_id: contest_id, user_id: user_id, curnt_time: curnt_time, req_type: "exam_contest_play"},
                            success: function (data) {
                                var obj = jQuery.parseJSON(data);
//                                alert(obj.data);
                                if (obj.data == 0)
                                {
                                    $.alert('Not Enough Coins!');

                                } else if (obj.data == 1)
                                {
                                    window.location = "exam_contest_start.php?contest_id=" + contest_id;

                                } else if (obj.data == 2)
                                {
                                    $.alert('Maximum Players Reached!!');
//                                            ele.find(".card").remove();
                                } else if (obj.data == 3)
                                {
                                    $.alert('Contest Already played!');
//                                            ele.find(".card").remove();
                                }

//                                window.open("user_start_quiz.php?contest_id=" + contest_id,'newwindow');
                            }
                        });


                    },
                    no: function () {

                    }

                }
            });

        });

    });
</script>


<!--************check the time of contest**************--> 
<script type="text/javascript">
    $(document).ready(function ()
    {
        var quizstatus = [];
        setInterval(function () {
            $('.examContestTime').each(function () {
                var ele = $(this);
                var contest_id = ele.attr("contest-id");
                if (typeof quizstatus[contest_id] == 'undefined')
                    quizstatus[contest_id] = true;
                if (typeof quizstatus[contest_id] != 'undefined' && quizstatus[contest_id]) {
                    quizstatus[contest_id] = false;
                    $.ajax({
                        type: "post",
                        url: "controller/ajaxcontroller.php",
                        data: {contest_id: contest_id, req_type: "examContestTime"},
                        success: function (response) {
//                                    console.log("data--" + response);
                            var obj = jQuery.parseJSON(response);
                            var data = obj.data;

                            console.log(data);
                            if (data == 0)
                            {
                                var remainToStart = obj.start_time;
                                ele.find(".showupcom").text("Upcoming!");
                                ele.find(".showstarttym").text("Start After " + remainToStart);


                            } else if (data == 1)
                            {
                                ele.find(".showupcom").hide();
                                ele.find(".showstarttym").hide();
                                var remainToEnd = obj.end_time;
                                ele.addClass("exam_contest");
                                ele.find(".startText").text("Play Now!");
                                ele.find(".showendtym").text("Ends After " + remainToEnd);
                            } else if (data == 2) {
                                console.log(".timecomplete" + contest_id);
                                $(".timecomplete" + contest_id).hide();
                            }

                        },
                        error: function (err) {
                            console.log(err);
                        },
                        complete: function (data) {
                            quizstatus[contest_id] = true;
                        }
                    });
                }
            });
        }, 1000);

    });
</script>

<!--**************directly redirect the user to contest scores*************--> 
<script>
    $(document).ready(function ()
    {
        $('.view_rank').click(function ()
        {
            var ele = $(this);
            var contest_id = ele.attr('contest-id');
//                    window.location = ;
            window.location = "exam_contest_score.php?contest_id=" + contest_id;
        });
    });
</script>

