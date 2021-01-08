<?php
include_once ('header.php');
$categories = array();

if ($tcat = $db->selectQuery("select * from edu_category order by parent_category")) {
    foreach ($tcat as $catt) {
        if ($catt['parent_category'] == "") {
//            str_clean
            $categories[$db->str_clean($catt['category_name'])] = array("name" => $catt['category_name'], "sub" => array());
        } else {
            $categories[$db->str_clean($catt['parent_category'])]["sub"][] = $catt['category_name'];
        }
    }
}
//echo "<pre>";
//print_r($categories);die;
//echo $categories['sub'];die;
?>

<div class="container-fluid">
    <main role="main" class="col-md-12 pt-3">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2"><i class="fa fa-"></i>Add Subjects</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                          <!--   <a class="btn btn-primary ml-1" href="page-userlist.php"><i class="fa fa-list pr-2"></i>Users List</a> -->
            </div>
        </div>
    </main>   
    <div class="row">

        <div class="col-lg-6 col-md-6 col-sm-12">
            <?php
            if (isset($_SESSION['sub_inserted'])) {
                ?>
                <p class="alert alert-success"><?php echo $_SESSION['sub_inserted']; ?></p>
                <?php
            }
            ?>

            <!--*************add subjects***********************-->
            <form class="border rounded p-4" action="controller/edu_controller.php" method="post" enctype="multipart/form-data">

                <div class="form-group mb-2">
                    Parent Category<span class="required">*</span>
                    <select for="Parent Category" id="selected_parent" class="form-control" required=""> 
                        <option value="">Select Any One</option>
                        <?php
                        foreach ($categories as $parentCat => $cat_array) {
                            ?>
                            <option value="<?php echo $parentCat; ?>"><?php echo $cat_array['name']; ?></option>

                            <?php
                        }
                        ?>
                    </select>
                </div>

                <input type="hidden" id="parentcategory" name="parent_category" value="">

                <div class="form-group mb-2">
                    Sub Category<span class="required">*</span>
                    <select for="sub_cat" id="subcategory" name="sub_category" class="form-control" required="">    
                        <option value="">Select Any One</option>

                    </select>
                </div>

                <div class="form-group mb-2">
                    <label for="subjects">Subject<span class="required">*</span></label>
                    <input type="text" name="subjects" class="form-control" value=""  required>
                </div>

                <div class="form-group mb-2">
                    Select Board
                    <select for="board" name="board" class="form-control">
                        <option value="">-Select-</option>
                        <?php
                        $boardName = $db->selectQuery("SELECT * FROM `study_board`");
                        foreach ($boardName as $board) {
                            ?>
                            <option value="<?php echo $board['board']; ?>"><?php echo $board['board']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div> 

                <div class="form-group mt-3">    
                    <button type="submit" name="submit" value="add_subjects" class="btn btn-primary btn-block button_submit">Submit</button>
                </div>
            </form>
        </div>

        <?php
        $subjectData = $db->selectQuery("SELECT * FROM `edu_subjects` order by id DESC");
        ?>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <table class="table table-sm table-hover">
                <thead class="bg-white">
                    <tr>
                        <th>#ID</th>
                        <th>Subject</th>
                        <th>Board</th>
                        <th>Sub Category</th>
                        <th>Parent Category</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($subjectData as $subData) {
                        ?>
                        <tr>
                            <td><?php echo $subData['id'] ?></td>
                            <td><?php echo $subData['subjects'] ?></td>
                            <td><?php echo ($subData['board']) ? $subData['board'] : '-'; ?></td>
                            <td><?php echo $subData['sub_category'] ?></td>
                            <td><?php echo $subData['parent_category']; ?></td>
                            <td><button type="button" id="deletesubject" subject-id="<?php echo $subData['id']; ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash-alt"></i></button></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>   
</div>

<?php
if (isset($_SESSION['sub_inserted'])) {
    unset($_SESSION['sub_inserted']);
}

include_once ('footer.php');
?>


<script>

    var categories = JSON.parse('<?php echo json_encode($categories) ?>');
//    console.log(categories);
    $(document).ready(function () {
        $('#selected_parent').on('change', function () {
            var parent_category = $(this).val();
            $('#subcategory').find("option").remove();
            $('#subcategory').append("<option value=''>-Select-</option>");
            $('#parentcategory').val(categories[parent_category]['name']);
            $.each(categories[parent_category]['sub'], function (key, value) {
                console.log(value);
                $('#subcategory').append("<option value='" + value + "'>" + value + "</option>");
//                $('#subcatname').val(parent_category);
            });

//            console.log(parent_category);
        });
    });
</script>

<script>
    $(document).ready(function () {
//        delete subject
        $('body').on('click', '#deletesubject', function ()
        {
            var ele = $(this);
            var subject_id = ele.attr('subject-id');
//            console.log(subject_id);
            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure?',
                buttons: {
                    yes: function () {
                        $.ajax({
                            type: "post",
                            url: "controller/edu_ajaxcontroller.php",
//                            dataType: 'json',
                            data: {subject_id: subject_id, req_type: "delete_subject"},
                            success: function (data) {
                                var obj = jQuery.parseJSON(data);
//                                var obj = json.parseInt(data);
                                var data = obj.data;
//                                alert(obj.data);
//                                console.log(obj.data);
                                if (data == 1)
                                {
                                    location.reload();
                                } else {
                                    $.alert('Delete Process Failed!');
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