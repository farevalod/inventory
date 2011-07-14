<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
</head>
<body>
<?php include("header.php"); ?>
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
<div class="doclist">
<form action="index.php" method="get">
<fieldset>
<legend>Lista de doctores</legend>
<?php
            $query = "SELECT * FROM doctores ORDER BY apellido";
	        $results = mysql_query($query);
	        echo '<select name="id_doctor_sel">';
	        while($row = mysql_fetch_assoc($results))
        	{
                //Genera una opción para el select por cada row del resultado.
                echo '<option value="'.$row['id'].'">'.$row['apellido'].', '.$row['nombre'].'</option>';
            }
            if (mysql_num_rows($results) == 0) 
        	{
                echo '<option value=0>No hay doctores ingresados.</option>';
            }
            mysql_close($conn);
?>
        </select>
        <input type="submit" value="Consultar doctor">
        </fieldset>
        </form>
        </div>
        		<?php include("newdoctor.php"); ?>
        						            <?php include("footer.php"); ?>
