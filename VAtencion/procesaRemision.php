
<?php 
	
	
	if(!empty($_REQUEST['del'])){
		$id=$_REQUEST['del'];
		$Tabla=$_REQUEST['TxtTabla'];
		$IdTabla=$_REQUEST['TxtIdTabla'];
		$IdPre=$_REQUEST['TxtIdPre'];
		mysql_query("DELETE FROM $Tabla WHERE $IdTabla='$id'") or die(mysql_error());
		header("location:Cotizaciones.php?TxtIdCliente=$IdPre");
	}
		
	if(!empty($_REQUEST['TxtSaldo'])){
		
		$fecha=date("Y-m-d");
		
		$obVenta=new ProcesoVenta($idUser);
				
		//$DatosCotizacion=$obVenta->DevuelveValores("cotizacionesv5","ID",$_REQUEST['TxtIdCotizacion']);
		
		$tab="remisiones";
		$NumRegistros=13;  
							
		
		$Columnas[0]="Fecha";						$Valores[0]=$Cantidad;
		$Columnas[1]="Clientes_idClientes";						$Valores[1]=$DatosProducto["Referencia"];
		$Columnas[2]="ObservacionesRemision";					$Valores[2]=$DatosProducto["PrecioVenta"];
		$Columnas[3]="Cotizaciones_idCotizaciones";						$Valores[3]=$Subtotal;
		$Columnas[4]="Obra";						$Valores[4]=$DatosProducto["Nombre"];
		$Columnas[5]="Direccion";								$Valores[5]=$IVA;
		$Columnas[6]="Ciudad";						$Valores[6]=$DatosProducto["CostoUnitario"];
		$Columnas[7]="Telefono";					$Valores[7]=$DatosProducto["CostoUnitario"];
		$Columnas[8]="Retira";							$Valores[8]=$Total;
		$Columnas[9]="FechaDespacho";						$Valores[9]=$DatosDepartamento["TipoItem"];
		$Columnas[10]="HoraDespacho";						$Valores[10]=$idUser;
		$Columnas[11]="Anticipo";						$Valores[11]=$DatosProducto["CuentaPUC"];
		$Columnas[12]="Estado";			    			$Valores[12]=$TablaItem;
		
		$obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		
		header("location:Cotizaciones.php?TxtAsociarCliente=$idClientes");
			
	}
	
	
		
			
	
	?>