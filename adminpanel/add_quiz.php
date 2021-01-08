<?php 
    include_once('header.php'); 
 ?>
	<div class="container-fluid">
            <div class="row">

                <main role="main" class="col-md-12 pt-3">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2"><i class="fa fa-"></i>Add Quiz Category</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
                      <!--   <a class="btn btn-primary ml-1" href="page-userlist.php"><i class="fa fa-list pr-2"></i>Users List</a> -->
        </div>
    </div>
    <div class="col-12 col-md-8 mx-auto">
    
          <?php if(isset($_SESSION['msg']))
            {
                ?>
                <div class="text-danger">
                    <p><?php echo $_SESSION['msg']; ?></p>
                </div>
                <?php
            } ?>

        <form class="border rounded p-4 submitform" action="controller/quiz_controller.php" method="post">
            <p class="h4">Add New Category</p>
            
            <div class="form-group mb-2">
                <label for="category_name">Add Category<span class="required">*</span></label>
                <input type="text" name="category_name" class="form-control" value=""  required="">
            </div>

           
            <div class="form-group">
                <button type="submit" name="submit" value="add_category" class="btn btn-primary btn-block button_submit">Add</button>
            </div>
        </form>
    </div>
</main>

            </div>
        </div>
<?php 
    include_once('footer.php'); 
 ?>
