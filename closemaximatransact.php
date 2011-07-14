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
    if($_GET['facturar'])
   	    $query = "UPDATE bodyworx.maximatransact SET num_factura = '".$_GET['num_factura'.$_GET['tid']]."', boleta = '".$_GET['boleta'.$_GET['tid']]."', completa = '1' WHERE transact_id = '".$_GET['tid']."'";
   	else
   	    $query = "DELETE FROM bodyworx.maximatransact WHERE transact_id = '".$_GET['tid']."' AND completa='0'";
    mysql_query($query);
    echo $query;
    header( 'Location: doctor.php');
?>
