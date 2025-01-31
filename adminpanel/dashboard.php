<?php
$title = "Dashboard";
$apage = "dashboard";
?>
<?php include_once("header.php"); ?>
<main role="main" class="col-12">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2"><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
    </div>
    <!--    <div class="p-5 m-5 text-center border h1">
            Welcome to Adminpanel
        </div>-->
    <div class="row mb-3">
        <div class="col-sm-12 col-12">
            <div class="row">
                <div class="col-md-3 col-6 py-2">
                    <div class="card bg-primary text-white h-100">
                        <div class="card-body">
                            <div class="rotate">
                                <i class="fa fa-users fa-4x"></i>
                            </div>
                            <h5 class="text-uppercase">All Users</h5>
                            <h1 class="">
                                <?php echo $total_users = $db->countRows("w_users"); ?>
                            </h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6 py-2">
                    <div class="card bg-success text-white h-100">
                        <div class="card-body">
                            <div class="rotate">
                                <i class="fa fa-users fa-4x"></i>
                            </div>
                            <h5 class="text-uppercase">Active Users</h5>
                            <h1 class="">
                                <?php echo $total_users = $db->countRows("w_users", "isActive='1'"); ?>
                            </h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6 py-2">
                    <div class="card bg-warning text-white h-100">
                        <div class="card-body">
                            <div class="rotate">
                                <i class="fa fa-users fa-4x"></i>
                            </div>
                            <h5 class="text-uppercase">Today Reg Users</h5>
                            <h1 class="">
                                <?php echo $total_users = $db->countRows("w_users", "date(createdAt) = CURDATE()"); ?>
                            </h1>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-6 py-2">
                    <div class="card bg-info text-white h-100">
                        <div class="card-body">
                            <div class="rotate">
                                <i class="fa fa-users fa-4x"></i>
                            </div>
                            <h5 class="text-uppercase">Today Active Users</h5>
                            <h1 class="">
                                <?php echo $total_users = $db->countRows("w_users", "isActive='1' and date(activateDate) = CURDATE()"); ?>
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-6 py-2">
                    <div class="card bg-danger text-white h-100">
                        <div class="card-body">
                            <div class="rotate">
                                <i class="fas fa-money-bill fa-4x"></i>
                            </div>
                            <h5 class="text-uppercase">Total Withdraw</h5>
                            <h1 class="">
                                <?php
                                $withdraw = 0;
                                if ($wdata = $db->selectQuery("select sum(uCoin) as uCoin from w_user_withdraw where status='1'")) {
                                    $withdraw = $wdata[0]['uCoin'];
                                }
                                echo "₹ " . $withdraw;
                                ?>
                            </h1>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-6 py-2">
                    <div class="card bg-success text-white h-100">
                        <div class="card-body">
                            <div class="rotate">
                                <i class="fas fa-money-bill fa-4x"></i>
                            </div>
                            <h5 class="text-uppercase">Pending Withdraw</h5>
                            <h1 class="">
                                <?php
                                $withdraw = 0;
                                if ($wdata = $db->selectQuery("select sum(uCoin) as uCoin from w_user_withdraw where status='0'")) {

                                    $withdraw = $wdata[0]['uCoin'] != '' ? $wdata[0]['uCoin'] : 0;
                                }
                                echo "₹ " . $withdraw;
                                ?>
                            </h1>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-6 py-2">
                    <div class="card bg-info text-white h-100">
                        <div class="card-body">
                            <div class="rotate">
                                <i class="fas fa-money-bill fa-4x"></i>
                            </div>
                            <h5 class="text-uppercase">Today Withdraw</h5>
                            <h1 class="">
                                <?php
                                $withdraw = 0;
                                if ($wdata = $db->selectQuery("select sum(uCoin) as uCoin from w_user_withdraw where status='1' and date(updatedAt) = CURDATE()")) {

                                    $withdraw = $wdata[0]['uCoin'] != '' ? $wdata[0]['uCoin'] : 0;
                                }
                                echo "₹ " . $withdraw;
                                ?>
                            </h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6 py-2">
                    <div class="card bg-warning text-white h-100">
                        <div class="card-body">
                            <div class="rotate">
                                <i class="fas fa-money-bill fa-4x"></i>
                            </div>
                            <h5 class="text-uppercase">Today Pending Withdraw</h5>
                            <h1 class="">
                                <?php
                                $withdraw = 0;
                                if ($wdata = $db->selectQuery("select sum(uCoin) as uCoin from w_user_withdraw where status='0' and date(updatedAt) = CURDATE()")) {

                                    $withdraw = $wdata[0]['uCoin'] != '' ? $wdata[0]['uCoin'] : 0;
                                }
                                echo "₹ " . $withdraw;
                                ?>
                            </h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 col-6 py-2">
                    <div class="card bg-info text-white h-100">
                        <div class="card-body">
                            <div class="rotate">
                                <i class="fas fa-coins fa-4x"></i>
                            </div>
                            <h5 class="text-uppercase">Today Gameplay</h5>
                            <h3 class="">
                                <?php
                                $withdraw = 0;
                                if ($wdata = $db->selectQuery("select sum(uCoin) as uCoin from w_user_coins where review='gameplay' and date(createdAt) = CURDATE()")) {

                                    $withdraw = $wdata[0]['uCoin'] != '' ? $wdata[0]['uCoin'] : 0;
                                }
                                echo "₹ " . $withdraw;
                                ?>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6 py-2">
                    <div class="card bg-primary text-white h-100">
                        <div class="card-body">
                            <div class="rotate">
                                <i class="fas fa-coins fa-4x"></i>
                            </div>
                            <h5 class="text-uppercase">Today Gamewin</h5>
                            <h3 class="">
                                <?php
                                $withdraw = 0;
                                if ($wdata = $db->selectQuery("select sum(uCoin) as uCoin from w_user_coins where review='gamewin' and date(createdAt) = CURDATE()")) {

                                    $withdraw = $wdata[0]['uCoin'] != '' ? $wdata[0]['uCoin'] : 0;
                                }
                                echo "₹ " . $withdraw;
                                ?>
                            </h3>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-6 py-2">
                    <div class="card bg-danger text-white h-100">
                        <div class="card-body">
                            <div class="rotate">
                                <i class="fas fa-coins fa-4x"></i>
                            </div>
                            <h5 class="text-uppercase">Today Level Income</h5>
                            <h3 class="">
                                <?php
                                $withdraw = 0;
                                if ($wdata = $db->selectQuery("select sum(uCoin) as uCoin from w_user_coins where review='levelincome' and date(createdAt) = CURDATE()")) {

                                    $withdraw = $wdata[0]['uCoin'] != '' ? $wdata[0]['uCoin'] : 0;
                                }
                                echo "₹ " . $withdraw;
                                ?>
                            </h3>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-6 py-2">
                    <div class="card bg-success text-white h-100">
                        <div class="card-body">
                            <div class="rotate">
                                <i class="fas fa-coins fa-4x"></i>
                            </div>
                            <h5 class="text-uppercase">Today Game Profit</h5>
                            <h3 class="">
                                <?php
                                $withdraw = 0;
                                if ($wdata = $db->selectQuery("select sum(uCoin) as uCoin from w_user_coins where review='gameprofit' and date(createdAt) = CURDATE()")) {

                                    $withdraw = $wdata[0]['uCoin'] != '' ? $wdata[0]['uCoin'] : 0;
                                }
                                echo "₹ " . $withdraw;
                                ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="row">
                <div class="col-sm-4 col-12 py-2">
                    <div class="card text-white bg-info h-100">
                        <div class="card-body">
                            <div class="rotate">
                                <i class="fa fa-money-bill-alt fa-4x"></i>
                            </div>
                            <h5 class="text-uppercase">Withdraw Pending</h5>
                            <h1 class=""><?php
            // $pending_withdraw = 0;
            // if ($withdraw = $db->selectQuery("select sum(amount) as amount from w_withdraw where status='0'"))
            //     if ($withdraw[0]['amount'] != '')
            //         $pending_withdraw = $withdraw[0]['amount'];
            // echo $pending_withdraw;
            ?></h1>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</main>
<?php include_once("footer.php"); ?>