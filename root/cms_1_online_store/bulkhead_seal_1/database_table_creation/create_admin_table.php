<?php
//	Connect to the MySQL database
//require "../connect_to_mysql.php";  // Line commented out to prevent accidental firing of create script

$sqlCommand  = "CREATE TABLE IF NOT EXISTS inet_prod_extra ( 
		id int(11) NOT NULL auto_increment,
		username varchar(255) NOT NULL,
		password varchar(255) NOT NULL,
		last_log_date date NOT NULL,
		PRIMARY KEY(id),
		UNIQUE KEY username(username)
		)";
$query = mysqli_query($db_conx_store, $sqlCommand); 
if ($query === TRUE) {
	echo "<h3>admin table created OK :) </h3>"; 
} else {
	echo "<h3>admin table NOT created :( </h3>"; 
}
?>