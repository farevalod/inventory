<?php
	session_start();
    $conn = mysql_connect('localhost:3306','root','pass') or die("Fallo la conexion.");
    if (!$conn) 
    {
        echo "Unable to connect to DB: " . mysql_error();
        exit;
    }
//    $query = "USE bodyworx";
    if(empty($_GET))
    echo "No GET variables";
//    mysql_query($query);
   	$insquery = "INSERT INTO bodyworx.doctores VALUES (NULL, '".$_GET['nombre']."','".$_GET['apellido']."', '".$_GET['clinica']."', '".$_GET['fecha_nac']."')";
    if(mysql_query($insquery, $conn))
       echo 'Insertado doctor '.$_GET['nombre'].' '.$_GET['apellido'].' correctamente en la base de datos.';
    echo '<br/>';
    echo "INSERT INTO bodyworx.doctores VALUES (NULL, '".$_GET['nombre']."','".$_GET['apellido']."', '".$_GET['clinica']."', '".$_GET['fecha_nac']."')";
    echo mysql_error();
    header( 'Location: menu.php');
?>
