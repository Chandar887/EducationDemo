<?php
session_start();
$title = "View All Test";
$apage = "viewalltest";
include_once('header.php');

//$categories = array();
//if ($rrData = $db->selectRows("practice_test", "DISTINCT test_ti")) {
//    foreach ($rrData as $dd) {
//        $categories[] = $dd['test_title'];
//    }
//}



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
}
?>
<?php
$limit = 20;
$offset = 0;
$page = 1;
$totaldata = 0;
$q = '';
$condtion = array();

if (isset($request['q']) && $request['q'] != '') {
    $q = $request['q'];
    $condtion[] = "(test_title like '%" . $request['q'] . "%' or duration like '%')";
}

if (isset($request['test_title']) && $request['test_title'] != '') {
    $condtion[] = "test_title='{$request['test_title']}'";
}

if (count($condtion) > 0)
    $condtion = 'where ' . implode(" and ", $condtion);
else
    $condtion = '';

if ($totaldd = $db->selectQuery('SELECT count(ID) as totaldata from practice_test ' . $condtion)) {
    $totaldata = $totaldd[0]['totaldata'];
}
if (isset($request['page']) && $request['page'] > 1) {
    $page = $request['page'];
    $offset = $limit * ($page - 1);
}
?>
<style>
    button.btn.btn-warning {
        background-color: yellow;
        border: yellow;
    }
</style>

<div class="container-fluid">
    <div class="row">

        <main role="main" class="col-md-12 pt-3">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h2 class="h2"><i class="fa fa-trophy pr-2"></i>View All Test</h2>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <form method='get' action='<?php echo $currenturl; ?>' class="form-inline mr-2">
                        <div class="input-group mr-1">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class='fa fa-search'></i></div>
                            </div>
<!--                            <select class="form-control" id="category" name='test_title'>
                                <option value=''>All Categories</option>
                            <?php
//                                foreach ($categories as $catid => $catname) {
//                                    $selected = $request['test_title'] == $catname ? "selected" : "";
//                                    echo "<option value='$catname' $selected>$catname</option>";
//                                }
                            ?>
                            </select>-->
                            <input type="search" class="form-control" id="q" name='q' value='<?php echo $q; ?>' placeholder="Search">
                        </div>
                        <button type="submit" class="btn btn-primary">Search</button>

                        <a class="btn btn-primary mx-1" href="add_new_test.php">Add New Test</a>
                    </form>


                </div>
            </div>
            <div class="col-12 col-md-12 mx-auto">
                <?php
                if (isset($_SESSION['que_updated'])) {
                    ?>
                    <h6 class="alert alert-success"><?php echo $_SESSION['que_updated']; ?></h6>

                    <?php
                } else if (isset($_SESSION['que_added'])) {
                    ?>
                    <h6 class="alert alert-success"><?php echo $_SESSION['que_added']; ?></h6>

                    <?php
                }


                $rslt = mysqli_query($db->con, "SELECT * FROM `practice_test` $condtion order by id DESC LIMIT $limit OFFSET $offset");
                if (mysqli_num_rows($rslt) > 0) {
                    ?>
                    <table class="table table-sm table-hover">
                        <thead class="bg-white">
                            <tr>
                                <th>#ID</th>
                                <th>Test Title</th>
                                <!--<th>Category 1</th>-->
    <!--                                <th>Category 2</th>
                                <th>Category 3</th>
                                <th>Category 4</th>-->
                                <th>Test Duration</th>
                                <!--<th>Total Questions</th>-->
                                <!--<th>Test Status</th>-->
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_array($rslt)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['ID']; ?></td>
                                    <td class="text-capitalize"><?php echo $row['test_title']; ?></td>
                                    <?php
                                    $jsonData = json_decode($row['cat_que'], true);
                                    ?>
                                    <td><?php echo $row['duration']; ?></td>
                                    <!--<td><button type="button" id="status" test-id="<?php echo $row['ID']; ?>" class="btn btn-sm <?php echo ($row['status'] == 0) ? 'btn-success' : 'btn-danger'; ?> statuschnge">Active</button></td>-->

                                    <td class="text-right">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <!--<a target="_blank" href="view_contest.php?contest_id=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="fa fa-eye"></i></a>-->

                                            <a href="#?que_id=<?php echo $row['ID']; ?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                            <button type="button" id="deltest" test-id="<?php echo $row['ID']; ?>" class="btn btn-danger"><i class="fa fa-trash-alt"></i></button>

                                        </div>    
                                    </td>
                                </tr>
        <?php
    }
    ?></tbody>
                            <?php
                        }
                        ?>

                </table>
            </div>
<?php pagination($totaldata, $limit, $offset, $page, $q, $currenturl); ?>
        </main>

    </div>
</div>
<?php
include_once('footer.php');


if (isset($_SESSION['que_updated']) || isset($_SESSION['que_added'])) {
    unset($_SESSION['que_updated']);
    unset($_SESSION['que_added']);
}
?>


<script>
    $(document).ready(function ()
    {
        $('body').on('click', '#deltest', function ()
        {
            var ele = $(this);
            var test_id = ele.attr('test-id');
            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure?',
                buttons: {
                    yes: function () {

//                console.log(question_id);
                        $.ajax({
                            type: "post",
                            url: "controller/edu_ajaxcontroller.php",
                            data: {test_id: test_id, req_type: "delete_test"},
                            success: function (data) {
//                                alert(data);
                                location.reload();
                            }
                        });
                    },
                    no: function () {

                    }
                }
            });
        });


//        change status
//        $('.statuschnge').click(function ()
//        {
//            var ele = $(this);
//            var test_id = ele.attr('test-id');
//
//            $.confirm({
//                title: 'Confirm!',
//                content: 'Want To Update Status?',
//                buttons: {
//                    yes: function () {
//
////                console.log(question_id);
//                        $.ajax({
//                            type: "post",
//                            url: "controller/edu_ajaxcontroller.php",
//                            data: {test_id: test_id, req_type: "update_status"},
//                            success: function (data) {
////                                alert(data);
//                                location.reload();
//                            }
//                        });
//                    },
//                    no: function () {
//
//                    }
//                }
//            });
//        });
    });

</script>


