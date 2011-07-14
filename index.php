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
	$query = "SELECT * FROM bodyworx.doctores WHERE doctores.id=".$_GET['id_doctor_sel']."";
	$results = mysql_query($query);
	if($row = mysql_fetch_assoc($results))
	{
	    //Consulta acerca del usuario en $_POST:
	    //Carga los datos en $_SESSION[] y los accede en otros .php
	    $_SESSION['doctor_id'] = $row['id'];
		$_SESSION['nombre'] = $row['nombre'];
		$_SESSION['apellido'] = $row['apellido'];
		$_SESSION['clinica'] = $row['clinica'];
		$_SESSION['fecha_nac'] = $row['fecha_nac'];
		echo 'Se consultarán los datos de: '.$_SESSION['nombre'].' '.$_SESSION['apellido'];
		header( 'Location: doctor.php');
	}
    if (mysql_num_rows($results) == 0) 
	{
        echo 'No hay doctores ingresados con id = '.$_GET['id'];
    }
	//$query
	//Hecha la transacción redirige a home.php (el contenido):
    /*echo '<html>
			<head>
				<META HTTP-EQUIV="Refresh" CONTENT="0;URL=doctor.php">
			</head>
		</html>';*/
?>
