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
    $condtion[] = "red like '%" . $request['q'] . "%' or green like '%" . $request['q'] . "%' or blue like '%" . $request['q'] . "%' or yellow like '%" . $request['q'] . "%'";
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
                    <select class="form-control" id="isRoom" name='isactive'>
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
        <table id="myTable" class="table table-sm table-striped">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Players</th>
                    <th>Total Bet</th>
                    <th>Winner</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</main>

<?php
include_once("footer.php");
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/r-2.2.5/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.16.1/firebase-app.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/firebasejs/7.16.1/firebase-database.js"></script>
<script>
//    var firebaseConfig = {
//        apiKey: "AIzaSyANaAavBymdIzly1Ik0JWhEUrrKBcvge4s",
//        authDomain: "ludoplay-96f43.firebaseapp.com",
//        databaseURL: "https://ludoplay-96f43.firebaseio.com",
//        projectId: "ludoplay-96f43",
//        storageBucket: "ludoplay-96f43.appspot.com",
//        messagingSenderId: "1045677680791",
//        appId: "1:1045677680791:web:3cb18f2600360eb10b21d2"
//    };
    firebaseConfig = {
        apiKey: "AIzaSyDue8rpB4no5OHCEdtA_Ze5gD2p-K5g0dE",
        authDomain: "ludobusiness-aed1c.firebaseapp.com",
        databaseURL: "https://ludobusiness-aed1c.firebaseio.com",
        projectId: "ludobusiness-aed1c",
        storageBucket: "ludobusiness-aed1c.appspot.com",
        messagingSenderId: "835940298550",
        appId: "1:835940298550:web:126ef3a5197fca29ce0d97",
        measurementId: "G-SB98C8E8KB"
    };
    firebase.initializeApp(firebaseConfig);
    database = firebase.database();
    //day_of_year 203/l_online_play/2player-10/1595331724300-717
    var ref_online = "l_games/20200807/l_online_play/2player-10/";
    database.ref(ref_online).limitToFirst(100).once('value', function (snapshot) {
        var dataSet = [];
        $.each(snapshot.val(), function (key, value) {
            var dataRow=[];
            var rowdata = "<tr>";
            var users = "";
            var bet = 0;
            var winner = "";
            var action = "";
            action += "<button class='btn btn-primary'>View</button>";
            $.each(value, function (k, v) {
                if (k == 'red' || k == 'blue' || k == 'yellow' || k == 'green') {
                    if (k == 'yellow')
                        users += "<span class='badge rounded p-1 m-1' style='color:black;background-color:" + k + "'>" + v.mobile + "# " + v.name + "</span>";
                    else
                        users += "<span class='badge rounded p-1 m-1' style='color:white;background-color:" + k + "'>" + v.mobile + "# " + v.name + "</span>";
                    if (v.winner != 0) {
                        winner += "<span class='border rounded px-2 py-1 my-1' style='background-color:" + k + "'>&nbsp;</span>";
                    }
                }
                if (typeof v.bet == 'number')
                    bet = bet + v.bet;
            });
            dataSet.push([key, users, winner, bet, action]);
            rowdata += "<td>" + key + "</td>" + "<td>" + users + "</td>" + "<td>" + winner + "</td>" + "<td>₹ " + bet + "</td>" + "<td>" + action + "</td>";
            rowdata += "<tr>";
//            $('#myTable tbody').append(rowdata);
        });
        console.log(dataSet);
        $('#myTable').DataTable({data: [dataSet]});
    });
</script>
