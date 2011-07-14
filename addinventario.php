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
   	$query =   "INSERT INTO bodyworx.inventario VALUES ('".$_GET['ref']."' , '".substr($_GET['sn'],0,-3)."' , '".$_GET['sn']."', '".$_GET['factura']."', NULL)";
    mysql_query($query);
    header( 'Location: newinventario.php');
?>
