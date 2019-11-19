<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
require_once("./config.php");

include_once("classes/Crud.php");
 
$crud = new Crud();
 
//fetching data in descending order (lastest entry first)
/*$query = "SELECT * FROM products ORDER BY id DESC";
$result = $crud->getData($query);
echo '<pre>'; print_r($result); exit;*/


$page_slug = "inventory_list";
require_once("./templates/header.php");
require_once("./templates/menu.php");

//Add/Edit

if(isset($_POST['add_edit_prd']))
{
    $id = isset($_POST['id'])?$_POST['id']:'';
    $name = isset($_POST['name'])?$_POST['name']:'';
    $category = isset($_POST['category'])?$_POST['category']:'';
    $starting_inventory = isset($_POST['starting_inventory'])?$_POST['starting_inventory']:'';
    $inventory_received = isset($_POST['inventory_received'])?$_POST['inventory_received']:'';
    $inventory_hold = isset($_POST['inventory_hold'])?$_POST['inventory_hold']:'';

    if($id != '' && $id > 0)
    {
        //update
        $upd_query = "update products set name ='".$name."',category='".$category."',starting_inventory='".$starting_inventory."',inventory_received='".$inventory_received."',inventory_hold='".$inventory_hold."' where id = '".$id."'";
        //echo $upd_query; exit();
        $result = $crud->execute($upd_query);
        header("Location: ".BASE_URL."inventory_list.php");
    }
    else
    {
        $ins_query = "INSERT INTO products (`name`, `category`, `starting_inventory`, `inventory_received`, `inventory_hold`) VALUES ('".$name."', '".$category."', '".$starting_inventory."', '".$inventory_received."', '".$inventory_hold."');";

        $crud->execute($ins_query);
        header("Location: ".BASE_URL."inventory_list.php");
    }

}

if(isset($_GET['id']))
{
    $edit_id = $_GET['id'];
    $query = "SELECT * FROM products where id = '".$edit_id."'";

    $products = $crud->getData($query);
}
else
{
    $edit_id = '';
    $products = array();
}


$name = isset($products[0]['name'])?$products[0]['name']:'';
$category = isset($products[0]['category'])?$products[0]['category']:'';
$starting_inventory = isset($products[0]['starting_inventory'])?$products[0]['starting_inventory']:'';
$inventory_received = isset($products[0]['inventory_received'])?$products[0]['inventory_received']:'';
$inventory_hold = isset($products[0]['inventory_hold'])?$products[0]['inventory_hold']:'';
?>
<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                
                <h1 class="page-header">
                    Add Products
                </h1>
            </div>
        </div>
        <!-- /. ROW  -->

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <form role="form" action="<?php echo BASE_URL.'add_edit_product.php';?>" method="post">
                                    <div class="form-group">
                                        <label>Product Name</label>
                                        <input class="form-control" type="text" name="name" value="<?php echo $name; ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Category</label>
                                        <select class="form-control" name="category" required>
                                            <option value="">Select Category</option>
                                            <option value="cell-phones" <?php if($category == 'cell-phones') { echo "selected"; } ?> >Cell-phones</option>
                                            <option value="cars"  <?php if($category == 'cars') { echo "selected"; } ?> >cars</option>
                                        </select> 
                                    </div>

                                    <div class="form-group">
                                        <label>Starting Inventory</label>
                                        <input class="form-control" type="text" name="starting_inventory" value="<?php echo $starting_inventory; ?>"  >
                                    </div>

                                    <div class="form-group">
                                        <label>Inventory Received</label>
                                        <input class="form-control" type="text" name="inventory_received" value="<?php echo $inventory_received; ?>"  >
                                    </div>

                                    <div class="form-group">
                                        <label>Inventory Hold</label>
                                        <input class="form-control" type="text" name="inventory_hold" value="<?php echo $inventory_hold; ?>"  >
                                    </div>
                                    <input type="hidden" name="id" value="<?php echo $edit_id; ?>">
                                    <?php
                                    $btn_txt = "Add";
                                    if(isset($edit_id) && $edit_id > 0)
                                    {
                                        $btn_txt = "Edit";
                                    }
                                    ?>
                                    <button type="submit" name="add_edit_prd" class="btn btn-default"><?php echo $btn_txt; ?></button>
                                </form>
                            </div>
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