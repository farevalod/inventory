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
	<div class="newinventario">
    <form action="addmaxima.php" method="get">
    <fieldset>
        <legend>Agregar a inventario</legend>
        <label for="newcode">Code</label><span class="cantidad"><input type="text" name="newcode"></span><br/><br/>
        <label for="factura">Factura</label><span class="cantidad"><input type="text" name="factura"></span><br/><br/>
        <label for="newcantidad">Cantidad</label><span class="cantidad"><input type="text" name="newcantidad"></span><br/><br/>
        <input type="submit" value="Enviar">
    </fieldset>
    </form>
</div>

    <div class="maximainventariolist">
    <fieldset>
    <legend>Productos en Stock</legend>
    <?php
    $query = "SELECT code, COUNT(code) AS cantidad FROM maxima GROUP BY code";
    $results = mysql_query($query);
    while($row = mysql_fetch_assoc($results))
    {
        if($row['cantidad'] != 0)
        {
            $model = substr($row['code'],12,4);
            $size = substr($row['code'],10,2);
            $eur = ($size-50)/5;
            $query_trans = "SELECT code, COUNT(code) AS transito FROM bodyworx.maximatransact WHERE code = '".$row['code']."' AND completa = 0 GROUP BY code";
            $results_trans = mysql_query($query_trans);
            $row_trans = mysql_fetch_assoc($results_trans);
            $query_sold = "SELECT code, COUNT(code) AS vendidas FROM bodyworx.maximatransact WHERE code = '".$row['code']."' AND completa = 1 GROUP BY code";
            $results_sold = mysql_query($query_sold);
            $row_sold = mysql_fetch_assoc($results_sold);
            echo '<div class="dotbox">';
            echo $model.' / '.$eur.'/'.$size.' <span class="cantidad">'.($row['cantidad'] - $row_trans['transito'] - $row_sold['vendidas']).' Unidades';
            if(mysql_num_rows($results_trans) != 0)
            {
//                echo ' + '.$row_trans['transito'].' en tránsito</a><br/>';
                echo ' + <a href="newtransact.php?code='.$row_trans['code'].'">'.$row_trans['transito'].' en tránsito</a><br/>';
            }
            echo '</span></div>';
        }
    }
?>
</fieldset>
</div>

<div class="consulta_fact">
    <fieldset>
    <legend>Consultar Factura</legend>
    <?php
    $fact_query = "SELECT DISTINCT factura FROM bodyworx.maxima ORDER BY factura ASC";
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
	<?php include("footer.php"); ?>
	</body>
	</html>
