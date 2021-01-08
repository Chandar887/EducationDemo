<?php
$title = "Downline";
$apage = "downline";
include_once("header.php");

$limit = 20;
$offset = 0;
$page = 1;
$totaldata = 0;
$q = '';
$condtion = array();

if (isset($request['q']) && $request['q'] != '') {
    $q = $request['q'];
    $condtion[] = "uniqueID like '%" . $request['q'] . "%' or uName like '%" . $request['q'] . "%' or uMobile like '%" . $request['q'] . "%' or uEmail like '%" . $request['q'] . "%' or uSponsor like '%" . $request['q'] . "%'";
}
if(isset($request['uid'])) {
    $condtion[] = "tag_sp='{$request['uid']}'";
}
$condtion[] = "level!='0'";
if (count($condtion) > 0)
    $condtion = 'where ' . implode(" and ", $condtion);
else
    $condtion = '';
?>
<main role="main" class="col-md-12 pt-3">
    <div class="row">
        <div class="col-6">
            <h1 class="h2 mx-auto">Downline</h1>
        </div>
        <div class="col-6">
            <a href="./page-downline-sp.php?uid=<?php echo $request['uid']; ?>" class="btn btn-primary btn-sm float-right my-2">Tree</a>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Name</th>
                    <th>UniqueID</th>
                    <th>Level</th>
                    <th>Active</th>
                    <th>Datetime</th>

<!--<th class="text-right">Action</th>-->
                </tr>
            </thead>
            <tbody id="tabledata">
                <?php
                $totaldata = $db->countRows('w_user_downline', "$condtion");
                if (isset($request['page']) && $request['page'] > 1) {
                    $page = $request['page'];
                    $offset = $limit * ($page - 1);
                }
                if ($data = $db->selectQuery("SELECT * from w_user_downline $condtion order by level LIMIT $limit OFFSET $offset")) {
                    foreach ($data as $d) {
                        $userData = $db->selectQuery("select uName,uniqueID from w_users where ID={$d['userID']}");
                        $user = $userData[0];
                        ?>
                        <tr id="datarow-<?php echo $d['ID'] ?>">
                            <td><?php echo $d['ID'] ?></td>
                            <td><?php echo $user['uName'] ?></td>
                            <td><?php echo $user['uniqueID'] ?></td>
                            <td><?php echo $d['level'] ?></td>
                            <td>
                                <?php
                                if ($d['isActive']) {
                                    echo "<p class='badge badge-secondary m-1'><i class='fas fa-circle text-success'></i></p>";
                                } else {
                                    echo "<p class='badge badge-secondary m-1'><i class='fas fa-circle text-danger'></i></p>";
                                }
                                ?>
                            </td>
                            <td><?php echo $d['createdAt'] ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr><td colspan="14" class="text-danger h3 text-center">No Record Found</td></tr>  
                <?php } ?>
            </tbody>
        </table>
    </div>
</main>

<?php
include_once("footer.php");
?>