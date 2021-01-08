<?php
include_once('include/quiz_header.php');

if (isset($_GET['parent_category']) && $_GET['parent_category'] != "") {
    $parent_category = $_GET['parent_category'];

    $getparent = $db->selectQuery("select * from edu_category where parent_category = '$parent_category'");
//    print_r($getboard);die;
}
?>

<style>
    .card-header {
        background-color: #007bff;
        color: white;
        font-size: 22px;
        font-weight: bold;
        padding: 0px;
    }
    .card-body {
        padding: 8px;
        background-color: white;
    }
</style>

<section>
    <div class="col-12 mt-3">
        <?php
        if ($getparent[0]['demo'] != "") {
            foreach ($getparent as $data) {
                ?>
                <div class="card text-white bg-info mb-3" style="max-width: 100%;">
                    <div class="card-header text-center"><?php echo $data['category_name']; ?></div>
                    <div class="card-body text-center">
                        <a href="<?php echo $data['demo']; ?>" class="btn btn-success mb-3">Watch Video</a>
                    </div>
                </div>


                <?php
            }
        } else {
            ?>
            <div class="my-3"><p class="alert text-center" style="color: white; background-color: #e03c3c;;border-color: #e03c3c;">Demo Videos Are Not Available!</p></div>
            <?php
        }
        ?>
    </div>
</section>



<?php
include_once('include/quiz_footer.php');
?>
