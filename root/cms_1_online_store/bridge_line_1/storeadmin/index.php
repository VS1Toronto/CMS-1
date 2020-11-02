<?php 
session_start();
if (!isset($_SESSION["manager"])) {
    header("location: admin_login.php"); 
    exit();
}

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
     exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Store Admin Index Page</title>

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
include_once("../bulkhead_seal_1/connect_to_mysql.php");
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
        <div align="left" style="margin-left:24px;">
            <h2>Hello store manager, what would you like to do today?</h2>
            <p><a href="inventory_list.php">Manage Inventory</a><br />
            <p><a href="http://leedavidsoncontentmanagementsystem1.com/cms_1/root/cms_1_online_store/bridge_line_1/index.php">Exit to store</a><br />
        </div>
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
