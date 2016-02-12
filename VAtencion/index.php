
 <script src="js/funciones.js"></script>
<?php 

session_start();

include_once("../modelo/php_conexion.php");

if (!isset($_SESSION['username']))
{
  exit("No se ha iniciado una sesion <a href='../index.php' >Iniciar Sesion </a>");
  
}

$NombreUser=$_SESSION['nombre'];
$idUser=$_SESSION['idUser'];	

$pa=mysql_query("SELECT * FROM atencion_mesa_activa WHERE Usuarios_idUsuarios='$idUser'");
$DatosMesa=mysql_fetch_array($pa);

if (!isset($DatosMesa['idMesa_Activa']))
{
  $_SESSION['idMesaActiva']=1;
  $idMesa=1;
  mysql_query("INSERT INTO atencion_mesa_activa VALUES ('$idUser', '$idMesa');");
}else{
	
	$_SESSION['idMesaActiva']=$DatosMesa['idMesa_Activa'];
	$idMesa=$DatosMesa['idMesa_Activa'];
}


	$Filtro="";

	if(!empty($_POST['CmbDepartamento'])){
		//print("Entra");
		if($_POST['CmbDepartamento']<>"*")
				$Filtro="WHERE pv.Sub1= '".$_POST['CmbDepartamento']."'";
	}

	if(!empty($_GET['del'])){
		$id=$_GET['del'];
		mysql_query("DELETE FROM atencion_pedidos WHERE Prod_Referencia='$id' AND Usuarios_idUsuarios='$idUser' AND Mesas_idMesas='$idMesa'");
		header('location:index.php');
	}
	
	
	
	if(!empty($_POST['CmbMesa'])){
		$idMesa=$_POST['CmbMesa'];
		mysql_query("REPLACE INTO atencion_mesa_activa VALUES ('$idUser', '$idMesa');");
		$_SESSION['idMesaActiva'] = $idMesa;
		header('location:index.php');
	}
	
	
	
