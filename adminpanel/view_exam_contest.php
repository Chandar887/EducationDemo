<?php
session_start();
$title = "View Exam Contest";
$apage = "viewexamcontest";
include_once('header.php');

$categories = array();
if ($rrData = $db->selectRows("exam_contest","DISTINCT category_name")) {
    foreach ($rrData as $dd) {
        $categories[$dd['category_name']] = $dd['category_name'];
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
    $condtion[] = "(contest_name like '%" . $request['q'] . "%' or category_name like '%" . $request['q'] . "%' or end_time like '%" . $request['q'] . "%' or quiz_time like '%" . $request['q'] . "%' or amount like '%" . $request['q'] . "%')";
}

if (isset($request['category_name']) && $request['category_name'] != '') {
    $condtion[] = "category_name='{$request['category_name']}'";
}

if (count($condtion) > 0)
    $condtion = 'where ' . implode(" and ", $condtion);
else
    $condtion = '';

if ($totaldd = $db->selectQuery('SELECT count(ID) as totaldata from exam_contest ' . $condtion)) {
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
                <h2 class="h2"><i class="fa fa-trophy pr-2"></i>View Exam Contests</h2>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <form method='get' action='<?php echo $currenturl; ?>' class="form-inline mr-4">
                        <div class="input-group mr-1">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class='fa fa-search'></i></div>
                            </div>
                            <select class="form-control" id="category" name='category_name'>
                                <option value=''>All Categories</option>
                                <?php
                                foreach ($categories as $catid => $catname) {
                                    $selected = $request['category_name'] == $catname ? "selected" : "";
                                    echo "<option value='$catname' $selected>$catname</option>";
                                }
                                ?>
                            </select>
                            <input type="search" class="form-control" id="q" name='q' value='<?php echo $q; ?>' placeholder="Search">
                        </div>
                        <button type="submit" class="btn btn-primary">Search</button>
                        <a class="btn btn-primary mx-1" href="add_exam_contest.php">Add Exam Contest</a>
                    </form>
                </div>
            </div>



            <div class="col-12 col-md-12 mx-auto">
                <?php if (isset($_SESSION['que_imported'])) {
                    ?>
                    <h6 class="alert alert-success"><?php echo $_SESSION['que_imported']; ?></h6>
                    <?php
                }


                if (isset($_SESSION['updateexamcon'])) {
                    ?>
                    <h6 class="alert alert-success"><?php echo $_SESSION['updateexamcon']; ?></h6>
                    <?php
                } else if (isset($_SESSION['exam_contest_added'])) {
                    ?>
                    <h6 class="alert alert-success"><?php echo $_SESSION['exam_contest_added']; ?></h6>
                    <?php
                }

                $rslt = mysqli_query($db->con, "SELECT * FROM `exam_contest` $condtion order by id DESC LIMIT $limit OFFSET $offset");
                if (mysqli_num_rows($rslt) > 0) {
                    ?>


                    <table class="table table-sm table-hover">
                        <thead class="bg-white">
                            <tr>
                                <th>#ID</th>
                                <th>Contest Title</th>
                                <th>Exam Category</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Total Duration</th>
                                <th>Join Amount</th>
                                <!--<th>Total Member</th>-->
                                <!--<th>Winning Amount</th>-->
                                <th>Status</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_array($rslt)) {
                                ?>

                                <!-- Modal -->
<!--                            <div class="modal fade" id="uploadfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                        <input type="file" name="exam_questions" class="custom-file-input" accept=".xls,.xlsx" id="inputGroupFile01">
                                                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                                    </div>
                                                </div>

                                                <input type="hidden" name="contest_id" value="<?php echo $row['id']; ?>">


                                                <div class="form-group">
                                                    <button type="submit" name="upload_exam_ques" value="upload_exam_questions" class="btn btn-primary">Upload</button>
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

                            <tr>

                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['contest_name']; ?></td>  
                                <td><?php echo $row['category_name']; ?></td>  

                                <td><?php echo $row['play_time']; ?></td>
                                <td><?php echo $row['end_time']; ?></td>
                                <td><?php echo $row['quiz_time']; ?> Seconds</td>

                                <td>₹ <?php echo $row['amount']; ?></td>
                                <!--<td><?php echo $row['total_member']; ?></td>-->
                                <!--<td>₹<?php echo $row['winning_amount']; ?></td>-->
                                <td><?php
                                    $currrtime = date("Y-m-d H:i:s");
                                    if ($row['checked'] == 1) {
                                        ?>
                                        <button type="button" class="btn btn-danger" title="Completed"></button>
                                        <?php
                                    } else if ($row["status"] == 1 || $row["status"] == 2) {
                                        ?>
                                        <button type="button" class="btn btn-success" title="Pending"></button>  
                                        <?php
                                    } else if ($row["status"] == 0) {
                                        ?> 
                                        <button type="button" class="btn btn-warning" title="Upcomming"></button>      
                                    <?php }
                                    ?></td>
                                <td class="text-right">
                                    <div class="btn-group btn-group-sm" role="group">

                                        <a target="_blank" href="exam_contest.php?exam_contest_id=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                        <?php
                                        if ($row["status"] == 0) {
                                            ?>

                                            <a href="add_exam_contest.php?update_examcon=<?php echo $row['id']; ?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                            <button type="button" id="deleteexamcon" exam-contest-id="<?php echo $row['id']; ?>" class="btn btn-danger"><i class="fa fa-trash-alt"></i></button>
                                            <!-- Button trigger modal -->
                                            <a href="add_questions.php?contest_id=<?php echo $row['id']; ?>" class="btn btn-primary">Add Questions</a> 
                                            <?php
                                        } else {
                                            ?>
                                            <a target="_blank" href="page-coins-list.php?roomID=<?php echo $row['id']; ?>&type=examquiz" class="btn btn-info"><i class="fa fa-coins"></i></a>
                                            <?php }
                                            ?>
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


if (isset($_SESSION['updateexamcon']) || isset($_SESSION['exam_contest_added']) || isset($_SESSION['que_imported'])) {
    unset($_SESSION['updateexamcon']);
    unset($_SESSION['exam_contest_added']);
    unset($_SESSION['que_imported']);
}
?>


<script>
    $(document).ready(function ()
    {

        $('body').on('click', '#deleteexamcon', function ()
        {
            var ele = $(this);
            var contest_id = ele.attr('exam-contest-id');
            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure?',
                buttons: {
                    yes: function () {
                        $.ajax({
                            type: "post",
                            url: "controller/edu_ajaxcontroller.php",
                            data: {contest_id: contest_id, req_type: 'delete_exam_contest'},
                            success: function (data) {
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
