<?php
include_once("include/quiz_header.php");
//echo $user_id = $userData['ID'];die;
//   if(isset($_SESSION['stop_back']))
//    {
//       echo "<script type='text/javascript'> document.location = 'user_start_quiz.php'; </script>";
//        exit;
//    }
?>

<style type="text/css"> 
    .table.table-hover>thead>tr>td, .table.table-hover>thead>tr>th {
        border-top: 1px solid #F5F5F5;
        font-size: 14px;
        color: black;
        padding: 15px 15px;
    }

    .table.table-hover>tbody>tr>td, .table.table-hover>tbody>tr>td {
        border-top: 1px solid #F5F5F5;
        font-size: 14px;
        color: black;
        padding: 15px 15px; 
    }

    .tb_content {
        display: none; /* Hide all elements by default */
    }

    .show {
        display: block;
    }

</style>

<!--<div class="container">-->

<section>

    <div id="demo" class="carousel slide" data-ride="carousel">

        <!--Indicators--> 
        <ul class="carousel-indicators">
            <li data-target="#demo" data-slide-to="0" class="active"></li>
            <li data-target="#demo" data-slide-to="1"></li>
            <li data-target="#demo" data-slide-to="2"></li>
        </ul>

        <!--The slideshow--> 
        <div class="carousel-inner">
            <?php
            $data = $db->selectQuery("select * from w_slider_images where type = 'quizpanel'");

            foreach ($data as $slider) {
                ?>
                <div class="carousel-item active">
                    <img src="<?php echo $db->site . "/EducationDemo/" . $slider['img1']; ?>" class="banner_img">
                </div>
                <div class="carousel-item">
                    <img src="<?php echo $db->site . "/EducationDemo/" . $slider['img2']; ?>" class="banner_img">
                </div>
                <?php if ($slider['img3'] != "") {
                    ?>
                    <div class="carousel-item ">
                        <img src="<?php echo $db->site . "/EducationDemo/" . $slider['img3']; ?>" class="banner_img">
                    </div>
                    <?php
                }
                if ($slider['img4'] != "") {
                    ?>
                    <div class="carousel-item ">
                        <img src="<?php echo $db->site . "/EducationDemo/" . $slider['img4']; ?>" class="banner_img">
                    </div>
                    <?php
                }
            }
            ?>

        </div>

    </div>
</section>




<!--</div>-->

<!-- view all contests -->

<?php
if (isset($_SESSION["ludouser"])) {

    $user_id = $_SESSION["ludouser"]["ID"];
}
$q = "SELECT * FROM `quiz_category` order by id DESC";
$result = mysqli_query($db->con, $q);
if (mysqli_num_rows($result) > 0) {

//    $quiz_back = array(
//        'img/quiz_back1.jpg',
//        'img/quiz_back2.jpg',
//        'img/quiz_back4.jpg',
//        'img/quiz_back5.jpg',
////        'img/quiz_back6.jpg',
//        'img/quiz_back7.jpg',
//        'img/quiz_back8.jpg',
//        'img/quiz_back9.jpg',
//        'img/quiz_back10.jpg',
//        'img/quiz_back11.jpg',
//        'img/quiz_back12.jpg',
//        'img/quiz_back13.jpg',
//        'img/quiz_back14.jpg',
//        'img/quiz_back15.jpg',
//        'img/quiz_back111.jpg',
//        'img/quiz_back222.jpg',
//        'img/quiz_back333.jpg',
//        'img/quiz_back444.jpg',
//        'img/quiz_back555.jpg',
//        'img/quiz_back666.jpg',
//        'img/quiz_back777.jpg'
//    );
    ?>

    <!--    <div class="container">
            <h6 class="mb-1 mt-1">Exam Quiz Contest</h6>
            <div class="scrolling-wrapper row flex-row flex-nowrap">
    <?php
    $x = 0;
    while ($data = mysqli_fetch_assoc($result)) {
        ?>
                        <div class="p-1">

                            <div class="card categorytype" cat-name="<?php echo $data['category_name']; ?>" style="background:url(<?php echo $data['cat_image']; ?>); height: 27vw; border-radius: 15px; border: none; background-size:cover;">
                                <div class="overlay"><h6 class="text-white text-center" style="line-height: 25vw;"><?php echo $data['category_name']; ?></h6></div>
                            </div>  


                        </div>
        <?php
        $x++;
    }
}
?>
    </div>
</div>-->


<!--
<section class="mb-2 mt-2">

    <div>
        <img src="img/NEW.png" class="banner_img">
    </div>

</section>-->