?>
 
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Atencion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Software de Techno Soluciones Vista Mesero">
    <meta name="author" content="Techno Soluciones SAS">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="ico/favicon.png">
  
  
  

  
  
  
  </head>

  <body>

  
  
  
    <div class="navbar navbar-inverse navbar-fixed-top" >
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="../Menu.php">SoftConTech</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="index.php">Principal</a></li>
               <!-- <li><a href="mis_pedidos.php">Mis Pedidos</a></li> -->
			  <li><form name= "FormMesa" action="index.php" id="FormMesa" method="post" target="_self"> 
					<select name="CmbMesa" onchange="EnviaFormSC()">
					<?php
						
						$pa=mysql_query("SELECT * FROM atencion_mesas");				
							while($DatosMesa=mysql_fetch_array($pa)){  
						    if($_SESSION['idMesaActiva']==$DatosMesa['idMesa'])
								print("<option value=$DatosMesa[idMesa] selected>$DatosMesa[NombreMesa]</option>");
							else
								print("<option value=$DatosMesa[idMesa]>$DatosMesa[NombreMesa]</option>");
							}
					?>
					</select>
					<input type="submit" name="BtnSelect" value="Enviar Mesa" class="btn btn-primary"></input>
				</form>
			  </li>
			  
			  <li><form name= "FormDepar" action="index.php" id="FormDepar" method="post" target="_self"> 
					<select name="CmbDepartamento" onchange="EnviaFormDepar()">
					<?php
						
						$pa=mysql_query("SELECT * FROM prod_sub1");	
							print("<option value='NO'>Seleccione un Filtro</option>");
							while($DatosDepartamento=mysql_fetch_array($pa)){  
						    
								print("<option value=$DatosDepartamento[idSub1]>$DatosDepartamento[NombreSub1]</option>");
							}
							print("<option value='*'>TODO</option>");
					?>
					</select>
					<input type="submit" name="BtnDepartamento" value="Filtrar" class="btn btn-primary"></input>
				</form>
			  </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">

      <!-- Main hero unit for a primary marketing message or call to action -->
      

      <!-- Example row of columns -->
	  
	  <div class="span4" >
            <?php
				if(!empty($_POST['codigo'])){
					$codigo=$_POST['codigo'];
					
					$pa=mysql_query("SELECT MAX(Prioridad) as Pri FROM atencion_pedidos");
					$row=mysql_fetch_array($pa);
					$MaxPri=$row['Pri']+1;
					$pa=mysql_query("SELECT * FROM atencion_pedidos WHERE Prod_Referencia='$codigo' AND Usuarios_idUsuarios='$idUser' AND Mesas_idMesas = '$_SESSION[idMesaActiva]'");				
					if($row=mysql_fetch_array($pa)){
						$new_cant=$row['Prod_Cantidad']+$_POST['TxtCantidad'];
						mysql_query("UPDATE atencion_pedidos SET Prod_Cantidad='$new_cant' WHERE Prod_Referencia='$codigo'");
					}else{
						
						$pa1=mysql_query("SELECT Prioridad FROM atencion_pedidos WHERE Usuarios_idUsuarios='$idUser' AND Mesas_idMesas = '$_SESSION[idMesaActiva]'");
						if($row1=mysql_fetch_array($pa1)){
							$MaxPri=$row1['Prioridad'];
						}				
						
						mysql_query("INSERT INTO atencion_pedidos (Prod_Referencia, Prod_Cantidad, Usuarios_idUsuarios, Mesas_idMesas, Prioridad) 
						VALUES ('$codigo','$_POST[TxtCantidad]','$_SESSION[idUser]','$idMesa','$MaxPri')");
					}
				}
			?>
               
            </div>
	  
	  <div id="contenidoMesas" class="container" >
	
		<?php include("contMesas.php");	?>
		

    </div>
				
				
				
	  
	  
      <div class="row">
      	
      </div>
      <div align="center">
      	
        <div class="row-fluid">
    		<div class="span8">
			<?php
				$sql="SELECT * FROM productosventa pv INNER JOIN prod_comicalenias pc ON pv.Departamento=pc.Departamento_Comi $Filtro";
				//print($sql);
                $pa=mysql_query($sql);				
                while($row=mysql_fetch_array($pa)){
				$ImageRuta=explode("/", $row['Imagen']);
				$PrecioFinal=$row['PrecioVenta']+$row['FichasModelos']+$row['ShowsModelos']+$row['Administrador'];
            ?>                       
        	<table class="table table-bordered">
            	<tr><td>
                	<div class="row-fluid">
                    	<div class="span4">
                            <center><strong><?php echo $row['Nombre']; ?></strong></center><br>
                            <img src="imagepro/<?php echo $ImageRuta[3]; ?>" class="img-polaroid">
                        </div>
                        <div class="span4"><br>
                            
                            <strong>Valor: </strong>$ <?php echo number_format($PrecioFinal); ?>
                        </div>
                        <div class="span4"><br>
                        	<form name="form<?php $row['Referencia']; ?>" method="post" action="">
                            	<input type="hidden" name="codigo" value="<?php echo $row['Referencia']; ?>">
								<input type="hidden" name="PrecioFinal" value="<?php echo $PrecioFinal; ?>">
								<image src="../iconos/subir1.png" onclick="incrementa('<?php echo $row['Referencia']; ?>')"></image>
								<input type="number" name="TxtCantidad" id="<?php echo $row['Referencia']; ?>" value="1" step="any" style="height:50px;font-size:20;width:100px"> 
								<image src="../iconos/bajar1.png" onclick="decrementa('<?php echo $row['Referencia']; ?>')"></image><br><br>
                                <button type="submit" name="boton" class="btn btn-primary">
                                    <i class="icon-shopping-cart"></i> <strong>Agregar</strong>
                                </button>
                            </form>
                        </div>
                    </div>
            	</td></tr>
        	</table>
        	<?php } ?>
        	</div>
            
    	</div>
        
      </div>

      <hr>

      <footer>
        <p>&copy; Techno Soluciones SAS 2015</p>
      </footer>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>
	

   
		
<a style="display:scroll; position:fixed; bottom:10px; right:10px;" href="#" title="Volver arriba"><img src="../iconos/up1_amarillo.png" /></a>
  </body>
  
  
</html>
