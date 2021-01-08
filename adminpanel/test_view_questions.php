<?php
session_start();
$title = "View Test Questions";
$apage = "viewtestquestions";
include_once('header.php');

$categories = array();
if ($rrData = $db->selectRows("test_questions", "DISTINCT cat_1")) {
    foreach ($rrData as $dd) {
        $categories[] = $dd['cat_1'];
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
    $condtion[] = "(cat_1 like '%" . $request['q'] . "%' or cat_2 like '%" . $request['q'] . "%' or cat_3 like '%" . $request['q'] . "%' or cat_4 like '%" . $request['q'] . "%' or questions like '%" . $request['q'] . "%')";
}

if (isset($request['cat_1']) && $request['cat_1'] != '') {
    $condtion[] = "cat_1='{$request['cat_1']}'";
}

if (count($condtion) > 0)
    $condtion = 'where ' . implode(" and ", $condtion);
else
    $condtion = '';

if ($totaldd = $db->selectQuery('SELECT count(ID) as totaldata from test_questions ' . $condtion)) {
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
                <h2 class="h2"><i class="fa fa-trophy pr-2"></i>View Test Questions</h2>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <form method='get' action='<?php echo $currenturl; ?>' class="form-inline mr-2">
                        <div class="input-group mr-1">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class='fa fa-search'></i></div>
                            </div>
                            <select class="form-control" id="category" name='cat_1'>
                                <option value=''>All Categories</option>
                                <?php
                                foreach ($categories as $catid => $catname) {
                                    $selected = $request['cat_1'] == $catname ? "selected" : "";
                                    echo "<option value='$catname' $selected>$catname</option>";
                                }
                                ?>
                            </select>
                            <input type="search" class="form-control" id="q" name='q' value='<?php echo $q; ?>' placeholder="Search">
                        </div>
                        <button type="submit" class="btn btn-primary">Search</button>

                        <a class="btn btn-primary mx-1" href="test_question_details.php">Add More Questions</a>
                    </form>


                    <!--************upload excel file************-->

                    <!-- Button trigger modal -->
                    <!--                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadfile">
                                            Import Questions
                                        </button>
                    
                                         Modal 
                                        <div class="modal fade" id="uploadfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Upload Excel File</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="controller/controller.php" method="post" enctype="multipart/form-data">
                                                            <div class="form-group input-group mb-3">
                                                                <div class="custom-file">
                                                                    <input type="file" name="question_file" class="custom-file-input" accept=".xls,.xlsx" id="inputGroupFile01">
                                                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                                                </div>
                                                            </div>
                    
                    
                    
                                                            <div class="form-group">
                                                                <button type="submit" name="upload_file" value="upload_question_file" class="btn btn-primary">Upload</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>-->
                    <!--************upload excel file section ends************-->


                </div>
            </div>
            <div class="col-12 col-md-12 mx-auto">
                <?php
                if (isset($_SESSION['que_updated'])) {
                    ?>
                    <h6 class="alert alert-success"><?php echo $_SESSION['que_updated']; ?></h6>

                    <?php
                } else if(isset($_SESSION['que_added'])) {
                    ?>
                    <h6 class="alert alert-success"><?php echo $_SESSION['que_added']; ?></h6>

                    <?php
                }


                $rslt = mysqli_query($db->con, "SELECT * FROM `test_questions` $condtion order by id DESC LIMIT $limit OFFSET $offset");
                if (mysqli_num_rows($rslt) > 0) {
                    ?>
                    <table class="table table-sm table-hover">
                        <thead class="bg-white">
                            <tr>
                                <th>#ID</th>
                                <th>Category 1</th>
                                <th>Category 2</th>
                                <th>Category 3</th>
                                <th>Category 4</th>
                                <th>Question</th>
                                <th>Question Image</th>
                                <th>A</th>
                                <th>B</th>
                                <th>C</th>
                                <th>D</th>
                                <th>Answer</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_array($rslt)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['ID']; ?></td>
                                    <td class="text-capitalize"><?php echo $row['cat_1']; ?></td> 
                                    <td class="text-capitalize"><?php echo $row['cat_2']; ?></td> 
                                    <td class="text-capitalize"><?php echo ($row['cat_3']=='') ? '<b>-</b>' : $row['cat_3']; ?></td>
                                    <td class="text-capitalize"><?php echo ($row['cat_4']=='') ? '<b>-</b>' : $row['cat_4']; ?></td> 
                                    <td><?php echo $row['questions']; ?></td>  
                                    <td class="text-center"><?php echo ($row['que_image'] != '') ? "<img src='$row[que_image]' style='height:70px!important;'>" : "<b>-</b>"; ?></td>
                                    <?php
                                    $get_suggestions = $row['suggestions'];
                                    $jsonData = json_decode($get_suggestions, true);
//                                    echo "<pre>";
//                                    print_r($jsonData);
                                    ?>
                                    <td><?php echo (filter_var($jsonData['A'], FILTER_VALIDATE_URL)) ? "<img src='$jsonData[A]' width='70px' height='70px'>" : $jsonData['A']; ?></td>
                                    <td><?php echo (filter_var($jsonData['B'], FILTER_VALIDATE_URL)) ? "<img src='$jsonData[B]' width='70px' height='70px'>" : $jsonData['B']; ?></td>
                                    <td><?php echo (filter_var($jsonData['C'], FILTER_VALIDATE_URL)) ? "<img src='$jsonData[C]' width='70px' height='70px'>" : $jsonData['C']; ?></td>
                                    <td><?php echo (filter_var($jsonData['D'], FILTER_VALIDATE_URL)) ? "<img src='$jsonData[D]' width='70px' height='70px'>" : $jsonData['D']; ?></td>
                                    <td><?php echo $row['answer']; ?></td>

                                    <td class="text-right">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <!--<a target="_blank" href="view_contest.php?contest_id=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="fa fa-eye"></i></a>-->

                                            <a href="test_update_question.php?que_id=<?php echo $row['ID']; ?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                            <button type="button" id="deltestque" que-id="<?php echo $row['ID']; ?>" class="btn btn-danger"><i class="fa fa-trash-alt"></i></button>

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
        $('body').on('click', '#deltestque', function ()
        {
            var ele = $(this);
            var que_id = ele.attr('que-id');
            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure?',
                buttons: {
                    yes: function () {

//                console.log(question_id);
                        $.ajax({
                            type: "post",
                            url: "controller/edu_ajaxcontroller.php",
                            data: {que_id: que_id, req_type: "delete_test_que"},
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
    });

</script>

