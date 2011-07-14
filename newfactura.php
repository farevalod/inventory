<?php
	session_start();
    $conn = mysql_connect('localhost:3306','user','pwpwpw') or die("Fallo la conexion.");
    if (!$conn) 
    {
        echo "Unable to connect to DB: " . mysql_error();
        exit;
    }
    $query = "USE bodyworx";
    mysql_query($query);
?>
	<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
	</head>
	<body>
	<?php include("header.php"); ?>
<?php
     if(!empty($_GET))
     {
        $head = NULL;
        echo '<div class="detalle_fact">';
        echo '<fieldset>';
        echo '<legend>Detalle ';
        if($_GET['boleta'])
            echo 'Boleta ';
        else
            echo 'Factura ';
        echo $_GET['num_factura_consulta'].'</legend>';
        $ref_query = "SELECT doctores.nombre, doctores.apellido, transact.fecha_trans, transact.sn, transact.nombre_paciente, transact.boleta, factura.monto, factura.boleta, productos.code FROM transact INNER JOIN productos INNER JOIN doctores INNER JOIN inventario INNER JOIN factura ON transact.sn=inventario.sn AND inventario.ref = productos.code AND transact.doctor_id = doctores.id AND factura.num = transact.num_factura AND factura.boleta = transact.boleta WHERE transact.num_factura = '".$_GET['num_factura_consulta']."' AND transact.boleta = '".$_GET['boleta']."' ORDER BY doctores.apellido ASC";
        $ref_results = mysql_query($ref_query);
        while($ref_row = mysql_fetch_assoc($ref_results))
        {
            $monto = $ref_row['monto'];
            if($head == NULL)
            {
                $head = 1;
                echo 'Doctor: '.$ref_row['nombre'].' '.$ref_row['apellido'].' <br/>Fecha transaccion: '.$ref_row['fecha_trans'].'<br/> Nombre Paciente: '.$ref_row['nombre_paciente'].'<br/><br/>';
            }
            echo 'Modelo: '.$ref_row['code'].' sn: '.$ref_row['sn'].' ';
            echo '<br/>';
        }
    //SECCIÓN MAXIMA
    
        $maxref_query = "SELECT doctores.nombre, doctores.apellido, maximatransact.fecha_trans, maximatransact.code, maximatransact.boleta, factura.monto, factura.boleta FROM maximatransact INNER JOIN doctores INNER JOIN factura ON maximatransact.doctor_id = doctores.id AND factura.num = maximatransact.num_factura WHERE factura.boleta = maximatransact.boleta AND maximatransact.num_factura = '".$_GET['num_factura_consulta']."' AND maximatransact.boleta = '".$_GET['boleta']."' ORDER BY doctores.apellido ASC";
        $maxref_results = mysql_query($maxref_query);
        while($maxref_row = mysql_fetch_assoc($maxref_results))
        {
            $maxmonto = $maxref_row['monto'];
            if($head == NULL)
            {
                $head = 1;
                echo 'Doctor: '.$maxref_row['nombre'].' '.$maxref_row['apellido'].' <br/>Fecha transaccion: '.$maxref_row['fecha_trans'].'<br/><br/>';
            }
            echo 'Modelo: '.$maxref_row['code'];
            echo '<br/>';
        }
        echo '<br/>';
        echo 'Monto ';
        $total = $monto + $maxmonto;
        if($ref_row['boleta']==1 || $maxref_row['boleta'])
            echo 'Boleta';
        else
            echo 'Factura';
            
        echo ': $'.$total;
        echo '</div>';
    }
?>
<div class="newfactura">
    <form action="addfactura.php" method="get">
    <fieldset>
        <legend>Nueva</legend>
        <select name="boleta"><option name="boleta" value="1">Boleta</option><option name="boleta" value="0">Factura</option></select>
        <br/><br/>
        <label for="num_factura">N°</label><input type="text" name="num_factura"><br/><br/>
        <label for="monto">Monto</label><input type="text" name="monto"><br/><br/>
        <input type="submit" value="Enviar">
    </fieldset>
    </form>
    </div>
<div class="factlist">
<fieldset>
    <legend>Consultar Factura</legend>
    <form action="newfactura.php" method="get">
    <label for="num_factura_consulta">N°</label>

    <select name="boleta">
    <option value="0">Factura</option>
    <option value="1">Boleta</option>

    </select>
<?php
        echo '<select name="num_factura_consulta">';
        $fact_query = "SELECT num, boleta FROM bodyworx.factura ORDER BY boleta ASC";
        $fact_results = mysql_query($fact_query);
        while($fact_row = mysql_fetch_assoc($fact_results))
        {
            if($fact_row['boleta']==1)
                echo '<option value="'.$fact_row['num'].'">Boleta '.$fact_row['num'].'</option>';
            else
                echo '<option value="'.$fact_row['num'].'">Factura '.$fact_row['num'].'</option>';
        }
?>
    </select>
    <input type="submit" value="Enviar">
    </form>
    </fieldset>
</div>
<?php include("footer.php"); ?>
