<?php
$title = "Test Questions Details";
$apage = "testquestiondetails";
include_once('header.php');

$categories = array();

if ($tcat = $db->selectQuery("select * from test_category where cat_parent='0'")) {
//    $categories=$db->orderCategory($tcat);
    foreach ($tcat as $cat1) {
        $categories[$cat1['cat_sku']] = $cat1;
        $categories[$cat1['cat_sku']]['child'] = array();
        if ($tcat2 = $db->selectQuery("select * from test_category where cat_parent='{$cat1['ID']}'")) {
            foreach ($tcat2 as $cat2) {
                $categories[$cat1['cat_sku']]['child'][$cat2['cat_sku']] = $cat2;
                $categories[$cat1['cat_sku']]['child'][$cat2['cat_sku']]['child'] = array();
                if ($tcat3 = $db->selectQuery("select * from test_category where cat_parent='{$cat2['ID']}'")) {
                    foreach ($tcat3 as $cat3) {
                        $categories[$cat1['cat_sku']]['child'][$cat2['cat_sku']]['child'][$cat3['cat_sku']] = $cat3;
                        $categories[$cat1['cat_sku']]['child'][$cat2['cat_sku']]['child'][$cat3['cat_sku']]['child'] = array();
                        if ($tcat4 = $db->selectQuery("select * from test_category where cat_parent='{$cat3['ID']}'")) {
                            foreach ($tcat4 as $cat4) {
                                $categories[$cat1['cat_sku']]['child'][$cat2['cat_sku']]['child'][$cat3['cat_sku']]['child'][$cat4['cat_sku']] = $cat4;
                                $categories[$cat1['cat_sku']]['child'][$cat2['cat_sku']]['child'][$cat3['cat_sku']]['child'][$cat4['cat_sku']]['child'] = array();
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
?>
<div class="container-fluid">
    <div class="row">

        <main role="main" class="col-md-12 pt-3">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">

                <h1 class="h2"><i class="fa fa-"></i><?php echo isset($update_id) ? 'Update' : 'Add'; ?> Test Question Details</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a class="btn btn-primary ml-1" href="test_view_questions.php"><i class="fa fa-list pr-2"></i>Questions List</a> 
                </div>
            </div>

            <div class="col-12 col-md-8 mx-auto">

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

                <form class="border rounded p-4 submitform" action="test_add_questions.php" method="post" enctype="multipart/form-data">


                    <p class="h4">Test Question Details</p>




                    <div class="form-group mb-2">
                        Category Level 1
                        <?php
//                        if (isset($updateData[0]['parent_category'])) {
//                            $parett = $str = str_replace(' ', '_', $updateData[0]['parent_category']);
//                        }
                        ?>
                        <select for="Parent Category" name="cat_1" id="category_level1" class="form-control"> 
                            <option value="0">-No Category-</option>
                            <?php
                            foreach ($categories as $childCat) {
                                ?>
                                <option value="<?php echo $childCat['cat_sku']; ?>"><?php echo $childCat['cat_name']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div> 


                    <div class="form-group mb-2">
                        Category Level 2
                        <select for="category level 2" name="cat_2" id="category_level2" class="form-control">
                            <option value="0">-No Category-</option>
                        </select>
                    </div>


                    <div class="form-group mb-2">
                        <label for="category level 3">Category Level 3</label>
                        <select for="category level 3" name="cat_3" id="category_level3" class="form-control">
                            <option value="0">-No Category-</option>
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <label for="category level 4">Category Level 4</label>
                        <select for="category level 4" name="cat_4" id="category_level4" class="form-control">
                            <option value="0">-No Category-</option>
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <label for="no of questions">No. Of Questions</label>
                        <input type="number" name="no_of_que" class="form-control" value="2">
                    </div>

                    <div class="form-group">
                        <?php
                        if (isset($update_id)) {
                            ?>
                            <button type="submit" name="update" value="update_exam_contest" class="btn btn-primary btn-block button_submit">Update</button>
                            <?php
                        } else {
                            ?>
                            <button type="submit" name="submit" value="test_question_details" class="btn btn-primary btn-block button_submit">Submit</button>
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
if (isset($_SESSION['cat_inserted']) || isset($_SESSION['checksku'])) {
    unset($_SESSION['cat_inserted']);
    unset($_SESSION['checksku']);
}

include_once('footer.php');
?>

<script>

    var categories = JSON.parse('<?php echo json_encode($categories) ?>');

    $(document).ready(function () {
//        category level 1
        $('#category_level1').on('change', function () {
            var parent_category = $(this).val();
            $("#cat_parent").val(parent_category);
//            $("#cat_level").val("1");
            $('#category_level2').html("<option value=''>-No Category-</option>");
            $('#category_level3').html("<option value=''>-No Category-</option>");
            $('#category_level4').html("<option value=''>-No Category-</option>");
            if (parent_category != "" && Object.keys(categories[parent_category]['child']).length > 0) {
                $.each(categories[parent_category]['child'], function (key, value) {
                    $('#category_level2').append("<option value='" + value['cat_sku'] + "'>" + value['cat_name'] + "</option>");
                });
            }
        });

//        category level 2
        $('#category_level2').on('change', function () {
            var parent_category = $("#category_level1").val();
            var cat_level2 = $(this).val();
            $("#cat_parent").val(cat_level2);
//            $("#cat_level").val("2");
            var categories2 = categories[parent_category]['child'];
            $('#category_level3').html("<option value=''>-No Category-</option>");
            $('#category_level4').html("<option value=''>-No Category-</option>");
            if (cat_level2 != "" && Object.keys(categories2[cat_level2]['child']).length > 0) {
                $.each(categories2[cat_level2]['child'], function (key, value) {
                    $('#category_level3').append("<option value='" + value['cat_sku'] + "'>" + value['cat_name'] + "</option>");
                });
            }
        });

        $('#category_level3').on('change', function () {
            var parent_category = $("#category_level1").val();
            var cat_level2 = $("#category_level2").val();
//            alert(JSON.stringify(categories));
//            console.log(JSON.stringify(categories[parent_category]['child']));
            var cat_level3 = $(this).val();

//           $("#cat_parent").val(cat_level3);
//            $("#cat_level").val("3");
            var categories3 = categories[parent_category]['child'][cat_level2]['child'];

//              alert(JSON.stringify(categories3[cat_level3]['child']));

            $('#category_level4').html("<option value=''>-No Category-</option>");
            if (cat_level3 != "" && Object.keys(categories3[cat_level3]['child']).length > 0) {
                $.each(categories3[cat_level3]['child'], function (key, value) {
                    $('#category_level4').append("<option value='" + value['cat_sku'] + "'>" + value['cat_name'] + "</option>");
                });
            }
        });


        $('#category_level4').on('change', function () {
            var parent_category = $("#category_level1").val();
//            var cat_level4 = $(this).val();
//            $("#cat_parent").val(cat_level4);
//            $("#cat_level").val("4");
        });



//        sku code
        $("#catsku").keyup(function () {
            $("#sku").val(($("#catsku").val().replace(/ /g, "_")).toLowerCase());
        });
    });
</script>
