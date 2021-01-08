<?php
$title = "Game Records";
$apage = "gameplay";
?>
<?php include_once("header.php"); ?>
<?php
$limit = 20;
$offset = 0;
$page = 1;
$totaldata = 0;
$q = '';
$condtion = array();

if (isset($request['q']) && $request['q'] != '') {
    $q = $request['q'];
    $condtion[] = "roomID like '%" . $request['q'] . "%' or red like '%" . $request['q'] . "%' or green like '%" . $request['q'] . "%' or blue like '%" . $request['q'] . "%' or yellow like '%" . $request['q'] . "%'";
}

if (isset($request['isRoom']) && $request['isRoom'] != '') {
    $condtion[] = "isRoom='{$request['isRoom']}'";
}

if (count($condtion) > 0)
    $condtion = 'where ' . implode(" and ", $condtion);
else
    $condtion = '';
?>
<main role="main" class="col-md-12 pt-3">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h2 class="h2"><i class="fa fa-users"></i> Game Records</h2>
        <div class="btn-toolbar mb-2 mb-md-0">
            <form method='get' action='<?php echo $currenturl; ?>' class="form-inline mr-4">
                <div class="input-group mr-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class='fa fa-search'></i></div>
                    </div>
                    <select class="form-control" id="isRoom" name='isRoom'>
                        <option value=''>All</option>
                        <option value='0'>Direct Play</option>
                        <option value='1'>Room Play</option>
                    </select>
                    <input type="text" class="form-control" id="q" name='q' value='<?php echo $q; ?>' placeholder="Search">
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
                <!--<a class="btn btn-primary mx-1" href="page-useradd.php"><i class="fa fa-user-plus pr-2"></i>New User</a>-->
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <th>#RoomID</th>
                    <th>Players</th>
                    <th>Winner</th>
                    <th>TotalBet</th>
                    <th>Direct|Room</th>
                    <th>Status</th>
                    <th>DateTime</th>
                    <th>Transactions</th>
                </tr>
            </thead>
            <tbody id="tabledata">
                <?php
                if ($totaldd = $db->selectQuery('SELECT count(roomID) as totaldata from w_gameplay')) {
                    $totaldata = $totaldd[0]['totaldata'];
                }
                if (isset($request['page']) && $request['page'] > 1) {
                    $page = $request['page'];
                    $offset = $limit * ($page - 1);
                }
                $query = "SELECT * from w_gameplay $condtion order by createdAt desc LIMIT $limit OFFSET $offset";
                if ($data = $db->selectQuery($query)) {
                    foreach ($data as $d) {
                        ?>
                        <tr id="datarow-<?php echo $d['roomID'] ?>">
                            <td><?php echo $d['roomID'] ?></td>
                            <td><?php
                                if ($d['red'] != '') {
                                    $pdata = json_decode($d['red'], true);
                                    echo "<span class='m-1 p-1 rounded' style='background-color:red;border:solid black;color:white;'>{$pdata['mobile']}# {$pdata['name']}</span>";
                                }

                                if ($d['yellow'] != '') {
                                    $pdata = json_decode($d['yellow'], true);
                                    echo "<span class='m-1 p-1 rounded' style='background-color:yellow;border:solid black;color:black;'>{$pdata['mobile']}# {$pdata['name']}</span>";
                                }

                                if ($d['blue'] != '') {
                                    $pdata = json_decode($d['blue'], true);
                                    echo "<span class='m-1 p-1 rounded' style='background-color:blue;border:solid black;color:white;'>{$pdata['mobile']}# {$pdata['name']}</span>";
                                }
                                if ($d['green'] != '') {
                                    $pdata = json_decode($d['green'], true);
                                    echo "<span class='m-1 p-1 rounded' style='background-color:green;border:solid black;color:white;'>{$pdata['mobile']}# {$pdata['name']}</span>";
                                }
                                ?>
                            </td>
                            <td class="text-center"><?php
                                if ($d['winners'] != '') {
                                    $pdata = json_decode($d['winners'], true);
                                    foreach ($pdata as $w) {
                                        if ($w != '')
                                            echo "<span class='m-1 p-1 rounded' style='background-color:{$w};border:solid black;width:32px;height:32px;'>&nbsp;&nbsp;</span>";
                                    }
                                }
                                ?>
                            </td>
                            <td><?php echo $d['totalBet']; ?></td>
                            <td><?php echo $d['isRoom']==1?"ROOM":"DIRECT"; ?></td>
                            <td><?php echo $d['status']==2?"Completed":"-"; ?></td>
                            <td><?php echo $d['createdAt']; ?></td>
                            <td><a class="btn btn-sm btn-info" target="_blank" href="page-coins-list.php?q=<?php echo $d['roomID']; ?>">Transactions</a</td>
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
    <?php pagination($totaldata, $limit, $offset, $page, $q, $currenturl); ?>
</main>

<?php
include_once("footer.php");
?>