<?php

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//	Localhost Database used to build website before transfer to live server
//
$db_conx = mysqli_connect("localhost", "root", "", "cms_1");

//	To use a server online comment the localhost code out above and enter your online database data
//
//	$db_conx = mysqli_connect("host", "user", "password", "database");
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

// Evaluate the connection
if (mysqli_connect_errno()) {
	echo mysqli_connect_error();
	exit();
}
?>