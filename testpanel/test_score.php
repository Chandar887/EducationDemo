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
if (isset($_SESSION['test_id'])) {
    $test_id = $_SESSION['test_id'];
//    echo $test_id;
} else if (isset($_GET['test_id'])) {
    $test_id = $_GET['test_id'];
}
else {
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
    exit;
}
?>
<div class="container">

    <div class="col-lg-6 col-md-4 col-12 mt-2 p-0">
        <h4 class="py-2 text-center">View Your Rank</h4>

        <button type="button" id="myresult" class="btn btn-sm btn-primary float-right my-2">My Result</button>

        <!--***********get user question answers********************-->
        <?php
        $user_id = $userData['ID'];
        $d = mysqli_query($db->con, "SELECT * FROM `quiz_play_detail` where user_id = '$user_id' && test_id = '$test_id'");

        if (mysqli_num_rows($d) > 0) {
            $dt = mysqli_fetch_assoc($d);
            $json = $dt['answer'];
            $jsondecoded = json_decode($json);
//                    echo "<pre>";
//                    print_r($jsondecoded);die;
            if ($jsondecoded != "") {
                foreach ($jsondecoded as $key => $data) {

                    $result = $db->selectQuery("SELECT * FROM `test_questions` WHERE ID = '$key'");
//                            echo "<pre>";
//                            print_r($result);die;

                    $realAns = $result[0]['answer'];
//                                echo $realAns;die;
                    $json = $result[0]['suggestions'];
                    $contestqueDt = json_decode($json);
                    ?>
                    <div class="col-lg-4 col-md-4 col-sm-12 mt-3 showresult" style="display: none; clear:both;">

                        <div class="card mt-3" style="max-width: 100%; height: auto;">
                            <h5 class="card-header <?php echo ($realAns == $data) ? 'bg-success' : 'bg-danger'; ?>" style="color: white;">
                                <?php echo $result[0]['questions']; ?>
                            </h5> 
                            <ul class="list-group list-group-flushs">
                              <?php
                                if(filter_var($result[0]['que_image'], FILTER_VALIDATE_URL)){
                                  ?>
                                <li class="list-group-item"><label><img src="<?php echo $result[0]['que_image']; ?>" style="width:100px;"></label>
                                </li>
                                <?php
                                }
                              ?>
                                <li class="list-group-item"><label class="<?php echo ($realAns == "A") ? "text-success" : "text-muted"; ?> "><?php echo $data == "A" ? '<i class="fa fa-check-circle"></i>' : '<i class="fa fa-circle"></i>'; ?> <?php echo $contestqueDt->A; ?></label>
                                </li>

                                <li class="list-group-item"><label class="<?php echo ($realAns == "B") ? "text-success" : "text-muted"; ?> "><?php echo $data == "B" ? '<i class="fa fa-check-circle"></i>' : '<i class="fa fa-circle"></i>'; ?> <?php echo $contestqueDt->B; ?></label></li>

                                <li class="list-group-item"><label class="<?php echo ($realAns == "C") ? "text-success" : "text-muted"; ?> "><?php echo $data == "C" ? '<i class="fa fa-check-circle"></i>' : '<i class="fa fa-circle"></i>'; ?> <?php echo $contestqueDt->C; ?></label></li>

                                <li class="list-group-item"><label class="<?php echo ($realAns == "D") ? "text-success" : "text-muted"; ?> "><?php echo $data == "D" ? '<i class="fa fa-check-circle"></i>' : '<i class="fa fa-circle"></i>'; ?> <?php echo $contestqueDt->D; ?></label></li>
                            </ul>
                        </div>
                    </div>
                    <?php
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
            $rankqqq = mysqli_query($db->con, "SELECT * FROM `quiz_play_detail` WHERE test_id = '$test_id' ORDER BY score DESC,complete_time ASC");
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

if (isset($_SESSION['test_id'])) {
    unset($_SESSION['test_id']);
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

