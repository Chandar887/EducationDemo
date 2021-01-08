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
        <h5 class="text-center my-auto p-1"><b>View Test History</b></h5>
    </div>

    <div class="mt-5">
        <?php
        if ($history = $db->selectQuery("select * from quiz_play_detail where user_id = '$user_id' and test_id != ''")) {
            foreach ($history as $udata) {
//                echo "<pre>";
//                print_r($udata);die;
//                echo "select * from practice_test where ID = {$udata['test_id']}";die;
                $gettest = $db->selectQuery("select * from practice_test where ID = {$udata['test_id']}");
                $gettest = $gettest[0];
//            print_r($gettest);die;
                ?>

                <div class="col-xl-3 col-sm-6 col-12 mb-3 p-0 view_rank" test-id="<?php echo $gettest['ID']; ?>"> 
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <i class="fa fa-list-alt text-primary" style="font-size: 40px;"></i>
                                    </div>
                                    <div class="media-body text-right">
                                        <h4><?php echo $gettest['duration']; ?> Mins</h4>
                                        <span style="font-size: 14px;"><?php echo $gettest['test_title']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
            }
        } else {
            ?>
            <p class="alert alert-danger">No Test Quiz Played Yet!</p>
            <?php
        }
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
            var test_id = ele.attr('test-id');
            window.location = "test_score.php?test_id=" + test_id;
        });
    });
</script>