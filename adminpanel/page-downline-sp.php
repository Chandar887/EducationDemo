<?php
$title = "Tree";
$apage = "tree";
include_once("header.php");


$limit = 20;
$offset = 0;
$page = 1;
$totaldata = 0;
$q = '';
$condtion = array();

if (isset($request['q']) && $request['q'] != '') {
    $q = $request['q'];
    $condtion[] = "%' or uName like '%" . $request['q'] . "%' or uMobile like '%" . $request['q'] . "%' or uEmail like '%" . $request['q'] . "%' or uSponsor like '%" . $request['q'] . "%'";
}
$condtion[] = "tag_sp='{$request['uid']}'";
$condtion[] = "level!='0'";
if (count($condtion) > 0)
    $condtion = 'where ' . implode(" and ", $condtion);
else
    $condtion = '';
?>
<main role="main" class="col-md-12 pt-3">
    <?php
    $uid = $request['uid'];
    $udata = array();
    $users = $db->selectQuery("select u.* from w_users u inner join w_sponsor_downline s on s.userID=u.ID where s.downline like '%-$uid-%' or s.userID='$uid' order by s.uSponsor");
    
    foreach ($users as $u) {
        $parent = "#";
        $state["opened"] = true;
        if ($u["underplaceID"] != "0" && $u["ID"] != $uid) {
            $parent = "user-" . $u["underplaceID"];
            $state["opened"] = false;
        }
        $image = isset($u["img"]) ? $u["img"] : $db->site . 'uploads/userempty.jpg';
        $udata[] = array("id" => "user-" . $u["ID"], "parent" => $parent, "state" => $state, "icon" => false, "text" => '<img src="' . $image . '" width=20> ' . $u["uniqueID"] . '# <b>' . $u["uName"] . '</b><span class="badge badge-pill badge-danger d-none">52</span>');
    }
//    print_r($udata);
    $udata = json_encode($udata);
    ?>
    <?php
//    $uid = $request['uid'];
//    $udata2 = array();
//    $query = "select u.* from w_users u inner join w_user_downline s on s.userID=u.ID where s.tag_sp='$uid' order by s.level";
//    $users = $db->selectQuery($query);
//
//    foreach ($users as $u) {
//        $parent = "#";
//        $state["opened"] = true;
//        if ($u["uSponsor"] != "0" && $u["ID"] != $uid) {
//            $parent = "user-" . $u["underplaceID"];
//            $state["opened"] = false;
//        }
//        $image = isset($u["img"]) ? $u["img"] : $db->site . 'uploads/userempty.jpg';
//        $udata2[] = array("id" => "user-" . $u["ID"], "parent" => $parent, "state" => $state, "icon" => false, "text" => '<img src="' . $image . '" width=20> ' . $u["uniqueID"] . '# <b>' . $u["uName"] . '</b><span class="badge badge-pill badge-danger d-none">52</span>');
//    }
//    $udata2 = json_encode($udata2);
    ?>
    <h1 class="h2 mx-auto">Tree</h1>
    <div class="p-2 border">
        <div class="overflow-auto" id="sTree"></div>
    </div>
</main>

<?php
include_once("footer.php");
?>
<script src="assets/jstree/jstree.min.js"></script>
<script>
    $('#sTree').jstree({
        'core': {
            "themes": {"icons": false},
            'data': <?php echo $udata; ?>
        }
    });
</script>