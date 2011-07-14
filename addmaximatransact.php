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
    $n = $_GET['trcantidad'];
   	$query =   "INSERT INTO bodyworx.maximatransact VALUES (NULL, '".$_GET['id_doctor_sel']."', '".$_GET['trcode']."', NULL, '0', '0', '0')";
    for($i=0;$i<$n;$i++)
        mysql_query($query);
    echo $query;
    header( 'Location: newtransact.php');
?>
