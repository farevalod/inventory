<?php
	session_start();
    $conn = mysql_connect('localhost:3306','root','pass') or die("Fallo la conexion.");
    if (!$conn) 
    {
        echo "Unable to connect to DB: " . mysql_error();
        exit;
    }
    $query = "USE bodyworx";
    if(empty($_GET))
        echo "No GET variables";
    mysql_query($query);
   	$query =   "INSERT INTO bodyworx.factura VALUES (NULL, '".$_GET['num_factura']."' , '".$_GET['monto']."' , '".$_GET['boleta']."', NULL)";
    mysql_query($query);
    header( 'Location: menu.php');
?>
