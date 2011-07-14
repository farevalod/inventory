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
    if($_GET['sn1'] != NULL)
    {
   	$query =   "INSERT INTO bodyworx.transact VALUES (NULL, ".$_GET['id_doctor_sel']." , '".$_GET['sn1']."' , '".$_GET['nombre_paciente']."' , NULL , 0, 0, 0)";
    mysql_query($query);
    }
    if($_GET['sn2'] != NULL)
    {
    $query =   "INSERT INTO bodyworx.transact VALUES (NULL, ".$_GET['id_doctor_sel']." , '".$_GET['sn2']."' , '".$_GET['nombre_paciente']."' , NULL , 0, 0, 0)";
    mysql_query($query);
    }
    if($_GET['sn3'] != NULL)
    {
    $query =   "INSERT INTO bodyworx.transact VALUES (NULL, ".$_GET['id_doctor_sel']." , '".$_GET['sn3']."' , '".$_GET['nombre_paciente']."' , NULL , 0, 0, 0)";
    mysql_query($query);
    }
    if($_GET['sn4'] != NULL)
    {
    $query =   "INSERT INTO bodyworx.transact VALUES (NULL, ".$_GET['id_doctor_sel']." , '".$_GET['sn4']."' , '".$_GET['nombre_paciente']."' , NULL , 0, 0, 0)";
    mysql_query($query);
    }
    if($_GET['sn5'] != NULL)
    {
    $query =   "INSERT INTO bodyworx.transact VALUES (NULL, ".$_GET['id_doctor_sel']." , '".$_GET['sn5']."' , '".$_GET['nombre_paciente']."' , NULL , 0, 0, 0)";
    mysql_query($query);
    }
    if($_GET['sn6'] != NULL)
    {
    $query =   "INSERT INTO bodyworx.transact VALUES (NULL, ".$_GET['id_doctor_sel']." , '".$_GET['sn6']."' , '".$_GET['nombre_paciente']."' , NULL , 0, 0, 0)";
    mysql_query($query);
    }
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
<title>Comprobante de Transaccion</title>
</head>
<body>
<h3>
    <?php
        if($_GET['sn1'] != NULL)
        {
            echo '<div class="comprobante">';
            $query = "SELECT doctores.nombre, doctores.apellido, transact.fecha_trans, transact.sn, transact.nombre_paciente, productos.code FROM transact INNER JOIN productos INNER JOIN doctores INNER JOIN inventario ON transact.sn=inventario.sn AND inventario.ref = productos.code AND transact.doctor_id = doctores.id WHERE transact.sn = '".$_GET['sn1']."' ORDER BY doctores.apellido ASC";
            $results = mysql_query($query);
            $row = mysql_fetch_assoc($results);
            echo "S/N: ".$row['sn']."<br/>";
            echo "Modelo: ".$row['code'].'<br/>';
            echo '<span class="center">'.$row['fecha_trans'].'</span>';
            echo '</div>';
         }
         if($_GET['sn2'] != NULL)
        {
            echo '<div class="comprobante">';
            $query = "SELECT doctores.nombre, doctores.apellido, transact.fecha_trans, transact.sn, transact.nombre_paciente, productos.code FROM transact INNER JOIN productos INNER JOIN doctores INNER JOIN inventario ON transact.sn=inventario.sn AND inventario.ref = productos.code AND transact.doctor_id = doctores.id WHERE transact.sn = '".$_GET['sn2']."' ORDER BY doctores.apellido ASC";
            $results = mysql_query($query);
            $row = mysql_fetch_assoc($results);
            echo "S/N: ".$row['sn']."<br/>";
            echo "Modelo: ".$row['code'].'<br/>';
            echo '<span class="center">'.$row['fecha_trans'].'</span>';
            echo '</div>';
         }
         if($_GET['sn3'] != NULL)
        {
            echo '<div class="comprobante">';
            $query = "SELECT doctores.nombre, doctores.apellido, transact.fecha_trans, transact.sn, transact.nombre_paciente, productos.code FROM transact INNER JOIN productos INNER JOIN doctores INNER JOIN inventario ON transact.sn=inventario.sn AND inventario.ref = productos.code AND transact.doctor_id = doctores.id WHERE transact.sn = '".$_GET['sn3']."' ORDER BY doctores.apellido ASC";
            $results = mysql_query($query);
            $row = mysql_fetch_assoc($results);
            echo "S/N: ".$row['sn']."<br/>";
            echo "Modelo: ".$row['code'].'<br/>';
            echo '<span class="center">'.$row['fecha_trans'].'</span>';
            echo '</div>';
         }
         if($_GET['sn4'] != NULL)
        {
            echo '<div class="comprobante">';
            $query = "SELECT doctores.nombre, doctores.apellido, transact.fecha_trans, transact.sn, transact.nombre_paciente, productos.code FROM transact INNER JOIN productos INNER JOIN doctores INNER JOIN inventario ON transact.sn=inventario.sn AND inventario.ref = productos.code AND transact.doctor_id = doctores.id WHERE transact.sn = '".$_GET['sn4']."' ORDER BY doctores.apellido ASC";
            $results = mysql_query($query);
            $row = mysql_fetch_assoc($results);
            echo "S/N: ".$row['sn']."<br/>";
            echo "Modelo: ".$row['code'].'<br/>';
            echo '<span class="center">'.$row['fecha_trans'].'</span>';
            echo '</div>';
         }
         if($_GET['sn5'] != NULL)
        {
            echo '<div class="comprobante">';
            $query = "SELECT doctores.nombre, doctores.apellido, transact.fecha_trans, transact.sn, transact.nombre_paciente, productos.code FROM transact INNER JOIN productos INNER JOIN doctores INNER JOIN inventario ON transact.sn=inventario.sn AND inventario.ref = productos.code AND transact.doctor_id = doctores.id WHERE transact.sn = '".$_GET['sn5']."' ORDER BY doctores.apellido ASC";
            $results = mysql_query($query);
            $row = mysql_fetch_assoc($results);
            echo "S/N: ".$row['sn']."<br/>";
            echo "Modelo: ".$row['code'].'<br/>';
            echo '<span class="center">'.$row['fecha_trans'].'</span>';
            echo '</div>';
         }
         if($_GET['sn6'] != NULL)
        {
            echo '<div class="comprobante">';
            $query = "SELECT doctores.nombre, doctores.apellido, transact.fecha_trans, transact.sn, transact.nombre_paciente, productos.code FROM transact INNER JOIN productos INNER JOIN doctores INNER JOIN inventario ON transact.sn=inventario.sn AND inventario.ref = productos.code AND transact.doctor_id = doctores.id WHERE transact.sn = '".$_GET['sn6']."' ORDER BY doctores.apellido ASC";
            $results = mysql_query($query);
            $row = mysql_fetch_assoc($results);
            echo "S/N: ".$row['sn']."<br/>";
            echo "Modelo: ".$row['code'].'<br/>';
            echo '<span class="center">'.$row['fecha_trans'].'</span>';
            echo '</div>';
         }
?>
</h3>
<a href="newtransact.php">Volver a Nueva Transaccion</a>
</body>
</html>
