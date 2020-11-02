<?php
//////////////////////////////////////////////////////////////////////////////////
//  1111111111
//  Start session first thing in script then connect to database immediately after
//  to ensure access to the database from anywhere in this script
//////////////////////////////////////////////////////////////////////////////////
//
session_start();
// Connect to the MySQL database  
include_once("../bulkhead_seal_1/connect_to_mysql.php");
?>
<?php 
//////////////////////////////////////////////////////////////////////////////////
//  2222222222
//  Script Error Reporting turn on to
//  find errors if you are having problems
//////////////////////////////////////////////////////////////////////////////////
//
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
?>
<?php
//////////////////////////////////////////////////////////////////////////////////
//  3333333333
//  This is the section that deals with the cart existence and its contents
//////////////////////////////////////////////////////////////////////////////////
//
//  This is grabbing the productID from POST which is sent when the user pushes 
//  submit on the form on the product page i.e. the button Add To Shopping Cart
if (isset($_POST['productID'])) {
    $productID = $_POST['productID'];
	$wasFound = false;
	$i = 0;
	
	// If the cart session variable is not set or cart array is empty
	if (!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1) { 
	    //  Run if the cart is empty or not set i.e. this is pushing
        //  the  first variable into the cart if it is empty
		$_SESSION["cart_array"] = array(0 => array("item_id" => $productID, "quantity" => 1));
	} else {
        //  If it is not empty then run if the cart has at least one item in it i.e. if this item
        //  is already in the cart you do the the splice and add another of the same item
		foreach ($_SESSION["cart_array"] as $each_item) { 
		      $i++;
		      while (list($key, $value) = each($each_item)) {
				  if ($key == "item_id" && $value == $productID) {
                    //  That item is in cart already so lets adjust its quantity using array_splice()
                    array_splice($_SESSION["cart_array"], $i-1, 1, array(array("item_id" => $productID, "quantity" => $each_item['quantity'] + 1)));
					  $wasFound = true;
				  } // close if condition
		      } // close while loop
            } // close foreach loop
            //  if the this is a new item run this to push it into the cart 
            //  i.e. it adds the new item to the aray at the end of the array
            //  or in other words it will add a new assosiative array to the 
            //  end of your multi-dimentional array with a quantity of 1
            if ($wasFound == false) {
                array_push($_SESSION["cart_array"], array("item_id" => $productID, "quantity" => 1));
            }
	}
	//  This line is VERY IMPORTANT it stops a double
	//  adding of a product if the user refreshes the page
	header("location: cart.php"); 
}
?>
<?php
//////////////////////////////////////////////////////////////////////////////////
//  4444444444
//  This code deals with emptying the cart if the user chooses to do so
//////////////////////////////////////////////////////////////////////////////////
//
if(isset($_GET['cmd']) && $_GET['cmd'] == "emptycart"){
   unset($_SESSION["cart_array"]);
   
   	//  This line redirects to the index page because when a transaction is
	//  completed the user is redirected to checkout_complete.php which sets
	//  the     cmd     SESSION variable above to     emptycart     via the
	//  only button available to the user which redirects to the cart in its
	//  final step which causes the user to arrive here for momentarily with
	//  the above session variables set which causes this code block to run
	//  which empties the cart before taking its final step below and
	//  redirecting to the main index page
	//
	//  This is all done to ensure that when the user completes a purchase
	//  through Paypal and the user is redirected back to the
	//  checkout_complete.php     that the cart is emptied as a final step
	//  to avoid any confusion if the user continues to shop.
	//
	header("location: index.php"); 
}
?>






