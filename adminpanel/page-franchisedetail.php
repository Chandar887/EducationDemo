<?php
$title = "Franchise List";
$apage = "franchise";
?>
<?php include_once("header.php"); ?>
<?php
$franchiseID = $request['franchiseID'];
?>
<main role="main" class="col-md-12 pt-3">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h2 class="h2">Franchise Details</h2>

    </div>
    <div class="row mb-3">
        <div class="col-sm-12 col-12">
            <div class="row">
                <div class="col-6 mb-3 pr-1">
                    <div class="action-button action-animate blue">
                        <span class="h6">Today Refer Earning</span><br/>
                        <?php
                        $tempD = 0;
                        if ($tdata = $db->selectQuery("select sum(uCoin) as coins from w_user_coins where (review='refer_income_fr') and uID='{$franchiseID}' and date(createdAt)=date(now())")) {
                            $tempD = $tdata[0]['coins'] == "" ? 0 : $tdata[0]['coins'];
                        }
                        ?>
                        <span class="h4 d-block">₹ <?php echo $tempD; ?></span>
                    </div>
                </div>
                <div class="col-6 mb-3 pr-1">
                    <div class="action-button action-animate blue">
                        <span class="h6">Total Refer Earning</span><br/>
                        <?php
                        $tempD = 0;
                        if ($tdata = $db->selectQuery("select sum(uCoin) as coins from w_user_coins where (review='refer_income_fr') and uID='{$franchiseID}'")) {
                            $tempD = $tdata[0]['coins'] == "" ? 0 : $tdata[0]['coins'];
                        }
                        ?>
                        <span class="h4 d-block">₹ <?php echo $tempD; ?></span>
                    </div>
                </div>

                <div class="col-6 mb-3 pr-1">
                    <div class="action-button action-animate blue">
                        <span class="h6">Today Payout</span><br/>
                        <?php
                        $tempD = 0;
                        if ($tdata = $db->selectQuery("select sum(uCoin) as coins from w_user_coins where (review='gameprofit_fr' || review='quizprofit_fr') and uID='{$franchiseID}' and date(createdAt)=date(now())")) {
                            $tempD = $tdata[0]['coins'] == "" ? 0 : $tdata[0]['coins'];
                        }
                        ?>
                        <span class="h4 d-block">₹ <?php echo $tempD; ?></span>
                    </div>
                </div>
                <div class="col-6 mb-3 pr-1">
                    <div class="action-button action-animate blue">
                        <span class="h6">Total Payout</span><br/>
                        <?php
                        $tempD = 0;
                        if ($tdata = $db->selectQuery("select sum(uCoin) as coins from w_user_coins where (review='gameprofit_fr' || review='quizprofit_fr') and uID='{$franchiseID}'")) {
                            $tempD = $tdata[0]['coins'] == "" ? 0 : $tdata[0]['coins'];
                        }
                        ?>
                        <span class="h4 d-block">₹ <?php echo $tempD; ?></span>
                    </div>
                </div>

                <div class="col-6 mb-3 pr-1">
                    <div class="action-button action-animate blue">
                        <span class="h6">Last Active Earning</span><br/>
                        <?php
                        $tempD = 0;
                        if ($tdata = $db->selectQuery("select uCoin as coins from w_user_coins where (review='active_bonus') and uID='{$franchiseID}' order by createdAt desc limit 1")) {
                            $tempD = $tdata[0]['coins'] == "" ? 0 : $tdata[0]['coins'];
                        }
                        ?>
                        <span class="h4 d-block">₹ <?php echo $tempD; ?></span>
                    </div>
                </div>
                <div class="col-6 mb-3 pr-1">
                    <div class="action-button action-animate blue">
                        <span class="h6">Total Active Earning</span><br/>
                        <?php
                        $tempD = 0;
                        if ($tdata = $db->selectQuery("select sum(uCoin) as coins from w_user_coins where (review='active_bonus') and uID='{$franchiseID}'")) {
                            $tempD = $tdata[0]['coins'] == "" ? 0 : $tdata[0]['coins'];
                        }
                        ?>
                        <span class="h4 d-block">₹ <?php echo $tempD; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
include_once("footer.php");
?>