<?php
$title = "Update Test Question";
$apage = "updatetestque";
include_once('header.php');

if (isset($_GET['que_id']) && $_GET['que_id'] != "") {
    $que_id = $_GET['que_id'];
    $getData = $db->selectQuery("select * from test_questions where ID = $que_id");
//    print_r($getData);
//    die;
}
?> 


<div class="container-fluid">
    <div class="row">
        <main role="main" class="col-md-12 pt-3">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="fa fa-"></i><?php echo isset($que_id) ? 'Update Question' : 'Add Questions'; ?></h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <?php
                    if (isset($_GET['contest_id'])) {
                        ?>
                        <a class="btn btn-primary ml-1" href="view_exam_contest.php"><i class="fa fa-list pr-2"></i>Exam Contest List</a> 
                        <?php
                    }
                    ?>

                </div>
            </div>



            <div class="col-12 col-md-8 mx-auto">

                <form class="border rounded p-4 submitform" action="controller/test_controller.php" method="post" enctype="multipart/form-data">

                    <input type="hidden" name="ID" value="<?php echo $que_id; ?>">

                    <p class="m-0 mt-2 mb-1" style="border-bottom:solid 1px gray">Question</p>

                    <div class="row">
                        <div class="col-md-5 col-12">
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">Question</span>
                                </div>

                                <input type="text" name="questions" class="form-control" value="<?php echo isset($que_id) ? $getData[0]['questions'] : ''; ?>" required>

                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <input type="file" name="que_image" class="form-control" value="<?php echo isset($que_id) && $getData[0]['que_image'] ? $getData[0]['que_image'] : ''; ?>">
                            </div>
                        </div>

                        <div class="col-md-3 col-12">
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Answer</span>
                                </div>

                                <select type="text" name="answer" class="form-control" required>
                                    <option value="A" <?php echo isset($que_id) && $getData[0]['answer'] == 'A' ? "selected" : '' ?> >A</option>
                                    <option value="B" <?php echo isset($que_id) && $getData[0]['answer'] == 'B' ? "selected" : '' ?> >B</option>
                                    <option value="C" <?php echo isset($que_id) && $getData[0]['answer'] == 'C' ? "selected" : '' ?> >C</option>
                                    <option value="D" <?php echo isset($que_id) && $getData[0]['answer'] == 'D' ? "selected" : '' ?> >D</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <?php
                    if (isset($que_id)) {
                        $sugg = $getData[0]['suggestions'];
                        $suggestion = json_decode($sugg, true);
                    }
                    ?>

                    <div class="row">
                        <div class="col-9 col-md-9">
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">A</span>
                                </div>
                                <input type="<?php echo (filter_var($suggestion['A'], FILTER_VALIDATE_URL)) ? 'file' : 'text'; ?>" name="suggestions[A]" class="form-control changetype-A-1" value="<?php echo isset($que_id) ? $suggestion['A'] : ''; ?>" required>
                            </div>
                        </div>

                        <div class="col-3 col-md-3">
                            <div class="btn-group btn-group-toggle mb-2" data-toggle="buttons">
                                <label class="btn btn-primary active">
                                    <input type="radio" class="change" data-id="A-1" value="text"> Text
                                </label>
                                <label class="btn btn-primary">
                                    <input type="radio" class="change" data-id="A-1" value="image"> Image
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-9 col-md-9">
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">B</span>
                                </div>
                                <input type="<?php echo (filter_var($suggestion['B'], FILTER_VALIDATE_URL)) ? 'file' : 'text'; ?>" name="suggestions[B]" class="form-control changetype-B-2" value="<?php echo isset($que_id) ? $suggestion['B'] : ''; ?>" required>
                            </div>
                        </div>

                        <div class="col-3 col-md-3">
                            <div class="btn-group btn-group-toggle mb-2" data-toggle="buttons">
                                <label class="btn btn-primary active">
                                    <input type="radio" class="change" data-id="B-2" value="text"> Text
                                </label>
                                <label class="btn btn-primary">
                                    <input type="radio" class="change" data-id="B-2" value="image"> Image
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-9 col-md-9">
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="" required>C</span>
                                </div>
                                <input type="<?php echo (filter_var($suggestion['C'], FILTER_VALIDATE_URL)) ? 'file' : 'text'; ?>" name="suggestions[C]" class="form-control changetype-C-3" value="<?php echo isset($que_id) ? $suggestion['C'] : ''; ?>" required>
                            </div>
                        </div>

                        <div class="col-3 col-md-3">
                            <div class="btn-group btn-group-toggle mb-2" data-toggle="buttons">
                                <label class="btn btn-primary active">
                                    <input type="radio" class="change" data-id="C-3" value="text"> Text
                                </label>
                                <label class="btn btn-primary">
                                    <input type="radio" class="change" data-id="C-3" value="image"> Image
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-9 col-md-9">
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">D</span>
                                </div>

                                <input type="<?php echo (filter_var($suggestion['D'], FILTER_VALIDATE_URL)) ? 'file' : 'text'; ?>" class="form-control changetype-D-4" name="suggestions[D]" value="<?php echo isset($que_id) ? $suggestion['D'] : ''; ?>" required>
                            </div>
                        </div>

                        <div class="col-3 col-md-3">
                            <div class="btn-group btn-group-toggle mb-2" data-toggle="buttons">
                                <label class="btn btn-primary active">
                                    <input type="radio" class="change" data-id="D-4" value="text"> Text
                                </label>
                                <label class="btn btn-primary">
                                    <input type="radio" class="change" data-id="D-4" value="image"> Image
                                </label>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <button type="submit" name="update" value="update_test_que" class="btn btn-primary btn-block button_submit">Update</button>   
                    </div>
                </form>

            </div>  
        </main>

    </div>
</div>


<?php
include_once('footer.php');


if (isset($_SESSION['quizq']) || isset($_SESSION['add_more']) || isset($_SESSION['add_examque'])) {
    unset($_SESSION['quizq']);
    unset($_SESSION['add_more']);
    unset($_SESSION['add_examque']);
}
?>

<script>
    $(document).ready(function () {
        $(".change").on('change', function () {
            
            var ele = $(this);
            var key = ele.attr("data-id");
//            alert(key);
            if (ele.val() == 'image') {
                $('.changetype-' + key).attr('type', 'file');
                $('.changetype-' + key).attr('value', '');
            } else {
                $('.changetype-' + key).attr('type', 'text');
                $('.changetype-' + key).attr('value', '');
            }
        });
    });
</script>

