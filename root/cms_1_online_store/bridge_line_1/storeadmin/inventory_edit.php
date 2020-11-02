<?php
//  1111111111
session_start();
if (!isset($_SESSION["manager"])) {
    header("location: admin_login.php"); 
    exit();
}
$edit_Product_Complete = "";
// Be sure to check that this manager SESSION value is in fact in the database
$managerID = preg_replace('#[^0-9]#i', '', $_SESSION["id"]); // filter everything but numbers and letters
$manager = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["manager"]); // filter everything but numbers and letters
$password = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["password"]); // filter everything but numbers and letters
// Run mySQL query to be sure that this person is an admin and that their password session var equals the database information


// Connect to the MySQL database  
include_once("../../bulkhead_seal_1/connect_to_mysql.php");


$sql = "SELECT * FROM admin WHERE id=$managerID AND username='$manager' AND password='$password' LIMIT 1";
$query = mysqli_query($db_conx_store, $sql); 


// ------- MAKE SURE PERSON EXISTS IN DATABASE ---------
$existCount = mysqli_num_rows($query); // count the row nums
if ($existCount == 0) { // evaluate the count
	 echo "Your login session data is not on record in the database.";
}
?>





<?php
//  2222222222
//  This block is for Error Reporting
//  Some Php.ini files are setup to suppress display_errors
//  This code will force them to display if they occur
//error_reporting(E_ALL);
//ini_set('display_errors','1');
?>




<?php
//  3333333333
//  Parse the form data and add inventory item to the system
if(isset($_POST['product_name'])) {
    
    
    //  Step 1 - POSTED variables cleaned before entry to database
    $productID      =   mysqli_real_escape_string($db_conx_store, $_POST['thisID']);
    $product_name   =   mysqli_real_escape_string($db_conx_store, $_POST['product_name']);
    $price          =   mysqli_real_escape_string($db_conx_store, $_POST['price']);
    $category       =   mysqli_real_escape_string($db_conx_store, $_POST['category']);
    $subcategory    =   mysqli_real_escape_string($db_conx_store, $_POST['subcategory']);
    $details        =   mysqli_real_escape_string($db_conx_store, $_POST['details']);
    

    
    
    //  Step 2 - See if that product name is an identical match to another product in the system
    $sql = "UPDATE products SET product_name='$product_name',price='$price',category='$category',
                subcategory='$subcategory',details='$details' WHERE id='$productID' LIMIT 1";
    $query = mysqli_query($db_conx_store, $sql); 
    
    if($_FILES['fileField']['tmp_name']!=""){
    //  Step 4 - Place image in the folder
	    $newname = "$productID.jpg";
	    move_uploaded_file($_FILES['fileField']['tmp_name'], "../inventory_images/$newname");
    }
    $edit_Product_Complete = 'Product Editing Complete  <a href="inventory_list.php">click here</a>';
    
    header("location: admin_login.php"); 
}
?>





<?php
//  4444444444
//  Gather this product's full information for inserting automatically into the edit form below on page
//  productID is a url variable
if (isset($_GET['productID'])) {
        //  Step 1 - Get variable cleaned before entry to database
        //productID  =   mysqli_real_escape_string($db_conx_store, $_GET['productID']);

        $targetID = $_GET['productID'];
        $sql = "SELECT * FROM products WHERE id='$targetID' LIMIT 1";
        $query = mysqli_query($db_conx_store, $sql); 
        $productCount = mysqli_num_rows($query); // count the output amount
        if($productCount > 0){
            while($row = mysqli_fetch_array($query)){
                $id = $row["id"];
                $product_name = $row["product_name"];
                $price = $row["price"];
                $category = $row["category"];
                $subcategory = $row["subcategory"];
                $details = $row["details"];
                $date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
            }
        } else {
            echo 'Sorry that product is not listed in the store , <a href="inventory_edit.php">click here</a>';
        }
}      
?>




















<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Inventory Edit Page</title>

<link rel="stylesheet" href="../../bulkhead_vision_3/style/style.css" type="text/css" media="screen" />

<script src="../../bulkhead_vision_3/stoe_js/store_main.js"></script>


<script type="text/javascript">
	function active(){
		var searchBar = document.getElementById('searchBar');
				
		if(searchBar.value == 'Search...'){
			searchBar.value = ''
			searchBar.placeholder = 'Search...'
		}
	}
	function inactive(){
		var searchBar = document.getElementById('searchBar');
				
		if(searchBar.value == ''){
			searchBar.value = 'Search...'
				searchBar.placeholder = ''
		}
	}
</script> 






</head>

<body>
    
    
    
    
    
