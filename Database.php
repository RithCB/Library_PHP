<?php
$db_server="localhost"; 
$db_user= "root"; 
$db_password=""; 
$db_name="Library"; 
$conn=""; 
try{
    $conn = mysqli_connect($db_server,$db_user,$db_password,$db_name); 
    // echo "Database connect successfully";
}
catch(mysqli_sql_connect){
    echo "Database can't connect"; 
}








?>