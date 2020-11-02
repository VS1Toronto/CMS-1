<?php
//	Connect to the MySQL database
//require "../connect_to_mysql.php";  //  Line commented out to prevent accidental firing of create script

$sqlCommand = "CREATE TABLE IF NOT EXISTS products(
		id int(11) NOT NULL auto_increment,
		product_name varchar(225) NOT NULL,
		price varchar(16) NOT NULL,
		details text NOT NULL,
		category varchar(64) NOT NULL,
		subcategory varchar(64) NOT NULL,
		date_added date NOT NULL,
		PRIMARY KEY(id),
		UNIQUE KEY product_name(product_name)
		)";
$query = mysqli_query($db_conx_store, $sqlCommand); 
if ($query === TRUE) {
	echo "<h3>products table created OK :) </h3>"; 
} else {
	echo "<h3>products table NOT created :( </h3>"; 
}
?>
