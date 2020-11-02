<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<title>Checkout Complete Page</title>

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

	    $search_output ='<a id= search_results href="product.php?id='.$id.'" title="'.$product_name.'"><img style="border:#000000 1px solid;" src="inventory_images/' . $id . '.jpg" alt="' . $product_name . '" width="77" height=102" border="1" /></a><a target="_blank"></a>';
	
        echo  '<h3>' . $search_output  . '</br>' . '</br>' . ' ' . $id . '</br>' . '</br>' . ' ' . $product_name . '</br>' .  ' ' . $category. '</br>' .  ' £ ' . $price.'</p><br />' ;            
	}

}
?>
</div>
</div>





<div id="pageMiddle" >

<div style="margin:24px; text-align:left;">
    </br>
    </br>
    </br>
    </br>
        <?php echo 'Your transaction has completed successfully' ?>
    </br>
    </br>
    </br>
        <a href="cart.php?cmd=emptycart">Click here to return to main product page</a>
</div>
    
</div>





<div id="statusarea">

</div>




<div id="pageBottom" style="margin-top: 40px">
	    <?php include_once("../bulkhead_vision_3/footers/template_store_footer.php");?>
</div>


</div>
</body>
</html>