<?php
//  1111111111
session_start();
if (!isset($_SESSION["manager"])) {
    header("location: admin_login.php"); 
    exit();
}
$admin_index_page = '<a href="index.php">admin index page</a>';
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
//  Delete item Question to Admmin
//  deleteID is a url variable
if (isset($_GET['deleteID'])) {
	echo 'Do you really want to delete product with ID of ' . $_GET['deleteID'] . '? <a href="inventory_list.php?yesDelete=' . $_GET['deleteID'] . '">Yes</a> | <a href="inventory_list.php">No</a>';
	exit();
}
?>
<?php
//  Delete item Question to Admmin
//  yesDelete is a url variable
if (isset($_GET['yesDelete'])) {
    //  Remove from system and delete its picture
    //  Delete from database
    $id_to_delete = $_GET['yesDelete'];
    $sql = "DELETE FROM products WHERE id='$id_to_delete' LIMIT 1";
    $query = mysqli_query($db_conx_store, $sql); 
    //  Unlink image from server
    $pictodelete = ("../inventory_images/$id_to_delete.jpg");
    if(file_exists($pictodelete)){
        unlink($pictodelete);
    }
        header("location: inventory_list.php");
}
?>





<?php
//  4444444444
//  Parse the form data and add inventory item to the system
if(isset($_POST['product_name'])) {
    
    
    //  Step 1 - POSTED variables cleaned before entry to database

    $product_name   =   mysqli_real_escape_string($db_conx_store, $_POST['product_name']);
    $price          =   mysqli_real_escape_string($db_conx_store, $_POST['price']);
    $category       =   mysqli_real_escape_string($db_conx_store, $_POST['category']);
    $subcategory    =   mysqli_real_escape_string($db_conx_store, $_POST['subcategory']);
    $details        =   mysqli_real_escape_string($db_conx_store, $_POST['details']);
    

    
    
    //  Step 2 - See if that product name is an identical match to another product in the system
    $sql = "SELECT id FROM products WHERE product_name ='$product_name' LIMIT 1";
    $query = mysqli_query($db_conx_store, $sql); 
    
    $productMatch = mysqli_num_rows($query);  //  count the output amount
    if($productMatch){
            echo $product_name;
        echo 'Sorry you tried to place a duplicate "Product Name" into the system, <a href="inventory_list.php">click here</a>';
        exit();
    }
    
    //  Step 3 - Add this product into the database now
    $sql = "INSERT INTO products (product_name, price, category, subcategory, details, date_added)
            VALUES ('$product_name','$price','$category','$subcategory','$details', now())";
        
    $query = mysqli_query($db_conx_store, $sql); 
    //$productID = mysqli_insert_id_();
    
    $sql = "SELECT COUNT(*) FROM products";
    $query = mysqli_query($db_conx_store, $sql); 
    $rows = mysqli_fetch_row($query);
    //  This gives how many rows are in the product table so it can be used
    //  to populate the $newname variable below and give the jpeg the correct
    //  number for the correct row
    //echo $rows[0];

    
    //  Step 4 - Place image in the folder
	$newname = "$rows[0].jpg";
	move_uploaded_file($_FILES['fileField']['tmp_name'], "../inventory_images/$newname");
}
?>





<?php
//  5555555555
//  This block grabs the whole list for viewing
//  ?deleteID is a url variable
$dollar = "$";
$product_list = "";
$sql = "SELECT * FROM products ORDER BY date_added ASC";
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
        $price = $row["price"];
        $date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
        $product_list .= "Product ID: $id - <strong>$product_name</strong> - $dollar$price - $category - $subcategory - $details - <em>Added $date_added</em> &nbsp; &nbsp; &nbsp;
                        <a href='inventory_edit.php?productID=$id'>edit</a> &bull; <a href='inventory_list.php?deleteID=$id'>delete</a><br />";
    }
} else {
    $product_list = "You have no products listed in your store yet";
}
?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Inventory List Page</title>

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
        <div align="left" style="margin-left:24px;"><?php echo $admin_index_page; ?></div>
        <div align="right" style="margin-right:24px;"><a href="inventory_list.php#inventoryForm">+Add New Inventory item</a></div>
        
        <div align="left" style="margin-left:24px;">

            <h2>Inventory List</h2>

            <?php echo $product_list; ?>
        </div>
        <hr />
		<a name="inventoryForm" id+"inventoryForm"></a>
		<h3>
			&darr;Add New Inventory Item Form &darr;
		</h3>
		<form action="inventory_list.php" enctype="multipart/form-data" name="myForm" id="myForm" method="post">
		<table width="90%" border="0" cellspacing="0" cellpadding="6">
			<tr>
				<td width="20%" align+"right">Product Name</td>
				<td width="80%"><label>
				    <input name="product_name" type="text" id="product_name" size="64" />
				</label>
			</tr>
			<tr>
			    <td align="right">Product Price</td>
			    <td><label>
			        $
			        <input name="price" type="text" id+"price" size="12" />
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
			    <option value=""></option> 
			        <option value="Hats">Hats</option>
			        <option value="Trousers">Trousers</option>
			        <option value="Shirts">Shirts</option>
			        <option value="Shoes">Shoes</option>
			    </select></td>
			</tr>
			<tr>
			    <td align="right">Product Details</td>
			    <td><label>
			        <textarea name="details" id="details" cols="64" rows="5"></textarea>
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
			        <input type="submit" name="button" id="button" value="Add This Item Now" />
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

