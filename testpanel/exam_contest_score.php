<?php
require_once('include/quiz_header.php');
?>

<style>
    .table.table-hover>thead>tr>th {
        border-bottom: 0px solid #ddd;
        color: black;
    }

    .table.table-hover>tbody>tr>td, .table.table-hover>tbody>tr>th, .table.table-hover>tfoot>tr>td, .table.table-hover>tfoot>tr>th, .table.table-hover>thead>tr>td, .table.table-hover>thead>tr>th {
        border-top: 1px solid #F5F5F5;
        font-size: 14px;
        color: black;
        padding: 15px 15px;
    }
</style>


<?php
if (isset($_SESSION['contest_id'])) {
    $contest_id = $_SESSION['contest_id'];
} else if (isset($_GET['contest_id'])) {
    $contest_id = $_GET['contest_id'];
} else {
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
    exit;
}
?>
<div class="container">

    <div class="col-lg-6 col-md-4 col-12 mt-2 p-0">
        <h4 class="py-2 text-center">View Your Rank</h4>
        <?php
        if (isset($_GET['contest_id'])) {
            $contest_id = $_GET['contest_id'];

            $data = mysqli_fetch_assoc(mysqli_query($db->con, "SELECT * FROM `exam_contest` where id = '$contest_id'"));
            ?>
            <div class="card text-white bg-white" style="max-width: 100%; height: 100%;">
                <!-- <div class="card-header">Header</div> -->

                <div class="card-body">
                    <div class="col-12">
                        <div class="row">

                            <p class="card-text text-secondary cardp"><?php echo $data['category_name']; ?></p>


                            <p class="card-text ml-auto text-secondary cardp"><?php echo $data['id']; ?></p>
                        </div>

                        <div class="row">  


                            <p class="card-text text-dark"><?php echo $data['contest_name']; ?></p>

                            <p class="card-text text-white ml-auto"><span class="cardspan">&#8377;<?php echo $data['amount']; ?></span></p>
                        </div>

                        <div class="">
                            <?php
//                            $total_mem = 10;
                            $prog = mysqli_query($db->con, "SELECT count(id) as count FROM `quiz_play_detail` where exam_id = '$contest_id'");
                            $count = mysqli_fetch_array($prog);
//                            $val = 100 / $total_mem;
//                            $cunt = $val * $count['count'];
//                            $spots = $total_mem - $count['count'];
                            ?>
                            <!--<div class="progress-bar progress-bar-striped bg-primary card-text" role="progressbar" style="width: <?php echo $cunt; ?>%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>-->
                        </div>

                        <div>
                            <p class="text-primary cardp"><b><?php echo $count['count']; ?> Time Played</b></p>
                        </div>       


                    </div>
                </div>

            </div>

            <?php
            if ($data['checked'] == 1) {
                ?>

                <button type="button" id="myresult" class="btn btn-sm btn-primary float-right my-2">My Result</button>


                <!--***********get user question answers********************-->
                <?php
                $user_id = $userData['ID'];
                $d = mysqli_query($db->con, "SELECT * FROM `quiz_play_detail` where user_id = '$user_id' && exam_id = '$contest_id'");


                if (mysqli_num_rows($d) > 0) {


                    $dt = mysqli_fetch_assoc($d);
                    $json = $dt['answer'];
                    $jsondecoded = json_decode($json);

                    if ($jsondecoded != "") {

                        foreach ($jsondecoded as $key => $data) {

                            $q = "SELECT * FROM `contest_que` WHERE id = '$key'";
                            $result = mysqli_query($db->con, $q);


                            if (mysqli_num_rows($result) > 0) {

                                $josn = mysqli_fetch_assoc($result);
                                $realAns = $josn['answer'];
                                $json = $josn['suggestions'];
                                $contestqueDt = json_decode($json);



//                        $test = false;
                                ?>
                                <?php // echo"<br>x=$x ". ($x != 1 ? "d-none" : ""); ?>
                                <div class="col-lg-4 col-md-4 col-sm-12 mt-3 showresult" style="display:none; clear:both;">

                                    <div class="card mt-3" style="max-width: 100%; height: auto;">
                                        <h5 class="card-header <?php echo ($realAns == $data) ? 'bg-success' : 'bg-danger'; ?>" style="color: white;">
                                            <?php echo $josn['questions']; ?>
                                        </h5> 
                                        <ul class="list-group list-group-flushs">
                                            <?php
                                            if ($josn['que_image'] != "") {
                                                ?>
                                                <li class="list-group-item"><label>Question Image<br><img src='<?php echo $josn["que_image"]; ?>' style='height:100px!important;'></label>
                                                </li>
                                                <?php
                                            }
                                            ?>

                                            <li class="list-group-item"><label class="<?php echo ($realAns == "A") ? "text-success" : "text-muted"; ?> "><?php echo $data == "A" ? '<i class="fa fa-check-circle"></i>' : '<i class="fa fa-circle"></i>'; ?><?php
                                                    if (filter_var($contestqueDt['0'], FILTER_VALIDATE_URL)) {
                                                        echo "<img src='$contestqueDt[0]' style='height:100px!important;'>";
                                                    } else {
                                                        echo $contestqueDt['0'];
                                                    }
                                                    ?></label>
                                            </li>

                                            <li class="list-group-item"><label class="<?php echo ($realAns == "B") ? "text-success" : "text-muted"; ?> "><?php echo $data == "B" ? '<i class="fa fa-check-circle"></i>' : '<i class="fa fa-circle"></i>'; ?> <?php
                                                    if (filter_var($contestqueDt['1'], FILTER_VALIDATE_URL)) {
                                                        echo "<img src='$contestqueDt[1]' style='height:100px!important;'>";
                                                    } else {
                                                        echo $contestqueDt['1'];
                                                    }
                                                    ?></label></li>

                                            <li class="list-group-item"><label class="<?php echo ($realAns == "C") ? "text-success" : "text-muted"; ?> "><?php echo $data == "C" ? '<i class="fa fa-check-circle"></i>' : '<i class="fa fa-circle"></i>'; ?> <?php
                                                    if (filter_var($contestqueDt['2'], FILTER_VALIDATE_URL)) {
                                                        echo "<img src='$contestqueDt[2]' style='height:100px!important;'>";
                                                    } else {
                                                        echo $contestqueDt['2'];
                                                    }
                                                    ?></label></li>

                                            <li class="list-group-item"><label class="<?php echo ($realAns == "D") ? "text-success" : "text-muted"; ?> "><?php echo $data == "D" ? '<i class="fa fa-check-circle"></i>' : '<i class="fa fa-circle"></i>'; ?> <?php
                                                    if (filter_var($contestqueDt['3'], FILTER_VALIDATE_URL)) {
                                                        echo "<img src='$contestqueDt[3]' style='height:100px!important;'>";
                                                    } else {
                                                        echo $contestqueDt['3'];
                                                    }
                                                    ?></label></li>
                                        </ul>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    } else {
                        ?>
                        <div class="col-12 mt-5 show_err" style="display:none;">
                            <div class="alert alert-danger">
                                Not attempted any question!.
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="m-4 p-5">
                        <div class="alert alert-danger">
                            <strong>Missing!</strong> Record not Found.
                        </div>
                    </div>
                    <?php
                }
            }
        }
        ?>



        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Name</th>

                </tr>
            </thead>

            <?php
            $x = 0;
            $rankqqq = mysqli_query($db->con, "SELECT * FROM `quiz_play_detail` WHERE exam_id = '$contest_id' ORDER BY score DESC,complete_time ASC");
            while ($rnkdt = mysqli_fetch_assoc($rankqqq)) {
                $user_id = $rnkdt['user_id'];
                $x++;
                ?>
                <tbody>
                    <tr>
                        <td><?php echo $x; ?></td>
                        <?php
                        $usrq = mysqli_fetch_assoc(mysqli_query($db->con, "SELECT * FROM `w_users` where ID = '$user_id'"));
                        ?>
                        <td><?php echo $usrq['uName']; ?>&nbsp;&nbsp; <?php echo $userData['ID'] == $user_id ? '<i class="fa fa-star text-primary" aria-hidden="true"></i>' : ''; ?></td>

                    </tr>
                </tbody>
                <?php
            }
            ?>


        </table>
    </div>

</div>




<?php
require_once('include/quiz_footer.php');

if (isset($_SESSION['contest_id'])) {
    unset($_SESSION['contest_id']);
//    unset($_SESSION['quiz_success']);
}
?>   


<script type="text/javascript">

    $(document).ready(function () {
        $('#myresult').click(function ()
        {
            $('.showresult').toggle(1000);
            $('.show_err').toggle(1000);
        });

    });

</script>


<!-- <script>
  $(document).ready(function()
  {
    $('#check').
  });
</script>
-->


