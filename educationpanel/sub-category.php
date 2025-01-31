<?php
include_once('include/quiz_header.php');

if (isset($_GET['parent_category']) && $_GET['parent_category'] != "") {
    $parent_category = $_GET['parent_category'];
    $catData = $db->selectQuery("select * from edu_category where category_name = '$parent_category'");
//    print_r($catData);die;
}
?>

<style>
    .jconfirm-box{
        border: 8px solid #007bff;
        background: #f8f9fa;
        text-align: center;
    }

    /*    .rounded-pill_shadow {
            box-shadow: 0px 3px 7px 2px #0c080838;
        }*/

    .jconfirm.jconfirm-light .jconfirm-box .jconfirm-buttons{
        float:none;
    }
</style>

<section>
    <div class="col-12 bg-primary p-2 text-white">
        <div class="container-fluid">
            <div class="row">
                <img src="<?php echo $catData[0]['cat_image']; ?>" class="rounded-circle" style="width: 18vw; height: 18vw;">
                <a href="index.php" class="my-auto ml-4 text-white" style="font-size:6vw;"><b><?php echo $parent_category; ?></b><span class="ml-1"><i class="fa fa-edit"></i></span></a>
                <!-- <a href="index.php" class="mt-2 ml-auto">Change</a> -->
            </div>
        </div> 
    </div>   
    <?php
    if ($sub_catData = $db->selectQuery("select * from edu_category where parent_category = '$parent_category' order by id ASC")) {
        ?>
        <div class="col-12">
            <div class="container-fluid">
                <div class="rounded bg-light mt-3" style="border-left: 10px solid #007bff;">
                    <h5 class="text-center my-auto p-1"><b><?php echo ($catData[0]['category_name'] == '6th To 12th') ? 'SUB CATEGORIES' : 'SUBJECTS'; ?></b></h5>
                </div>

                <div class="row mt-3">
                    <!--d-flex justify-content-around-->
                    <?php
                    $x = 0;
                    foreach ($sub_catData as $data) {
                        $x++;
                        ?>
                        <div class="col-6 text-center <?php echo ($parent_category == '6th To 12th') ? '' : 'subcat'; ?> <?php echo ($x > 2) ? 'mt-2' : ''; ?>" sub-category="<?php echo $data['category_name']; ?>">

                            <?php
//                            and type='coursepurchase'
                            $check_purchaseCourse_byUser = $db->countRows("w_user_coins", "uID='{$userData['ID']}' and roomID='{$data['id']}' and review='purchaseCourse' and type='coursepurchase'");
                            ?>
                            <span class="<?php echo ($parent_category == '6th To 12th') ? 'bg-success text-white rounded' : 'd-none'; ?>" style="font-size: 14px; padding-left: 3px;padding-right: 3px; float:right;">
                                <?php echo ($check_purchaseCourse_byUser == 0) ? $parent_category == '6th To 12th' ? '₹' . $data['course_amount'] : "" : "Owned"; ?>
                            </span>
                            <?php
                            $subcatt = $data['category_name'];
                            $getSubcategories = $db->selectQuery("select * from `study_material` where parent_category = '$parent_category' and sub_category='$subcatt'");
                            $array = array();
                            $i = 0;
                            foreach ($getSubcategories as $subcat) {
                                $array[] = array($subcat['subject'] => $subcat['demo']);
                                $i++;
                            }
                            $cat_demo = json_encode($array);
                            ?>

                            <h6 class="my-auto bg-primary rounded text-white p-2 <?php echo ($parent_category == '6th To 12th') ? ($check_purchaseCourse_byUser == 0) ? 'purchaseCourse' : 'course_purchased' : ''; ?>" classes='<?php echo $cat_demo; ?>' amount="<?php echo $data['course_amount']; ?>" class-id="<?php echo $data['id']; ?>" class-name="<?php echo $data['category_name']; ?>"><?php echo $data['category_name']; ?></h6>
                        </div>
                    <?php }
                    ?>
                </div>
                <?php
            } else {
                ?>
                <h6 class="text-danger mt-3 text-center">No Sub Categories Available!</h6> 
                <?php
            }
            ?>
        </div> 
    </div> 
