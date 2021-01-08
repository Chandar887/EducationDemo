<?php
session_start();
$title = "View Categories";
$apage = "viewcategories";
include_once('header.php');

$categories = array();
if ($rrData = $db->selectRows("test_category", "DISTINCT cat_name")) {
    foreach ($rrData as $dd) {
        $categories[$dd['cat_name']] = $dd['cat_name'];
    }
}
?>
<?php
$categories = array();
if ($tcat = $db->selectQuery("select * from test_category where cat_parent='0'")) {
//    $categories=$db->orderCategory($tcat);
    foreach ($tcat as $cat1) {
        $categories[$cat1['ID']] = $cat1;
        $categories[$cat1['ID']]['child'] = array();
        if ($tcat2 = $db->selectQuery("select * from test_category where cat_parent='{$cat1['ID']}'")) {
            foreach ($tcat2 as $cat2) {
                $categories[$cat1['ID']]['child'][$cat2['ID']] = $cat2;
                $categories[$cat1['ID']]['child'][$cat2['ID']]['child'] = array();
                if ($tcat3 = $db->selectQuery("select * from test_category where cat_parent='{$cat2['ID']}'")) {
                    foreach ($tcat3 as $cat3) {
                        $categories[$cat1['ID']]['child'][$cat2['ID']]['child'][$cat3['ID']] = $cat3;
                        $categories[$cat1['ID']]['child'][$cat2['ID']]['child'][$cat3['ID']]['child'] = array();
                        if ($tcat4 = $db->selectQuery("select * from test_category where cat_parent='{$cat3['ID']}'")) {
                            foreach ($tcat4 as $cat4) {
                                $categories[$cat1['ID']]['child'][$cat2['ID']]['child'][$cat3['ID']]['child'][$cat4['ID']] = $cat4;
                                $categories[$cat1['ID']]['child'][$cat2['ID']]['child'][$cat3['ID']]['child'][$cat4['ID']]['child'] = array();
                            }
                        }
                    }
                }
            }
        }
    }
//    echo"<pre>";
//    print_r($categories);
//    die;
///
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
<!--                    <form method='get' action='<?php echo $currenturl; ?>' class="form-inline mr-2">
                        <div class="input-group mr-1">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class='fa fa-search'></i></div>
                            </div>
                            <select class="form-control" id="category" name='cat_name'>
                                <option value=''>All Categories</option>
                    <?php
//                                foreach ($categories as $catid => $catname) {
//                                    $selected = $request['cat_name'] == $catname ? "selected" : "";
//                                    echo "<option value='$catname' $selected>$catname</option>";
//                                }
                    ?>
                            </select>
                            <input type="search" class="form-control" id="q" name='q' value='<?php echo $q; ?>' placeholder="Search">
                        </div>
                        <button type="submit" class="btn btn-primary">Search</button>
                        <a class="btn btn-primary mx-1" href="page-useradd.php"><i class="fa fa-user-plus pr-2"></i>New User</a>
                    </form>-->

                    <a href="test_add_category.php" class="btn btn-primary">Add New Category</a>
                </div>



            </div>
            <div class="col-12 col-md-12 mx-auto">

                <table class="table table-sm table-hover">
                    <thead class="bg-white">
                        <tr>
                            <th>#ID</th>
                            <th>Category Name</th>

                            <th>Category Sku</th>

                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($categories as $row) {
                            ?>
                            <tr>
                                <td><?php echo $row['ID']; ?></td>
                                <td><?php echo $row['cat_name']; ?></td> 
                                <td><?php echo $row['cat_sku']; ?></td>  
                                <td class="text-right">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <!--<a href="add_contest.php?update_id=<?php echo $row['ID']; ?>" class="btn btn-success"><i class="fa fa-edit"></i></a>-->
                                        <button type="button" id="deletecon" cat-id="<?php echo $row['ID']; ?>" class="btn btn-danger"><i class="fa fa-trash-alt"></i></button>
                                    </div>    
                                </td>
                            </tr>
                            <?php
                            foreach ($row['child'] as $row2) {
                                ?>
                                <tr>
                                    <td><?php echo $row2['ID']; ?></td>
                                    <td><?php echo $row2['cat_name']; ?></td> 
                                    <td><?php echo $row2['cat_sku']; ?></td>  
                                    <td class="text-right">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <!--<a href="add_contest.php?update_id=<?php echo $row2['ID']; ?>" class="btn btn-success"><i class="fa fa-edit"></i></a>-->
                                            <button type="button" id="deletecon" cat-id="<?php echo $row2['ID']; ?>" class="btn btn-danger"><i class="fa fa-trash-alt"></i></button>
                                        </div>    
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?></tbody>


                </table>
            </div>

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
            var cat_id = ele.attr('cat-id');
            $.confirm({
                title: 'Confirm!',
                content: 'Are you sure?',
                buttons: {
                    yes: function () {
                        $.ajax({
                            type: "post",
                            url: "controller/edu_ajaxcontroller.php",
                            data: {cat_id: cat_id, req_type: 'delete_test_category'},
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
