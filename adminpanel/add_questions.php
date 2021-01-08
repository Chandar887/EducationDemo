<?php
$title = "New Question";
$apage = "addquestion";
include_once('header.php');

if (isset($_GET['update_id']) && $_GET['update_id'] != "") {
    $update_id = $_GET['update_id'];
    $getData = $db->selectQuery("select * from contest_que where id = $update_id");
//    print_r($getData);
//    die;
} else if (isset($_GET['contest_id']) && $_GET['contest_id'] != "") {
    $contest_id = $_GET['contest_id'];
}
?> 


<div class="container-fluid">
    <div class="row">
        <main role="main" class="col-md-12 pt-3">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2"><i class="fa fa-"></i><?php echo isset($update_id) ? 'Update Question' : 'Add Questions'; ?></h1>
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


                <?php
                if (isset($_SESSION['add_more'])) {
                    ?>
                    <p class="alert alert-success"><?php echo $_SESSION['add_more']; ?></p>
                    <?php
                } else if (isset($_SESSION['add_examque'])) {
                    ?>
                    <p class="alert alert-success"><?php echo $_SESSION['add_examque']; ?></p>
                    <?php
                }
                ?>

                <form class="border rounded p-4 submitform" action="controller/quiz_controller.php" method="post" enctype="multipart/form-data">
                    <?php
                    if (isset($_GET['contest_id'])) {
                        $catname = $db->selectQuery("select * from exam_contest where id = $contest_id");
                        ?>
                        <div class="form-group">
                            <input type="hidden" name="contest_id" value="<?php echo $contest_id; ?>">
                        </div>

                        <div class="form-group">
                            Category <br>
                            <input type="text" name="category_name" class="form-control mt-1" value="<?php echo $catname[0]['category_name']; ?>" readonly>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="">Category</span>
                            </div>

                            <input type="text" list="cat_list" name="category_name" value="<?php echo isset($update_id) ? $getData[0]['category_name'] : ''; ?>" class=" form-control mr-2" required>
                            <datalist id="cat_list">
                                <?php
                                $cat_query = mysqli_query($db->con, "SELECT DISTINCT category_name FROM `contest_que`");
                                while ($cat_name = mysqli_fetch_assoc($cat_query)) {
                                    ?>
                                    <option value="<?php echo $cat_name['category_name']; ?>">
                                    <?php }
                                    ?>

                            </datalist>
                        </div>

                        <?php
                    }
                    ?>

                    <p class="m-0 mt-2 mb-1" style="border-bottom:solid 1px gray">Question</p>
                    <div class="form-group">
                        <?php
                        if (!isset($update_id)) {
                            ?>
                            <input type="hidden" name="question_no" value="<?php echo rand(1000, 9999); ?>">
                            <?php
                        } else {
                            ?>
                            <input type="hidden" name="question_id" value="<?php echo $getData[0]['id']; ?>">
                            <?php
                        }
                        ?>
                    </div>
                    <div class="row">
                        <div class="col-md-5 col-12">
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">Question</span>
                                </div>

                                <input type="text" name="questions" class="form-control" value="<?php echo isset($update_id) ? $getData[0]['questions'] : ''; ?>" required>

                            </div>
                        </div>
                        <?php
                        if (isset($contest_id) || isset($update_id) && $getData[0]['que_image'] != '') {
                            ?>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <input type="file" name="que_image" class="form-control" value="<?php echo isset($update_id) && $getData[0]['que_image'] ? $getData[0]['que_image'] : ''; ?>">
                                </div>
                            </div>
                            <?php
                        }
//                        else if (isset($update_id) && $getData[0]['que_image'] != '') {
//                            
                        ?>
                        <!--                            <div class="col-md-4 col-12 mb-2">
                                                        <img src="//<?php // echo $getData[0]['que_image'];   ?>" width="70px" height="70x">
                                                    </div>-->
                        <?php
