<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
require_once("./config.php");
include_once("classes/Crud.php");
$page_slug = "dashboard";
require_once("./templates/header.php");
require_once("./templates/menu.php");

$crud = new Crud();
$query_pagination = "SELECT category,count(*) as prd_count FROM products group BY category";
$products_count = $crud->getData($query_pagination);
?>
<div id="page-wrapper">
            <div id="page-inner">


                <div class="row">
                    <div class="col-md-12">
                        
                        <h1 class="page-header">
                            Dashboard <small>Summary of your App</small>
                        </h1>
                    </div>
                </div>
                <!-- /. ROW  -->

                <div class="row">

                	<?php 
                	foreach ($products_count as $key => $value) {
                	?>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="panel panel-primary text-center no-boder bg-color-green">
                            <div class="panel-body">
                                <i class="fa fa-bar-chart-o fa-5x"></i>
                                <h3><?php echo $value['prd_count']; ?></h3>
                            </div>
                            <div class="panel-footer back-footer-green">
                                <?php echo $value['category']; ?>

                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
				<footer></footer>
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
<?php
require_once("./templates/footer.php");
?>