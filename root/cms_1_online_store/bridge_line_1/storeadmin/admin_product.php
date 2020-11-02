<?php
//  1111111111
// Connect to the MySQL database  
include_once("../../bulkhead_seal_1/connect_to_mysql.php");
?>
<?php 
//  2222222222
//  Script Error Reporting turn on to
//  find errorsif you are having problems
//
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
?>
<?php
//  3333333333
// Check to see the URL variable is set and that it exists in the database
if (isset($_GET['id'])) {
    
	// Connect to the MySQL database  
    include_once("../../bulkhead_seal_1/connect_to_mysql.php");
    
	$id = preg_replace('#[^0-9]#i', '', $_GET['id']); 
	// Use this var to check to see if this ID exists, if yes then get the 
	// product details, if no provide message and link back to this script
	
	$sql = "SELECT * FROM products WHERE id='$id' LIMIT 1";
    $query = mysqli_query($db_conx_store, $sql); 
	

	$productCount = mysqli_num_rows($query); // count the output amount
    if ($productCount > 0) {
		// get all the product details
		while($row = mysqli_fetch_array($query)){ 
            $product_name = $row["product_name"];
            $price = $row["price"];
            $category = $row["category"];
            $subcategory = $row["subcategory"];
            $details = $row["details"];
            $price = $row["price"];
            $date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
            $full_image = '<a href="product_full_size.php?id=' . $id . '">View Full Size Image</a>';
         }
	} else {
	    echo 'Sorry that product is not listed in the store , <a href="product.php">click here</a>';
	}
		
} else {
    echo 'Data to render this page is missing , <a href="product.php">click here</a>';;
}
mysqli_close();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Product Page</title>

<link rel="stylesheet" href="../../bulkhead_vision_3/style/style.css" media="screen" />

<script src="../../bulkhead_vision_3/store_js/store_main.js"></script>


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

	    $search_output ='<a id= search_results href="admin_product.php?id='.$id.'" title="'.$product_name.'"><img style="border:#000000 1px solid;" src="inventory_images/' . $id . '.jpg" alt="' . $product_name . '" width="77" height=102" border="1" /></a><a target="_blank"></a>';
	
        echo  '<h3>' . $search_output  . '</br>' . '</br>' . ' ' . $id . '</br>' . '</br>' . ' ' . $product_name . '</br>' .  ' ' . $category. '</br>' .  ' £ ' . $price.'</p><br />' ;            
	}

}
?>
</div>
</div>




<div id="pageMiddle" >
    
<div id="table1" >
    <table width="100%" cellspacing="0" cellpadding="10">
        <tr>
            <td width="32%" valign="top"><img src="inventory_images/<?php echo $id; ?>.jpg" width="480" height="480" alt="$product_name" /></br>
                <p><?php echo $full_image; ?><br />
            </td>
            <td width="80%" valign="top">
                <h3><?php echo $product_name; ?></h3>
                </br>
                <p><?php echo "£".$price ?>
                </br>
                </br>
                    <?php echo "$subcategory $category"; ?>
                </br>
                </br>
                    <?php $details; ?>
                </p>
                <p>
                    <form id="form1" name="form1" method="post" action="cart.php">
                    <input type="hidden" name="productID" id-"productID" value="<?php echo $id; ?>" />
                    <input type="submit" name="button" id="button" value="Add to Shopping Cart" />
                </form>
                <p>
                </br>
                </br>
                    <?php echo 'Click here to return to product page , <a href="index.php">click here</a>' ?>;
                </p>
            </td>
        </tr>
    </table>
</div>       

</div>





<div id="pageBottom" style="margin-top: 40px">
	    <?php include_once("../../bulkhead_vision_3/footers/template_store_footer.php");?>
</div>


</div>
</body>
</html>