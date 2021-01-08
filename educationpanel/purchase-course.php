<?php
include_once("include/quiz_header.php");

if (isset($_GET['parent_category'])) {
    $parent_category = $_GET['parent_category'];
    
}
?>

<div class="col-12">
    <div class="container-fluid">
        <h4 class="my-3 text-center">PURCHASE COURSE</h4>
        <div class="bg-primary p-4 text-center rounded">
            <h5 class=" text-white">Purchase Course</h5>
        </div>
    </div> 
</div>   

<?php
include_once("include/quiz_footer.php");
?>


