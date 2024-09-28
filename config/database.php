<?php

// variables
$server_name = "localhost";
$user_name = "root";
$password = "";
$db_name = "encues";

$conn = new mysqli($server_name, $user_name,$password ,$db_name );
if ($conn-> connect_error)
{
die ("error de conexion".$conn->connect_error);
}
?>