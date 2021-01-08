<?php
$title = "New Contest";
$apage = "newcontest";
include_once('header.php');

if (isset($_GET['update_id']) && $_GET['update_id'] != "") {
    $update_id = mysqli_real_escape_string($db->con, $_GET['update_id']);

    $updateq = mysqli_fetch_assoc(mysqli_query($db->con, "SELECT * FROM `quiz_contest` where id = '$update_id'"));
    $contest_name = $updateq['contest_name'];
    $category_id = $updateq['category_id'];
    $play_time = $updateq['play_time'];
    $quiz_time = $updateq['quiz_time'];
    $amount = $updateq['amount'];
    $total_member = $updateq['total_member'];
    $no_of_que = $updateq['no_of_que'];

    $q_catt = mysqli_fetch_assoc(mysqli_query($db->con, "SELECT * FROM `quiz_category` where id = '$category_id'"));
    $category_name = $q_catt['category_name'];
}
?>
<div class="container-fluid">
    <div class="row">

        <main role="main" class="col-md-12 pt-3">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">

                <h1 class="h2"><i class="fa fa-"></i>Add Quiz Contest</h1>



                <div class="btn-toolbar mb-2 mb-md-0">
                                 <a class="btn btn-primary ml-1" href="view_all_contest.php"><i class="fa fa-list pr-2"></i>Contest List</a> 
                </div>
            </div>
            
            
            <div class="col-12 col-md-8 mx-auto">
                <!--<a href="view_all_contest.php" class="btn btn-primary">View All Contest</a>-->
                
                <?php
                if (isset($_SESSION['err_msg'])) {
                    ?>
                    <h4 class="alert alert-danger"><?php echo $_SESSION['err_msg']; ?></h4>
                <?php }
                ?>
                <form class="border rounded p-4 submitform" action="controller/quiz_controller.php" method="post" enctype="multipart/form-data">


                    <p class="h4">Add New Contest</p>

                    <div class="form-group mb-2">
                        <label for="contest_name">Contest Name<span class="required">*</span></label>
                        <input type="text" id="mobile" name="contest_name" class="form-control U_mobileNumber" value="<?php
                        if (isset($update_id)) {
                            echo $contest_name;
                        } else {
                            echo '';
                        }
                        ?>" required>
                    </div>
<!--a href="add_quiz.php" class="float-right">Add New</a>-->
                    <div class="form-group mb-2">
                        <label for="category_id">Quiz Category<span class="required">*</span></label>	
                        <select class="form-control" name="category_name">
                            <option value="">Select Any One</option>
                            <?php
                            $q_cat = mysqli_query($db->con, "SELECT DISTINCT category_name FROM `contest_que`");

                            while ($result = mysqli_fetch_array($q_cat)) {
                                ?>
                                <option value="<?php echo $result['category_name']; ?>"><?php echo $result['category_name']; ?></option>
                                <?php
                            }
                            ?>

                        </select> 
                    </div>   



                    <div class="form-group mb-2">
                        <label for="Play Date">Play Datetime<span class="required">*</span></label>
                        <input type="datetime-local" name="play_time" class="form-control" value="<?php echo isset($update_id) ? $play_time : '' ?>" required="">
                    </div>

                    <div class="form-group mb-2">   
                        <label for="End Date">End Datetime<span class="required">*</span></label>
                        <input type="datetime-local" name="end_time" class="form-control" value="" required="">
                    </div>

                    <div class="form-group mb-2">   
                        <label for="type">Select Type<span class="required">*</span></label>
                        <select class="form-control" name="type" required="">
                            <option value="">Select Any One</option>
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>

                        </select>   
                    </div>

                    <div class="form-group mb-1">
                        <label for="Quiz Time">Total Duration(seconds)<span class="required">*</span></label>
                        <input type="number" name="quiz_time" class="form-control" value="<?php
                        if (isset($update_id)) {
                            echo $quiz_time;
                        } else {
                            echo '';
                        }
                        ?>"  required>	
                    </div>

                    <div class="form-group mb-2">	
                        <label for="join_amount">Join Amount<span class="required">*</span></label>
                        <input type="number" name="amount" class="form-control U_mobileNumber" value="<?php
                        if (isset($update_id)) {
                            echo $amount;
                        } else {
                            echo '';
                        }
                        ?>"  required>
                    </div>		

                    <div class="form-group mb-2">
                        <label for="Total_Member">Max Member<span class="required">*</span></label>
                        <input type="number" name="total_member" class="form-control" value="<?php
                        if (isset($update_id)) {
                            echo $total_member;
                        } else {
                            echo '';
                        }
                        ?>" required="">
                    </div>

                    <div class="form-group">
                        <label for="no_of_questions">No. of Questions<span class="required">*</span></label>
                        <input type="number" name="no_of_que" class="form-control" value="<?php
                        if (isset($update_id)) {
                            echo $no_of_que;
                        } else {
                            echo '';
                        }
                        ?>" required="">
                    </div>

                    <?php
                    if (isset($update_id)) {
                        ?>
                        <div class="form-group">
                            <input type="hidden" name="contest_id" class="form-control" value="<?php echo $update_id; ?>" required="">

                        </div>
                    <?php }
                    ?>

                    <div class="form-group">
                        <?php
                        if (isset($update_id)) {
                            ?>
                            <button type="submit" name="update" value="update_contest" class="btn btn-primary btn-block button_submit">Update</button>
                            <?php
                        } else {
                            ?>
                            <button type="submit" name="submit" value="add_contest" class="btn btn-primary btn-block button_submit">Submit</button>
                            <?php
                        }
                        ?>

                    </div>
                </form>
            </div>
        </main>

    </div>
</div>

<?php
include_once('footer.php');

if (isset($_SESSION['err_msg'])) {
    unset($_SESSION['err_msg']);
}
?>