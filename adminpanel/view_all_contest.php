<?php
session_start();
$title = "View Contest";
$apage = "viewcontest";
include_once('header.php');

$categories = array();
if ($rrData = $db->selectRows("quiz_contest","DISTINCT category_name")) {
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

if (isset($request['category']) && $request['category'] != '') {
    $condtion[] = "category_name='{$request['category']}'";
}

if (count($condtion) > 0)
    $condtion = 'where ' . implode(" and ", $condtion);
else
    $condtion = '';

if ($totaldd = $db->selectQuery('SELECT count(ID) as totaldata from quiz_contest ' . $condtion)) {
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
                <h2 class="h2"><i class="fa fa-trophy pr-2"></i>View All Contests</h2>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <form method='get' action='<?php echo $currenturl; ?>' class="form-inline mr-2">
                        <div class="input-group mr-1">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class='fa fa-search'></i></div>
                            </div>
                            <select class="form-control" id="category" name='category'>
                                <option value=''>All Categories</option>
                                <?php
                                foreach ($categories as $catid => $catname) {
                                    $selected = $request['category'] == $catname ? "selected" : "";
                                    echo "<option value='$catname' $selected>$catname</option>";
                                }
                                ?>
                            </select>
                            <input type="search" class="form-control" id="q" name='q' value='<?php echo $q; ?>' placeholder="Search">
                        </div>
                        <button type="submit" class="btn btn-primary">Search</button>
                        <!--<a class="btn btn-primary mx-1" href="page-useradd.php"><i class="fa fa-user-plus pr-2"></i>New User</a>-->
                    </form>
                    
                    <a href="add_contest.php" class="btn btn-primary">Add New Contest</a>
                </div>
                
                
                
            </div>
            <div class="col-12 col-md-12 mx-auto">
                <?php
                if (isset($_SESSION['updatecon'])) {
                    ?>
                    <h6 class="alert alert-success"><?php echo $_SESSION['updatecon']; ?></h6>
                    <?php
                } else if (isset($_SESSION['update_ques'])) {
                    ?>
                    <h6 class="alert alert-success"><?php echo $_SESSION['update_ques']; ?></h6>

                    <?php
                } else if (isset($_SESSION['AddMoreContest'])) {
                    ?>
                    <h6 class="alert alert-success"><?php echo $_SESSION['AddMoreContest']; ?></h6>
                    <?php
                }

                $rslt = mysqli_query($db->con, "SELECT * FROM `quiz_contest` $condtion order by id DESC LIMIT $limit OFFSET $offset");
                if (mysqli_num_rows($rslt) > 0) {
                    ?>
                    <table class="table table-sm table-hover">
                        <thead class="bg-white">
                            <tr>
                                <th>#ID</th>
                                <th>Contest Name</th>
                                <th>Category Name</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Quiz Time</th>
                                <th>Amount</th>
                                <th>Total Member</th>
                                <!--<th>Winning Amount</th>-->
                                <th>Status</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_array($rslt)) {
                                ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['contest_name']; ?></td>  
                                    <td><?php echo $row['category_name']; ?></td>  

                                    <td><?php echo $row['play_time']; ?></td>
                                    <td><?php echo $row['end_time']; ?></td>
                                    <td><?php echo $row['quiz_time']; ?> Seconds</td>

                                    <td>₹ <?php echo $row['amount']; ?></td>
                                    <td><?php echo $row['total_member']; ?></td>
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
                                            <a target="_blank" href="view_contest.php?contest_id=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                            <?php
                                            if ($row["status"] == 0) {
                                                ?>

                                                <a href="add_contest.php?update_id=<?php echo $row['id']; ?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                                <button type="button" id="deletecon" contest-id="<?php echo $row['id']; ?>" class="btn btn-danger"><i class="fa fa-trash-alt"></i></button>

                                                <?php
                                            } else {
                                                ?>
                                                <a target="_blank" href="page-coins-list.php?roomID=<?php echo $row['id']; ?>&type=educationquiz" class="btn btn-info"><i class="fa fa-coins"></i></a>
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


if (isset($_SESSION['updatecon']) || isset($_SESSION['update_ques']) || isset($_SESSION['AddMoreContest'])) {
    unset($_SESSION['updatecon']);
    unset($_SESSION['update_ques']);
    unset($_SESSION['AddMoreContest']);
}
?>


<script>
    $(document).ready(function ()
    {

        $('body').on('click', '#deletecon', function ()
        {
            var ele = $(this);
            var contest_id = ele.attr('contest-id');
            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure?',
                buttons: {
                    yes: function () {
                        $.ajax({
                            type: "post",
                            url: "controller/ajaxcontroller.php",
                            data: {contest_id: contest_id},
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
