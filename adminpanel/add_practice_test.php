<?php
$title = "Add Practice Test";
$apage = "addpracticetest";
include_once('header.php');

?>
<div class="container-fluid">
    <div class="row">

        <main role="main" class="col-md-12 pt-3">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">

                <h1 class="h2"><i class="fa fa-"></i><?php echo isset($update_id) ? 'Update' : 'Add'; ?> Practice Test</h1>
<!--                <div class="btn-toolbar mb-2 mb-md-0">
                    <a class="btn btn-primary ml-1" href="view_exam_contest.php"><i class="fa fa-list pr-2"></i>Exams List</a> 
                </div>-->
            </div>
           
            <div class="col-12 col-md-8 mx-auto">

                <?php
                if (isset($_SESSION['cat_added'])) {
                    ?>
                    <p class="alert alert-success"><?php echo $_SESSION['cat_added']; ?></p>
                    <?php
                }
                ?>

                <form class="border rounded p-4 submitform" action="#" method="post" enctype="multipart/form-data">


                    <p class="h4">Add New Practice Test</p>

                    <div class="form-group mb-2">
                        <label for="contest_name">Test Title<span class="required">*</span></label>
                        <input type="text" name="test_title" class="form-control U_mobileNumber" value="<?php echo isset($update_id) && $updateDt[0]['contest_name'] != '' ? $updateDt[0]['contest_name'] : ''; ?>" required>
                    </div>
                    <!--a href="add_quiz.php" class="float-right">Add New</a>-->
                    <div class="form-group mb-2">
                        <label for="category_id">Test Category<span class="required">*</span></label>	
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
                        <label for="category_id">Sub Category<span class="required">*</span></label>	
                        <select class="form-control" name="sub_category">
                            <option value="">Select Any One</option>
                            <?php
                            $q_cat = mysqli_query($db->con, "SELECT DISTINCT category_name FROM `edu_category` where parent_category !=''");

                            while ($result = mysqli_fetch_array($q_cat)) {
                                ?>
                                <option value="<?php echo $result['category_name']; ?>" <?php echo isset($update_id) && $updateDt[0]['category_name'] == $result['category_name'] ? 'selected' : ''; ?>><?php echo $result['category_name']; ?></option>
                                <?php
                            }
                            ?>
                        </select> 
                    </div>

                    <div class="form-group mb-2">
                        <label for="Play Date">Test Start Time<span class="required">*</span></label>
                        <input type="datetime-local" name="start_time" class="form-control" value="<?php echo isset($update_id) && $updateDt[0]['play_time'] != '' ? $updateDt[0]['play_time'] : ''; ?>" required="">
                    </div>


                    <div class="form-group mb-1">
                        <label for="Total Duration">Total Duration(seconds)<span class="required">*</span></label>
                        <input type="number" name="test_time" class="form-control" value="<?php echo isset($update_id) && $updateDt[0]['quiz_time'] != '' ? $updateDt[0]['quiz_time'] : ''; ?>"  required>	
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


include_once('footer.php');


?>