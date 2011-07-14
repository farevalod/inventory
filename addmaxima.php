<?php
	session_start();
    $conn = mysql_connect('localhost:3306','user','pwpwpw') or die("Fallo la conexion.");
    if (!$conn) 
    {
        echo "Unable to connect to DB: " . mysql_error();
        exit;
    }
    $query = "USE bodyworx";
    if(empty($_GET))
        echo "No GET variables";
    mysql_query($query);
    $n = $_GET['newcantidad'];    
   	$query =   "INSERT INTO bodyworx.maxima VALUES (NULL, '".$_GET['newcode']."', NULL, '".$_GET['factura']."')";
    for($i=0;$i<$n;$i++)
        mysql_query($query);
    echo $query;
    header( 'Location: maxima.php');
?>
