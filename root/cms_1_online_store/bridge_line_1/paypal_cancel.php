<?php
//Start the session
session_start();
// Connect to the MySQL database  
include_once("../bulkhead_seal_1/connect_to_mysql.php");
$space = "";
//  Transactions form variables
//
$transaction_id = "";
$payment_date = "";
$first_name = "";
$last_name = $_POST['last_name'];
$price_from_paypal = "";
$client_email = $_POST['client_email'];
$transaction_date = $_POST['transaction_date'];
$database_output = "";
$txn_search_output = "";
?>
<?php
//////////////////////////////////////////////////////////////////////////////////
//  1111111111
//  This is the section that renders the cart for the user to view
//
//  The cart_array SESSION variable only holds IDs and QUANTITIES of those IDS to 
//  keep things streamlined thats why its necessary to query the database to get
//  the products other details
//////////////////////////////////////////////////////////////////////////////////
//
$cartOutput = "";

//  Red warning bar variables
//
$cart_total = "";
$paypal_total = "";


if(!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1){
$cartOutput = "<h2 align='center'>Your shopping cart is empty</h2>";
} else {
    $i = 0;
    //  Within this for loop the code accesses each item that is in the cart 
    //  multi-dimentional array
    //
    //  So for each associative array inside the main cart array there is an
    //  each_item variable created for each item in the array so the while
    //  loop can be removed and we can instead access each individual indice
    //  within the array in the new code below above the commented out while
    //  loop
    foreach($_SESSION["cart_array"] as $each_item){
        //  We are using the SESSION data below to populate a local variable 
        //  to use it i.e. item_id to access the database for that particular
        //  item with that particular item_id
        $item_id = $each_item['item_id'];
        $sql = "SELECT * FROM products WHERE id='$item_id' LIMIT 1";
        $query = mysqli_query($db_conx_store, $sql); 
        //  The while loop below allows us to access each variable and 
        //  populate local variables with them so that we can then
        //  easily use them throughout the page as we do immediately
        //  below the while loop
        while($row = mysqli_fetch_array($query)){
            $product_name = $row["product_name"];
            $price = $row{"price"};
            $details = $row["details"];
        }
        //  This code takes the price of the individual item and multiplies
        //  it by the quantity to ensure the correct price if the user picks
        //  the same item multiple times and this line has been changed
        //  from $price to $price_total because we are pulling the $price_total
        //  single from the databse while loop above and need the line below
        //  for calulating and displaying $price_total should the user pick
        //  the same item multiple times
        $price_total = $price * $each_item['quantity'];
        $cart_total = $price_total + $cart_total;
        //  !!!!!     This code update from the line above is incredibly important and that is why I have highlighted it     !!!!!
        //  Without this code containing the number_format function php will remove the decimal endings to any number it performs 
        //  a mathematical number it performs a mathematical calculation on like $price_total     it also adds its own  £ sign
        setlocale(LC_MONETARY, "en_GB.UTF-8");
        $price_total = money_format("%10.2n",$price_total);


        //  Dynamic Table Row assembly
        //  This is the dynamic table row assembly code however i'm removing
        //  the table borders in the html because it looks to dated like that
        //
        //  Some of the data below is drawn from the database and some from
        //  the SESSION variables
        $cartOutput .= "<tr>";
		$cartOutput .= '<td><a href="product.php?id=' . $item_id . '">' . $product_name . '</a><br /><img src="inventory_images/' . $item_id . '.jpg" alt="' . $product_name. '" width="40" height="52" border="1" /></td>';
        //  The line below is a second way to write the line above if there are problems with the . ' syntax
        //$cartOutput .= "<td><a href=\"product.php?id=$item_id\">$product_name</a><br/><img src=\"inventory_images/$item_id.jpg\" alt=\" $product_name\" width=\"40\" height=\"52\" border=\"1\" /></td>";		
		$cartOutput .= '<td>' . $details . '</td>';
		$cartOutput .= '<td>£' . $price . '</td>';
		//$cartOutput .= '<td>' . $each_item['quantity'] . '</td>';
		// Current max length in change cart amount below is set to "2" which allows a user to put in 999 into the amount box if it was set to "1" it would be a maximum of 9
		$cartOutput .= '<td><form action="cart.php" method="post">
		<input name="quantity" type="text" value="' . $each_item['quantity'] . '" size="1" maxlength="2" />
		<input name="adjustBtn' . $item_id . '" type="submit" value="change" />
		<input name="item_to_adjust" type="hidden" value="' . $item_id . '" />
		</form></td>';
		$cartOutput .= '<td> ' . $price_total . '</td>';
		
		//  In the code below to remove an item we are sending the value of this array index pointer     "type="hidden" value+"' . $i . '"     
		//  to the piece of code above that deletes an entry
		//
		//  In the code below     "name="deletBtn . $item_id . '"     this is done to make sure each delete button has a unique id to avoid 
		//  validation errors by making sure the repeated form output to the page does not contain multiple delete buttons all with the same id
		$cartOutput .= '<td>
		                <form action="cart.php" method="post">
		                    <input name="deleteBtn' . $item_id . '" type="submit" value="X" />
                            <input name="index_to_remove" type="hidden" value="' . $i . '" />
                        </form>
                        </td>';
		$cartOutput .= '</tr>';
		$i++; 
    }

    //  !!!!!     This code update from the line above is incredibly important and that is why I have highlighted it     !!!!!
    //  Without this code containing the number_format function php will remove the decimal endings to any number it performs 
    //  a mathematical number it performs a mathematical calculation on like $cart_total     it also adds its own  £  sign
    setlocale(LC_MONETARY, "en_GB.UTF-8");
    $cart_total = money_format("%10.2n",$cart_total);
    $cart_total = "Cart Total: ".$cart_total . " GBP";
    


    //  This is another way to position the total value, i've left it as a reference point
    //$cart_total = "<div align='right'>Cart Total: £ " . $cart_total . " GBP </div>";
}
?>
<?php
        if(isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1) { 
            
        foreach($_SESSION["cart_array"] as $each_item){
        //  We are using the SESSION data below to populate a local variable 
        //  to use it i.e. item_id to access the database for that particular
        //  item with that particular item_id
        $item_id = $each_item['item_id'];
        $sql = "SELECT * FROM transactions WHERE payer_email='$client_email' AND last_name='$last_name' LIMIT 1000";
        $query = mysqli_query($db_conx_store, $sql); 
        //  The while loop below allows us to access each variable and 
        //  populate local variables with them so that we can then
        //  easily use them throughout the page as we do immediately
        //  below the while loop
        while($row = mysqli_fetch_array($query)){
            $paypal_total = "Paypal Total: £". $row{"mc_gross"} ." GBP";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<title>Paypal Cancel Page</title>

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



<script type="text/javascript">

function (){

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
        <strong><?php echo 'Your transaction has a price discrepancy' ?></strong>
        </br>
        </br>
        <strong><?php echo 'the cart and Paypal totals do not match' ?></strong>
        </br>
        </br>
        <strong><?php echo 'please investigate further' ?></strong>
    </br>
    </br>
    </br>
    </br>
      <div style="margin:24px; text-align:left;">
    <br />
            </br>
            <div>
                <strong><?php echo 'CART INFORMATION' ?></strong>
            </div>
        </br>
    <table width="100%"  cellspacing="0" cellpadding="6">
        <tr>
            <td width="18%" bgcolor="#EAEAEA"><strong>Product</strong></td>
            <td width="47%" bgcolor="#EAEAEA"><strong>Product Description</strong></td>
            <td width="10%" bgcolor="#EAEAEA"><strong>Unit Price</strong></td>
            <td width="9%"  bgcolor="#EAEAEA"><strong>Quantity</strong></td>
            <td width="7%"  bgcolor="#EAEAEA"><strong>Total</strong></td>
            <td width="9%"  bgcolor="#EAEAEA"><strong>Remove</strong></td>
        </tr>
    <?php echo $cartOutput; ?>
    </table>
    </br>
    </br>
    </br>
        <div>
            <div style="margin:24px; text-align:center; border-style: solid; border-color: red;">
                <strong><h2><?php echo $cart_total; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            &nbsp;&nbsp;<?php echo $paypal_total; ?></h2></strong>
            </div>
        </div>
    </br>

    </div>  

        <?php
        if(isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1) { 
            
            
        foreach($_SESSION["cart_array"] as $each_item){
        //  We are using the SESSION data below to populate a local variable 
        //  to use it i.e. item_id to access the database for that particular
        //  item with that particular item_id
        $item_id = $each_item['item_id'];
        $sql = "SELECT * FROM products WHERE id='$item_id' LIMIT 1";
        $query = mysqli_query($db_conx_store, $sql); 
        //  The while loop below allows us to access each variable and 
        //  populate local variables with them so that we can then
        //  easily use them throughout the page as we do immediately
        //  below the while loop
        while($row = mysqli_fetch_array($query)){
            $database_output .=  'Product ID = '. $productID = $row['id'] . '<br />';
            $database_output .=  'Product Name = '. $product_name = $row['product_name'] . '<br />';
            $database_output .=  'Price = '. $price_from_store_database = $row['price'] . '<br />';
            $database_output .=  '' . '<br />';               
            $database_output .=  '' . '<br />'; 
            }
        }

        
        }
        ?>
        <div style="margin:24px; text-align:left;">
            </br>
                <div>
                    <strong><?php echo 'DATABASE INFORMATION' ?></strong>
                </div>
            </br>
                <div>
                    <?php echo $database_output; ?>
                </div>
            </br>
        </div>







        <?php
        if(isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1) { 
            
        foreach($_SESSION["cart_array"] as $each_item){
        //  We are using the SESSION data below to populate a local variable 
        //  to use it i.e. item_id to access the database for that particular
        //  item with that particular item_id
        $item_id = $each_item['item_id'];
        $sql = "SELECT * FROM transactions WHERE payer_email='$client_email' AND last_name='$last_name' LIMIT 1000";
        $query = mysqli_query($db_conx_store, $sql);
        $productCount = mysqli_num_rows($query); // count the output amount
        while($row = mysqli_fetch_array($query)){
            $txn_search_output .=  'Transaction ID = '.$transaction_id = $row['id'] . '<br />';
            $txn_search_output .=  'Payment Date = '.$payment_date = $row['payment_date'] . '<br />';
            $txn_search_output .=  'First Name = '.$first_name = $row["first_name"] . '<br />';
            $txn_search_output .=  'Last Name = '.$last_name = $row['last_name'] . '<br />';               
            $txn_search_output .=  'Paypal Total Recorded Transaction = £'.$price_from_paypal = $row['mc_gross']. '<br />';
            $txn_search_output .=  '' . '<br />';               
            $txn_search_output .=  '' . '<br />'; 

            }
            }
        }
        ?>
        <div style="margin:24px; text-align:left;">
            </br>
                <div>
                    <strong><?php echo 'PAYPAL TRANSACTIONS INFORMATION' ?></strong>
                </div>
            </br>
                <div>
                    <?php echo $txn_search_output; ?>
                </div>
            </br>
            </br>
                <div>
                    <strong><?php echo 'Enter Client Email and Last Name in the Form Shown' ?></strong>
                </div>
            </br>
            <form id="form1" action="paypal_cancel.php" method='post'>
                <div>Client Email: </div>
                <input id="client_email" type="text" name="client_email" placeholder="Enter client email" />
                </br>
                </br>
                <div>Client Surname: </div>
                <input id="last_name" type="text" name="last_name" placeholder="Enter last name" />
                </br>
                </br>
                </br>
                <input id="search_button" type="submit"   value="Search Transactions" />
            </form>
        </div>
        
    <div style="margin:24px; text-align:right;">
        <?php echo 'To return to product page  <a href="index.php">click here</a>' ?>
    </div>
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