<div id="main_wrapper">
    
    
    
    
        
<div align="center" id="pageTop">
	<?php include_once("../../bulkhead_vision_3/headers/template_store_admin_header.php"); ?>
</div>





<div id="pageLeft">
    
    
    
    
    
<?php
// Connect to the MySQL database  
include_once("../../bulkhead_seal_1/connect_to_mysql.php");
error_reporting(E_ALL);
ini_set('display_errors', '1');
$search_output = "";
if(isset($_GET['searchquery']) && $_GET['searchquery'] != ""){
	$searchquery = preg_replace('#[^a-z 0-9?!]#i', '', $_GET['searchquery']);
    $sqlCommand="SELECT id, product_name, price, category FROM products WHERE product_name LIKE '%$searchquery%' OR category LIKE '%$searchquery%'";
    $query = mysqli_query($db_conx_store, $sqlCommand); 

    $num_rows = mysqli_num_rows($query);
	$search_output .= "<hr />$num_rows results for <strong>$searchquery</strong><hr />$sqlCommand<hr />";

	
    while($row = mysqli_fetch_array($query)){
        $id = $row['id'];
        $product_name = $row['product_name'];
        $price = $row["price"];
        $category = $row["category"];

	    $search_output ='<a id= search_results href="admin_product.php?id='.$id.'" title="'.$product_name.'"><img style="border:#000000 1px solid;" src="http://leedavidsoncontentmanagementsystem1.com/cms_1/root/cms_1_online_store/bridge_line_1/inventory_images/' . $id . '.jpg" alt="' . $product_name . '" width="77" height=102" border="1" /></a><a target="_blank"></a>';
	
        echo  '<h3>' . $search_output  . '</br>' . '</br>' . ' ' . $id . '</br>' . '</br>' . ' ' . $product_name . '</br>' .  ' ' . $category. '</br>' .  ' £ ' . $price.'</p><br />' ;            
	}

}
?>
</div>
	
	
	



<div id="pageMiddle">
    
    <div id="pageContent"><br />
        
        <div align="right" style="margin-right:24px;"><a href="inventory_list.php#inventoryForm">+Add New Inventory item</a></div>
        
        <div align="left" style="margin-left:24px;">
            <h2>Inventory List</h2>
            <?php echo $edit_Product_Complete; ?>
        </div>
        <hr />
		<a name="inventoryForm" id+"inventoryForm"></a>
		<h3>
			&darr;Edit Inventory Item Form &darr;
		</h3>
		<form action="inventory_edit.php" enctype="multipart/form-data" name="myForm" id="myForm" method="post">
		<table width="90%" border="0" cellspacing="0" cellpadding="6">
			<tr>
				<td width="20%" align+"right">Product Name</td>
				<td width="80%"><label>
				    <input name="product_name" type="text" id="product_name" size="64"  value="<?php echo $product_name; ?>" />
				</label>
			</tr>
			<tr>
			    <td align="right">Product Price</td>
			    <td><label>
			        $
			        <input name="price" type="text" id+"price" size="12" value="<?php echo $price; ?>"
			    </label></td>
			</tr>
			<tr>
			    <td align="right">Category</td>
			    <td><label>
			        <select name="category" id="category">
			        <option value="Clothing">Clothing</option>
			        </select>
			    </label></td>
			</tr>
			<tr>
			    <td align="right">Subcategory</td>
			    <td><select name="subcategory" id="subcategory">
                        <option value="<?php echo $subcategory; ?>"><?php echo $subcategory; ?></option>
			            <option value="Hats">Hats</option>
			            <option value="Trousers">Trousers</option>
			            <option value="Shirts">Shirts</option>
			            <option value="Shoes">Shoes</option>
			        </select>
			    </td>
			</tr>
			<tr>
			    <td align="right">Product Details</td>
			    <td><label>
			        <textarea name="details" id="details" cols="64" rows="5"><?php echo $details; ?></textarea>
			    </label></td>
			</tr>
			<tr>
			    <td align="right">Product Image</td>
			    <td><label>
			        <input type="file" name="fileField" id="fileField" />
			    </label></td>
			</tr>
			<tr>
			    <td>&nbsp;</td>
			    <td><label>
			        <input name="thisID" type="hidden" value="<?php echo $targetID; ?>" />
			        <input type="submit" name="button" id="button" value="Make Changes" />
			    </label></td>
			</tr>
		</table>
		</form>
        <br />
        <br />
        <br />
    </div>

</div>





<div id="pageBottom">
	    <?php include_once("../../bulkhead_vision_3/footers/template_store_admin_footer.php");?>
</div>


</div>
</body>
</html>