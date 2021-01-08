<?php
include_once('header.php');

if (isset($_GET['update_cat']) && $_GET['update_cat']) {
    $update_id = $_GET['update_cat'];
    $updateData = $db->selectQuery("SELECT * FROM `quiz_category` where id = '$update_id'");
}
?>
<div class="container-fluid">
    <div class="row">

        <main role="main" class="col-md-12 pt-3">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="fa fa-"></i>Add Exam Category</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a class="btn btn-primary ml-1" href="add_exam_contest.php">Add Exam Contest</a> 
                </div>
            </div>


            <?php if (isset($update_id)) {
                ?>
                <a href="add_exam_cat.php" class="btn btn-primary my-2">Add New</a>
            <?php }
            ?>
            <div class="row">



                <div class="col-6 col-md-6">



                    <?php
                    if (isset($_SESSION['msg'])) {
                        ?>
                        <div class="text-danger">
                            <p><?php echo $_SESSION['msg']; ?></p>
                        </div>
                    <?php } else if (isset($_SESSION['cat_updated'])) {
                        ?>
                        <p class="alert alert-success"><?php echo $_SESSION['cat_updated']; ?></p>
                        <?php
                    }
                    ?>


                    <form class="border rounded p-4 submitform" action="controller/quiz_controller.php" method="post" enctype="multipart/form-data">
                        <p class="h4">Add New Category</p>

                        <div class="form-group mb-2">
                            <label for="category_name">Exam Category<span class="required">*</span></label>
                            <input type="text" name="category_name" class="form-control" value="<?php echo isset($update_id) && $updateData[0]['category_name'] != '' ? $updateData[0]['category_name'] : ''; ?>"  required="">
                        </div>

                        <div class="form-group mb-2" id="catimage">
                            <label for="cat_image">Category Image</label>
                            <input type="file" name="cat_image" class="form-control" value="<?php echo isset($update_id) ? $updateData[0]['cat_image'] : ''; ?>" required="">
                        </div>
                        <?php
                        if (isset($update_id)) {
                            ?>
                            <input type="hidden" name="id" value="<?php echo $update_id; ?>">
                            <?php
                        }
                        ?>

                        <div class="form-group">
                            <button type="submit" name="<?php echo isset($update_id) ? 'update' : 'submit'; ?>" value="<?php echo isset($update_id) ? 'update_exam_category' : 'add_exam_category'; ?>" class="btn btn-primary btn-block button_submit"><?php echo isset($update_id) ? 'Update' : 'Submit'; ?></button>
                        </div>
                    </form>
                </div>



                <?php
                $categoriesData = $db->selectQuery("SELECT * FROM `quiz_category` order by id DESC");
                ?>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <table class="table table-sm table-hover">
                        <thead class="bg-white">
                            <tr>
                                <th>#ID</th>
                                <th>Category Name</th>
                                <th>Category Image</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($categoriesData as $catData) {
                                ?>
                                <tr>
                                    <td><?php echo $catData['id'] ?></td>
                                    <td><?php echo $catData['category_name']; ?></td>
                                    <td><img src="<?php echo $catData['cat_image']; ?>" width="80px" height="80px"></td>
                                    <td class="text-right">
                                        <div class="btn-group btn-group-sm">
                                            <a href="add_exam_cat.php?update_cat=<?php echo $catData['id']; ?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                            <button type="button" id="deletecat" cat-id="<?php echo $catData['id']; ?>" class="btn btn-danger"><i class="fa fa-trash-alt"></i></button>
                                        </div>
                                    </td>    
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

    </div>
</div>
<?php
if (isset($_SESSION['msg']) || isset($_SESSION['cat_updated'])) {
    unset($_SESSION['msg']);
    unset($_SESSION['cat_updated']);
}

include_once('footer.php');
?>


<script>
    $(document).ready(function ()
    {
        $('body').on('click', '#deletecat', function ()
        {
            var ele = $(this);
            var cat_id = ele.attr('cat-id');
            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure?',
                buttons: {
                    yes: function () {

//                console.log(question_id);
                        $.ajax({
                            type: "post",
                            url: "controller/edu_ajaxcontroller.php",
                            data: {cat_id: cat_id, req_type: "delete_exam_category"},
                            success: function (data) {
                                var obj = jQuery.parseJSON(data);
                                var data = obj.data;
                                if (data == 1)
                                {
                                    location.reload();
                                } else {
                                    $.alert('Delete Process Failed!')
                                }
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