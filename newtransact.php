	<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
	<script>
	function kH(e) {
        var pK = e ? e.which : window.event.keyCode;
        return pK != 13;
    }
    document.onkeypress = kH;
    if (document.layers) document.captureEvents(Event.KEYPRESS);
    </script>
	</head>
	<body>
	<?php include("header.php"); ?>
<?php
    $conn = mysql_connect('localhost:3306','user','pwpwpw') or die("Fallo la conexion.");
    if (!$conn) 
    {
        echo "Unable to connect to DB: " . mysql_error();
        exit;
    }
    $query = "USE bodyworx";
    mysql_query($query);
?>
<?php
     if(!empty($_GET['ref']))
     {
        echo '<div class="reftransact">';
        echo '<fieldset>';
        echo '<legend>Transacciones producto '.$_GET['ref'].'</legend>';
        $ref_query = "SELECT doctores.nombre, doctores.apellido, transact.fecha_trans, transact.sn FROM transact INNER JOIN productos INNER JOIN doctores INNER JOIN inventario ON transact.sn=inventario.sn AND inventario.ref = productos.code AND transact.doctor_id = doctores.id WHERE inventario.ref = '".$_GET['ref']."' ORDER BY doctores.apellido ASC";
        $ref_results = mysql_query($ref_query);
        while($ref_row = mysql_fetch_assoc($ref_results))
        {
            echo 'Doctor: '.$ref_row['nombre'].' '.$ref_row['apellido'].' '.$ref_row['fecha_trans'].' sn: '.$ref_row['sn'];
            echo '<br/>';
        }
            echo '</div>';
    }
    else if(!empty($_GET['code'])) //PARTE MAXIMA
    {
    echo '<div class="reftransact">';
    echo '<fieldset>';
    echo '<legend>Transacciones producto '.$_GET['code'].'</legend>';
    $maxref_query = "SELECT doctores.nombre, doctores.apellido, maximatransact.fecha_trans FROM maximatransact, doctores WHERE maximatransact.code = '".$_GET['code']."' AND doctores.id = maximatransact.doctor_id AND maximatransact.completa = 0 ORDER BY doctores.apellido ASC";
    $maxref_results = mysql_query($maxref_query);
    while($maxref_row = mysql_fetch_assoc($maxref_results))
    {
        echo 'Doctor: '.$maxref_row['nombre'].' '.$maxref_row['apellido'].' '.$maxref_row['fecha_trans'].' <br/>Code: '.$_GET['code'];
        echo '<br/>';
    }
    echo '</div>';
    }
?>
<div class="newtransact">
<form action="addtransact.php" method="get">
<fieldset>
<legend>Nueva Transacción</legend>
<label for="id_doctor_sel">Doctor</label><span class="cantidad"><select name="id_doctor_sel">
<?php
    $query = "SELECT * FROM doctores ORDER BY apellido";
    $results = mysql_query($query);
    while($row = mysql_fetch_assoc($results))
    {
        //Genera una opción para el select por cada row del resultado.
        echo '<option value="'.$row['id'].'">'.$row['apellido'].', '.$row['nombre'].'</option>';
    }
?>
</select></span><br/><br/>
<label for="nombre_paciente">Paciente</label><span class="cantidad"><input type="text" name="nombre_paciente"></span><br/><br/>
<label for="sn1">N° Serie 1</label><span class="cantidad"><input type="text" name="sn1"></span><br/><br/>
<label for="sn2">2</label><span class="cantidad"><input type="text" name="sn2"></span><br/><br/>
<label for="sn3">3</label><span class="cantidad"><input type="text" name="sn3"></span><br/><br/>
<label for="sn4">4</label><span class="cantidad"><input type="text" name="sn4"></span><br/><br/>
<label for="sn5">5</label><span class="cantidad"><input type="text" name="sn5"></span><br/><br/>
<label for="sn6">6</label><span class="cantidad"><input type="text" name="sn6"></span><br/><br/>
<input type="submit" value="Enviar">
</fieldset>
</form>
</div>

<div class="translist">
<fieldset>
<legend>Transacciones pendientes</legend>
<?php
    $last_apellido = NULL;
    $query = "SELECT doctores.nombre, doctores.apellido, productos.code, productos.type, productos.vol, transact.fecha_trans, transact.sn FROM transact INNER JOIN productos INNER JOIN doctores INNER JOIN inventario ON transact.sn=inventario.sn AND inventario.ref = productos.code AND transact.doctor_id = doctores.id WHERE transact.completa = 0 ORDER BY doctores.apellido ASC";
    $results = mysql_query($query);
    while($row = mysql_fetch_assoc($results))
    {
       	if($last_apellido == NULL)
	    {
	        echo '<div class="dotbox">';
	        $last_apellido = $row['apellido'];
	        echo 'Doctor: '.$row['nombre'].' '.$row['apellido'].'<br/><br/>';
        }
        if($last_apellido != $row['apellido'])
        {
            echo '</div><div class="dotbox">';
            $last_apellido = $row['apellido'];
            echo 'Doctor: '.$row['nombre'].' '.$row['apellido'].'<br/><br/>';
        }
        echo 'Fecha: '.$row['fecha_trans'].' '.$row['code'].' '.$row['type'].' '.$row['vol'].'cc  sn: '.$row['sn'].'<br/>';
    }
?>
</div>
<?php
    $last_apellido = NULL;
    $maxquery = "SELECT doctores.nombre, doctores.apellido, maximatransact.code, maximatransact.fecha_trans FROM maximatransact INNER JOIN doctores ON maximatransact.doctor_id = doctores.id WHERE maximatransact.completa = 0 ORDER BY doctores.apellido ASC";
    $maxresults = mysql_query($maxquery);
    while($maxrow = mysql_fetch_assoc($maxresults))
    {
       	if($last_apellido == NULL)
	    {
	        echo '<div class="maxdotbox">';
	        $last_apellido = $maxrow['apellido'];
	        echo 'Doctor: '.$maxrow['nombre'].' '.$maxrow['apellido'].'<br/><br/>';
        }
        if($last_apellido != $maxrow['apellido'])
        {
            echo '</div><div class="dotbox">';
            $last_apellido = $maxrow['apellido'];
            echo 'Doctor: '.$maxrow['nombre'].' '.$maxrow['apellido'].'<br/><br/>';
        }
        echo 'Fecha: '.$maxrow['fecha_trans'].' Maxima ';
        $model = substr($maxrow['code'],12,4);
        $size = substr($maxrow['code'],10,2);
        $eur = ($size-50)/5;
        echo $model.' / '.$eur.'/'.$size.'<br/>';
    }
?>

</div>
</div>

<div class="maxtransact">
<form action="addmaximatransact.php" method="get">
<fieldset>
    <legend>Nueva Transacción Maxima</legend>
<label for="id_doctor_sel">Doctor</label><span class="cantidad"><select name="id_doctor_sel">
<?php
    $query = "SELECT * FROM doctores ORDER BY apellido";
    $results = mysql_query($query);
    while($row = mysql_fetch_assoc($results))
    {
        //Genera una opción para el select por cada row del resultado.
        echo '<option value="'.$row['id'].'">'.$row['apellido'].', '.$row['nombre'].'</option>';
    }
?>
</select></span><br/><br/>
    <label for="trcode">Code</label><span class="cantidad"><input type="text" name="trcode"></span><br/><br/>
    <label for="trcantidad">Cantidad</label><span class="cantidad"><input type="text" name="trcantidad"></span><br/><br/>
    <input type="submit" value="Enviar">
</fieldset>
</form>
</div>
	
<?php include("footer.php"); ?>
