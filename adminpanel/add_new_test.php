<?php
$title = "Add Practice Test";
$apage = "addnewtest";
include_once('header.php');

$categories = array();

if ($tcat = $db->selectQuery("select * from test_category where cat_parent='0'")) {
//    $categories=$db->orderCategory($tcat);
    foreach ($tcat as $cat1) {
        $categories[$cat1['ID']] = $cat1;
        $categories[$cat1['ID']]['child'] = array();
        if ($tcat2 = $db->selectQuery("select * from test_category where cat_parent='{$cat1['ID']}'")) {
            foreach ($tcat2 as $cat2) {
                $categories[$cat1['ID']]['child'][$cat2['ID']] = $cat2;
                $categories[$cat1['ID']]['child'][$cat2['ID']]['child'] = array();
                if ($tcat3 = $db->selectQuery("select * from test_category where cat_parent='{$cat2['ID']}'")) {
                    foreach ($tcat3 as $cat3) {
                        $categories[$cat1['ID']]['child'][$cat2['ID']]['child'][$cat3['ID']] = $cat3;
                        $categories[$cat1['ID']]['child'][$cat2['ID']]['child'][$cat3['ID']]['child'] = array();
                        if ($tcat4 = $db->selectQuery("select * from test_category where cat_parent='{$cat3['ID']}'")) {
                            foreach ($tcat4 as $cat4) {
                                $categories[$cat1['ID']]['child'][$cat2['ID']]['child'][$cat3['ID']]['child'][$cat4['ID']] = $cat4;
                            }
                        }
                    }
                }
            }
        }
    }
//    echo"<pre>";
//    print_r($categories);
//    die;
}
?>