//                        }
                        ?>


                        <div class="col-md-3 col-12">
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Answer</span>
                                </div>

                                <select type="text" name="answer" class="form-control" required>
                                    <option value="A" <?php echo isset($update_id) && $getData[0]['answer'] == 'A' ? "selected" : '' ?> >A</option>
                                    <option value="B" <?php echo isset($update_id) && $getData[0]['answer'] == 'B' ? "selected" : '' ?> >B</option>
                                    <option value="C" <?php echo isset($update_id) && $getData[0]['answer'] == 'C' ? "selected" : '' ?> >C</option>
                                    <option value="D" <?php echo isset($update_id) && $getData[0]['answer'] == 'D' ? "selected" : '' ?> >D</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (isset($contest_id)) {
                        ?>
                        <div class="btn-group btn-group-toggle mb-2" data-toggle="buttons">
                            <label class="btn btn-primary active">
                                <input type="radio" name="change" class="change" id="option1" value="text"> Text
                            </label>
                            <label class="btn btn-primary">
                                <input type="radio" name="change" class="change" id="option2" value="image"> Image
                            </label>
                        </div>
                    <?php }
                   
                    if (isset($update_id)) {
                        $sugg = $getData[0]['suggestions'];
                        $suggestion = json_decode($sugg, true);
                    }
                    ?>

                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">A</span>
                                </div>
                                <input type="<?php
                                if (isset($update_id)) {
                                    if (filter_var($suggestion['0'], FILTER_VALIDATE_URL)) {
                                        echo 'file';
                                    } else {
                                        echo 'text';
                                    }
                                } else {
                                    echo 'text';
                                }
                                ?>" name="suggestions[]" class="form-control changetype" value="<?php echo isset($update_id) ? $suggestion['0'] : ''; ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">B</span>
                                </div>
                                <input type="<?php
                                if (isset($update_id)) {
                                    if (filter_var($suggestion['0'], FILTER_VALIDATE_URL)) {
                                        echo 'file';
                                    } else {
                                        echo 'text';
                                    }
                                } else {
                                    echo 'text';
                                }
                                ?>" name="suggestions[]" class="form-control changetype" value="<?php echo isset($update_id) ? $suggestion['1'] : ''; ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="" required>C</span>
                                </div>
                                <input type="<?php
                                if (isset($update_id)) {
                                    if (filter_var($suggestion['0'], FILTER_VALIDATE_URL)) {
                                        echo 'file';
                                    } else {
                                        echo 'text';
                                    }
                                } else {
                                    echo 'text';
                                }
                                ?>" name="suggestions[]" class="form-control changetype" value="<?php echo isset($update_id) ? $suggestion['2'] : ''; ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">D</span>
                                </div>

                                <input type="<?php
                                if (isset($update_id)) {
                                    if (filter_var($suggestion['0'], FILTER_VALIDATE_URL)) {
                                        echo 'file';
                                    } else {
                                        echo 'text';
                                    }
                                } else {
                                    echo 'text';
                                }
                                ?>" class="form-control changetype" name="suggestions[]" value="<?php echo isset($update_id) ? $suggestion['3'] : ''; ?>" required>


                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <?php
                        if (isset($update_id)) {
                            ?>
                            <button type="submit" name="update" value="update_questions" class="btn btn-primary btn-block button_submit">Update</button>   
                            <?php
                        } else {
                            ?>
                            <button type="submit" name="submit" value="<?php echo isset($contest_id) ? 'add_exam_questions' : 'add_questions'; ?>" class="btn btn-primary btn-block button_submit">Submit</button>           
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


if (isset($_SESSION['quizq']) || isset($_SESSION['add_more']) || isset($_SESSION['add_examque'])) {
    unset($_SESSION['quizq']);
    unset($_SESSION['add_more']);
    unset($_SESSION['add_examque']);
}
?>

<script>
    $(document).ready(function () {
        $(".change").on('change', function () {
            var selValue = $(".change:checked").val();
            if (selValue == 'image') {
                $('.changetype').attr('type', 'file');
            } else {
                $('.changetype').attr('type', 'text');
            }
        });
    });
</script>

