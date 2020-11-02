<?php
//  1111111111

// Connect to the MySQL database  
include_once("../bulkhead_seal_1/connect_to_mysql.php");

//  This block grabs the whole product list and appends each entry
//  into its own table and displays them on the index page
$dollar = "$";
$dynamic_list = "";
$sql = "SELECT * FROM products ORDER BY date_added DESC";
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
                $' . $price . '<br />
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Product Page</title>

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




<div id="pageMiddle" >
    
    
<div id="table1" >
  <table width="100%" cellspacing="0" cellpadding="10">
  <tr>
    <td width="32%" valign="top">
        <h3>What the Hell?</h3>
      <p>This Wevsite is very temporarily being used as an online live showcase area for an E - Commerce script:<br />
        <a href="" target="http://www.youtube.com/flashbuilding" target="_blank">http://www.youtube.com/flashbuildin</a></p>
        
      <p>It is not an actual store and it will change directly after the tutorial series. <br />
        <br />
        This tutorial series is for educational purposes only. Use the scripts at your own risk.</p>
    </td>
    <td width="35%" valign="top">
        <h3>Latest Designer Fashions</h3>
            <p><?php echo $dynamic_list; ?><br />
            </p>
            <p><br />
            </p>
    </td>
    <td width="33%" valign="top">
        <h3>Handy Tips</h3>
            <p>If you operate any store online you should read the documentation provided to you by the online payment gateway you choose 
                for handling the checkout process. You can get much more insight than I can offer on the various details of a gateway, from
                the gateway providers themselves. They are there to help you with whatever you need since they get a cut of your online business dealings.</p></td>
    </tr>
    </table>
 </div>   


</div>





<div id="pageBottom" style="margin-top: 0px">
	    <?php include_once("../bulkhead_vision_3/footers/template_store_footer.php");?>
</div>


</div>
</body>
</html>





