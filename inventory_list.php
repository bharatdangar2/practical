<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
require_once("./config.php");

include_once("classes/Crud.php");
include_once("classes/Pagination.php");
 
$crud = new Crud();
 
//fetching data in descending order (lastest entry first)
/*$query = "SELECT * FROM products ORDER BY id DESC";
$result = $crud->getData($query);
echo '<pre>'; print_r($result); exit;*/

if(isset($_GET['action']) && isset($_GET['id']))
{
    if($_GET['action'] == 'delete' && $_GET['id'] > 0)
    {
        $delete_sql = "delete from products where id = '".$_GET['id']."'";
        $result = $crud->execute($delete_sql);
        header("Location: ".BASE_URL."inventory_list.php");
    }
}


$search_name = isset($_GET['search_name'])?$_GET['search_name']:'';
$search_category = isset($_GET['search_category'])?$_GET['search_category']:'';

$page_slug = "inventory_list";
require_once("./templates/header.php");
require_once("./templates/menu.php");

$baseURL = BASE_URL."inventory_list.php?search_name=".$search_name."&search_category=".$search_category;
$limit = 5;

// Paging limit & offset
$offset = !empty($_GET['page'])?(($_GET['page']-1)*$limit):0;

$query_pagination = "SELECT COUNT(*) as rowNum FROM products ";

$query_pagination .=" where 1=1 ";

if ($search_name != '') 
{
    $query_pagination .=" and name like '%".$search_name."%' ";
}

if ($search_category != '') 
{
    $query_pagination .=" and category = '".$search_category."' ";
}

$query_pagination .=" ORDER BY id DESC";
$products_count = $crud->getData($query_pagination);
$rowCount= $products_count[0]['rowNum'];

// Initialize pagination class
$pagConfig = array(
    'baseURL' => $baseURL,
    'totalRows'=>$rowCount,
    'perPage'=>$limit
);

$pagination =  new Pagination($pagConfig);

$query = "SELECT * FROM products ";
$query .=" where 1=1 ";

if ($search_name != '') 
{
    $query .=" and name like '%".$search_name."%' ";
}

if ($search_category != '') 
{
    $query .=" and category = '".$search_category."' ";
}
$query .=" ORDER BY id DESC LIMIT ".$offset.",".$limit;
$products = $crud->getData($query);
?>
<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                
                <h1 class="page-header">
                    Products <small>List of products</small>
                </h1>
            </div>
        </div>
        <!-- /. ROW  -->

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="col-lg-12">
                            <form role="form" action="<?php echo BASE_URL.'inventory_list.php';?>" method="get">
                                <div class="form-group col-lg-4">
                                    <label>Product Name</label>
                                    <input class="form-control" type="text" name="search_name" value="<?php echo $search_name; ?>">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>Category</label>
                                    <select class="form-control" name="search_category">
                                        <option value="">Select Category</option>
                                        <option value="cell-phones" <?php if($search_category == 'cell-phones') { echo "selected"; } ?> >Cell-phones</option>
                                        <option value="cars"  <?php if($search_category == 'cars') { echo "selected"; } ?> >cars</option>
                                    </select> 
                                </div>
                                <div class="form-group col-lg-4">
                                    <option value="">&nbsp;</option>
                                    <button type="submit" name="btn_search" class="btn btn-default">Search</button>
                                </div>
                            </form>
                        </div>
                        <a href="<?php echo BASE_URL.'add_edit_product.php'; ?>" class="btn btn-success d-flex align-items-end">Add Product</a>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Starting Inventory</th>
                                        <th>Inventory Received</th>
                                        <th>Inventory Hold</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($products as $key => $value) {
                                        echo "<tr><td>".++$offset."</td>";
                                        echo "<td>".$value['name']."</td>";
                                        echo "<td>".$value['category']."</td>";
                                        echo "<td>".$value['starting_inventory']."</td>";
                                        echo "<td>".$value['inventory_received']."</td>";
                                        echo "<td>".$value['inventory_hold']."</td>";
                                        echo "<td>
                                                <a href='".BASE_URL."add_edit_product.php?id=".$value['id']."'>
                                                    <i class='fa fa-edit'></i>
                                                </a> &nbsp;
                                                <a href='".BASE_URL."inventory_list.php?id=".$value['id']."&action=delete'>
                                                    <i class='fa fa-trash-o' aria-hidden='true'></i>
                                                </a>
                                            </td></tr>";
                                    } ?>
                                </tbody>
                            </table>
                            <?php echo $pagination->createLinks(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    	<footer></footer>
    </div>
<!-- /. PAGE INNER  -->
</div>
<!-- /. PAGE WRAPPER  -->
<?php
require_once("./templates/footer.php");
?>