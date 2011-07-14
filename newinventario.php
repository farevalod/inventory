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
<?php include("header.php")?>
<?php
    $conn = mysql_connect('localhost:3306','root','pass') or die("Fallo la conexion.");
    if (!$conn)
    {
        echo "Unable to connect to DB: " . mysql_error();
        exit;
    }
    $query = "USE bodyworx";
    mysql_query($query);
 
if(!empty($_GET))
{
    echo '<div class="detalle_sn">';
    echo '<fieldset>';
    echo '<legend>Detalle producto N°'.$_GET['sn'].'</legend>';
    $query = "SELECT * FROM transact INNER JOIN inventario INNER JOIN doctores ON inventario.sn = transact.sn AND doctores.id = transact.doctor_id WHERE transact.sn = '".$_GET['sn']."'";
    $res = mysql_query($query);
    if(mysql_num_rows($res) == 0)
    {
        $prod_query = "SELECT * FROM inventario WHERE sn  = '".$_GET['sn']."'";
        $res = mysql_query($prod_query);
        $row = mysql_fetch_assoc($res);
        echo 'El producto N° serie '.$_GET['sn'].' Modelo: '.$row['ref'].'<br/> llego con la factura '.$row['factura'].' en la fecha '.$row['fecha'].', y se encuentra en inventario<br/>';
        echo '</legend></div>';
    }
    else
    {
        $row = mysql_fetch_assoc($res);
        if($row['completa'] == 0)
        {
            echo 'El producto N° serie '.$_GET['sn'].' Modelo: '.$row['ref'].' esta en transito.<br/>';
            echo 'Doctor: '.$row['nombre'].' '.$row['apellido'].'<br/>';
            echo 'Nombre paciente: '.$row['nombre_paciente'];
            echo '<br/>';
        }
        else
        {
            echo 'El producto N° serie '.$_GET['sn'].' Modelo: '.$row['ref'].' fue vendido.<br/>';
            echo 'Doctor: '.$row['nombre'].' '.$row['apellido'].'<br/>';
            echo 'Nombre paciente: '.$row['nombre_paciente'].'<br/>';
            echo ' N° ';
            if($row['boleta'] == 0)
                echo 'Factura: ';
            else
                echo 'Boleta: ';
            echo $row['num_factura'];
            echo '<br/>';
            echo 'en la fecha '.$row['fecha_trans'];
            echo '<br/>';
        }
    }
    echo '</div>';
}
?>
<div class="newinventario">
    <form action="addinventario.php" method="get">
    <fieldset>
        <legend>Agregar a inventario</legend>
        <label for="ref">REF</label><span class="cantidad"><input type="text" name="ref"></span><br/><br/>
        <label for="sn">N° Serie</label><span class="cantidad"><input type="text" name="sn"></span><br/><br/>
        <label for="factura">Factura</label><span class="cantidad"><input type="text" name="factura"></span><br/><br/>
        <input type="submit" value="Enviar">
    </fieldset>
    </form>
</div>

<div class="inventariolist">
    <fieldset>
    <legend>Productos en Stock</legend>
    <?php
    $query = "SELECT ref, COUNT(ref) AS cantidad FROM bodyworx.inventario WHERE NOT EXISTS (SELECT * FROM transact WHERE transact.sn = inventario.sn) GROUP BY ref";
    $results = mysql_query($query);
    while($row = mysql_fetch_assoc($results))
    {
        $query_trans = "SELECT ref, COUNT(ref) AS transito FROM bodyworx.transact INNER JOIN bodyworx.inventario ON transact.sn = inventario.sn WHERE ref = '".$row['ref']."' AND completa = 0 GROUP BY ref";
        $results_trans = mysql_query($query_trans);
        $row_trans = mysql_fetch_assoc($results_trans);
        echo '<div class="dotbox">';
        echo $row['ref'].' <span class="cantidad">'.$row['cantidad'].' Unidades';
        if(mysql_num_rows($results_trans) != 0)
        {
            echo ' + <a href="newtransact.php?ref='.$row_trans['ref'].'">'.$row_trans['transito'].' en tránsito</a><br/>';
        }
        echo '</span></div>';
    }
?>
</fieldset>
</div>
<div class="consulta_fact">
    <fieldset>
    <legend>Consultar Factura</legend>
    <?php
    $fact_query = "SELECT DISTINCT factura FROM bodyworx.inventario ORDER BY factura ASC";
    $fact_results = mysql_query($fact_query);
    echo '<form action="consulta_fact.php" method="get">';
    echo '<label for="fact_num">N° Factura: </label>';
    echo '<select name="fact_num">';
    while($fact_row = mysql_fetch_assoc($fact_results))
    {
        echo '<option value="'.$fact_row['factura'].'">'.$fact_row['factura'].'</option>';
    }
    ?>
    </select><br/><br/>
    <input type="submit" value="Enviar">
    </fieldset>
</form>
</div>

<div class="consulta_sn">
<fieldset>
<legend>Consulta N° Serie</legend>
<?php
    echo '<form action="newinventario.php" method="get">';
    echo '<label for="sn">N° Serie</label><span class="cantidad"><input type="text" name="sn"></span><br/><br/>';
    echo '<input type="submit" value="Enviar">';
    echo '</form>';
?>
</div>
<?php include("footer.php"); ?>
</body>
</html>
