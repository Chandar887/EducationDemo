<?php
include_once("include/quiz_header.php");

if (isset($_GET['sub_category']) && $_GET['subject_name'] && $_GET['type'] && $_GET['lesson']) {
    $sub_category = $_GET['sub_category'];
    $subject_name = $_GET['subject_name'];
    $lesson = $_GET['lesson'];
//   *************** check type of study material
    if ($_GET['type'] == "ebook") {
        $type = $_GET['type'];
    } else if ($_GET['type'] == "vbook") {
        $type = $_GET['type'];
    }
    

    if (isset($_GET['parent'])) {
        $parent = $_GET['parent'];
        if ($parent == '6th To 12th') {
            $studyMaterialData = $db->selectQuery("select * from study_material where sub_category = '$sub_category' and study_type = '$type' and subject = '$subject_name' and parent_category = '$parent' and lesson = '$lesson' order by id DESC");
        } else {
            $studyMaterialData = $db->selectQuery("select * from study_material where sub_category = '$sub_category' and study_type = '$type' and parent_category = '$parent' and lesson = '$lesson' order by id DESC");
        }
    }
}

//$parentCat = $db->selectQuery("select * from edu_category where category_name = '$sub_category'");
//echo "<pre>";
//print_r($studyMaterialData);die;
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
        <div class="content">

            <?php
//            get data of study material**************************
            foreach ($studyMaterialData as $subData) {
                if ($subData['study_type'] == 'ebook' && $subData['ebook'] != "") {
                    ?>
                    <div class="card mt-4" style="width: 100%;"> 
                        <p class="card-header text-center p-0" style="font-size: 17px;"><?php echo isset($subData['description'])&&$subData['description']!="" ? $subData['description'] : "Lesson $subData[lesson]"; ?></p>
                        <a href="https://docs.google.com/gview?embedded=true&url=<?php echo $subData['ebook']; ?>" target="">
                            <div class="card-body text-center openPdf">
                                <img src="img/educationpanel/pdfimage.jpg" width="100vw" height="100vw">
                            </div> 
                        </a>
                        <div class="card-footer text-center p-0" style="font-size: 17px;"><?php echo ($subData['subject'] == '') ? $subData['sub_category'] : $subData['subject']; ?></div>
                    </div>
                    <?php
                } else if ($subData['study_type'] == 'vbook' && ($subData['embed_link']) != "") {
                    ?>
                    <div class="card mt-3 mb-2" style="width: 100%;">  
                        <p class="card-header text-center p-0" style="font-size: 17px;"><?php echo isset($subData['description'])&&$subData['description']!="" ? $subData['description'] : "Lesson $subData[lesson]"; ?></p>
                        <div class="card-body text-center">

                            <?php
                           if ($subData['embed_link'] != "") {
                                ?>
                                <div>
                                    <?php echo $subData['embed_link']; ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="card-footer text-center p-0" style="font-size: 17px;"><?php echo ($subData['subject'] == '') ? $subData['sub_category'] : $subData['subject']; ?></div>
                    </div>
                    <?php
                }
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
            $('.content').append('<div class="my-3"><p class="alert text-center" style="color: white; background-color: #e03c3c;;border-color: #e03c3c;">No Content Available!</p></div>');
        }

        $('iframe').css("width", "100%");

    });
</script>




