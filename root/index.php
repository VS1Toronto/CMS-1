<?php
include_once("php_includes/check_login_status.php");

$sql="SELECT username, avatar FROM users WHERE avatar IS NOT NULL AND activated='1' ORDER BY RAND() ";
$query =mysqli_query($db_conx,$sql);
$userlist="";
while($row=mysqli_fetch_array($query, MYSQLI_ASSOC)){
	$u=$row["username"];
	$avatar = $row["avatar"];
	$profile_pic = 'user/'.$u.'/'.$avatar;
	$userlist .='<a href="user.php?u='.$u.'" title="'.$u.'"><img src="'.$profile_pic.'" alt="'.$u.'" style="width: 100px; height: 100px;"margin: 10px;"></a><a target="_blank"><img src="images/spacing_cube.png" alt="spacing_cube" width="10" height="10"></a>';	
}


$sql="SELECT username, avatar FROM users WHERE avatar IS NULL AND activated='1' ORDER BY RAND() ";
$query =mysqli_query($db_conx,$sql);
while($row=mysqli_fetch_array($query, MYSQLI_ASSOC)){
	$u=$row["username"];
	$avatar = $row["avatar"];
    $profile_pic = 'images/avatardefault.png';
	$userlist .='<a href="user.php?u='.$u.'" title="'.$u.'"><img src="'.$profile_pic.'" alt="'.$u.'" style="width: 100px; height: 100px;"margin: 10px;"></a><a target="_blank"><img src="images/spacing_cube.png" alt="spacing_cube" width="10" height="10"></a>';	
}


$sql="SELECT COUNT(id) FROM users WHERE activated= '1'";
$query=mysqli_query($db_conx,$sql);
$row=mysqli_fetch_row($query);
$usercount=$row[0];
?>



<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Content Management System 1</title>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="style/style.css">
<script src="js/main.js"></script>











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
    <?php include_once("template_pageTop.php"); ?>
    

<div id="pageLeft">
        
<div id="search_container" width="400" height="400">
    
<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

$search_output = "";

if(isset($_GET['searchquery']) && $_GET['searchquery'] != ""){
    
	$searchquery = preg_replace('#[^a-z 0-9?!]#i', '', $_GET['searchquery']);
    $sqlCommand="SELECT id, username, country, avatar FROM users WHERE username LIKE '%$searchquery%' OR country LIKE '%$searchquery%'";
    $query = mysqli_query($db_conx,$sqlCommand);

    $num_rows = mysqli_num_rows($query);
	$search_output .= "<hr />$num_rows results for <strong>$searchquery</strong><hr />$sqlCommand<hr />";

	
    while($row = mysqli_fetch_array($query)){
        $id = $row['id'];
        $username = $row['username'];
        $country = $row['country'];
        $u=$row["username"];
	    $avatar = $row["avatar"];
	    if($avatar){
            $profile_pic = 'user/'.$u.'/'.$avatar;
	    }
	    else{
            $profile_pic = 'images/avatardefault.png';
	    }
	    $search_output ='<a id= search_results href="user.php?u='.$u.'" title="'.$u.'"><img src="'.$profile_pic.'" alt="'.$u.'" style="width: 100px; height: 100px;"margin: 10px;"></a><a target="_blank"><img src="images/spacing_cube.png" alt="spacing_cube" width="10" height="10"></a>';
	
        echo  '<h3>' . $search_output  . '</br>' . '</br>' . ' ' . $id . '</br>' . '</br>' . ' ' . $username . '</br>' .  ' ' . $country .'</p><br />' ;            
	}

}
?>
</div>   
</div>
    
    

          
    
   
    
    
<div id="pageMiddle">
    </br>
    </br>
        <h3>Total Users: <?php echo $usercount; ?></h3>
    </br></a>
    </br>
        <h3>Users Registered on CMS 1</h3>
    </br>
    </br>	
        <?php echo $userlist; ?>
        
        

        
</div>





 







<div id="statusarea">

</div>



<div id="pageBottom">
    <?php include_once("template_pageBottom.php");?>
</div>

</body>
</html>