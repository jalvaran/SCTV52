<?php
	
	$con = mysql_connect("localhost","root","pirlo1985");
	mysql_select_db("softcontech_v5",$con) or die(mysql_error());
	date_default_timezone_set("America/Bogota");
	
	$CuentaDestino=110510;   //Cuenta Por defecto para caja menor
	$CuentaIngresos=4135;
	$TablaCuentaIngreso="cuentas";
	$CuentaIVAGen=2408;
	$TablaIVAGen="cuentas";
	$RegCREE="SI";
	$CuentaCostoMercancia=6135;
	$CuentaInventarios=1435;
	$AjustaInventario="SI";
	$RegCREE="SI";
	$COMPrinter=3;
	$PrintCuenta="SI";
	
class Consultar_Producto{
	private $consulta;
	private $fetch;
	
	function __construct($codigo){
		$this->consulta = mysql_query("SELECT * FROM productosventa WHERE Referencia='$codigo'");
		$this->fetch = mysql_fetch_array($this->consulta);
	}
	
	function consultar($campo){
		return $this->fetch[$campo];
	}
}

//////////////////////////////////////////////////////////////////////////
////////////Clase para guardar ventas ///////////////////////////////////
////////////////////////////////////////////////////////////////////////

class ProcesoVenta{
	private $consulta;
	private $fetch;
	private $MaxNumCoti;
	private $idUser;
	private $NumCotizacion;
	private $NombreUser;
	