</section>

<?php
include_once('include/quiz_footer.php');
?>


<script type="text/javascript">
    $(document).ready(function ()
    {
        $('body').on('click', '.purchaseCourse', function ()
        {
            var ele = $(this);
            var class_id = ele.attr('class-id');
            var class_name = ele.attr('class-name');
            var amount = ele.attr('amount');
            var user_id = '<?php echo $userData['ID']; ?>';
            var classes = ele.attr('classes');
            var obj = jQuery.parseJSON(classes);
            var demo = "";
            if (Object.keys(obj).length > 0) {

                demo = "<div class='col-12 p-2 my-2 border'><div class='h5 text-center' style='letter-spacing:2px'>DEMO</div>";

                console.log(obj);
                $.each(obj, function (kk, vv) {
                    var key = Object.keys(vv)[0];
                    var value = Object.values(vv)[0];
                    value = value === null ? "#" : value;
                    console.log(key + "====" + value);
                    if (value != "") {
                        demo += "<a href=" + value + " class='btn btn-sm m-1 btn-success btn-inline' target='_blank'>" + key + "</a>";
                    }
                });

                demo += "</div>";
            }

            //            console.log(amount);
            $.confirm({
                title: "<div class='pt-2 pb-2 pr-3 pl-3'><h6 class='my-auto'>Want to Purchase Course?</h6></div>",
                content: "<div class='text-center text-primary' style=margin-bottom:-20px;'><b style='font-size: 45px;'>₹" + amount + "</b></div><hr class='w-50 mx-auto'><br><div class='text-center text-primary' style='margin-top: -37px; margin-bottom:-20px;'><b style='font-size: 25px;'>" + class_name + "</b></div><br><small>The Amount will be debited from your account.</small> " + demo + " ",
                //                title: 'Want to Purchase Course?',
                //                content: '<small>The Course Amount <b style="font-size: 16px;color: #e42929;">Rs.' + amount + '</b> will be debited from your account.</small>',
                closeIcon: true,
                buttons: {
                    Pay: {
                        text: 'PURCHASE NOW',
                        btnClass: 'btn-primary',
                        action: function () {


                            $.ajax({
                                type: "POST",
                                url: "controller/ajaxcontroller.php",
                                data: {class_id: class_id, user_id: user_id, req_type: "schoolCourse"},
                                //                            dataType: "json",
                                success: function (data) {
                                    var obj = jQuery.parseJSON(data);
                                    //                                alert(data);
                                    console.log(obj.data);
                                    if (obj.data == 0)
                                    {
                                        $.alert('Not Enough Coins!');
                                    } else if (obj.data == 1)
                                    {

                                        $.confirm({
                                            title: 'Congratulations!',
                                            content: '<small>Course Purchased Successfully!</small>',
                                            type: 'green',
                                            typeAnimated: true,
                                            buttons: {
                                                yes: {
                                                    text: 'OK',
                                                    btnClass: 'btn-green',
                                                    action: function () {
                                                        window.location = "board.php?sub_category=" + class_name;

                                                    }
                                                },
                                                //                                            close: function () {
                                                //                                            }
                                            }
                                        });
                                    }
                                }
                            });
                        }
                    },
//                   
                    //                    Cancel: function () {
                    //
                    //                    }

                }
            });
        });
        //        course purchased
        $('.course_purchased').click(function ()
        {
            var ele = $(this);
            var class_name = ele.attr('class-name');
            window.location = "board.php?sub_category=" + class_name;
        });

        
//        direct go to e-book v-book page
        $('body').on('click', '.subcat', function ()
        {
            var ele = $(this);
            var sub_category = ele.attr('sub-category');
            var parentCat = '<?php echo $parent_category; ?>';

            window.location = "study_type.php?subjct_name=" + sub_category + "& parent_category=" + parentCat;
            //            }

        });
    });
</script>
