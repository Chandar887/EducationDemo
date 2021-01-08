<?php

if (!isset($db)) {
    include_once '../../database.php';
}


//delete study material category
if (isset($_REQUEST['req_type']) && $_REQUEST['req_type'] == "delete_category") {
    $cat_id = $_REQUEST['cat_id'];
    $subcat = $db->selectQuery("select category_name,parent_category,cat_image from edu_category where id = '$cat_id'");
    $subcatName = $subcat[0]['category_name'];
    $parent = $subcat[0]['parent_category'];

//    delete pdf files from upload folder
    $getPdfs = $db->selectQuery("select ebook from study_material where parent_category = '$parent' and sub_category = '$subcatName'");
    foreach ($getPdfs as $ebook) {
        if (isset($ebook['ebook']) && $ebook['ebook'] != '') {
            $url = parse_url($ebook['ebook']);
            $pdf = str_replace('/ludonew/', '', $url['path']);

            $remove = $db->imageRemove('../../' . $pdf);
        }
    }

//    echo $remove;die;
//    echo $parent;
    if ($db->deleteData("study_material", "sub_category='{$subcatName}' and parent_category='{$parent}'")) {
        $db->deleteData("edu_category", "id='{$cat_id}'");

        $response['data'] = 1;
    } else {
        $response['data'] = 0;
    }
    echo json_encode($response);
}

//delete whole parent category with sub categories
if (isset($_REQUEST['req_type']) && $_REQUEST['req_type'] == "deleteparent") {
    $cat_id = $_REQUEST['cat_id'];

    $parentName = $db->selectQuery("select category_name,cat_image from edu_category where id = '$cat_id'");
    $data = $parentName[0];
    $parent = $data['category_name'];

    if (isset($data['cat_image']) && $data['cat_image'] != '') {
        $url = parse_url($data['cat_image']);

        $img = str_replace('/ludonew/', '', $url['path']);

        if ($img != 'uploads/edu_quiz/video_thumb.png') {
            $db->imageRemove('../../' . $img);
        }
    }

//     echo $remove;die;
    if ($db->deleteData("edu_category", "parent_category='{$parent}'")) {

//        delete pdf files from upload folder
        $getPdfs = $db->selectQuery("select ebook from study_material where parent_category = '$parent'");
        foreach ($getPdfs as $ebook) {
            if (isset($ebook['ebook']) && $ebook['ebook'] != '') {
                $url = parse_url($ebook['ebook']);
//                print_r($url);
//                die;
                $pdf = str_replace('/ludonew/', '', $url['path']);
                $db->imageRemove('../../' . $pdf);
            }
        }

        $db->deleteData("study_material", "parent_category='{$parent}'");
        $db->deleteData("edu_category", "category_name='{$parent}'");
        $response['data'] = 1;
    } else {
        $response['data'] = 0;
    }
    echo json_encode($response);
}


//delete study material table row data
if (isset($_REQUEST['req_type']) && $_REQUEST['req_type'] == "deletestudy") {
    $study_id = $_REQUEST['study_id'];

//    delete pdf file from uploads folder
    $getPdfs = $db->selectQuery("select ebook from study_material where id = '$study_id'");

    if (isset($getPdfs[0]['ebook']) && $getPdfs[0]['ebook'] != '') {
        $url = parse_url($getPdfs[0]['ebook']);
        $pdf = str_replace('/ludonew/', '', $url['path']);
        $db->imageRemove('../../' . $pdf);
    }

    if ($db->deleteData("study_material", 'id' . '=' . $study_id)) {
        $response['data'] = 1;
    } else {
        $response['data'] = 0;
    }
    echo json_encode($response);
}


//delete live class table row data
if (isset($_REQUEST['req_type']) && $_REQUEST['req_type'] == "delliveclass") {
    $class_id = $_REQUEST['class_id'];

    $liveClassImg = $db->selectQuery("select thumbnail from live_class_data where id = '$class_id'");

    if (isset($liveClassImg[0]['thumbnail']) && $liveClassImg[0]['thumbnail'] != '') {
        $url = parse_url($liveClassImg[0]['thumbnail']);
//        print_r($url);die;
        $img = str_replace('/ludonew/', '', $url['path']);
        $db->imageRemove('../../' . $img);
    }

    if ($db->deleteData("live_class_data", 'id' . '=' . $class_id)) {
        $response['data'] = 1;
    } else {
        $response['data'] = 0;
    }

    echo json_encode($response);
}

//delete question
if (isset($_REQUEST['req_type']) && $_POST['req_type'] == "live_que_deletion") {
    $question_id = $_REQUEST['question_id'];
//    echo $question_id;die;
    if ($db->deleteData("live_class_que", "id=" . $question_id)) {
        $response['data'] = 1;
    } else {
        $response['data'] = 0;
    }
}



//delete exam contest from quizpanel
if (isset($_REQUEST['req_type']) && $_POST['req_type'] == "delete_exam_contest") {
    $contest_id = $_REQUEST['contest_id'];
//    echo $question_id;die;
    if ($db->deleteData("exam_contest", "id=" . $contest_id)) {
        $response['data'] = 1;
    } else {
        $response['data'] = 0;
    }
}


//delete exam contest category
if (isset($_REQUEST['req_type']) && $_REQUEST['req_type'] == "delete_exam_category") {
    $cat_id = $_REQUEST['cat_id'];

    if ($db->deleteData("quiz_category", 'id' . '=' . $cat_id)) {
        $response['data'] = 1;
    } else {
        $response['data'] = 0;
    }
    echo json_encode($response);
}


//PRACTICE TEST SECTION
//DELETE CATEGORY
if (isset($_REQUEST['req_type']) && $_REQUEST['req_type'] == "delete_test_category") {

    $cat_id = $_REQUEST['cat_id'];
//    echo $cat_id;die;
    if ($db->deleteData("test_category", 'cat_parent' . '=' . $cat_id)) {
        $db->deleteData("test_category", 'ID' . '=' . $cat_id);
        $response['data'] = 1;
    } else {
        $response['data'] = 0;
    }
    echo json_encode($response);
}

//delete test question
if (isset($_REQUEST['req_type']) && $_REQUEST['req_type'] == "delete_test_que") {
    
    $que_id = $_REQUEST['que_id'];
//    echo $que_id;die;
    if ($db->deleteData("test_questions", 'ID' . '=' . $que_id)) {
        $response['data'] = 1;
    } else {
        $response['data'] = 0;
    }
    echo json_encode($response);
}

//delete practice test
if (isset($_REQUEST['req_type']) && $_REQUEST['req_type'] == "delete_test") {
    
    $test_id= $_REQUEST['test_id'];
//    echo $test_id;die;
    if ($db->deleteData("practice_test", 'ID' . '=' . $test_id)) {
        $response['data'] = 1;
    } else {
        $response['data'] = 0;
    }
    echo json_encode($response);
}

//change status of practice test
//if (isset($_REQUEST['req_type']) && $_REQUEST['req_type'] == "update_status") {
//    
//    $test_id= $_REQUEST['test_id'];
////    echo $test_id;die;
//    if ($db->updateData("practice_test", array("status") ,'ID' . '=' . $test_id)) {
//        $response['data'] = 1;
//    } else {
//        $response['data'] = 0;
//    }
//    echo json_encode($response);
//}





