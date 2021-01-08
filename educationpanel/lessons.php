<?php
include_once("include/quiz_header.php");

if (isset($_GET['sub_category']) && $_GET['subject_name'] && $_GET['type']) {
    $sub_category = $_GET['sub_category'];
    $subject_name = $_GET['subject_name'];

//   *************** check type of study material
    if ($_GET['type'] == "ebook") {
        $type = $_GET['type'];
    } else if ($_GET['type'] == "vbook") {
        $type = $_GET['type'];
    }

    if (isset($_GET['parent'])) {
        $parent = $_GET['parent'];
        if ($parent == '6th To 12th') {
            $studyMaterialData = $db->selectQuery("select DISTINCT lesson from study_material where sub_category = '$sub_category' and study_type = '$type' and subject = '$subject_name' and parent_category = '$parent'");
        } else {
            $studyMaterialData = $db->selectQuery("select DISTINCT lesson from study_material where sub_category = '$sub_category' and study_type = '$type' and parent_category = '$parent'");
        }
    }
}
?>

<style>
    body {background: url('img/educationpanel/body-back.jpg'); background-size: cover;}
    .card-header {
        background-color: #007bff;
        color: white;
        font-size: 21px;
    }
</style>

<section>
    <div class="col-12 bg-primary text-white p-2">
        <div class="container">
            <div class="row d-flex justify-content-around">
                <a href="index.php" class="ml-2 text-white" style="font-size:6vw;"><b><?php echo $parent; ?></b><span class="ml-1"><i class="fa fa-edit"></i></span></a>
                <!--<h5 class=""><?php echo $sub_category; ?><a href="study_type.php?sub_category=<?php echo $sub_category; ?> && subject_name=<?php echo $subject_name; ?> && board=<?php echo ($studyMaterialData[0]['board']) ? $studyMaterialData[0]['board'] : 'PSEB'; ?>" class="ml-2 text-white"><i class="fa fa-edit"></i></a></h5>-->
            </div>
        </div>
    </div>
</section>


<section>
    <div class="col-12">
        <div class="row mt-3 content">
            <?php
            $x = 0;
//            get data of study material**************************
            foreach ($studyMaterialData as $subData) {
                $x++;
                ?>
                <div class="col-6 text-center gotovideos <?php echo ($x > 2) ? 'mt-2' : ''; ?>" lesson="<?php echo $subData['lesson']; ?>" sub_category="<?php echo $sub_category; ?>" subject_name="<?php echo $subject_name; ?>" type="<?php echo $type; ?>" parent="<?php echo $parent; ?>">
                    <h6 class="my-auto bg-primary rounded text-white p-2">Lesson <?php echo $subData['lesson']; ?></h6>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>
<?php
include_once("include/quiz_footer.php");
?>

<script>
    $(document).ready(function ()
    {
        if ($('.content *').length === 0) {
            $('.content').append('<div class="my-3 w-75 mx-auto"><p class="alert text-center" style="color: white; background-color: #e03c3c;;border-color: #e03c3c;">No Content Available!</p></div>');
        }

        $('iframe').css("width", "100%");

//        go to study material page 
        $('.gotovideos').click(function ()
        {
            var ele = $(this);
            var sub_category = ele.attr('sub_category');
            var subject_name = ele.attr('subject_name');
            var type = ele.attr('type');
            var parent = ele.attr('parent');
            var lesson = ele.attr('lesson');

            window.location = "study_material.php?sub_category=" + sub_category + "& subject_name=" + subject_name + "& type=" + type + "& parent=" + parent + "& lesson=" + lesson;
        });
    });
</script>




