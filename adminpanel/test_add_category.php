<?php
$title = "Add Test Category";
$apage = "testaddcategory";
include_once('header.php');

if (isset($_GET['cat_id']) && $_GET['cat_id'] != "") {
    $cat_id = $_GET['cat_id'];

    $getData = $db->selectQuery("SELECT * FROM `test_category` where ID = '$cat_id'");
} else {

    $categories = array();


    if ($tcat = $db->selectQuery("select * from test_category where cat_parent='0'")) {
//    $categories=$db->orderCategory($tcat);
        foreach ($tcat as $cat1) {
            $categories[$cat1['ID']] = $cat1;
            $categories[$cat1['ID']]['child'] = array();
            if ($tcat2 = $db->selectQuery("select * from test_category where cat_parent='{$cat1['ID']}'")) {
                foreach ($tcat2 as $cat2) {
                    $categories[$cat1['ID']]['child'][$cat2['ID']] = $cat2;
                    $categories[$cat1['ID']]['child'][$cat2['ID']]['child'] = array();
                    if ($tcat3 = $db->selectQuery("select * from test_category where cat_parent='{$cat2['ID']}'")) {
                        foreach ($tcat3 as $cat3) {
                            $categories[$cat1['ID']]['child'][$cat2['ID']]['child'][$cat3['ID']] = $cat3;
                            $categories[$cat1['ID']]['child'][$cat2['ID']]['child'][$cat3['ID']]['child'] = array();
                            if ($tcat4 = $db->selectQuery("select * from test_category where cat_parent='{$cat3['ID']}'")) {
                                foreach ($tcat4 as $cat4) {
                                    $categories[$cat1['ID']]['child'][$cat2['ID']]['child'][$cat3['ID']]['child'][$cat4['ID']] = $cat4;
                                }
                            }
                        }
                    }
                }
            }
        }
//    echo"<pre>";
//    print_r($categories);
//    die;
///
    }
}
?>
<div class="container-fluid">

    <div class="row">
        <main role="main" class="col-md-12 pt-3">

            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">

                <h1 class="h2"><i class="fa fa-"></i><?php echo isset($cat_id) ? 'Update' : 'Add'; ?> Test Category</h1>
                <div class="btn-toolbar mb-2 mb-md-0 <?php echo isset($cat_id) ? '' : 'd-none'; ?>">
                    <a class="btn btn-primary ml-1" href="test_add_category.php"><i class="fa fa-list pr-2"></i>Add New Category</a> 
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6">

                    <?php
                    if (isset($_SESSION['cat_inserted'])) {
                        ?>
                        <p class="alert alert-success"><?php echo $_SESSION['cat_inserted']; ?></p>
                        <?php
                    } else if (isset($_SESSION['checksku'])) {
                        ?>
                        <p class="alert alert-danger"><?php echo $_SESSION['checksku']; ?></p>
                        <?php
                    }
                    ?>

                    <form class="border rounded p-4 submitform" action="controller/test_controller.php" method="post" enctype="multipart/form-data">


                        <p class="h4">Add New Practice Test</p>

                        <div class="form-group mb-2">
                            <label for="category_name">Category Name<span class="required">*</span></label>
                            <input type="text" name="cat_name" id="catsku" class="form-control" value="<?php echo isset($cat_id) ? $getData[0]['cat_name'] : ''; ?>" required>

                        </div>

<!--                        <div class="form-group mb-2">
                            Category Image
                            <input type="file" name="cat_img" class="cat_img form-control" value="<?php // echo isset($cat_id) ? $getData[0]['cat_img'] : ''; ?>">
                        </div>-->

                        <input type="hidden" class="form-control" name="cat_sku" id="sku" value="<?php echo isset($cat_id) ? $getData[0]['cat_sku'] : ''; ?>" readonly="">

                        <input type="hidden" name="cat_parent" id="cat_parent" class="form-control" value="<?php echo isset($cat_id) ? $getData[0]['cat_parent'] : ''; ?>">

                        <input type="hidden" name="cat_level" id="cat_level" class="form-control" value="<?php echo isset($cat_id) ? $getData[0]['cat_level'] : '0'; ?>">

                        <div class="form-group mb-2">
                            Category Level 1
                            <?php