	function __construct($idUserR){
		$this->consulta =mysql_query("SELECT MAX(NumCotizacion) as NumCotizacion ,MAX(NumVenta) as NumVenta, MAX(NumFactura) as NumFactura  FROM vestasactivas
		
		WHERE Usuario_idUsuario='$idUserR'") or die('problemas para consultas vestasactivas: ' . mysql_error());
		$this->fetch = mysql_fetch_array($this->consulta);
		$this->CotiUser = $this->fetch['NumCotizacion'];
		$this->NumVenta = $this->fetch["NumVenta"];
		$this->NumFactura = $this->fetch["NumFactura"];
		
		$this->consulta =mysql_query("SELECT Nombre FROM usuarios WHERE idUsuarios='$idUserR'") or die('problemas para consultas usuarios: ' . mysql_error());
		$this->fetch = mysql_fetch_array($this->consulta);
		$this->NombreUser = $this->fetch['Nombre'];
		$this->idUser=$idUserR;
		
	}
	
	/////////////////////Funcion que permite verificar u obtener los datos de la venta activa si extisten
	
	function ObtengaDatosEspacio(){
		
		return array($this->CotiUser,$this->NumVenta,$this->NumFactura);
	}
	
	/////////////////////Si no existen datos de venta activa deberá crearse
	
	function ObtengaEspacioVenta(){
		
		$this->consulta=mysql_query("SELECT MAX(NumCotizacion) as NumCotizacion, MAX(NumVenta) as NumVenta, MAX(NumFactura) as NumFactura  FROM vestasactivas") or die('problemas para consultas vestasactivas: ' . mysql_error());
		$this->fetch=mysql_fetch_array($this->consulta);
		$this->NumCotizacion = $this->fetch["NumCotizacion"]+1;
		$this->NumVenta = $this->fetch["NumVenta"]+1;
		$this->NumFactura = $this->fetch["NumFactura"]+1;
		if($this->CotiUser>0){
				
			mysql_query("UPDATE vestasactivas SET NumCotizacion='$this->NumCotizacion' WHERE Usuario_idUsuario='$this->idUser'") or die('problemas para actualizar vestasactivas: ' . mysql_error());
			
		}else{
						
			mysql_query("INSERT INTO vestasactivas (`Nombre`,`Usuario_idUsuario`,`Clientes_idClientes`, `NumCotizacion`,`NumVenta`,`NumFactura` ) 
						VALUES('Venta por: $this->NombreUser','$this->idUser','1','$this->NumCotizacion','$this->NumVenta','$this->NumFactura')") 
						or die('problemas para actualizar vestasactivas: ' . mysql_error());
		}

		
		return array($this->CotiUser,$this->NumVenta,$this->NumFactura);
	}
	
	
	/////////////////////RegistraVenta Desde Vista Admin
	
	function AdminRegVenta($Fecha,$Hora,$idMesa,$idMesero,$NumCotizacion,$NumVenta,$NumFactura,$Clientes_idClientes,$Usuarios_idUsuarios){
		
		$reg=mysql_query("select * from fechas_descuentos where Fecha = '$Fecha'") or die('no se pudo consultar los valores de fechas descuentos en AdminRegVenta: ' . mysql_error());
		$reg=mysql_fetch_array($reg);
		$Porcentaje=$reg["Porcentaje"];
		$Departamento=$reg["Departamento"];
		
	$reg=mysql_query("select * from prod_comicalenias where Departamento_Comi = '$Departamento'") or die('no se pudo consultar los valores de prod_comicalenias en AgregaPreventa: ' . mysql_error());
	$reg=mysql_fetch_array($reg);
	
	$TotalComisiones=$reg["FichasModelos"] + $reg["ShowsModelos"] + $reg["Administrador"];
		
		
		$this->consulta=mysql_query("SELECT * FROM atencion_pedidos ap INNER JOIN productosventa pv ON ap.Prod_Referencia=pv.Referencia
				INNER JOIN prod_comicalenias pc ON pc.Departamento_Comi=pv.Departamento
				WHERE ap.Usuarios_idUsuarios='$idMesero' AND ap.Mesas_idMesas='$idMesa'") 
				or die('problemas para consultar atencion_pedidos en php_conexion Clase AdminRegVenta: ' . mysql_error());
		while($this->fetch=mysql_fetch_array($this->consulta)){
			

			$idProductosVenta=$this->fetch["idProductosVenta"];
			$NombreP=$this->fetch["Nombre"];
			$Prod_Referencia=$this->fetch["Prod_Referencia"];
			$Prod_Cantidad=$this->fetch["Prod_Cantidad"];
			$CostoUnitario=$this->fetch["CostoUnitario"];
			
			$impuesto=$this->fetch["IVA"];
			$impuesto=$impuesto+1;
			//$Departamento=$reg["Departamento"];
			$ValorUnitario=ROUND($this->fetch["PrecioVenta"]/$impuesto);
			
			if($Porcentaje>0 and ($this->fetch["Departamento"]==$Departamento) or $Departamento=="TODO"){
		
				$Porcentaje=$Porcentaje/100;
				$ValorUnitario=$ValorUnitario*$Porcentaje;
				
			}
			
			$Subtotal=$ValorUnitario*$this->fetch["Prod_Cantidad"];
			$impuesto=round(($impuesto-1)*$Subtotal);
			$Total=$Subtotal+$impuesto;
			$TotalComisiones=($this->fetch["FichasModelos"] + $this->fetch["ShowsModelos"] + $this->fetch["Administrador"])*$this->fetch["Prod_Cantidad"];
			$TotalCosto=$this->fetch['CostoUnitario']*$this->fetch["Prod_Cantidad"];
			
			mysql_query("INSERT INTO ventas (`NumVenta`,`Fecha`,`Productos_idProductos`, `Producto`,`Referencia`,`Cantidad`,
						`ValorCostoUnitario`,`ValorVentaUnitario`,`Impuestos`, `Descuentos`,`TotalCosto`,`TotalVenta`,
						`TipoVenta`,`Cotizaciones_idCotizaciones`,`Especial`, `Clientes_idClientes`,`Usuarios_idUsuarios`,`HoraVenta`,
						`NoReclamacion`,`TotalComisiones`) 
						VALUES('$NumVenta','$Fecha','$idProductosVenta','$NombreP','$Prod_Referencia','$Prod_Cantidad',
						'$CostoUnitario','$ValorUnitario','$impuesto','0','$TotalCosto','$Total',
						'Contado','$NumCotizacion','NO','$Clientes_idClientes','$Usuarios_idUsuarios','$Hora',
						'$NumFactura','$TotalComisiones')") 
						or die('problemas para insertar la venta de $this->fetch[Prod_Referencia] en $idMesa: ' . mysql_error());
		}		
		
		
	}
		
	/////Suma un valor en especifico de una tabla	
		
	function SumeColumna($Tabla,$NombreColumnaSuma, $NombreColumnaFiltro,$filtro)
	{
	
		
	$sql="SELECT SUM($NombreColumnaSuma) AS suma FROM $Tabla WHERE $NombreColumnaFiltro = '$filtro'";
	
	$reg=mysql_query($sql) or die('no se pudo obtener la suma de $NombreColumnaSuma para la tabla $Tabla en SumeColumna: ' . mysql_error());
	$reg=mysql_fetch_array($reg);
	
	return($reg["suma"]);

	}	
	
	///Totaliza una venta
	
	function ObtengaTotalesVenta($NumVenta)
  {
	
		
	$sql="SELECT SUM(TotalVenta) AS TotalVenta, SUM(Impuestos) AS Impuestos, SUM(TotalCosto) AS TotalCosto FROM ventas 
	WHERE NumVenta = '$NumVenta'";
	
	$reg=mysql_query($sql) or die('no se pudo obtener los totales de la venta No $NumVenta en ObtengaTotalesVenta: ' . mysql_error());
	$reg=mysql_fetch_array($reg);
	
	$Subtotal=$reg["TotalVenta"]-$reg["Impuestos"];
	$GranTotal=$reg["TotalVenta"];
	return array($Subtotal,$reg["Impuestos"],$reg["TotalVenta"],$reg["TotalCosto"], $GranTotal);

	}	
	
	//////Funcion para insertar un Registro a un tabla
	
	public function InsertarRegistro($tabla,$NumRegistros,$Columnas,$Valores){
  
  	
	$sql="INSERT INTO $tabla (";
	$fin=$NumRegistros-1;
	for($i=0;$i<$NumRegistros;$i++){
		$col=$Columnas[$i];
		$reg=$Valores[$i];
		if($fin<>$i)
			$sql=$sql."`$col`,";
		else	
			$sql=$sql."`$col`)";
	}
	$sql=$sql."VALUES (";
	
	for($i=0;$i<$NumRegistros;$i++){
		
		$reg=$Valores[$i];
		if($fin<>$i)
			$sql=$sql."'$reg',";
		else	
			$sql=$sql."'$reg')";
	}
	
	
	mysql_query($sql) or die("no se pudo ingresar el registro en la tabla $tabla desde la funcion Insertar Registro: " . mysql_error());	
		
}


////////////////////////////////////////////////////////////////////
//////////////////////Funcion devuelve valores
///////////////////////////////////////////////////////////////////

	public function DevuelveValores($tabla,$ColumnaFiltro, $idItem){
	
		$reg=mysql_query("select * from $tabla where $ColumnaFiltro = '$idItem'") or die("no se pudo consultar los valores de la tabla $tabla en DevuelveValores: " . mysql_error());
		$reg=mysql_fetch_array($reg);	
		return ($reg);
	}	
	
////////////////////////////////////////////////////////////////////
//////////////////////Funcion realiza asiento contable factura
///////////////////////////////////////////////////////////////////

	public function RegFactLibroDiario($NumFact,$CuentaDestino,$CuentaIngresos,$TablaCuentaIngreso,$CuentaIVAGen, $TablaIVAGen, $CuentaCostoMercancia,$CuentaInventarios,$AjustaInventario,$RegCREE){
		
				
		$DatosFactura=$this->DevuelveValores("facturas","idFacturas",$NumFact);
		$fecha=	$DatosFactura["Fecha"];	
		$idFact=$DatosFactura["idFacturas"];
		$TotalVenta=$DatosFactura["Total"];
		$Subtotal=$DatosFactura["Subtotal"];
		$Impuestos=$DatosFactura["IVA"];
		$TotalCostosM=$DatosFactura["TotalCostos"];
		
		
		$DatosCliente=$this->DevuelveValores("clientes","idClientes",$DatosFactura['Clientes_idClientes']);
		$idCliente=$DatosFactura['Clientes_idClientes'];
		$NIT=$DatosCliente["Num_Identificacion"];
		$RazonSocialC=$DatosCliente["RazonSocial"];
		
		$tab="librodiario";
		$NumRegistros=24;
				
		if($DatosFactura['FormaPago']=="Contado"){
			$CuentaPUC=$CuentaDestino;
			$DatosCuenta=$this->DevuelveValores("cuentasfrecuentes","CuentaPUC",$CuentaPUC);
			
			$NombreCuenta=$DatosCuenta["Nombre"];
		}else{	
			$CuentaPUC="130505$idCliente";
			$NombreCuenta="Clientes Nacionales $RazonSocialC NIT $NIT";
		}
		
		
		$Columnas[0]="Fecha";					$Valores[0]=$fecha;
		$Columnas[1]="Tipo_Documento_Intero";	$Valores[1]="FACTURA";
		$Columnas[2]="Num_Documento_Interno";	$Valores[2]=$idFact;
		$Columnas[3]="Tercero_Tipo_Documento";	$Valores[3]=$DatosCliente['Tipo_Documento'];
		$Columnas[4]="Tercero_Identificacion";	$Valores[4]=$NIT;
		$Columnas[5]="Tercero_DV";				$Valores[5]=$DatosCliente['DV'];
		$Columnas[6]="Tercero_Primer_Apellido";	$Valores[6]=$DatosCliente['Primer_Apellido'];
		$Columnas[7]="Tercero_Segundo_Apellido";$Valores[7]=$DatosCliente['Segundo_Apellido'];
		$Columnas[8]="Tercero_Primer_Nombre";	$Valores[8]=$DatosCliente['Primer_Nombre'];
		$Columnas[9]="Tercero_Otros_Nombres";	$Valores[9]=$DatosCliente['Otros_Nombres'];
		$Columnas[10]="Tercero_Razon_Social";	$Valores[10]=$RazonSocialC;
		$Columnas[11]="Tercero_Direccion";		$Valores[11]=$DatosCliente['Direccion'];
		$Columnas[12]="Tercero_Cod_Dpto";		$Valores[12]=$DatosCliente['Cod_Dpto'];
		$Columnas[13]="Tercero_Cod_Mcipio";		$Valores[13]=$DatosCliente['Cod_Mcipio'];
		$Columnas[14]="Tercero_Pais_Domicilio";  $Valores[14]=$DatosCliente['Pais_Domicilio'];
		
		$Columnas[15]="CuentaPUC";				$Valores[15]=$CuentaPUC;
		$Columnas[16]="NombreCuenta";			$Valores[16]=$NombreCuenta;
		$Columnas[17]="Detalle";				$Valores[17]="ventas";
		$Columnas[18]="Debito";					$Valores[18]=$TotalVenta;
		$Columnas[19]="Credito";				$Valores[19]="0";
		$Columnas[20]="Neto";					$Valores[20]=$Valores[18];
		$Columnas[21]="Mayor";					$Valores[21]="NO";
		$Columnas[22]="Esp";					$Valores[22]="NO";
		$Columnas[23]="Concepto";				$Valores[23]="Ventas Por Atn Admin";
									
		$this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		
		
		///////////////////////Registramos ingresos
		
		$CuentaPUC=$CuentaIngresos; //4135   comercio al por menor y mayor
		
		$DatosCuenta=$this->DevuelveValores($TablaCuentaIngreso,"idPUC",$CuentaPUC);
		$NombreCuenta=$DatosCuenta["Nombre"];
		
		$Valores[15]=$CuentaPUC;
		$Valores[16]=$NombreCuenta;
		$Valores[18]="0";
		$Valores[19]=$Subtotal; 			//Credito se escribe el total de la venta menos los impuestos
		$Valores[20]=$Valores[19]*(-1);  											//Credito se escribe el total de la venta menos los impuestos
		
		$this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		
		///////////////////////Registramos IVA Generado si aplica
		
		if($Impuestos<>0){
		
			$CuentaPUC=$CuentaIVAGen; //2408   IVA Generado
			
			$DatosCuenta=$this->DevuelveValores($TablaIVAGen,"idPUC",$CuentaPUC);
			
			$NombreCuenta=$DatosCuenta["Nombre"];
			
			$Valores[15]=$CuentaPUC;
			$Valores[16]=$NombreCuenta;
			$Valores[18]="0";
			$Valores[19]=round($Impuestos); 			//Credito se escribe el total de la venta
			$Valores[20]=$Valores[19]*(-1);  	//para la sumatoria contemplar el balance
			
			$this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		
		}
					
					
					///////////////////////////////////////////////////////////////
		////////////Registramos Autoretencion
		if($RegCREE=="SI"){
			
			$CREE=$this->DevuelveValores("impret","Nombre","CREE");
			
			$ValorCREE=round($Subtotal*$CREE['Valor']);
			
			$CuentaPUC=135595; //  Autorretenciones CREE
			
			$DatosCuenta=$this->DevuelveValores("subcuentas","PUC",$CuentaPUC);
			$NombreCuenta=$DatosCuenta["Nombre"];
			
			$Valores[15]=$CuentaPUC;
			$Valores[16]=$NombreCuenta;
			$Valores[18]=$ValorCREE;     //Valor del CREE
			$Valores[19]=0; 			
			$Valores[20]=$ValorCREE;  	//para la sumatoria contemplar el balance
			
			$this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		
		///////////////////////////////////////////////////////////////
		////////////contra partida de la Autoretencion
		
			$CuentaPUC=23657502; //  Cuentas por pagar Autorretenciones CREE
			
			$DatosCuenta=$this->DevuelveValores("subcuentas","PUC",$CuentaPUC);
			$NombreCuenta=$DatosCuenta["Nombre"];
			
			$Valores[15]=$CuentaPUC;
			$Valores[16]=$NombreCuenta;
			$Valores[18]=0;     //Valor del CREE
			$Valores[19]=$ValorCREE; 			
			$Valores[20]=$ValorCREE*(-1);  	//para la sumatoria contemplar el balance
			
			$this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
			
			}
					
			///////////////////////Ajustamos el inventario
			
			if($AjustaInventario=="SI"){
				
				$CuentaPUC=$CuentaCostoMercancia; //6135   costo de mercancia vendida
				
				$DatosCuenta=$this->DevuelveValores('cuentas',"idPUC",$CuentaPUC);
				$NombreCuenta=$DatosCuenta["Nombre"];
				
				$Valores[15]=$CuentaPUC;
				$Valores[16]=$NombreCuenta;
				$Valores[18]=$TotalCostosM;//Debito se escribe el costo de la mercancia vendida
				$Valores[19]="0"; 			
				$Valores[20]=$TotalCostosM;  	//para la sumatoria contemplar el balance
				
				$this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
				
				///////////////////////Ajustamos el inventario
				
				$CuentaPUC=$CuentaInventarios; //1435   Mercancias no fabricadas por la empresa
				
				$DatosCuenta=$this->DevuelveValores('cuentas',"idPUC",$CuentaPUC);
				$NombreCuenta=$DatosCuenta["Nombre"];
				
				$Valores[15]=$CuentaPUC;
				$Valores[16]=$NombreCuenta;
				$Valores[18]="0";
				$Valores[19]=$TotalCostosM;//Credito se escribe el costo de la mercancia vendida			
				$Valores[20]=$TotalCostosM*(-1);  	//para la sumatoria contemplar el balance
				
				$this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
				
			}
	}	
	
	
	////////////////////////////////////////////////////////////////////
//////////////////////Funcion imprima factura
///////////////////////////////////////////////////////////////////

	public function ImprimeFactura($NumFactura,$COMPrinter,$PrintCuenta,$ruta){

		header("location:../printer/imprimir.php?print=$NumFactura&ruta=$ruta");
	}	

////////////////////////////////////////////////////////////////////
//////////////////////Funcion borra pedido
///////////////////////////////////////////////////////////////////

	public function BorraPedido($idMesa,$idMesero){

		mysql_query("DELETE FROM atencion_pedidos WHERE Usuarios_idUsuarios='$idMesero' AND Mesas_idMesas='$idMesa'");
	}
	
////////////////////////////////////////////////////////////////////
//////////////////////Funcion borra registro
///////////////////////////////////////////////////////////////////

	public function BorraReg($Tabla,$Filtro,$idFiltro){

		mysql_query("DELETE FROM $Tabla WHERE $Filtro='$idFiltro'");
	}
	
	////////////////////////////////////////////////////////////////////
//////////////////////Funcion reiniciar preventa
///////////////////////////////////////////////////////////////////

	public function ReiniciarPreventa($idPreventa){

		$sql="UPDATE `vestasactivas` SET `Clientes_idClientes` = '1', `SaldoFavor` = '0' WHERE `idVestasActivas` = $idPreventa;";

		mysql_query($sql) or die('no se pudo actualizar la Preventa: ' . mysql_error());	
	}

////////////////////////////////////////////////////////////////////
//////////////////////Funcion crea Preventa
///////////////////////////////////////////////////////////////////

	public function CrearPreventa($idUser){

		/////////////////////Si no existen datos de venta activa deberá crearse
	
	
		
		$this->consulta=mysql_query("SELECT MAX(NumCotizacion) as NumCotizacion, MAX(NumVenta) as NumVenta, MAX(NumFactura) as NumFactura  FROM vestasactivas") or die('problemas para consultas vestasactivas: ' . mysql_error());
		$this->fetch=mysql_fetch_array($this->consulta);
		
		if($this->CotiUser>0){
				
			
			mysql_query("INSERT INTO vestasactivas (`Nombre`,`Usuario_idUsuario`,`Clientes_idClientes`, `NumCotizacion`,`NumVenta`,`NumFactura` ) 
						VALUES('Venta por: $this->NombreUser','$this->idUser','1','$this->CotiUser','$this->NumVenta','$this->NumFactura')") 
						or die('problemas para actualizar vestasactivas: ' . mysql_error());
						
		}else{
			$this->NumCotizacion = $this->fetch["NumCotizacion"]+1;
			$this->NumVenta = $this->fetch["NumVenta"]+1;
			$this->NumFactura = $this->fetch["NumFactura"]+1;		
			mysql_query("INSERT INTO vestasactivas (`Nombre`,`Usuario_idUsuario`,`Clientes_idClientes`, `NumCotizacion`,`NumVenta`,`NumFactura` ) 
						VALUES('Venta por: $this->NombreUser','$this->idUser','1','$this->NumCotizacion','$this->NumVenta','$this->NumFactura')") 
						or die('problemas para actualizar vestasactivas: ' . mysql_error());
		}

		
		return array();
	
		
		
	}	
	
	
////////////////////////////////////////////////////////////////////
//////////////////////Funcion agregar preventa
///////////////////////////////////////////////////////////////////


public function AgregaPreventa($fecha,$Cantidad,$idVentaActiva,$idProducto,$idCliente,$idUsuario)
  {
	
	$reg=mysql_query("select * from fechas_descuentos where Fecha = '$fecha'") or die('no se pudo consultar los valores de fechas descuentos en AgregaPreventa: ' . mysql_error());
	$reg=mysql_fetch_array($reg);
	$Porcentaje=$reg["Porcentaje"];
	$Departamento=$reg["Departamento"];
	
	$reg=mysql_query("select * from productosventa where idProductosVenta = '$idProducto'") or die('no se pudo consultar los valores de productosventa en AgregaPreventa: ' . mysql_error());
	$reg=mysql_fetch_array($reg);
	$impuesto=$reg["IVA"];
	$impuesto=$impuesto+1;
	
	$ValorUnitario=ROUND($reg["PrecioVenta"]/$impuesto);
	
	if($Porcentaje>0 and ($reg["Departamento"]==$Departamento) or $Departamento=="TODO"){
		
		$Porcentaje=$Porcentaje/100;
		$ValorUnitario=$ValorUnitario*$Porcentaje;
		
	}
	
	$Subtotal=$ValorUnitario*$Cantidad;
	$impuesto=round(($impuesto-1)*$Subtotal);
	$Total=$Subtotal+$impuesto;

	
	$sql="INSERT INTO `preventa` ( `Fecha`, `Cantidad`, `VestasActivas_idVestasActivas`, `ProductosVenta_idProductosVenta`,`Clientes_idClientes`, `Usuarios_idUsuarios`, `ValorUnitario`,`ValorAcordado`, `Subtotal`, `Impuestos`, `TotalVenta`)
		VALUES ('$fecha', '$Cantidad', '$idVentaActiva', '$idProducto', '$idCliente', '$idUsuario', '$ValorUnitario','$ValorUnitario', '$Subtotal', '$impuesto', '$Total');";
	
	mysql_query($sql) or die('no se pudo guardar el item en preventa: ' . mysql_error());	
	
	
	}	
	
	////////////////////////////////////////////////////////////////////
//////////////////////Funcion Actualizar registro en tabla
///////////////////////////////////////////////////////////////////


public function ActualizaRegistro($tabla,$campo, $value, $filtro, $idItem)
  {		
	
	$sql="UPDATE `$tabla` SET `$campo` = '$value' WHERE `$filtro` = '$idItem'";
	
	mysql_query($sql) or die('no se pudo actualizar el registro en la $tabla: ' . mysql_error());	
		
	}
	
	
	/////////////////////RegistraVenta Desde Vista Admin
	
	function RegVenta($Fecha,$Hora,$idPreventa,$NumCotizacion,$NumVenta,$NumFactura,$TipoVenta,$Clientes_idClientes,$Usuarios_idUsuarios){
		
		$reg=mysql_query("select * from fechas_descuentos where Fecha = '$Fecha'") or die('no se pudo consultar los valores de fechas descuentos en RegVenta: ' . mysql_error());
		$reg=mysql_fetch_array($reg);
		$Porcentaje=$reg["Porcentaje"];
		$Departamento=$reg["Departamento"];
		
		$reg=mysql_query("select * from vestasactivas where idVestasActivas = '$idPreventa'") or die('no se pudo consultar la tabla vestasactivas en RegVenta: ' . mysql_error());
		$reg=mysql_fetch_array($reg);
		$idCliente=$reg["Clientes_idClientes"];
		
		$this->consulta=mysql_query("SELECT *,pv.IVA as IVAPro FROM preventa ap INNER JOIN productosventa pv ON ap.ProductosVenta_idProductosVenta=pv.idProductosVenta
				WHERE ap.VestasActivas_idVestasActivas='$idPreventa'") 
				or die('problemas para consultar preventa en php_conexion Clase RegVenta: ' . mysql_error());
				
		while($this->fetch=mysql_fetch_array($this->consulta)){
			

			$idProductosVenta=$this->fetch["idProductosVenta"];
			$NombreP=$this->fetch["Nombre"];
			$Prod_Referencia=$this->fetch["Referencia"];
			$Prod_Cantidad=$this->fetch["Cantidad"];
			$CostoUnitario=$this->fetch["CostoUnitario"];
			
			$impuesto=$this->fetch["IVAPro"];
			$impuesto=$impuesto+1;
			//$Departamento=$reg["Departamento"];
			$ValorUnitario=ROUND($this->fetch["PrecioVenta"]/$impuesto);
			
			if($Porcentaje>0 and ($this->fetch["Departamento"]==$Departamento) or $Departamento=="TODO"){
		
				$Porcentaje=$Porcentaje/100;
				$ValorUnitario=$ValorUnitario*$Porcentaje;
				
			}
			
			$Subtotal=$ValorUnitario*$this->fetch["Cantidad"];
			$impuesto=round(($impuesto-1)*$Subtotal);
			$Total=$Subtotal+$impuesto;
			
			$TotalCosto=$this->fetch['CostoUnitario']*$this->fetch["Cantidad"];
			
			mysql_query("INSERT INTO ventas (`NumVenta`,`Fecha`,`Productos_idProductos`, `Producto`,`Referencia`,`Cantidad`,
						`ValorCostoUnitario`,`ValorVentaUnitario`,`Impuestos`, `Descuentos`,`TotalCosto`,`TotalVenta`,
						`TipoVenta`,`Cotizaciones_idCotizaciones`,`Especial`, `Clientes_idClientes`,`Usuarios_idUsuarios`,`HoraVenta`,
						`NoReclamacion`) 
						VALUES('$NumVenta','$Fecha','$idProductosVenta','$NombreP','$Prod_Referencia','$Prod_Cantidad',
						'$CostoUnitario','$ValorUnitario','$impuesto','0','$TotalCosto','$Total',
						'$TipoVenta','$NumCotizacion','NO','$Clientes_idClientes','$Usuarios_idUsuarios','$Hora',
						'$NumFactura')") 
						or die('problemas para insertar la venta de $this->fetch[Referencia]: ' . mysql_error());
		}		
		
		
	}
	
	
	////////////////////////////////////////////////////////////////////
//////////////////////Funcion Obtener Ultimo ID de una Tabla
///////////////////////////////////////////////////////////////////


public function ObtenerMAX($tabla,$campo, $filtro, $idItem)
  {		
	if($filtro==1){
		$sql="SELECT MAX($campo) AS MaxNum FROM `$tabla`";
	}else{
		$sql="SELECT MAX($campo) AS MaxNum FROM `$tabla` WHERE `$filtro` = '$idItem'";
	}
		
	$Reg=mysql_query($sql) or die('no se pudo actualizar el registro en la $tabla: ' . mysql_error());	
	$MN=mysql_fetch_array($Reg);
	return($MN["MaxNum"]);	
	}
			
////////////////////////////////////////////////////////////////////
//////////////////////Funcion Obtener vaciar una tabla
///////////////////////////////////////////////////////////////////
public function VaciarTabla($tabla)
  {		
	
	$sql="TRUNCATE `$tabla`";
	
	mysql_query($sql) or die('no se pudo vaciar la tabla $tabla: ' . mysql_error());	
		
	}

	
	
////////////////////////////////////////////////////////////////////
//////////////////////Funcion Obtener inicializar las preventas
///////////////////////////////////////////////////////////////////
public function InicializarPreventas()
  {		
		$this->BorraReg("vestasactivas","Usuario_idUsuario","INI");
		$MaxFact=$this->ObtenerMAX("facturas","idFacturas", "1", "");
		$MaxCoti=$this->ObtenerMAX("cotizaciones","NumCotizacion", "1", "");
		$MaxNumVenta=$this->ObtenerMAX("ventas","NumVenta", "1", "");
		
		$tab="vestasactivas";
		$NumRegistros=6;
					
		$Columnas[0]="Nombre";				$Valores[0]="INICIALIZACION";
		$Columnas[1]="Usuario_idUsuario";	$Valores[1]="INI";
		$Columnas[2]="Clientes_idClientes";	$Valores[2]="1";
		$Columnas[3]="NumVenta";			$Valores[3]=$MaxNumVenta;
		$Columnas[4]="NumFactura";			$Valores[4]=$MaxFact;
		$Columnas[5]="NumCotizacion";		$Valores[5]=$MaxCoti;
											
		$this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		
		$sql="UPDATE `usuarios` SET Role=''";
	
		mysql_query($sql) or die('no se pudo actualizar los usuarios: ' . mysql_error());	
		
	}
	
////////////////////////////////////////////////////////////////////
//////////////////////Funcion Habilitar un espacio disponible
///////////////////////////////////////////////////////////////////
public function AsignarEspacioDisponible($idUser)
  {		
		$sql="SELECT (t1.idFacturas + 1) as gap_starts_at, (SELECT MIN(t3.idFacturas) -1 FROM facturas t3 WHERE t3.idFacturas > t1.idFacturas) as gap_ends_at FROM facturas t1 
		WHERE NOT EXISTS (SELECT t2.idFacturas FROM facturas t2 WHERE t2.idFacturas = t1.idFacturas + 1) HAVING gap_ends_at IS NOT NULL";
		$this->CrearPreventa($idUser);
		$DatosVenta=$this->DevuelveValores("vestasactivas","Usuario_idUsuario",$idUser);
			
		$Consul=mysql_query($sql) or die('no se pudo actualizar los usuarios: ' . mysql_error());
		while($DatosDispo=mysql_fetch_array($Consul)){
		
		$FactDispo=$DatosDispo['gap_starts_at'];
		$Ocupado=$this->DevuelveValores("vestasactivas","NumFactura",$FactDispo);
		if($FactDispo < $DatosVenta['NumFactura'] AND $Ocupado["NumFactura"]<>$FactDispo){
			$this->ActualizaRegistro("vestasactivas","NumVenta", $FactDispo, "Usuario_idUsuario", $idUser);
			$this->ActualizaRegistro("vestasactivas","NumFactura", $FactDispo, "Usuario_idUsuario", $idUser);
			
		}
		
		}
		//print("<script language='JavaScript'>alert('Factura $DatosVenta[NumFactura], Cotizacion $DatosVenta[NumCotizacion], Venta $DatosVenta[NumVenta], Ini $DatosDispo[gap_starts_at] , FIN $DatosDispo[gap_ends_at]')</script>");
		
	}	

////////////////////////////////////////////////////////////////////
//////////////////////Funcion consultar una tabla
///////////////////////////////////////////////////////////////////
public function ConsultarTabla($tabla,$Condicion)
  {		
		$sql="SELECT * FROM $tabla $Condicion";
		
			
		$Consul=mysql_query($sql) or die("no se pudo consultar la tabla $tabla en CosultarTabla php_conexion: " . mysql_error());
		
		return($Consul);
	}	
	

//////////////////////////////Fin	
}


	
?>