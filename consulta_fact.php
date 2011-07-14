<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
</head>
<body>
<?php include("header.php");?>
<?php
    $conn = mysql_connect('localhost:3306','root','pass') or die("Fallo la conexion.");
    if (!$conn) 
    {
        echo "Unable to connect to DB: " . mysql_error();
        exit;
    }
    $query = "USE bodyworx";
    mysql_query($query);
?>
<div class="productos_factura">
    <fieldset>
    <?php
    echo '<legend>Productos en factura '.$_GET['fact_num'].'</legend>';
    $query = "SELECT * from inventario WHERE factura = ".$_GET['fact_num']." ORDER BY ref ASC, sn ASC";
    $results = mysql_query($query);
    $fecha = NULL;
    while($row = mysql_fetch_assoc($results))
    {   if($fecha == NULL)
        {
            $fecha = $row['fecha'];
            echo 'Fecha de ingreso: '.$fecha.'<br/><br/>';
        }
        echo $row['ref'].' sn: '.$row['sn'].'<br/>';
    }
    
    //PARTE MAXIMA
    $query = "SELECT * from maxima WHERE factura = ".$_GET['fact_num']." ORDER BY code ASC";
    $results = mysql_query($query);
    $fecha = NULL;
    while($row = mysql_fetch_assoc($results))
    {   if($fecha == NULL)
        {
            $fecha = $row['fecha'];
            echo 'Fecha de ingreso: '.$fecha.'<br/><br/>';
        }
        echo $row['code'].'<br/>';
    }
    ?>
    </fieldset>
</div>
<?php include("footer.php");?>
</body>
</html>