<?php
//////////////////////////////////////////////////////////////////////////////////
//  5555555555
//  This code is what is called from the first form in block 7777777777 when the 
//  user alters the amount of each unit
//////////////////////////////////////////////////////////////////////////////////
//
if(isset($_POST['item_to_adjust']) && $_POST['item_to_adjust'] != ""){
    //  Execute some code
    $item_to_adjust = $_POST['item_to_adjust'];
    $quantity = $_POST['quantity'];
    //  !!!!!     You must do this to stop people putting points in and halfing things     !!!!!
    //  Filter everything but numbers  
    //
	$quantity = preg_replace('#[^0-9]#i', '', $quantity); 
    //  The code below prevents anyone from trying to buy more than 99 of any item_id
    //
    if($quantity >= 100){
        $quantity = 99;
    }
    //  The code below prevents anyone from trying to put in a zero
    //  If they want to delete the product we have the delete
    //  functionality for that
    //
    if($quantity < 1){
        $quantity = 1;
    }
    $i = 0;
    foreach($_SESSION["cart_array"] as $each_item){
        $i++;
        while(list($key, $value) = each($each_item)){
            if($key == "item_id" && $value == $item_to_adjust){
                //  That item is in cart already so lets adjust its quantity  using array_aplice()
                array_splice($_SESSION["cart_array"], $i-1, 1, array(array("item_id" => $item_to_adjust, "quantity" => $quantity)));
            }
        }
    }
}
  	//  This line is VERY IMPORTANT it stops a double adjustment
	//  of a product if the user refreshes the page
	header("location: cart.php");  
?>






<?php
//////////////////////////////////////////////////////////////////////////////////
//  6666666666
//  This is the delete function called from the from the second form in block 
//  7777777777 when the user wants to delete a product by clicking one of the X 
//  button on the page, if there is only one item in the cart the "if" statement 
//  will simply empty the cart, if there are multiple items the "else" will target
//  the individual item chosen via the POSTED "index_to_remove" variable
//////////////////////////////////////////////////////////////////////////////////
//
if (isset($_POST['index_to_remove']) && $_POST['index_to_remove'] != "") {
    // Access the array and run code to remove that array index
 	$key_to_remove = $_POST['index_to_remove'];
	if (count($_SESSION["cart_array"]) <= 1) {
		unset($_SESSION["cart_array"]);
	} else {
		unset($_SESSION["cart_array"]["$key_to_remove"]);
		//  The code below sorts the array into its correct linear numbered form
		//  after you remove a cell from it's order i.e. 0 1 3 4 because cell
		//  2222222222 as removed will be reordered as 0 1 2 3
		sort($_SESSION["cart_array"]);
	}
}
?>
<?php
//////////////////////////////////////////////////////////////////////////////////
//  7777777777
//  This is the section that renders the cart for the user to view
//
//  The cart_array SESSION variable only holds IDs and QUANTITIES of those IDS to 
//  keep things streamlined thats why its necessary to query the database to get
//  the products other details
//////////////////////////////////////////////////////////////////////////////////
//
$cartOutput = "";
$cart_total = "";


//  PAYPAL STEP 1
//
//  This is the Paypal button
//
$paypal_checkout_button = '';


//  PAYPAL STEP 2
//
//  This is the custom variable that we send to Paypal from PAYPAL STEP 6 below
//  this custom variable     $product_id_array     is then sent back from PAYPAL
//  once Paypal has completed processing the information to this sites own IPN
//  script so that the values i.e. the pricing can be checked to ensure each
//  item price sold matches the real original stock item price
//
$product_id_array = '';


