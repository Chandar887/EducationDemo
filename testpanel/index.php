<?php
include_once("include/quiz_header.php");
//echo $user_id = $userData['ID'];die;
//   if(isset($_SESSION['stop_back']))
//    {
//       echo "<script type='text/javascript'> document.location = 'user_start_quiz.php'; </script>";
//        exit;
//    }
?>

<style type="text/css"> 
    .table.table-hover>thead>tr>td, .table.table-hover>thead>tr>th {
        border-top: 1px solid #F5F5F5;
        font-size: 14px;
        color: black;
        padding: 15px 15px;
    }

    .table.table-hover>tbody>tr>td, .table.table-hover>tbody>tr>td {
        border-top: 1px solid #F5F5F5;
        font-size: 14px;
        color: black;
        padding: 15px 15px; 
    }

    .show {
        display: block;
    }


    .card.text-white.bg-white.mb-2.test {
        box-shadow: 1px 1px 4px #000000;
    }

    .grey-bg {  
        background-color: #F5F7FA;
    }
    .card{
        border: 2px solid #007bff;
        border-radius: 12px;
        background-color: #f1f1f1;
    }
</style>

<!--<div class="container">-->

<section>

    <div id="demo" class="carousel slide" data-ride="carousel">
        <!--Indicators--> 
        <ul class="carousel-indicators">
            <li data-target="#demo" data-slide-to="0" class="active"></li>
            <li data-target="#demo" data-slide-to="1"></li>
            <li data-target="#demo" data-slide-to="2"></li>
        </ul>

        <!--The slideshow--> 
        <div class="carousel-inner">
            <?php
            $data = $db->selectQuery("select * from w_slider_images where type = 'quizpanel'");

            foreach ($data as $slider) {
                ?>
                <div class="carousel-item active">
                    <img src="<?php echo $db->site . "/EducationDemo/" . $slider['img1']; ?>" class="banner_img">
                </div>
                <div class="carousel-item">
                    <img src="<?php echo $db->site . "/EducationDemo/" . $slider['img2']; ?>" class="banner_img">
                </div>
                <?php if ($slider['img3'] != "") {
                    ?>
                    <div class="carousel-item ">
                        <img src="<?php echo $db->site . "/EducationDemo/" . $slider['img3']; ?>" class="banner_img">
                    </div>
                    <?php
                }
                if ($slider['img4'] != "") {
                    ?>
                    <div class="carousel-item ">
                        <img src="<?php echo $db->site . "/EducationDemo/" . $slider['img4']; ?>" class="banner_img">
                    </div>
                    <?php
                }
            }
            ?>

        </div>

    </div>
</section>

<!--</div>-->

<!-- view all contests -->

<?php
if (isset($_SESSION["ludouser"])) {
    $user_id = $_SESSION["ludouser"]["ID"];
}
?>

<!-- all practice contests -->

<section>
    <div class="container-fluid">
        <div class="col-md-12 col-12">
            <h4 class="text-center py-2">All Practice Test</h4>


            <?php
            $getcatData = $db->selectQuery("select * from practice_test where status=0 order by ID DESC");
            $x = 0;
            foreach ($getcatData as $testData) {
                ?>
                <div class="col-xl-3 col-sm-6 col-12 mb-3 p-0 test" test-id="<?php echo $testData['ID']; ?>" user-id="<?php echo $userData['ID']; ?>"> 
                    <div class="card p-2">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <i class="fa fa-list-alt text-primary" style="font-size: 40px;"></i>
                                    </div>
                                    <div class="media-body text-right">
                                        <h4><?php echo $testData['duration']; ?> Mins</h4>
                                        <span style="font-size: 14px;"><?php echo $testData['test_title']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <?php
                $x++;
            }
            ?>
        </div>
    </div>
</section>
<?php
include_once('include/quiz_footer.php');
?>

<script>
    $(document).ready(function () {
        $('.test').click(function ()
        {
            var ele = $(this);
//            var test_id = ele.attr('test-id');
            var test_id = ele.attr('test-id');
            var user_id = ele.attr('user-id');
//            alert(test_cats);
            $.ajax({
                type: 'POST',
                url: 'controller/ajaxcontroller',
                data: {test_id: test_id, user_id: user_id, req_type: "start_practice_test"},
                success: function (data) {
//                   alert(data);
                    var obj = JSON.parse(data);
                    if (obj.data == 1) {
                        window.location = "test_type.php?test_id=" + test_id;
                    } else {
                        $.alert('Test Already Attempted!');
                    }
                }
            });
        });
    });
</script>


