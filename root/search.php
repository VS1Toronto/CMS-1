<?php
    $sql="SELECT * FROM users";
    $query =mysqli_query($db_conx,$sql);
    $num_rows = mysqli_num_rows($query);
 
    echo $num_rows;
?>
    