if(!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1){
$cartOutput = "<h2 align='center'>Your shopping cart is empty</h2>";
} else {
    
    
    //  PAYPAL STEP 3
    //
    //  Start paypal checkout button
    //  !!!!!     You must remeber to put your paypal business email in the form below     !!!!!
    //
    //  We include and append to the paypal checkout button here in the else
    //  condition rather than the if condition above because if theres no 
    //  items in the cart we definitly dont want a paypal button there
    $paypal_checkout_button .= '<form action="http://leedavidsoncontentmanagementsystem1.com/cms_1/root/cms_1_online_store/bridge_line_1/transaction_simulation.php" method="post">
                                <input type="hidden" name="cmd" value="_cart">
                                <input type="hidden" name="upload" value="1">
                                <input type="hidden" name="business" value="VS1Studios@hotmail.com">';
                                
                                
    //  !!!!!     THIS IS THE REAL PAYPAL BUTTON WHICH HAS BEEn DISABLED TO PREVENT USERS BUYING NON EXISTANT ITEMS     !!!!!
    //  The button above has been re-configured to direct customers to a page which holds step by step images of the checkout_complete
    //  trnsaction process if the button below was re-activated
    //
    //$paypal_checkout_button .= '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
    //                            <input type="hidden" name="cmd" value="_cart">
    //                            <input type="hidden" name="upload" value="1">
    //                            <input type="hidden" name="business" value="VS1Studios@hotmail.com">';
                                
      
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


        //  PAYPAL STEP 4
        //
        //  Dynamic Checkout Button Assembly
        //
        //  paypal dynamic checkout button assembly   -   dynamic variables are the values
        //
        //  The x below which is set in the three input types below i.e. name="item_name_'. $x .'"
        //  name="amount_'. $x .'"  name="quantity_'. $x .'"    is set to i + 1 to make sure the
        //  correct number is given to paypal because we want each item sent to start with a 1
        //
        $x = $i + 1; 
        $paypal_checkout_button .= '<input type="hidden" name="item_name_'. $x .'" value="'. $product_name .'">
                                    <input type="hidden" name="amount_'. $x .'" value="'. $price .'">
                                    <input type="hidden" name="quantity_'. $x .'" value="'. $each_item['quantity'] .'">';
                         
                                    
        //  PAYPAL STEP 5
        //
        //  Create the product array variable
        //  This variable will provide the information about the KEY / PAIR
        //  productID / quantity for each individual transaction and will
        //  Append each individual transaction to this string variable i.e.
        //  in this format     1-2,2-5     so that means product 1 has a
        //  quantity of 2     then a comma     then product 2 has a quantity
        //  of 5     
        //
        //  This String variable will be exploded into an array in the IPN
        //  script so that the values can be worked with checked etc
        //
        $product_id_array .= "$item_id-".$each_item['quantity'].",";

        
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
    
    
    //  PAYPAL STEP 6
    //
    //  Finish the paypal checkout button
    //
    //  The custom variable below     " name="custom" "     allows you to send any custom variable to paypal
    //  in the case below we are sending     $product_id_array     to Paypal which will be processed with the
    //  other variables before being sent back to this sites own IPN script so that the values i.e. the
    //  pricing can be checked to ensure item price sold matches the real original stock item price
    //
    $paypal_checkout_button .= '<input type="hidden" name="custom" value="' . $product_id_array . '">
	                            <input type="hidden" name="notify_url" value="http://leedavidsoncontentmanagementsystem1.com/cms_1/root/cms_1_online_store/bridge_line_1/storescripts/my_ipn.php">
	                            <input type="hidden" name="return" value="http://leedavidsoncontentmanagementsystem1.com/cms_1/root/cms_1_online_store/bridge_line_1/checkout_complete.php">
	                            <input type="hidden" name="rm" value="2">
	                            <input type="hidden" name="cbt" value="Return to The Store">
	                            <input type="hidden" name="cancel_return" value="http://leedavidsoncontentmanagementsystem1.com/cms_1/root/cms_1_online_store/bridge_line_1/paypal_cancel.php">
	                            <input type="hidden" name="lc" value="GB">
	                            <input type="hidden" name="currency_code" value="GBP">
	                            <input type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - its fast, free and secure!">
	                            </form>';

    //  This is another way to position the total value, i've left it as a reference point
    //$cart_total = "<div align='right'>Cart Total: £ " . $cart_total . " GBP </div>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Cart Page</title>

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
    <br />
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
        <div style="margin:24px; text-align:right;">
            <?php echo $cart_total; ?><br/>
        </div>
    </br>
    </br>
    <!--//  PAYPAL STEP 7
        //
        //  Show the paypal checkout button
        //-->
        <div style="margin:24px; text-align:right;">
            <?php echo $paypal_checkout_button; ?>
        </div>
    </br>
    </br>
        <?php echo 'To return to product page  <a href="index.php">click here</a>' ?>
    </br>
    </br>
    </br>
    </br>
    </br>
    </br>
        <a href="cart.php?cmd=emptycart">Click here to empty your Shopping Cart</a>
</div>
    
</div>





<div id="pageBottom" style="margin-top: 40px">
	    <?php include_once("../bulkhead_vision_3/footers/template_store_footer.php");?>
</div>


</div>
</body>
</html>