<?php
$title = "Withdraw";
$apage = "withdraw";
include_once("header.php");

$limit = 20;
$offset = 0;
$page = 1;
$totaldata = 0;
$q = '';
$condtion = array();

if (isset($request['q']) && $request['q'] != '') {
    $q = $request['q'];
    $condtion[] = "payMode like '%" . $request['q'] . "%' or uCoin like '%" . $request['q'] . "%' or uID like '%" . $request['q'] . "%'";
}

if (isset($request['datetime']) && $request['datetime'] != '') {
    $condtion[] = "w_user_withdraw.createdAt like '%" . $request['datetime'] . "%'";
}

if (count($condtion) > 0)
    $condtion = 'where ' . implode(" and ", $condtion);
else
    $condtion = '';
?>
<main role="main" class="col-md-12 pt-3">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h2 class="h2"><i class="fa fa-"></i> Withdraw Request</h2>
        <div class="btn-toolbar mb-2 mb-md-0">
            <form method='get' action='<?php echo $currenturl; ?>' class="form-inline mr-4">
                <label class="sr-only" for="q">Username</label>
                
                <div class="input-group mr-1">
                    
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class='fa fa-search'></i></div>
                    </div>
                    <input type="date" class="form-control" id="datetime" name='datetime' value='<?php echo isset($request['datetime']) ? $request['datetime'] : ""; ?>' placeholder="date">
                    <input type="text" class="form-control" id="q" name='q' value='<?php echo $q; ?>' placeholder="Search">
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
                <!--<a class="btn btn-primary mx-1" href="page-useradd.php"><i class="fa fa-user-plus pr-2"></i>New User</a>-->
            </form>
            <form action="../export_data.php" method="post">
                <input type="hidden" name="query" value="<?php echo "SELECT * from w_user_withdraw $condtion order by ID desc"; ?>"/>
                <button type="submit" class="btn btn-danger mx-1"><i class="fa fa-file pr-2"></i>Export All</button>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <th>UserID</th>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Payment Mode</th>
                    <th>Bank Detail</th>
                    <th>Status</th>
                    <th>Datetime</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody id="tabledata">
                <?php
                $totaldata = $db->countRows('w_user_withdraw', $condtion);
                if (isset($request['page']) && $request['page'] > 1) {
                    $page = $request['page'];
                    $offset = $limit * ($page - 1);
                }
                
                $query="SELECT * from w_user_withdraw $condtion order by ID desc LIMIT $limit OFFSET $offset";
                if ($data = $db->selectQuery($query)) {
                    foreach ($data as $d) {
                        $bank = array("bank_name" => "", "bank_ifsc" => "", "account_name" => "", "account_number" => "", "pan_card" => "");
                        if ($bankData = $db->selectQuery("select * from w_users_bank where uID={$d['uID']}"))
                            $bank = $bankData[0];
                        $userData = $db->selectQuery("select uName,uMobile from w_users where ID={$d['uID']}");
                        $user = $userData[0];
                        ?>
                        <tr id="datarow-<?php echo $d['ID'] ?>">
                            <td><?php echo $d['uID'] ?></td>
                            <td><?php echo $user['uName'] ?></td>
                            <td><?php echo $d['payMode'] ?></td>
                            <td><?php echo $d['uCoin'] ?></td>
                            <td><?php echo "Name: <b>" . $bank['account_name'] . "</b><br> Bank Name: <b>" . $bank['bank_name'] . "</b><bR> Account Number: <b>" . $bank['account_number'] . "</b><br> Bank IFSC: <b>" . $bank['bank_ifsc'] . "</b><br> Pan Card: <b>" . $bank['pan_card'] . "</b><br>UPI Type:<b>" . $bank['upi_type'] . "</b><br UPI Mobile:<b>" . $bank['upi_number'] . "</b>" ?></td>
                            <td>
                                <?php
                                if ($d['status'] == 0) {
                                    echo "<p class='text-primary m-1'>Pending</p>";
                                } else {
                                    echo "<p class='text-primary m-1'>Approved</p>";
                                }
                                ?>
                            </td>
                            <td><?php echo $d['createdAt'] ?></td>
                            <td class="text-right">
                                <div class="btn-group btn-group-sm" role="group">
                                    <?php if (isset($d['status']) && $d['status'] == 0) { ?>
                                        <button class="btn btn-primary paid_accept" data-id="<?php echo $d['ID']; ?>" data-uid="<?php echo $d['uID']; ?>" uCoin="<?php echo $d['uCoin']; ?>">Accept</button> 
                                        <button class="btn btn-danger paid_reject" data-id="<?php echo $d['ID']; ?>" data-uid="<?php echo $d['uID']; ?>" uCoin="<?php echo $d['uCoin']; ?>">Reject</button>
                                    <?php } else if ($d['status'] == 1) { ?>
                                        <div class="text-center"><span class="text-success">Request Accepted</span></div>
                                    <?php } else { ?>
                                        <div class="text-center"><span class="text-danger">Request Rejected</span></div>
                                    <?php } ?>

                                </div>
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