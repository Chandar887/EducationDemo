<?php
require_once('include/quiz_header.php');

$user_id = $userData['ID'];

//$quiz_query = mysqli_query($db->con, "SELECT quiz_id FROM `quiz_play` WHERE user_id = '$user_id'");
//$all_quiz = array();
//while ($quiz_data = mysqli_fetch_array($quiz_query)) {
//    $all_quiz[] = $quiz_data['quiz_id'];
//}
?>
<style type="text/css">
    .table.table-hover>tbody>tr>td, .table.table-hover>tbody>tr>th, .table.table-hover>tfoot>tr>td, .table.table-hover>tfoot>tr>th, .table.table-hover>thead>tr>td, .table.table-hover>thead>tr>th {
        border-top: 1px solid #F5F5F5;
        font-size: 14px;
        color: black;
        padding: 15px 15px;
    }

</style>
<div class="container">
    <!--<div class="col-md-4 col-12">-->
    <div class="rounded mt-3" style="border-left: 10px solid #007bff; background-color: #b4b5b545;">
        <h5 class="text-center my-auto p-1"><b>View Quiz History</b></h5>
    </div>

    <!--//        $quiz_q = mysqli_query($db->con, "SELECT * FROM `quiz_play_detail` where user_id = '$user_id' ORDER BY id DESC");
    //        if (mysqli_num_rows($quiz_q) > 0) {
                ?>-->



    <!--</div>-->

    <?php
//        $all_quiz_ids = " WHERE id =" . implode(' or id =', $all_quiz);
//        $quiz_q = mysqli_query($db->con, "SELECT id,quize_name,category_id from quiz $all_quiz_ids");
//        echo "SELECT * FROM `quiz_score` where user_id = '$user_id' ORDER BY id DESC";
    $quiz_q = mysqli_query($db->con, "SELECT * FROM `quiz_play_detail` where user_id = '$user_id' ORDER BY id DESC");
    if (mysqli_num_rows($quiz_q) > 0) {

        while ($quiz_data = mysqli_fetch_array($quiz_q)) {
            if ($quiz_data['contest_id'] != "") {
                $contest_ids = $quiz_data['contest_id'];
                $quiz_score = $quiz_data['score'];

                $quiz_query = mysqli_query($db->con, "SELECT * from quiz_contest where id = '$contest_ids'");
//            $quiz_query = mysqli_query($db->con, "SELECT * from exam_contest where id = '$contest_ids'");
                $quiz_qdata = mysqli_fetch_array($quiz_query);
                $quiz_name = $quiz_qdata['contest_name'];
                $contest_id = $quiz_qdata['id'];
                ?>
                <div class="card text-white bg-white mt-3" style="max-width: 100%; height: 100%;">
                    <!-- <div class="card-header">Header</div> -->

                    <div class="card-body view_rank" contest-id="<?php echo $contest_ids; ?>">
                        <div class="col-12">
                            <div class="row">

                                <p class="card-text text-secondary cardp"><?php echo $quiz_qdata['total_member']; ?> Player Battle</p>


                                <p class="card-text ml-auto text-secondary cardp"><?php echo $quiz_qdata['id']; ?></p>
                            </div>

                            <div class="row">  

                                <?php
                                $total_amount = $quiz_qdata['winning_amount'];

                                $adminCharge = 20;
                                $profit_percent_fr = 30;
                                $profit_percent_sp = 20;
//                            if ($ttdata = $db->selectRow("w_settings", "value", "name='adminCharge'")) {
//                                $adminCharge = $ttdata['value'];
//                            }

                                $admin_charge = ($adminCharge / 100) * $total_amount;

                                $win_amount = $total_amount - $admin_charge;
                                ?>
                                <p class="card-text text-dark"><b>&#8377; <?php echo $win_amount; ?></b></p>

                                <p class="card-text text-white ml-auto"><span class="cardspan">&#8377;<?php echo $quiz_qdata['amount']; ?></span></p>
                            </div>

                            <div class="progress">
                                <?php
                                $total_mem = $quiz_qdata['total_member'];
                                $prog = mysqli_query($db->con, "SELECT count(id) as count FROM `quiz_play_detail` where contest_id = '$contest_id'");
                                $count = mysqli_fetch_array($prog);
                                $val = 100 / $total_mem;
                                $cunt = $val * $count['count'];

                                $spots = $total_mem - $count['count'];
                                ?>
                                <div class="progress-bar progress-bar-striped bg-primary card-text" role="progressbar" style="width: <?php echo $cunt; ?>%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <div>
                                <p class="text-primary cardp"><b><?php echo $count['count']; ?> Time Played</b></p>
                            </div>       


                        </div>
                    </div>

                    <div class="card-footer card-footer bg-seondary text-dark d-flex justify-content-between">

                        <span class="card-text cardp"><i class="fa fa-trophy"></i> &#8377;<?php echo $quiz_qdata['winning_amount']; ?></span>



                        <span class="card-text cardp"><i class="fa fa-question"></i> <?php echo $quiz_qdata['no_of_que']; ?> Questions </span>

                        <span class="card-text cardp"><i class="fa fa-ticket"></i> <?php echo $spots; ?> spots</span>

                    </div>
                </div>

                <?php
            }
        }
    } else {
        ?>
        <div class="mt-3">
            <div class="alert alert-danger text-center">
                <p class="alert alert-danger text-center">No Contest Played Yet!</p>
            </div>
        </div>

    <?php }
    ?>

</div>
</div>


<?php
require_once('include/quiz_footer.php');
?>


<script>
    $(document).ready(function ()
    {
        $('.view_rank').click(function ()
        {
            var ele = $(this);
            var contest_id = ele.attr('contest-id');
            window.location = "user_quiz_score.php?contest_id=" + contest_id;
        });
    });
</script>