<!-- all quiz contests -->
<section>
    <div class="container-fluid">


        <?php
//        $currrtime = date("Y-m-d H:i:s");
//        DATE_FORMAT(play_time, '%Y-%m-%d') = DATE(NOW()) AND
        $query = "SELECT * FROM `quiz_contest` WHERE (status = 0 or status = 1) AND checked = 0 order by id DESC";
        $quizq = mysqli_query($db->con, $query);


        if (mysqli_num_rows($quizq) > 0) {
            ?>
            <!--show contests according to dates-->
            <section>
                <div>
                    <h6 class="mb-1 mt-1">All Contests</h6>

                </div>
                <ul class="navbar navbar-expand-lg navbar-light bg-light pl-0" id="tabs_nav">
                    <li class=" ml-0"><button class="btn tabs pr-3 pl-3 pt-1 pb-1 bordr active" href="#" onclick="filterSelection('showall')"><b>All</b></button></li>
                    <li><button class="btn tabs pr-3 pl-3 pt-1 pb-1 bordr " href="#" onclick="filterSelection('daily')"><b>Daily</b></button></li>
                    <li><button class="btn tabs pr-3 pl-3 pt-1 pb-1 bordr" href="#" onclick="filterSelection('weekly')"><b>Weekly</b></button></li>
                    <li><button class="btn tabs pr-3 pl-3 pt-1 pb-1 bordr" href="#" onclick="filterSelection('monthly')"><b>Monthly</b></button></li>

                </ul>
            </section>

            <!--show contests according to dates section end-->
            <?php
            $x = 0;

            while ($data = mysqli_fetch_assoc($quizq)) {
//                echo "<pre>";
//                print_r($data);die;
                
                $cur = date("Y-m-d H:i:s");
                $currrtime = strtotime($cur);
                $ee = $data['play_time'];
                $start_time = strtotime($ee);
                $end = $data['end_time'];
                $end_time = strtotime($end);
                $contest_id = $data['id'];

//                get upcoming time 
//                $upcoming_time = $start_time - $currrtime;
//                $startquiz_time = $end_time - $currrtime;


                $total_mem = $data['total_member'];

                $chekq = mysqli_query($db->con, "select * from `quiz_play_detail` where contest_id = '$contest_id'");
                if (mysqli_num_rows($chekq) >= $total_mem) {
                    $updqq = mysqli_query($db->con, "UPDATE `quiz_contest` SET `status` = 2 WHERE id = '$contest_id'");
                }

                if ($currrtime >= $end_time) {
                    $updq = mysqli_query($db->con, "UPDATE `quiz_contest` SET `status` = 2 WHERE id = '$contest_id'");

                    $handle = curl_init();
// 
                    $url = $db->site . "quizpanel/cron.php";
                    curl_setopt($handle, CURLOPT_URL, $url);
                    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
//            curl_exec($handle);
                    $output = curl_exec($handle);
                    curl_close($handle);
                }



                $x++;
                $cat_q = mysqli_query($db->con, "SELECT * FROM `quiz_category`");
                $cat_dt = mysqli_fetch_assoc($cat_q);

//                $start_time = $data['play_time'];
//
//                $end_time = $data['end_time'];
//                $currrtime = date("h:i A");

                $start_quiz = $currrtime >= $start_time && $currrtime <= $end_time;

                $contest_id = $data['id'];
                $user_id = $userData['ID'];


//                echo "SELECT count(id) as counter FROM `quiz_play_detail` WHERE contest_id = '$contest_id' and user_id = $user_id";die;
                $qq = mysqli_query($db->con, "SELECT * FROM `quiz_play_detail` WHERE contest_id = '$contest_id' and user_id = $user_id");
                $contest_play = mysqli_num_rows($qq) == 0;
                ?>

                <div class="col-lg-3 col-md-4 col-12 mt-2 p-0 tb_content <?php echo $data['type']; ?>">
                    <div class="card text-white bg-white mb-2" style="max-width: 100%; height: 100%;">
                        <!-- <div class="card-header">Header</div> -->
                        <div class="card-body checktime <?php echo ($start_quiz) ? $contest_play ? 'quiz_entry' : 'view_rank' : ''; ?>" contest-id="<?php echo $data['id']; ?>" user-id="<?php echo $user_id; ?>">
                            <div class="col-12">
                                <div class="row">

                                    <p class="card-text text-secondary cardp"><?php echo $data['total_member']; ?> Player Battle</p>


                                    <p class="card-text ml-auto text-secondary cardp"><?php echo $data['id']; ?></p>
                                </div>
                                <?php
                                $contest_id = $data['id'];
                                $user_id = $userData['ID'];

                                $qq = mysqli_query($db->con, "SELECT * FROM `quiz_play_detail` WHERE contest_id = '$contest_id' and user_id = $user_id");
                                if ($contest_play) {
                                    if ($start_quiz) {
                                        $total_mem = $data['total_member'];

                                        $chekq = mysqli_query($db->con, "select * from `quiz_play_detail` where contest_id = '$contest_id'");
                                        if (mysqli_num_rows($chekq) >= $total_mem) {
                                            $updqq = mysqli_query($db->con, "UPDATE `quiz_contest` SET `status` = 2 WHERE id = '$contest_id'");
                                        }
                                        ?>
                                        <div class="row">

                                            <p class="text-success startText"></p>



                                                                                                            <!--<p class="text-danger ml-auto showendtym"></p>-->
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
                                    <p class="text-danger"><b>Contest Already Played!</b></p>
                                    <?php
                                }
                                ?>


                                <div class="row">
                                    <?php
                                    $total_amount = $data['winning_amount'];

                                    $adminCharge = 20;
                                    $profit_percent_fr = 30;
                                    $profit_percent_sp = 20;
//                                    if ($ttdata = $db->selectRow("w_settings", "value", "name='adminCharge'")) {
//                                        $adminCharge = $ttdata['value'];
//                                    }

                                    $admin_charge = ($adminCharge / 100) * $total_amount;

                                    $win_amount = $total_amount - $admin_charge;
                                    ?>
                                    <p class="card-text text-dark"><b>&#8377; <?php echo $win_amount; ?></b></p>

                                    <p class="card-text text-white ml-auto"><span class="cardspan">&#8377; <?php echo $data['amount']; ?></span></p>
                                </div>

                                <div class="progress">
                                    <?php
                                    $total_mem = $data['total_member'];
                                    $prog = mysqli_query($db->con, "SELECT count(id) as count FROM `quiz_play_detail` where contest_id = '$contest_id'");
                                    $count = mysqli_fetch_array($prog);
                                    $val = 100 / $total_mem;

                                    $cunt = $val * $count['count'];

                                    $spots = $total_mem - $count['count'];
                                    ?>
                                    <div class="progress-bar progress-bar-striped bg-primary card-text" role="progressbar" style="width: <?php echo $cunt; ?>%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div>
                                    <p class="text-primary cardp"><b><?php echo $count['count']; ?> Time Played</b></p>
                                </div>  


                            </div>
                        </div>

                        <div class="card-footer card-footer bg-seondary text-dark d-flex justify-content-between">

                            <span class="card-text cardp"><i class="fa fa-trophy"></i> &#8377;<?php echo $win_amount; ?></span>



                            <span class="card-text cardp"><i class="fa fa-question"></i> <?php echo $data['no_of_que']; ?> Questions </span>

                            <span class="card-text cardp"><i class="fa fa-ticket"></i> <?php echo $spots; ?> spots</span>

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
            <?php
        }
        ?>

    </div>
</section>
<?php
include_once('include/quiz_footer.php');
?>

<script type="text/javascript">
    $(document).ready(function ()
    {
        $('body').on('click', '.quiz_entry', function ()
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


//                                console.log(contest_id);
                        // alert(user_id);         

                        $.ajax({
                            type: "post",
                            url: "controller/ajaxcontroller.php",
                            data: {contest_id: contest_id, user_id: user_id, curnt_time: curnt_time, req_type: "quiz_play_detail"},
                            success: function (data) {
                                var obj = jQuery.parseJSON(data);
//                                alert(obj.data);
//                                        console.log(obj.data);
                                if (obj.data == 0)
                                {
                                    $.alert('Not Enough Coins!');

                                } else if (obj.data == 1)
                                {
                                    window.location = "user_start_quiz.php?contest_id=" + contest_id;

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



<script>
    $(document).ready(function ()
    {
        var quizstatus = [];
        setInterval(function () {
            $('.checktime').each(function () {
                var ele = $(this);
                var contest_id = ele.attr("contest-id");
                var user_id = ele.attr("user-id");
//                        var upcomingtime = ele.attr("upcomingtime");
//                        console.log(upcomingtime);
//                        var upgradeTime = upcomingtime;
//                        var seconds = upgradeTime;

//                        upcoming timer function
//                        function timer() {
//                            var days = Math.floor(seconds / 24 / 60 / 60);
//                            var hoursLeft = Math.floor((seconds) - (days * 86400));
//                            var hours = Math.floor(hoursLeft / 3600);
//                            var minutesLeft = Math.floor((hoursLeft) - (hours * 3600));
//                            var minutes = Math.floor(minutesLeft / 60);
//                            var remainingSeconds = seconds % 60;
//                            function pad(n) {
//                                return (n < 10 ? "0" + n : n);
//                            }
//                            document.getElementById('showstarttime').innerHTML = pad(days) + ":" + pad(hours) + ":" + pad(minutes) + ":" + pad(remainingSeconds);
//                            if (seconds == 0) {
//                                clearInterval(countdownTimer);
//                                document.getElementById('showstarttime').innerHTML = "Completed!";
//                            } else {
//                                seconds--;
//                            }
//                        }
//                        var countdownTimer = setInterval(timer(), 1000);

                if (typeof quizstatus[contest_id] == 'undefined')
                    quizstatus[contest_id] = true;
                if (typeof quizstatus[contest_id] != 'undefined' && quizstatus[contest_id]) {
                    quizstatus[contest_id] = false;
                    $.ajax({
                        type: "post",
                        url: "controller/ajaxcontroller.php",
                        data: {contest_id: contest_id, req_type: "checktimeofquiz"},
                        success: function (response) {
//                                    console.log("Upcoming_check--" + response);
                            var obj = jQuery.parseJSON(response);
                            var data = obj.data;

                            console.log(response);

//                                    console.log(remainToEnd);
                            if (data == 0)
                            {
                                var remainToStart = obj.start_time;
                                ele.find(".showupcom").text("Upcoming!");
//                                        ele.find(".card-body":status).text("upcoming");
//                                        ele.find(".showstarttym").text("Start After " + remainToStart);


                            } else
                            {
                                ele.find(".showupcom").hide();
                                ele.find(".showstarttym").hide();

                                var remainToEnd = obj.end_time;
                                ele.addClass("quiz_entry");
                                ele.find(".startText").text("Play Now!");
//                                        ele.find(".card-body":status).text("playnow");
                                ele.find(".showendtym").text("Ends After " + remainToEnd);
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
        }, 2000);

    });
</script>


<script>
    $(document).ready(function ()
    {
        $('.view_rank').click(function ()
        {
            var ele = $(this);
            var contest_id = ele.attr('contest-id');
//                    window.location = ;
            window.location = "user_quiz_score.php?contest_id=" + contest_id, 'newwindow';
        });


        $('.categorytype').click(function ()
        {
            var ele = $(this);
            var category_name = ele.attr('cat-name');
//                    window.location = ;
            window.location = "user_selected_quiz.php?category_name=" + category_name;
        });

    });
</script>


<?php
//        $currrtime = date("Y-m-d H:i:s");
//        DATE_FORMAT(play_time, '%Y-%m-%d') = DATE(NOW()) AND
$checkquery = "SELECT * FROM `edu_quiz_contest` WHERE (status = 0 or status = 1) AND checked = 0 order by id DESC";
$get_respose = mysqli_query($db->con, $query);


if (mysqli_num_rows($get_respose) > 0) {
    ?>

    <script>

        //                set tab system 
        filterSelection("showall")
        function filterSelection(c) {
            var x, i;
            x = document.getElementsByClassName("tb_content");
            if (c == "showall")
                c = "";
            for (i = 0; i < x.length; i++) {
                w3RemoveClass(x[i], "show");
                if (x[i].className.indexOf(c) > -1)
                    w3AddClass(x[i], "show");
            }
        }

        function w3AddClass(element, name) {
            var i, arr1, arr2;
            arr1 = element.className.split(" ");
            arr2 = name.split(" ");
            for (i = 0; i < arr2.length; i++) {
                if (arr1.indexOf(arr2[i]) == -1) {
                    element.className += " " + arr2[i];
                }
            }
        }

        function w3RemoveClass(element, name) {
            var i, arr1, arr2;
            arr1 = element.className.split(" ");
            arr2 = name.split(" ");
            for (i = 0; i < arr2.length; i++) {
                while (arr1.indexOf(arr2[i]) > -1) {
                    arr1.splice(arr1.indexOf(arr2[i]), 1);
                }
            }
            element.className = arr1.join(" ");
        }


        // Add active class to the current button (highlight it)
        var tabs_nav = document.getElementById("tabs_nav");
        var btns = tabs_nav.getElementsByClassName("btn");
        for (var i = 0; i < btns.length; i++) {
            btns[i].addEventListener("click", function () {
                var current = document.getElementsByClassName("active");
                current[0].className = current[0].className.replace(" active", "");
                this.className += " active";

            });
        }
    </script>
<?php } ?>
        

