<?php
$title = "Test Questions";
$apage = "testaddquestion";
include_once('header.php');

//
//
//if (isset($_SESSION['category_name'])) {
//    $category_name = $_SESSION['category_name'];
//}
//
if ($request['submit'] == "test_question_details") {
    ?> 
    <div class="container-fluid">
        <div class="row">
            <main role="main" class="col-md-12 pt-3">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h1 class="h2"><i class="fa fa-"></i>Add Test Questions</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                                  <!--   <a class="btn btn-primary ml-1" href="page-userlist.php"><i class="fa fa-list pr-2"></i>Users List</a> -->
                    </div>
                </div>
                <div class="col-12">

                    <?php
//                $catq = mysqli_fetch_array(mysqli_query($db->con, "SELECT * FROM `quiz_category` where id = $category_name"));
//                print_r($catq);die;
                    $x = 0;
                    ?>
                    <div style="display: flex;">
                        <h4 class="add_que ">Max Questions : <?php echo $request['no_of_que']; ?></h4>
                        <h4 class="add_que ml-auto text-capitalize">Category : <?php echo $request['cat_1']; ?>-><?php echo ($request['cat_2'] == "") ? "" : $request['cat_2']; ?><?php echo ($request['cat_3'] == "") ? "" : "->" . $request['cat_3'] . "->"; ?><?php echo ($request['cat_4'] == "") ? "" : $request['cat_4']; ?></h4>
                    </div>


                    <form class="submitform" action="controller/test_controller.php" method="post" enctype="multipart/form-data">

                        <input type="hidden" name="cat_1" value="<?php echo $request['cat_1']; ?>"/>
                        <input type="hidden" name="cat_2" value="<?php echo $request['cat_2']; ?>"/>
                        <input type="hidden" name="cat_3" value="<?php echo $request['cat_3']; ?>"/>
                        <input type="hidden" name="cat_4" value="<?php echo $request['cat_4']; ?>"/>
                        <div class="row">
                            <?php
                            $datt = $request['no_of_que'];
                            for ($i = 1; $i <= $datt; $i++) {
                                $x++;
                                ?>
                                <div class=" col-12 col-lg-6">
                                    <div class="border rounded p-4 mb-4">
                                        <p class="h5 m-0" style="border-bottom:solid 1px gray">Question <?php echo $i; ?></p>
                                        <div class="mt-2">
                                            <div class="form-group input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="">Question</span>
                                                </div>
                                                <input type="text" name="questions[<?php echo $i; ?>][questions]" class="form-control" value="" required>
                                            </div>
                                        </div>

                                        <div class="row mt-2">   
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">    
                                                    <input type="file" name="questions[<?php echo $i; ?>][que_image]" class="que_image form-control" value="">
                                                </div>
                                            </div>


                                            <div class="col-md-6 col-12">
                                                <div class="form-group input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="">Answer</span>
                                                    </div>

                                                    <select type="text" name="questions[<?php echo $i; ?>][answer]" class="form-control" required>
                                                        <option value="A" <?php echo isset($answer) && $answer == 'A' ? "selected" : '' ?> > <?php echo isset($update_id) && $update_id != '' ? $answer : "A" ?> </option>
                                                        <option value="B" <?php echo isset($answer) && $answer == 'B' ? "selected" : '' ?> > <?php echo isset($update_id) && $update_id != '' ? $answer : "B" ?> </option>
                                                        <option value="C" <?php echo isset($answer) && $answer == 'C' ? "selected" : '' ?> > <?php echo isset($update_id) && $update_id != '' ? $answer : "C" ?> </option>
                                                        <option value="D" <?php echo isset($answer) && $answer == 'D' ? "selected" : '' ?> > <?php echo isset($update_id) && $update_id != '' ? $answer : "D" ?> </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <p class="h5 mb-2" style="border-bottom:solid 1px gray">Options</p>


                                        <div class="row"> 
                                            <div class="col-8 col-md-8">
                                                <div class="form-group input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="">A</span>
                                                    </div>

                                                    <input type="text" name="questions[<?php echo $i; ?>][suggestions][A]" class="form-control optionval changetype-A-<?php echo $i; ?>" value="" required>


                                                </div>
                                            </div>

                                            <div class="col-4 col-md-4">
                                                <div class="btn-group btn-group-toggle mb-2" data-toggle="buttons">
                                                    <label class="btn btn-primary active">
                                                        <input type="radio" class="change" data-id="A-<?php echo $i; ?>" value="text"> Text
                                                    </label>
                                                    <label class="btn btn-primary">
                                                        <input type="radio" class="change" data-id="A-<?php echo $i; ?>" value="image"> Image
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row"> 
                                            <div class="col-8 col-md-8">
                                                <div class="form-group input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="">B</span>
                                                    </div>

                                                    <input type="text" name="questions[<?php echo $i; ?>][suggestions][B]" class="form-control optionval changetype-B-<?php echo $i; ?>" value="" required>
                                                </div>
                                            </div>

                                            <div class="col-4 col-md-4">
                                                <div class="btn-group btn-group-toggle mb-2" data-toggle="buttons">
                                                    <label class="btn btn-primary active">
                                                        <input type="radio" class="change" data-id="B-<?php echo $i; ?>" value="text"> Text
                                                    </label>
                                                    <label class="btn btn-primary">
                                                        <input type="radio" class="change" data-id="B-<?php echo $i; ?>" value="image"> Image
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row"> 
                                            <div class="col-8 col-md-8">
                                                <div class="form-group input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="" required>C</span>
                                                    </div>

                                                    <input type="text" name="questions[<?php echo $i; ?>][suggestions][C]" class="form-control optionval changetype-C-<?php echo $i; ?>" value="" required>


                                                </div>
                                            </div>

                                            <div class="col-4 col-md-4">
                                                <div class="btn-group btn-group-toggle mb-2" data-toggle="buttons">
                                                    <label class="btn btn-primary active">
                                                        <input type="radio" class="change" data-id="C-<?php echo $i; ?>" value="text"> Text
                                                    </label>
                                                    <label class="btn btn-primary">
                                                        <input type="radio" class="change" data-id="C-<?php echo $i; ?>" value="image"> Image
                                                    </label>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row"> 
                                            <div class="col-8 col-md-8">
                                                <div class="form-group input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="">D</span>
                                                    </div>

                                                    <input type="text" class="form-control optionval changetype-D-<?php echo $i; ?>" name="questions[<?php echo $i; ?>][suggestions][D]" value="" required>
                                                </div>
                                            </div>

                                            <div class="col-4 col-md-4">
                                                <div class="btn-group btn-group-toggle mb-2" data-toggle="buttons">
                                                    <label class="btn btn-primary active">
                                                        <input type="radio" name="change" class="change" data-id="D-<?php echo $i; ?>" value="text"> Text
                                                    </label>
                                                    <label class="btn btn-primary">
                                                        <input type="radio" name="change" class="change" data-id="D-<?php echo $i; ?>" value="image"> Image
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>


                        <div class="form-group">

                            <button type="submit" name="submit" value="test_add_questions" class="btn btn-primary btn-block button_submit">Submit</button>           

                        </div>
                    </form>
                </div>
            </main>

        </div>
    </div>


    <?php
} else {
    echo "No Submit data";
}
include_once('footer.php');


if (isset($_SESSION['quizq'])) {
    unset($_SESSION['quizq']);
}
?>


<script>
    $(document).ready(function () {
        $(".que_image").fileinput({
            theme: "fa",
            allowedFileExtensions: ['jpg', 'png', 'gif'],
            showUpload: false,
            showUploadedThumbs: false,
            showPreview: false,
            showRemove: false,
            maxFileSize: 400,
            browseClass: "btn btn-dark",
            dropZoneEnabled: false
        });

//        $(".optionval[type='file']").fileinput({
//            theme: "fa",
//            allowedFileExtensions: ['jpg', 'png', 'gif'],
//            showUpload: false,
//            showUploadedThumbs: false,
//            showPreview: false,
//            showRemove: false,
//            maxFileSize: 400,
//            browseClass: "btn btn-dark",
//            dropZoneEnabled: false
//        });

        $(".change").on('change', function () {
            var ele = $(this);
//                ele.is(':checked');
//                var selValue = ele.is(':checked');
            var key = ele.attr("data-id");
            if (ele.val() == 'image') {
                $('.changetype-' + key).attr('type', 'file');
            } else {
                $('.changetype-' + key).attr('type', 'text');
            }
        });

    });
</script>


