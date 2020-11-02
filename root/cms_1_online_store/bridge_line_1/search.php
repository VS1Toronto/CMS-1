<?php
//  1111111111

// Connect to the MySQL database  
include_once("../bulkhead_seal_1/connect_to_mysql.php");

//  This block grabs the whole product list and appends each entry
//  into its own table and displays them on the index page
$dollar = "$";
$dynamic_list = "";
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
        $dynamic_list .= '<table width="100%" border="0" cellspacing="0" cellpadding+"6">
        <tr>
            <td width=18%" valign="top">
                <a href="product.php?id=' . $id . '"><img style="border:#000000 1px solid;" src="inventory_images/' . $id . '.jpg" alt="' . $product_name . '" width="77" height=102" border="1" /></a>
            </td>
            <td width="83%" valign="top">' . $product_name . '<br />
                £' . $price . '<br />
                <a href="product.php?id=' . $id . '">View Product Details</a>
            </td>
        </tr>
        </br>
        </table>';
    }
} else {
    $dynamict_list = "You have no products listed in the store yet";
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<title>CMS 1 Store Search Page</title>

<link rel="stylesheet" href="../bulkhead_vision_3/style/style.css" media="screen" />

<script src="../bulkhead_vision_3/store_js/store_main.js"></script>


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
    
    
<div>
    <?php include_once("../bulkhead_vision_3/headers/template_store_header.php"); ?>
</div>
	

<div>
    </br>
    <?php echo 'Search Results' ?>
    </br>
    </br>
    <?php echo 'To return to product page  <a href="index.php">click here</a>' ?>
</div>


    
    

<div id="pageLeft">
    
<div id="search_container" width="400" height="400">
    
    
    
    
    
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

	    $search_output ='<a id= search_results href="product.php?id='.$id.'" title="'.$product_name.'"><img style="border:#000000 1px solid;" src="inventory_images/' . $id . '.jpg" alt="' . $product_name . '" width="77" height=102" border="1" /></a><a target="_blank"></a>';
	
        echo  '<h3>' . $search_output  . '</br>' . '</br>' . ' ' . $id . '</br>' . '</br>' . ' ' . $product_name . '</br>' .  ' ' . $category. '</br>' .  ' £ ' . $price.'</p><br />' ;            
	}

}
?>
</div>
</div>





<div id="pageMiddle" >



</div>





<div id="statusarea">

</div>





<div id="pageBottom" style="margin-top: 40px">
	    <?php include_once("../bulkhead_vision_3/footers/template_store_footer.php");?>
</div>


</div>
</body>
</html>