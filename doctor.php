<?php
    $conn = mysql_connect('localhost:3306','user','pwpwpw') or die("Fallo la conexion.");
    if (!$conn) 
    {
        echo "Unable to connect to DB: " . mysql_error();
        exit;
    }
    $query = "USE bodyworx";
    mysql_query($query);
    session_start();
	if ( !isset($_SESSION['doctor_id']))
	{
	//	header('Location:index.php');
	}
?>
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
			<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
		</head>
		<body>
		<?php include("header.php"); ?>
				        <div class="datos_doctor">
				        <fieldset>
				            <legend>Información de Doctor</legend>
			                <?php
				                echo 'Nombre: '.$_SESSION['nombre'].' '.$_SESSION['apellido'].'<br/>';
				                echo 'Clinica: '.$_SESSION['clinica'].'<br/>';
			                ?>
			            </fieldset>
			            </div>
<?php     if(!empty($_GET))
{
        echo '<div class="detalle_fact">';
        echo '<fieldset>';
        echo '<legend>Detalle ';
        if($_GET['boleta'])
            echo 'Boleta ';
        else
            echo 'Factura ';
        echo $_GET['fact_num'].'</legend>';
        $ref_query = "SELECT doctores.nombre, doctores.apellido, transact.fecha_trans, transact.sn, transact.nombre_paciente, transact.boleta, factura.monto, factura.boleta, productos.code FROM transact INNER JOIN productos INNER JOIN doctores INNER JOIN inventario INNER JOIN factura ON transact.sn=inventario.sn AND inventario.ref = productos.code AND transact.doctor_id = doctores.id AND factura.num = transact.num_factura AND factura.boleta = transact.boleta WHERE transact.num_factura = '".$_GET['fact_num']."' AND transact.boleta = '".$_GET['boleta']."' ORDER BY nombre_paciente ASC";
        $ref_results = mysql_query($ref_query);
    while($ref_row = mysql_fetch_assoc($ref_results))
    {
        echo 'Doctor: '.$ref_row['nombre'].' '.$ref_row['apellido'].' <br/>Fecha transaccion: '.$ref_row['fecha_trans'].'<br/> Nombre Paciente: '.$ref_row['nombre_paciente'].'<br/>';
        echo 'Modelo: '.$ref_row['code'].' sn: '.$ref_row['sn'].' ';
        $monto = $ref_row['monto'];
        echo '<br/>';
        echo '<br/>';

    }
    echo 'Monto ';
    if($_GET['boleta']==1)
        echo 'Boleta';
    else
        echo 'Factura';
    echo ': $'.$monto;
    echo '</div>';
}
?>
			            <div class="transact_doctor">
			            <fieldset>
			            <legend>Transacciones pendientes</legend>
			                <?php
			                    $nombre_paciente = NULL;
                                $query =   "SELECT *
                                            FROM transact
                                            WHERE transact.doctor_id=".$_SESSION['doctor_id']." AND transact.completa = 0 ORDER BY nombre_paciente";
				                $results = mysql_query($query);
				                while($row = mysql_fetch_assoc($results))
                            	{
                            	    if($row['nombre_paciente'] != $nombre_paciente)
                            	    {
                            	        if($nombre_paciente != NULL)
                            	            echo '</div>';
                            	        $nombre_paciente = $row['nombre_paciente'];                                        
                                        echo '<div class="dotbox">';
                                        echo 'Nombre Paciente: '.$nombre_paciente.'<br/><br/>';
                                    }
                                       
                            	    if (mysql_num_rows($results) == 0) 
	                                {
                                        echo 'No hay transacciones de implantes ingresados para el doctor '.$_SESSION['nombre'].' '.$_SESSION['apellido'];
                                        $hay_trans = FALSE;
                                    }
                                    else
                                    {
                                        $hay_trans = TRUE;
                                    }
                            	    $product_query = "  SELECT * FROM bodyworx.inventario, bodyworx.productos 
                            	                        WHERE bodyworx.inventario.sn ='".$row['sn']."'
                            	                        AND bodyworx.productos.code = bodyworx.inventario.ref
														ORDER BY bodyworx.inventario.ref desc;"
														
                            	                        ;
                            	    $product_results = mysql_query($product_query);
                            	    if($product_row = mysql_fetch_assoc($product_results))
                            	    {
                                	    if (mysql_num_rows($product_results) == 0) 
	                                    {
                                            echo 'No hay transacciones ingresados con sn = '.$row['sn'];
                                        }
                            	        /*Salida antigua
                            	        echo $product_row['ref'].' '.$product_row['type'].' base: '.$product_row['base'].' proy: '.$product_row['proy'].', '.$product_row   ['vol'].'cc<br/>'; */
                            	        /*Salida nueva*/
                            	        echo $product_row['ref'].' '.$product_row['type'].' '.$product_row['vol'].'cc SN:'.$product_row['sn'].'<br/>'.$row['fecha_trans'].'<br/>';
                            	        echo '<form action="transact.php" method="get">';
                            	        echo '<input type="checkbox" name=tid value='.$row['transact_id'].'>Cerrar transacción <br/>';
                            	        echo '<input type="checkbox" name=facturar value=1>Agregar ';
                            	        echo '<select name="boleta'.$row['transact_id'].'"><option value="1">Boleta</option><option value="0">Factura</option></select>';
                            	        echo '<input type="text" name="num_factura'.$row['transact_id'].'" value="0">';
                            	        echo '<input type="submit" value="Enviar"><br/><br/>';
                            	        echo '</form>';
                            	    }
                            	    else
                            	    {
                            	        echo 'No se encuentra el producto '.$row['sn'].' en inventario<br/>';
                            	    }
				                }
				                
				                //PARTE MAXIMA
				                
				                $maxquery = "SELECT * FROM maximatransact where maximatransact.doctor_id = '".$_SESSION['doctor_id']."' AND maximatransact.completa = 0";
				                $maxresults = mysql_query($maxquery);
				                echo '<form action="closemaximatransact.php" method="get">';
				                while($maxrow = mysql_fetch_assoc($maxresults))
                            	{
                                        echo '<div class="dotbox">';
                                        $model = substr($maxrow['code'],12,4);
                                        $size = substr($maxrow['code'],10,2);
                                        $eur = ($size-50)/5;
                                        echo $model.' / '.$eur.'/'.$size;
                                        echo ' '.$maxrow['fecha_trans'].'<br/>';
                            	        echo '<input type="checkbox" name=tid value='.$maxrow['transact_id'].'>Cerrar transacción <br/>';
                            	        echo '<input type="checkbox" name=facturar value=1>Agregar ';
                            	        echo '<select name="boleta'.$maxrow['transact_id'].'"><option value="1">Boleta</option><option value="0">Factura</option></select>';
                            	        echo '<input type="text" name="num_factura'.$maxrow['transact_id'].'" value="0">';
                            	        echo '<input type="submit" value="Enviar"><br/><br/>';
                            	        echo '</form>';
                            	        echo '</div>';
                            	}
                            	
                            	
				            ?>
				            </fieldset>
				            </form>
				            </div>
				            <div class="transact_doctor_comp">
				            <fieldset>
				            <legend>Pacientes</legend>
				            <?php
                                $query =   "SELECT transact.nombre_paciente, num_factura, boleta
                                            FROM transact
                                            WHERE transact.doctor_id=".$_SESSION['doctor_id']." AND transact.completa = 1 GROUP BY nombre_paciente ORDER BY nombre_paciente";
	                            $results = mysql_query($query);
	                            while($row = mysql_fetch_assoc($results))
                        	    {
                        	        echo '<a href="doctor.php?fact_num='.$row['num_factura']."&boleta=".$row['boleta'].'">'.ucwords($row['nombre_paciente'])."</a><br/>";
                        	    }
				            ?>
				            </div>
				            <?php include("footer.php"); ?>
    </body>
	</html>