//                        if (isset($updateData[0]['parent_category'])) {
//                            $parett = $str = str_replace(' ', '_', $updateData[0]['parent_category']);
//                        }
                            ?>
                            <select for="Parent Category" id="category_level1" class="form-control"> 
                                <option value="0">-No Category-</option>
                                <?php
                                if(isset($cat_id)){
                                    $categories=$db->selectQuery("SELECT * FROM `test_category` where ID = '{$get[0]['cat_parent']}'");
                                }
                                
                                foreach ($categories as $childCat) {
                                    ?>
                                    <option value="<?php echo $childCat['ID']; ?>"><?php echo $childCat['cat_name']; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div> 


                        <div class="form-group mb-2">
                            Category Level 2
                            <select for="category level 2" id="category_level2" class="form-control">
                                <option value="0">-No Category-</option>
                            </select>
                        </div>


                        <div class="form-group mb-2">
                            <label for="category level 3">Category Level 3</label>
                            <select for="category level 3" id="category_level3" class="form-control">
                                <option value="0">-No Category-</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <?php
                            if (isset($update_id)) {
                                ?>
                                <button type="submit" name="update" value="update_exam_contest" class="btn btn-primary btn-block button_submit">Update</button>
                                <?php
                            } else {
                                ?>
                                <button type="submit" name="submit" value="add_practice_test" class="btn btn-primary btn-block button_submit">Submit</button>
                                <?php
                            }
                            ?>

                        </div>
                    </form>
                </div>

                <div class="col-12 col-md-6">
                    <div class="just-padding">

                        <div class="list-group list-group-root well">

                            <?php
                            foreach ($categories as $cat) {
                                ?>
                                <div style="display:flex;">
                                    <a href="#item-<?php echo $cat['ID']; ?>" class="list-group-item" data-toggle="collapse">
                                        <i class="fa fa-arrow-right mr-1"></i><?php echo $cat['cat_name']; ?>
                                    </a>

                                    <div class="ml-auto p-2">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="test_add_category.php?cat_id=<?php echo $cat['ID']; ?>" class="btn btn-sm btn-success"><i class="fa fa-edit"></i></a>
                                            <button type="button"  cat_id="<?php echo $cat['ID']; ?>" class="btn btn-sm btn-danger delcategory"><i class="fa fa-trash-alt"></i></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="list-group collapse" id="item-<?php echo $cat['ID']; ?>">
                                    <?php foreach ($cat['child'] as $cat2) { ?>
                                        <div style="display:flex;">
                                            <a href="#item-<?php echo $cat['ID']; ?>-<?php echo $cat2['ID']; ?>" class="list-group-item ml-2" data-toggle="collapse">
                                                <i class="fa fa-arrow-right mr-1"></i><?php echo $cat2['cat_name']; ?>
                                            </a>

                                            <div class="ml-auto p-2">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="test_add_category.php?cat_id=<?php echo $cat2['ID']; ?>" class="btn btn-sm btn-success"><i class="fa fa-edit"></i></a>
                                                    <button type="button"  cat_id="<?php echo $cat2['ID']; ?>" class="btn btn-sm btn-danger delcategory"><i class="fa fa-trash-alt"></i></button>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="list-group collapse" id="item-<?php echo $cat['ID']; ?>-<?php echo $cat2['ID']; ?>">
                                            <?php foreach ($cat2['child'] as $cat3) { ?>
                                                <div style="display:flex;">
                                                    <a href="#item-<?php echo $cat['ID']; ?>-<?php echo $cat2['ID']; ?>-<?php echo $cat3['ID']; ?>" class="list-group-item ml-4" data-toggle="collapse">
                                                        <i class="fa fa-arrow-right mr-1"></i><?php echo $cat3['cat_name']; ?>
                                                    </a>


                                                    <div class="ml-auto p-2">
                                                        <div class="btn-group btn-group-sm" role="group">
                                                            <a href="test_add_category.php?cat_id=<?php echo $cat3['ID']; ?>" class="btn btn-sm btn-success"><i class="fa fa-edit"></i></a>
                                                            <button type="button"  cat_id="<?php echo $cat3['ID']; ?>" class="btn btn-sm btn-danger delcategory"><i class="fa fa-trash-alt"></i></button>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="list-group collapse" id="item-<?php echo $cat['ID']; ?>-<?php echo $cat2['ID']; ?>-<?php echo $cat3['ID']; ?>">
                                                    <?php foreach ($cat3['child'] as $cat4) { ?>
                                                        <div style="display:flex;">
                                                            <a href="#item-<?php echo $cat['ID']; ?>-<?php echo $cat2['ID']; ?>-<?php echo $cat3['ID']; ?>-<?php echo $cat4['ID']; ?>" class="list-group-item ml-5" data-toggle="collapse">
                                                                <i class="fa fa-arrow-right mr-1"></i><?php echo $cat4['cat_name']; ?>
                                                            </a>

                                                            <div class="ml-auto p-2">
                                                                <div class="btn-group btn-group-sm" role="group">
                                                                    <a href="test_add_category.php?cat_id=<?php echo $cat4['ID']; ?>" class="btn btn-sm btn-success"><i class="fa fa-edit"></i></a>
                                                                    <button type="button"  cat_id="<?php echo $cat4['ID']; ?>" class="btn btn-sm btn-danger delcategory"><i class="fa fa-trash-alt"></i></button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>    
                                            <?php } ?>
                                        </div>
                                    <?php }
                                    ?>
                                </div>
                                <?php
                            }
                            ?>



                        </div>
                    </div>
                </div>
            </div>
    </div>
</main>
</div>
</div>
</div>

<?php
if (isset($_SESSION['cat_inserted']) || isset($_SESSION['checksku'])) {
    unset($_SESSION['cat_inserted']);
    unset($_SESSION['checksku']);
}

include_once('footer.php');
?>

<script>

    var categories = JSON.parse('<?php echo json_encode($categories) ?>');

    $(document).ready(function () {

        $(".cat_img").fileinput({
            theme: "fa",
            allowedFileExtensions: ['jpg', 'png', 'jpeg'],
            showUpload: false,
            showUploadedThumbs: false,
            showPreview: false,
            showRemove: false,
            maxFileSize: 400,
            browseClass: "btn btn-dark",
            dropZoneEnabled: false
        });


//        category level 1
        $('#category_level1').on('change', function () {
            var parent_category = $(this).val();
            $("#cat_parent").val(parent_category);
            $("#cat_level").val("1");
            $('#category_level2').html("<option value='0'>-No Category-</option>");
            $('#category_level3').html("<option value='0'>-No Category-</option>");
            if (parent_category != "" && Object.keys(categories[parent_category]['child']).length > 0) {
                $.each(categories[parent_category]['child'], function (key, value) {
                    $('#category_level2').append("<option value='" + value['ID'] + "'>" + value['cat_name'] + "</option>");
                });
            }
        });

//        category level 2
        $('#category_level2').on('change', function () {
            var parent_category = $("#category_level1").val();
            var cat_level2 = $(this).val();
            $("#cat_parent").val(cat_level2);
            $("#cat_level").val("2");
            var categories2 = categories[parent_category]['child'];
            $('#category_level3').html("<option value='0'>-No Category-</option>");
            if (cat_level2 != "" && Object.keys(categories2[cat_level2]['child']).length > 0) {
                $.each(categories2[cat_level2]['child'], function (key, value) {
                    $('#category_level3').append("<option value='" + value['ID'] + "'>" + value['cat_name'] + "</option>");
                });
            }
        });

        $('#category_level3').on('change', function () {
            var parent_category = $("#category_level1").val();
            var cat_level3 = $(this).val();
            $("#cat_parent").val(cat_level3);
            $("#cat_level").val("3");
        });

//        sku code
        $("#catsku").keyup(function () {
            $("#sku").val(($("#catsku").val().replace(/ /g, "_")).toLowerCase());
        });

        $('.list-group-item').on('click', function () {
            $('.fa-arrow', this)
                    .toggleClass('arrow-right')
                    .toggleClass('arrow-down');
        });



//        delete test category
        $('.delcategory').click(function ()
        {
            var ele = $(this);
            var cat_id = ele.attr('cat_id');
            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure?',
                buttons: {
                    yes: function () {
                        $.ajax({
                            type: "post",
                            url: "controller/edu_ajaxcontroller.php",
                            data: {cat_id: cat_id, req_type: 'delete_test_category'},
                            success: function (data) {
//                                alert(data);
                                location.reload();
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