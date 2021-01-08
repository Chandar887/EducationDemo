<?php
$title = "Coins Request";
$apage = "coinsrequest";

include_once("header.php"); 
$limit = 20;
$offset = 0;
$page = 1;
$totaldata = 0;
$q = '';
$condtion = array();

if (isset($request['q']) && $request['q'] != '') {
    $q = $request['q'];
    $condtion[] = "uCoin like '%" . $request['q'] . "%' or review like '%" . $request['q'] . "%'";
}

if (count($condtion) > 0)
    $condtion = 'where ' . implode(" and ", $condtion);
else
    $condtion = '';
?>
<main role="main" class="col-md-12 pt-3">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h2 class="h2"><i class="fa fa-coins"></i> Coins Request</h2>
        <div class="btn-toolbar mb-2 mb-md-0">
            <form method='get' action='<?php echo $currenturl; ?>' class="form-inline mr-4">
                <label class="sr-only" for="q">Username</label>
                <div class="input-group mr-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class='fa fa-search'></i></div>
                    </div>
<!--                    <select class="form-control" id="cat" name='cat'>
                        <option value=''> - All Category - </option>
                    </select>-->
                    <input type="text" class="form-control" id="q" name='q' value='<?php echo $q; ?>' placeholder="Search">
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
                <!--<a class="btn btn-primary mx-1" href="page-coins-add.php"><i class="fa fa-user-plus pr-2"></i>Add Coins</a>-->
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Coin</th>
                    <th>Review</th>
                    <th>Txtn ID</th>
                    <th>Slip</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody id="tabledata">
                <?php
                $totaldata = $db->countRows('w_coins_request', $condtion);
                if (isset($request['page']) && $request['page'] > 1) {
                    $page = $request['page'];
                    $offset = $limit * ($page - 1);
                }
                if ($data = $db->selectQuery("SELECT * from w_coins_request $condtion order by ID desc LIMIT $limit OFFSET $offset")) {
                    foreach ($data as $d) {
                       $userData = $db->selectQuery("select uName,uMobile from w_users where ID={$d['uID']}");
                       $user = $userData[0];
                        ?>
                        <tr id="datarow-<?php echo $d['ID'] ?>">
                            <td><?php echo $d['ID'] ?></td>
                            <td><?php echo $user['uName'] ?></td>
                            <td><?php echo $user['uMobile'] ?></td>
                            <td><?php echo $d['uCoin'] ?></td>
                            <td><?php echo $d['review'] ?></td>
                            <td><?php echo $d['txtnID'] ?></td>
                            <td><img src="<?php echo ($d['slip'] != '') ? $db->site.$d['slip'] : $db->site . '/uploads/noimage.jpg'; ?>" width="48"></td>
                            <td class="text-right">
                                <?php if($d['status']==0) {?>
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">Coins</button>
                                    <button type="button" data-id="<?php echo $d['ID'] ?>" class="btn btn-danger cancelCoinsbt">Cancel</button>
                                    <div class="dropdown-menu">
                                        <a href="page-activate.php?uid=<?php echo $d['uID'] ?>&coin=<?php echo $d['uCoin']; ?>&reqID=<?php echo $d['ID'] ?>" class="dropdown-item" title="Activate User" target="_blank">Activate User</a>
                                        <a href="page-coins-add.php?uid=<?php echo $d['uID'] ?>&coin=<?php echo $d['uCoin']; ?>&reqID=<?php echo $d['ID'] ?>" class="dropdown-item" title="Coins Send" target="_blank">Send Coins</a>
                                    </div>
                                </div>
                                <?php } else if($d['status']==1){ ?>
                                <p class="text-success">Coins Sent</p>
                                <?php } else if($d['status']==-1){ ?>
                                <p class="text-danger">Canceled</p>
                                <?php } ?>
                            </td>
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