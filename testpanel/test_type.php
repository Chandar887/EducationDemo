<?php
include_once('include/quiz_header.php');
//    
?>

<div class="container-fluid">

    <?php
    if (isset($_GET['test_id']) && $_GET['test_id']!="") {
        $test_id = $_GET['test_id'];
    } else {
        echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
        exit;
    }
    ?>

    <div class="col-12">
        <div class="rounded bg-light mt-3" style="border-left: 10px solid #007bff;">
            <h5 class="text-center my-auto p-1"><b>Test Attempt Type</b></h5>
        </div>

        <div class="row mt-4">
            <div class="col-6 text-center teststart" test-type="singleque" test-id="<?php echo $test_id; ?>">
                <h6 class="my-auto bg-primary rounded text-white p-2">Single Question</h6>
            </div>

            <div class="col-6 text-center teststart" test-type="modeltest" test-id="<?php echo $test_id; ?>">
                <h6 class="my-auto bg-primary rounded text-white p-2">Model Test Paper</h6>
            </div>
        </div>
    </div>
    <?php
    require_once('include/quiz_footer.php');
    ?>  

   
    <script>
        $(document).ready(function ()
        {
            $('.teststart').click(function ()
            {
                var ele = $(this);
                var test_id = ele.attr('test-id');
                var test_type = ele.attr('test-type');
                     window.location = "start_test.php?test_id=" +test_id+"&test_type=" +test_type;
               
            });
        });
    </script>