<div class="container-fluid">
    <div class="row">

        <main role="main" class="col-md-12 pt-3">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">

                <h1 class="h2"><i class="fa fa-"></i><?php echo isset($update_id) ? 'Update' : 'Add'; ?> Practice Test</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a class="btn btn-primary ml-1" href="view_all_test.php"><i class="fa fa-list pr-2"></i>Tests List</a> 
                </div>
            </div>


            <div class="col-12 col-md-8 mx-auto">

                <?php
                if (isset($_SESSION['test_created'])) {
                    ?>
                    <p class="alert alert-success"><?php echo $_SESSION['test_created']; ?></p>
                    <?php
                }
                ?>

                <!-- MultiStep Form -->
                <div class="container-fluid" id="grad1">

                    <div class="row justify-content-center mt-0">
                        <!--<div class="col-11 col-sm-9 col-md-7 col-lg-6 text-center p-0 mt-3 mb-2">-->
                        <div class="card px-0 pb-0 mb-3">

                            <div class="row">
                                <div class="col-md-12 mx-0">
                                    <form action="controller/test_controller.php"  id="msform" class="border rounded p-4 submitform">
                                        <!-- progressbar -->
                                        <ul id="progressbar">
                                            <li class="active" id="account"><strong>Add Test Details</strong></li>
                                            <li id="personal"><strong>Select Sub Categories</strong></li>
                                            <li id="payment"><strong>Add Questions</strong></li>
                                            <!--<li id="confirm"><strong>Finish</strong></li>-->
                                        </ul> 
                                        <!-- fieldsets -->

                                        <!-- STEP 1 Add Test Details section-->
                                        <fieldset id="test_details">
                                            <div class="form-card">
                                                <h2 class="fs-title">Add Test Details</h2>
                                                <p id="err" class="alert alert-danger d-none"></p>
                                                <div class="form-group">
                                                    <label for="Test Title">Test Title<span class="required">*</span></label>
                                                    <input type="text" name="test_title" id="test_title" class="form-control" required=""/>
                                                </div>

                                                <div class="form-group">
                                                    <select class="selectpicker form-control" id="categories" multiple data-live-search="true">
                                                        <?php
                                                        foreach ($categories as $childCat) {
                                                            ?>
                                                            <option value="<?php echo $childCat['ID']; ?>"><?php echo $childCat['cat_name']; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="Set Test Duration">Set Test Duration(In Minutes)<span class="required">*</span></label>
                                                    <input type="number" class="form-control" name="duration" id="duration" required=""/> 
                                                </div>
                                            </div> 
                                            <input type="button" name="next" class="next action-button" value="Next Step" />
                                        </fieldset>
                                        <!-- end section-->


                                        <!--STEP 2 Select Sub Categories section-->
                                        <fieldset id="subcategories">
                                            <div class="form-card">
                                                <h2 class="fs-title">Sub Categories</h2> 
                                                <div id="subcatlist"></div>
                                            </div>
                                            <input type="button" name="previous" class="previous action-button-previous" value="Previous" /> 
                                            <input type="button" name="next" class="next action-button" value="Next Step" />
                                        </fieldset>
                                        <!--end section-->


                                        <!--STEP 3 Add Questions section-->
                                        <fieldset id="testquestions">
                                            <div class="form-card">
                                                <h2 class="fs-title">Add Questions</h2>
                                                <div id="addquestions"></div>
                                            </div> 
                                            <input type="button" name="previous" class="previous action-button-previous" value="Previous" /> 
                                            <button type="submit" name="submit" id="addtest" class="next action-button" value="addtest">Confirm</button>
                                        </fieldset>
                                        <!--end section-->


                                        <!--STEP 4 success message section-->
                                        <!--                                        <fieldset id="success">
                                                                                    <div class="form-card">
                                                                                        <h2 class="fs-title text-center">Success !</h2> <br><br>
                                                                                        <div class="row justify-content-center">
                                                                                            <div class="col-3"> <img src="https://img.icons8.com/color/96/000000/ok--v2.png" class="fit-image"> </div>
                                                                                        </div> <br><br>
                                                                                        <div class="row justify-content-center">
                                                                                            <div class="col-7 text-center">
                                                                                                <h5>Test Created Successfully!</h5>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </fieldset>-->
                                        <!--end section-->

                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--</div>-->
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>    




<?php
if (isset($_SESSION['test_created'])) {
    unset($_SESSION['test_created']);
}


include_once('footer.php');
?>

<script>
    var categories = JSON.parse('<?php echo json_encode($categories) ?>');
    $(document).ready(function () {

        var current_fs, next_fs, previous_fs; //fieldsets
        var opacity;
//        alert(JSON.stringify(categories));
        $(".next").click(function () {

            var title = $('#test_title').val();
            var categoies = $('#categories').val();
            var duration = $('#duration').val();

            if (title != '' && categoies != '' && duration != '') {

                $('#err').addClass('d-none');
                current_fs = $(this).parent();
                next_fs = $(this).parent().next();

//Add Class Active
                $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

//show the next fieldset
                next_fs.show();
//hide the current fieldset with style
                current_fs.animate({opacity: 0}, {
                    step: function (now) {
// for making fielset appear animation
                        opacity = 1 - now;

                        current_fs.css({
                            'display': 'none',
                            'position': 'relative'
                        });
                        next_fs.css({'opacity': opacity});
                    },
                    duration: 600
                });

            } else {
                $('#err').removeClass('d-none');
                $('#err').html('All Fields Are Required!');
            }

        });

        $(".previous").click(function () {

            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

//Remove class active
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

//show the previous fieldset
            previous_fs.show();

//hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
                step: function (now) {
// for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    previous_fs.css({'opacity': opacity});
                },
                duration: 600
            });
        });

        $('.radio-group .radio').click(function () {
            $(this).parent().find('.radio').removeClass('selected');
            $(this).addClass('selected');
        });
//
        $(".submit").click(function () {
            return false;
        });


//        select sub categories fieldset
        $('select').selectpicker();

        $('.selectpicker').on('change', function () {
            var selected_cat = $(this).val();

            var list = "";
            $.each(selected_cat, function (ii, cc) {
//            console.log(categories);
                list += "<div class='pl-2 my-3'>";
                list += "<p class='h4' style='border-bottom:1px solid'>" + categories[cc]['cat_name'] + "</p>";
                list += '<input type="checkbox" class="form-check-input d-none catselect selectedcats-' + categories[cc]['ID'] + '" id="cat1-' + ii + '" value="' + categories[cc]['ID'] + '" checked>'
                $.each(categories[cc]['child'], function (iii, ccc) {
                    list += '<div class="form-check">'
                    list += '<input type="checkbox" class="form-check-input catselect selectedcats-' + ccc['ID'] + '" id="cat1-' + iii + '" value="' + ccc['ID'] + '">'
                    list += '<label class="form-check-label subcat-' + ccc['ID'] + '" style="margin-top: 1px;" for="cat1-' + iii + '">' + ccc['cat_name'] + '</label>'
                    list += '</div>'

                    list += "<div id='catbox-" + ccc['ID'] + "' class='catbox-" + ccc['ID'] + " d-none' style='margin-left:24px'>";
                    $.each(ccc['child'], function (iii2, ccc2) {
                        list += '<div class="form-check">'
                        list += '<input type="checkbox" class="selectedcats-' + ccc2['ID'] + ' form-check-input catselect cat-' + ccc['ID'] + '" id="cat2-' + iii2 + '" value="' + ccc2['ID'] + '">'
                        list += '<label class="form-check-label subcat-' + ccc2['ID'] + '" style="margin-top: 1px;" for="cat2-' + iii2 + '">' + ccc2['cat_name'] + '</label>'
                        list += '</div>'

                        list += "<div id='catbox-" + ccc2['ID'] + "' class='catbox-" + ccc['ID'] + " catbox-" + ccc2['ID'] + " d-none' style='margin-left:40px'>";
                        $.each(ccc2['child'], function (iii3, ccc3) {
                            list += '<div class="form-check">'
                            list += '<input type="checkbox" class="selectedcats-' + ccc3['ID'] + ' form-check-input catselect cat-' + ccc['ID'] + ' cat-' + ccc2['ID'] + '" id="cat3-' + iii3 + '" value="' + ccc3['ID'] + '">'
                            list += '<label class="form-check-label subcat-' + ccc3['ID'] + '" style="margin-top: 1px;" for="cat3-' + iii3 + '">' + ccc3['cat_name'] + '</label>'
                            list += '</div>'
                        });
                        list += "</div>";
                    });
                    list += "</div>";
                });
                list += "</div>";
            });
            $("#subcatlist").html(list);
        });

        $('#subcatlist').on('change', '.catselect', function () {
            var catid = $(this).val();

            if (this.checked) {
                $("#catbox-" + catid).removeClass("d-none");
            } else {
                $(".catbox-" + catid).addClass("d-none");
                $('.cat-' + catid).prop('checked', false);
            }
        });


        $('#subcatlist').on('change', '.catselect', function () {
            var selected_cat = $(this).val();
//            alert(selected_cat);
//            var questions = "";

            var subb = [];
            $(".catselect:checked").each(function () {
                subb.push($(this).val());
            });
//            console.log(subb);
//             alert(subb);
            var questions = "";
            questions += "<div class='my-3'>";

//                console.log("status=>"+($.inArray(cc.ID, subb)!=-1));
//                console.log("sub=>"+ subb);
//                console.log("ID=>"+cc.ID);
//                console.log("----------------------")

            $.each(categories, function (ii, cc) {
//                FIRST LEVEL
                if ($.inArray(cc.ID, subb) != -1) {

                    questions += '<div class="form-group form-inline">'
                    questions += '<label for="Questions">' + cc.cat_name + '</label>'
                    var child = Object.keys(categories[cc.ID]['child']);
//                    console.log("check child =>"+child);
                    if ($.inArray(child[0], subb) == -1) {
                        questions += '<input type="number" name="cat_que[' + cc.cat_sku + ']" class="form-control" value="" required=""/>'
                    }
                    questions += '</div>'


                    $.each(categories[cc.ID]['child'], function (ii2, cc2) {
//                        console.log(subb);
//                        console.log(cc2.ID+"=>"+$.inArray(cc2.ID, subb));
//                            SECOND LEVEL
                        if ($.inArray(cc2.ID, subb) != -1) {
                            questions += '<div class="form-group form-inline ml-2">'
                            questions += '<label for="Questions">' + cc2.cat_name + '</label>'
                            if ([cc2.ID] != "" && Object.keys(categories[cc.ID]['child'][cc2.ID]['child']).length == 0) {
                                questions += '<input type="number" name="cat_que[' + cc.cat_sku + '][' + cc2.cat_sku + ']" class="form-control" value="" required=""/>'
                            }
                            questions += '</div>'

                            $.each(categories[cc.ID]['child'][cc2.ID]['child'], function (ii3, cc3) {
//                                     THIRD LEVEL   
                                if ($.inArray(cc3.ID, subb) != -1) {
                                    questions += '<div class="form-group form-inline ml-3">'
                                    questions += '<label for="Questions">' + cc3.cat_name + '</label>'
                                    if ([cc3.ID] != "" && Object.keys(categories[cc.ID]['child'][cc2.ID]['child'][cc3.ID]['child']).length == 0) {
                                        questions += '<input type="number" name="cat_que[' + cc.cat_sku + '][' + cc2.cat_sku + '][' + cc3.cat_sku + ']" class="form-control" value="" required=""/>'
                                    }

                                    questions += '</div>'


                                    $.each(categories[cc.ID]['child'][cc2.ID]['child'][cc3.ID]['child'], function (ii4, cc4) {
//                                       FOURTH LEVEL
                                        if ($.inArray(cc4.ID, subb) != -1) {
                                            questions += '<div class="form-group form-inline ml-4">'
                                            questions += '<label for="Questions">' + cc4.cat_name + '<span class="required">*</span></label>'
                                            questions += '<input type="number" name="cat_que[' + cc.cat_sku + '][' + cc2.cat_sku + '][' + cc3.cat_sku + '][' + cc4.cat_sku + ']" class="form-control" value="" required=""/>'
                                            questions += '</div>'
                                        }
                                    });
                                }
                            });
                        }
                    });
                }

            });
//
            questions += "</div>";
//
            $("#addquestions").html(questions);
        });


//        $('#addtest').click(function(){
//            $('#submitform').submit();
//        });

    });
</script>

