<?php
$title = "New Exam contest";
$apage = "addexamcontest";
include_once('header.php');

if (isset($_GET['update_examcon']) && $_GET['update_examcon'] != "") {
    $update_id = mysqli_real_escape_string($db->con, $_GET['update_examcon']);

    $updateDt = $db->selectQuery("SELECT * FROM `exam_contest` where id = '$update_id'");
}
?>
<div class="container-fluid">
    <div class="row">

        <main role="main" class="col-md-12 pt-3">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">

                <h1 class="h2"><i class="fa fa-"></i><?php echo isset($update_id) ? 'Update' : 'Add'; ?> Exam Contest</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a class="btn btn-primary ml-1" href="view_exam_contest.php"><i class="fa fa-list pr-2"></i>Exams List</a> 
                </div>
            </div>
            <?php
            if (!isset($update_id)) {
                ?>
                <a href="add_exam_cat.php" class="btn btn-primary my-2">Add New Category</a>
                <?php
            }
            ?>

            <div class="col-12 col-md-8 mx-auto">

                <?php
                if (isset($_SESSION['cat_added'])) {
                    ?>
                    <p class="alert alert-success"><?php echo $_SESSION['cat_added']; ?></p>
                    <?php
                }
                ?>

                <form class="border rounded p-4 submitform" action="controller/quiz_controller.php" method="post" enctype="multipart/form-data">


                    <p class="h4">Add New Contest</p>

                    <div class="form-group mb-2">
                        <label for="contest_name">Contest Title<span class="required">*</span></label>
                        <input type="text" name="contest_name" class="form-control U_mobileNumber" value="<?php echo isset($update_id) && $updateDt[0]['contest_name'] != '' ? $updateDt[0]['contest_name'] : ''; ?>" required>
                    </div>
                    <!--a href="add_quiz.php" class="float-right">Add New</a>-->
                    <div class="form-group mb-2">
                        <label for="category_id">Exam Category<span class="required">*</span></label>	
                        <select class="form-control" name="category_name">

                            <option value="">Select Any One</option>
                            <?php
                            $q_cat = mysqli_query($db->con, "SELECT DISTINCT category_name FROM `quiz_category`");

                            while ($result = mysqli_fetch_array($q_cat)) {
                                ?>
                                <option value="<?php echo $result['category_name']; ?>" <?php echo isset($update_id) && $updateDt[0]['category_name'] == $result['category_name'] ? 'selected' : ''; ?>><?php echo $result['category_name']; ?></option>
                                <?php
                            }
                            ?>
                        </select> 
                    </div>   



                    <div class="form-group mb-2">
                        <label for="Play Date">Exam Start Time<span class="required">*</span></label>
                        <input type="datetime-local" name="play_time" class="form-control" value="<?php echo isset($update_id) && $updateDt[0]['play_time'] != '' ? $updateDt[0]['play_time'] : ''; ?>" required="">
                    </div>

                    <div class="form-group mb-2">   
                        <label for="End Date">Exam End Time<span class="required">*</span></label>
                        <input type="datetime-local" name="end_time" class="form-control" value="<?php echo isset($update_id) && $updateDt[0]['end_time'] != '' ? $updateDt[0]['end_time'] : ''; ?>" required="">
                    </div>


                    <div class="form-group mb-1">
                        <label for="Total Duration">Total Duration(seconds)<span class="required">*</span></label>
                        <input type="number" name="quiz_time" class="form-control" value="<?php echo isset($update_id) && $updateDt[0]['quiz_time'] != '' ? $updateDt[0]['quiz_time'] : ''; ?>"  required>	
                    </div>

                    <div class="form-group mb-2">	
                        <label for="join_amount">Join Amount<span class="required">*</span></label>
                        <input type="number" name="amount" class="form-control U_mobileNumber" value="<?php echo isset($update_id) && $updateDt[0]['amount'] != '' ? $updateDt[0]['amount'] : ''; ?>"  required>
                    </div>		

                    <?php
                    if (isset($update_id)) {
                        ?>
                        <div class="form-group">
                            <input type="hidden" name="id" class="form-control" value="<?php echo $update_id; ?>">

                        </div>
                    <?php }
                    ?>

                    <div class="form-group">
                        <?php
                        if (isset($update_id)) {
                            ?>
                            <button type="submit" name="update" value="update_exam_contest" class="btn btn-primary btn-block button_submit">Update</button>
                            <?php
                        } else {
                            ?>
                            <button type="submit" name="submit" value="add_exam_contest" class="btn btn-primary btn-block button_submit">Submit</button>
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
if (isset($_SESSION['cat_added'])) {
    unset($_SESSION['cat_added']);
}

include_once('footer.php');

if (isset($_SESSION['err_msg'])) {
    unset($_SESSION['err_msg']);
}
?>