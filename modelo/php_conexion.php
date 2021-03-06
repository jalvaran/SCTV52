<?php
	
	include_once 'php_settings.php';
	$CuentaDestino=110510;   //Cuenta Por defecto para caja menor
	$CuentaIngresos=4135;
	$TablaCuentaIngreso="cuentas";
	$CuentaIVAGen=2408;
	$TablaIVAGen="cuentas";
        $IDTablaIVAGen="idPUC";
	$RegCREE="SI";
        $CuentaCREE=135595;
        $ContraPartidaCREE=23657502;
	$CuentaCostoMercancia=6135;
	$CuentaInventarios=1435;
	$AjustaInventario="SI";
	$RegCREE="SI";
	$COMPrinter=3;
	$PrintCuenta="SI";
        $CuentaAnticipos=2705;
	
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
        public  $CuentaIVAGen=2408;
        public  $TablaIVAGen="cuentas";
        public  $IDTablaIVAGen="idPUC";
        public  $RegCREE="SI";
        public  $CuentaCREE=135595;
        public  $ContraPartidaCREE=23657502;
	public  $CuentaCostoMercancia=6135;
	public  $CuentaInventarios=1435;
	
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
		
	function SumeColumna($Tabla,$NombreColumnaSuma, $NombreColumnaFiltro,$filtro){
	
	
		
	$sql="SELECT SUM($NombreColumnaSuma) AS suma FROM $Tabla WHERE $NombreColumnaFiltro = '$filtro'";
	
	$reg=mysql_query($sql) or die('no se pudo obtener la suma de $NombreColumnaSuma para la tabla $Tabla en SumeColumna: ' . mysql_error());
	$reg=mysql_fetch_array($reg);
	
	return($reg["suma"]);

	}	
        
        /////Suma un valor en especifico de una tabla segun una condicion
		
	function Sume($Tabla,$NombreColumnaSuma, $Condicion){
	
	
		
	$sql="SELECT SUM($NombreColumnaSuma) AS suma FROM $Tabla $Condicion";
	
	$reg=mysql_query($sql) or die('no se pudo obtener la suma de '.$sql.' '.$NombreColumnaSuma.' para la tabla '.$Tabla.' en SumeColumna: ' . mysql_error());
	$reg=mysql_fetch_array($reg);
	
	return($reg["suma"]);

	}	
	
	///Totaliza una venta
	
	function ObtengaTotalesVenta($NumVenta){
  
	
		
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
//////////////////////Funcion devuelve el valor de una columna
///////////////////////////////////////////////////////////////////

	public function ValorActual($tabla,$Columnas,$Condicion){
	
		$reg=mysql_query("SELECT $Columnas FROM $tabla WHERE $Condicion") or die("no se pudo consultar los valores de la tabla $tabla en ValorActual: " . mysql_error());
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
	

        
/*
 * Funcion realiza asiento contable facturas item por item
 */

    public function InsertarFacturaLibroDiario($Datos){

            $idFact=$Datos["ID"];		
            $DatosFactura=$this->DevuelveValores("facturas","idFacturas",$idFact);
            $fecha=	$DatosFactura["Fecha"];	
            $CuentaDestino=$Datos["CuentaDestino"];
            $DatosCliente=$this->DevuelveValores("clientes","idClientes",$DatosFactura['Clientes_idClientes']);
            $idCliente=$DatosFactura['Clientes_idClientes'];
            $NIT=$DatosCliente["Num_Identificacion"];
            $RazonSocialC=$DatosCliente["RazonSocial"];
            $EmpresaPro=$Datos["EmpresaPro"];
            $CentroCostos=$Datos["CentroCostos"];
            $sql="SELECT * FROM facturas_items WHERE idFactura='$idFact'";
            $Consulta=$this->Query($sql);
            $tab="librodiario";
            $NumRegistros=26;
            while($DatosItems=$this->FetchArray($Consulta)){
                
		$Subtotal=$DatosItems["SubtotalItem"];
                $Total=$DatosItems["TotalItem"];
                $Impuestos=$DatosItems["IVAItem"];
                $TotalCostosM=$DatosItems["SubtotalCosto"];
		if($DatosFactura['FormaPago']=="Contado"){
			$CuentaPUC=$CuentaDestino;
			$DatosCuenta=$this->DevuelveValores("cuentasfrecuentes","CuentaPUC",$CuentaPUC);
			
			$NombreCuenta=$DatosCuenta["Nombre"];
		}else{	
			$CuentaPUC="130505$NIT";
			$NombreCuenta="Clientes Nacionales $RazonSocialC NIT $NIT";
		}
		
		
		$Columnas[0]="Fecha";			$Valores[0]=$fecha;
		$Columnas[1]="Tipo_Documento_Intero";	$Valores[1]="FACTURA";
		$Columnas[2]="Num_Documento_Interno";	$Valores[2]=$idFact;
		$Columnas[3]="Tercero_Tipo_Documento";	$Valores[3]=$DatosCliente['Tipo_Documento'];
		$Columnas[4]="Tercero_Identificacion";	$Valores[4]=$NIT;
		$Columnas[5]="Tercero_DV";		$Valores[5]=$DatosCliente['DV'];
		$Columnas[6]="Tercero_Primer_Apellido";	$Valores[6]=$DatosCliente['Primer_Apellido'];
		$Columnas[7]="Tercero_Segundo_Apellido";$Valores[7]=$DatosCliente['Segundo_Apellido'];
		$Columnas[8]="Tercero_Primer_Nombre";	$Valores[8]=$DatosCliente['Primer_Nombre'];
		$Columnas[9]="Tercero_Otros_Nombres";	$Valores[9]=$DatosCliente['Otros_Nombres'];
		$Columnas[10]="Tercero_Razon_Social";	$Valores[10]=$RazonSocialC;
		$Columnas[11]="Tercero_Direccion";      $Valores[11]=$DatosCliente['Direccion'];
		$Columnas[12]="Tercero_Cod_Dpto";	$Valores[12]=$DatosCliente['Cod_Dpto'];
		$Columnas[13]="Tercero_Cod_Mcipio";	$Valores[13]=$DatosCliente['Cod_Mcipio'];
		$Columnas[14]="Tercero_Pais_Domicilio"; $Valores[14]=$DatosCliente['Pais_Domicilio'];
		
		$Columnas[15]="CuentaPUC";		$Valores[15]=$CuentaPUC;
		$Columnas[16]="NombreCuenta";		$Valores[16]=$NombreCuenta;
		$Columnas[17]="Detalle";		$Valores[17]="Ventas";
		$Columnas[18]="Debito";			$Valores[18]=$Total;
		$Columnas[19]="Credito";		$Valores[19]="0";
		$Columnas[20]="Neto";			$Valores[20]=$Valores[18];
		$Columnas[21]="Mayor";			$Valores[21]="NO";
		$Columnas[22]="Esp";			$Valores[22]="NO";
		$Columnas[23]="Concepto";		$Valores[23]="Ventas";
		$Columnas[24]="idCentroCosto";		$Valores[24]=$CentroCostos;
		$Columnas[25]="idEmpresa";		$Valores[25]=$EmpresaPro;
                
		$this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		
		
		///////////////////////Registramos ingresos
		
		$CuentaPUC=$DatosItems["CuentaPUC"]; 
		$Longitud=strlen($CuentaPUC);
                if($Longitud>4){
                    $TablaCuenta="subcuentas";
                    $idTablaCuenta="PUC";
                }else{
                    $TablaCuenta="cuentas";
                    $idTablaCuenta="idPUC";
                }
		$DatosCuenta=$this->DevuelveValores($TablaCuenta,$idTablaCuenta,$CuentaPUC);
		$NombreCuenta=$DatosCuenta["Nombre"];
		
		$Valores[15]=$CuentaPUC;
		$Valores[16]=$NombreCuenta;
		$Valores[18]="0";
		$Valores[19]=$Subtotal;
		$Valores[20]=$Valores[19]*(-1);  											//Credito se escribe el total de la venta menos los impuestos
		
		$this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		
		///////////////////////Registramos IVA Generado si aplica
		
		if($Impuestos<>0){
		
                    $CuentaPUC=$this->CuentaIVAGen; //2408   IVA Generado
                    $DatosCuenta=$this->DevuelveValores($this->TablaIVAGen,$this->IDTablaIVAGen,$CuentaPUC);

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
		if($this->RegCREE=="SI"){
			
			$CREE=$this->DevuelveValores("impret","Nombre","CREE");
			
			$ValorCREE=round($Subtotal*$CREE['Valor']);
			
			$CuentaPUC=$this->CuentaCREE; //  Autorretenciones CREE
			
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
		
			$CuentaPUC=$this->ContraPartidaCREE; //  Cuentas por pagar Autorretenciones CREE
			
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
                        $AjustaInventario="";
			if($DatosItems["TipoItem"]=="PR"){
                            $AjustaInventario="SI";
                        }
			if($AjustaInventario=="SI"){
				
				$CuentaPUC=$this->CuentaCostoMercancia; //6135   costo de mercancia vendida
				
				$DatosCuenta=$this->DevuelveValores('cuentas',"idPUC",$CuentaPUC);
				$NombreCuenta=$DatosCuenta["Nombre"];
				
				$Valores[15]=$CuentaPUC;
				$Valores[16]=$NombreCuenta;
				$Valores[18]=$TotalCostosM;//Debito se escribe el costo de la mercancia vendida
				$Valores[19]="0"; 			
				$Valores[20]=$TotalCostosM;  	//para la sumatoria contemplar el balance
				
				$this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
				
				///////////////////////Ajustamos el inventario
				
				$CuentaPUC=$this->CuentaInventarios; //1435   Mercancias no fabricadas por la empresa
				
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


public function AgregaPreventa($fecha,$Cantidad,$idVentaActiva,$idProducto,$TablaItem)
  {
	$DatosProductoGeneral=$this->DevuelveValores($TablaItem, "idProductosVenta", $idProducto);
        $DatosDepartamento=$this->DevuelveValores("prod_departamentos", "idDepartamentos", $DatosProductoGeneral["Departamento"]);
        $DatosTablaItem=$this->DevuelveValores("tablas_ventas", "NombreTabla", $TablaItem);
        $TipoItem=$DatosDepartamento["TipoItem"];
        $consulta=$this->ConsultarTabla("preventa", "WHERE TablaItem='$TablaItem' AND ProductosVenta_idProductosVenta='$idProducto' AND VestasActivas_idVestasActivas='$idVentaActiva'");
       
	if($this->NumRows($consulta)){
            $DatosProduto=$this->FetchArray($consulta);
            $Cantidad=$DatosProduto["Cantidad"]+$Cantidad;
            $Subtotal=$DatosProduto["ValorAcordado"]*$Cantidad;
            $Impuestos=$DatosProductoGeneral["IVA"]*$Subtotal;
            $TotalVenta=$Subtotal+$Impuestos;
            
            $sql="UPDATE preventa SET Subtotal='$Subtotal', Impuestos='$Impuestos', TotalVenta='$TotalVenta', Cantidad='$Cantidad' WHERE TablaItem='$TablaItem' AND ProductosVenta_idProductosVenta='$idProducto' AND VestasActivas_idVestasActivas='$idVentaActiva'";
            $this->Query($sql);
        }else{
            $reg=mysql_query("select * from fechas_descuentos where Fecha = '$fecha'") or die('no se pudo consultar los valores de fechas descuentos en AgregaPreventa: ' . mysql_error());
            $reg=mysql_fetch_array($reg);
            $Porcentaje=$reg["Porcentaje"];
            $Departamento=$reg["Departamento"];

            
            $impuesto=$DatosProductoGeneral["IVA"];
            $impuesto=$impuesto+1;
            if($DatosTablaItem["IVAIncluido"]=="SI"){
                $ValorUnitario=$DatosProductoGeneral["PrecioVenta"]/$impuesto;
                
            }else{
                $ValorUnitario=$DatosProductoGeneral["PrecioVenta"];
                
            }
            if($Porcentaje>0 and ($DatosProductoGeneral["Departamento"]==$Departamento) or $Departamento=="TODO"){

                    $Porcentaje=$Porcentaje/100;
                    $ValorUnitario=$ValorUnitario*$Porcentaje;

            }

            $Subtotal=$ValorUnitario*$Cantidad;
            $impuesto=($impuesto-1)*$Subtotal;
            $Total=$Subtotal+$impuesto;


            $sql="INSERT INTO `preventa` ( `Fecha`, `Cantidad`, `VestasActivas_idVestasActivas`, `ProductosVenta_idProductosVenta`, `ValorUnitario`,`ValorAcordado`, `Subtotal`, `Impuestos`, `TotalVenta`, `TablaItem`, `TipoItem`)
                    VALUES ('$fecha', '$Cantidad', '$idVentaActiva', '$idProducto', '$ValorUnitario','$ValorUnitario', '$Subtotal', '$impuesto', '$Total', '$TablaItem', '$TipoItem');";

            $this->Query($sql) or die('no se pudo guardar el item en preventa: ' . mysql_error());	
	
        }
	}	
	
	////////////////////////////////////////////////////////////////////
//////////////////////Funcion Actualizar registro en tabla
///////////////////////////////////////////////////////////////////


public function ActualizaRegistro($tabla,$campo, $value, $filtro, $idItem)
  {		
	
	$sql="UPDATE `$tabla` SET `$campo` = '$value' WHERE `$filtro` = '$idItem'";
	
	mysql_query($sql) or die('no se pudo actualizar el registro en la $tabla: ' . mysql_error());	
		
	}
        
        ////////////////////////////////////////////////////////////////////
//////////////////////Funcion Actualizar registro en tabla
///////////////////////////////////////////////////////////////////


public function update($tabla,$campo, $value, $condicion)
  {		
	
	$sql="UPDATE `$tabla` SET `$campo` = '$value' $condicion";
	
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
	
////////////////////////////////////////////////////////////////////
//////////////////////Funcion query mysql
///////////////////////////////////////////////////////////////////
public function Query($sql)
  {		
					
    $Consul=mysql_query($sql) or die("no se pudo realizar la consulta $sql en query php_conexion: " . mysql_error());
    return($Consul);
}

////////////////////////////////////////////////////////////////////
//////////////////////Funcion fetcharray mysql
///////////////////////////////////////////////////////////////////
public function FetchArray($Datos)
  {		
					
    $Vector=  mysql_fetch_array($Datos);
    return($Vector);
}
////////////////////////////////////////////////////////////////////
//////////////////////Funcion Registra Anticipo
///////////////////////////////////////////////////////////////////

	public function RegistreAnticipo($idCliente,$Anticipo, $CuentaDestino,$CentroCosto,$Concepto,$idUser){
            $fecha=date("Y-m-d");
            $DatosCentro=$this->DevuelveValores("centrocosto","ID",$CentroCosto);
            $DatosCliente=$this->DevuelveValores("clientes","idClientes",$idCliente);
            $DatosCuentasFrecuentes=$this->DevuelveValores("cuentasfrecuentes","CuentaPUC",$CuentaDestino);
            $NIT=$DatosCliente["Num_Identificacion"];
            $RazonSocialC=$DatosCliente["RazonSocial"];
            
            //////Creo el comprobante de Ingreso
            
            $tab="comprobantes_ingreso";
            $NumRegistros=6;

            $Columnas[0]="Fecha";		$Valores[0]=$fecha;
            $Columnas[1]="Clientes_idClientes";	$Valores[1]=$idCliente;
            $Columnas[2]="Valor";               $Valores[2]=$Anticipo;
            $Columnas[3]="Tipo";		$Valores[3]="EFECTIVO";
            $Columnas[4]="Concepto";		$Valores[4]=$Concepto;
            $Columnas[5]="Usuarios_idUsuarios";	$Valores[5]=$idUser;
            
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
            
            $idIngreso=$this->ObtenerMAX($tab,"ID", 1,"");
            
            ////Registro el anticipo en el libro diario
            
            $tab="librodiario";
            $NumRegistros=26;
            $CuentaPUC=$CuentaDestino;
            $NombreCuenta=$DatosCuentasFrecuentes["Nombre"];
            $CuentaPUCContraPartida="238020".$NIT;
            $NombreCuentaContraPartida="Anticipos recibidos Cliente: $RazonSocialC NIT $NIT";
            


            $Columnas[0]="Fecha";			$Valores[0]=$fecha;
            $Columnas[1]="Tipo_Documento_Intero";	$Valores[1]="ComprobanteIngreso";
            $Columnas[2]="Num_Documento_Interno";	$Valores[2]=$idIngreso;
            $Columnas[3]="Tercero_Tipo_Documento";	$Valores[3]=$DatosCliente['Tipo_Documento'];
            $Columnas[4]="Tercero_Identificacion";	$Valores[4]=$NIT;
            $Columnas[5]="Tercero_DV";			$Valores[5]=$DatosCliente['DV'];
            $Columnas[6]="Tercero_Primer_Apellido";	$Valores[6]=$DatosCliente['Primer_Apellido'];
            $Columnas[7]="Tercero_Segundo_Apellido";    $Valores[7]=$DatosCliente['Segundo_Apellido'];
            $Columnas[8]="Tercero_Primer_Nombre";	$Valores[8]=$DatosCliente['Primer_Nombre'];
            $Columnas[9]="Tercero_Otros_Nombres";	$Valores[9]=$DatosCliente['Otros_Nombres'];
            $Columnas[10]="Tercero_Razon_Social";	$Valores[10]=$RazonSocialC;
            $Columnas[11]="Tercero_Direccion";		$Valores[11]=$DatosCliente['Direccion'];
            $Columnas[12]="Tercero_Cod_Dpto";		$Valores[12]=$DatosCliente['Cod_Dpto'];
            $Columnas[13]="Tercero_Cod_Mcipio";		$Valores[13]=$DatosCliente['Cod_Mcipio'];
            $Columnas[14]="Tercero_Pais_Domicilio";     $Valores[14]=$DatosCliente['Pais_Domicilio'];
            $Columnas[15]="CuentaPUC";			$Valores[15]=$CuentaPUC;
            $Columnas[16]="NombreCuenta";		$Valores[16]=$NombreCuenta;
            $Columnas[17]="Detalle";			$Valores[17]="Anticipos";
            $Columnas[18]="Debito";			$Valores[18]=$Anticipo;
            $Columnas[19]="Credito";			$Valores[19]="0";
            $Columnas[20]="Neto";			$Valores[20]=$Valores[18];
            $Columnas[21]="Mayor";			$Valores[21]="NO";
            $Columnas[22]="Esp";			$Valores[22]="NO";
            $Columnas[23]="Concepto";			$Valores[23]=$Concepto;
            $Columnas[24]="idCentroCosto";		$Valores[24]=$CentroCosto;
            $Columnas[25]="idEmpresa";			$Valores[25]=$DatosCentro["EmpresaPro"];

            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);


            ///////////////////////Registramos contra partida del anticipo

            $CuentaPUC=$CuentaPUCContraPartida; 
            $NombreCuenta=$NombreCuentaContraPartida;

            $Valores[15]=$CuentaPUC;
            $Valores[16]=$NombreCuenta;
            $Valores[18]="0";
            $Valores[19]=$Anticipo; 			//Credito se escribe el total de la venta menos los impuestos
            $Valores[20]=$Valores[19]*(-1);  											//Credito se escribe el total de la venta menos los impuestos

            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		
            return($idIngreso);
	}
        
/*
 * Funcion Registra Ingreso
 */


	public function RegistreIngreso($fecha,$CuentaDestino,$idProveedor,$Total,$CentroCosto,$Concepto,$idUser,$VectorIngreso){
            
            $DatosCentro=$this->DevuelveValores("centrocosto","ID",$CentroCosto);
            $DatosCliente=$this->DevuelveValores("proveedores","idProveedores",$idProveedor);
            $DatosCuentasFrecuentes=$this->DevuelveValores("cuentasfrecuentes","CuentaPUC",$CuentaDestino);
            $NIT=$DatosCliente["Num_Identificacion"];
            $RazonSocialC=$DatosCliente["RazonSocial"];
            
            //////Creo el comprobante de Ingreso
            
            $tab="comprobantes_ingreso";
            $NumRegistros=6;

            $Columnas[0]="Fecha";		$Valores[0]=$fecha;
            $Columnas[1]="Tercero";             $Valores[1]=$idProveedor;
            $Columnas[2]="Valor";               $Valores[2]=$Total;
            $Columnas[3]="Tipo";		$Valores[3]="EFECTIVO";
            $Columnas[4]="Concepto";		$Valores[4]=$Concepto;
            $Columnas[5]="Usuarios_idUsuarios";	$Valores[5]=$idUser;
            
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
            
            $idIngreso=$this->ObtenerMAX($tab,"ID", 1,"");
            
            ////Registro el anticipo en el libro diario
            
            $tab="librodiario";
            $NumRegistros=26;
            $CuentaPUC=$CuentaDestino;
            $NombreCuenta=$DatosCuentasFrecuentes["Nombre"];
            $CuentaPUCContraPartida="2205".$NIT;
            $NombreCuentaContraPartida="Proveedores Nacionales: $RazonSocialC NIT $NIT";
            


            $Columnas[0]="Fecha";			$Valores[0]=$fecha;
            $Columnas[1]="Tipo_Documento_Intero";	$Valores[1]="ComprobanteIngreso";
            $Columnas[2]="Num_Documento_Interno";	$Valores[2]=$idIngreso;
            $Columnas[3]="Tercero_Tipo_Documento";	$Valores[3]=$DatosCliente['Tipo_Documento'];
            $Columnas[4]="Tercero_Identificacion";	$Valores[4]=$NIT;
            $Columnas[5]="Tercero_DV";			$Valores[5]=$DatosCliente['DV'];
            $Columnas[6]="Tercero_Primer_Apellido";	$Valores[6]=$DatosCliente['Primer_Apellido'];
            $Columnas[7]="Tercero_Segundo_Apellido";    $Valores[7]=$DatosCliente['Segundo_Apellido'];
            $Columnas[8]="Tercero_Primer_Nombre";	$Valores[8]=$DatosCliente['Primer_Nombre'];
            $Columnas[9]="Tercero_Otros_Nombres";	$Valores[9]=$DatosCliente['Otros_Nombres'];
            $Columnas[10]="Tercero_Razon_Social";	$Valores[10]=$RazonSocialC;
            $Columnas[11]="Tercero_Direccion";		$Valores[11]=$DatosCliente['Direccion'];
            $Columnas[12]="Tercero_Cod_Dpto";		$Valores[12]=$DatosCliente['Cod_Dpto'];
            $Columnas[13]="Tercero_Cod_Mcipio";		$Valores[13]=$DatosCliente['Cod_Mcipio'];
            $Columnas[14]="Tercero_Pais_Domicilio";     $Valores[14]=$DatosCliente['Pais_Domicilio'];
            $Columnas[15]="CuentaPUC";			$Valores[15]=$CuentaPUC;
            $Columnas[16]="NombreCuenta";		$Valores[16]=$NombreCuenta;
            $Columnas[17]="Detalle";			$Valores[17]="Ingresos";
            $Columnas[18]="Debito";			$Valores[18]=$Total;
            $Columnas[19]="Credito";			$Valores[19]=0;
            $Columnas[20]="Neto";			$Valores[20]=$Valores[18];
            $Columnas[21]="Mayor";			$Valores[21]="NO";
            $Columnas[22]="Esp";			$Valores[22]="NO";
            $Columnas[23]="Concepto";			$Valores[23]=$Concepto;
            $Columnas[24]="idCentroCosto";		$Valores[24]=$CentroCosto;
            $Columnas[25]="idEmpresa";			$Valores[25]=$DatosCentro["EmpresaPro"];

            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);


            ///////////////////////Registramos contra partida del anticipo

            $CuentaPUC=$CuentaPUCContraPartida; 
            $NombreCuenta=$NombreCuentaContraPartida;

            $Valores[15]=$CuentaPUC;
            $Valores[16]=$NombreCuenta;
            $Valores[18]=0;
            $Valores[19]=$Total; 			//Credito se escribe el total de la venta menos los impuestos
            $Valores[20]=$Valores[19]*(-1);  											//Credito se escribe el total de la venta menos los impuestos

            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		
            return($idIngreso);
	}
        
        /*
 * Funcion Registra Ingreso
 */


	public function RegistreAnticipo2($fecha,$CuentaDestino,$idCliente,$Total,$CentroCosto,$Concepto,$idUser,$VectorIngreso){
            
            $DatosCentro=$this->DevuelveValores("centrocosto","ID",$CentroCosto);
            $DatosCliente=$this->DevuelveValores("clientes","idClientes",$idCliente);
            $DatosCuentasFrecuentes=$this->DevuelveValores("cuentasfrecuentes","CuentaPUC",$CuentaDestino);
            $NIT=$DatosCliente["Num_Identificacion"];
            $RazonSocialC=$DatosCliente["RazonSocial"];
            
            //////Creo el comprobante de Ingreso
            
            $tab="comprobantes_ingreso";
            $NumRegistros=6;

            $Columnas[0]="Fecha";		$Valores[0]=$fecha;
            $Columnas[1]="Clientes_idClientes"; $Valores[1]=$idCliente;
            $Columnas[2]="Valor";               $Valores[2]=$Total;
            $Columnas[3]="Tipo";		$Valores[3]="EFECTIVO";
            $Columnas[4]="Concepto";		$Valores[4]=$Concepto;
            $Columnas[5]="Usuarios_idUsuarios";	$Valores[5]=$idUser;
            
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
            
            $idIngreso=$this->ObtenerMAX($tab,"ID", 1,"");
            
            ////Registro el anticipo en el libro diario
            
            $tab="librodiario";
            $NumRegistros=26;
            $CuentaPUC=$CuentaDestino;
            $NombreCuenta=$DatosCuentasFrecuentes["Nombre"];
            $CuentaPUCContraPartida="238020".$NIT;
            $NombreCuentaContraPartida="Anticipos recibidos Cliente: $RazonSocialC NIT $NIT";
            


            $Columnas[0]="Fecha";			$Valores[0]=$fecha;
            $Columnas[1]="Tipo_Documento_Intero";	$Valores[1]="ComprobanteIngreso";
            $Columnas[2]="Num_Documento_Interno";	$Valores[2]=$idIngreso;
            $Columnas[3]="Tercero_Tipo_Documento";	$Valores[3]=$DatosCliente['Tipo_Documento'];
            $Columnas[4]="Tercero_Identificacion";	$Valores[4]=$NIT;
            $Columnas[5]="Tercero_DV";			$Valores[5]=$DatosCliente['DV'];
            $Columnas[6]="Tercero_Primer_Apellido";	$Valores[6]=$DatosCliente['Primer_Apellido'];
            $Columnas[7]="Tercero_Segundo_Apellido";    $Valores[7]=$DatosCliente['Segundo_Apellido'];
            $Columnas[8]="Tercero_Primer_Nombre";	$Valores[8]=$DatosCliente['Primer_Nombre'];
            $Columnas[9]="Tercero_Otros_Nombres";	$Valores[9]=$DatosCliente['Otros_Nombres'];
            $Columnas[10]="Tercero_Razon_Social";	$Valores[10]=$RazonSocialC;
            $Columnas[11]="Tercero_Direccion";		$Valores[11]=$DatosCliente['Direccion'];
            $Columnas[12]="Tercero_Cod_Dpto";		$Valores[12]=$DatosCliente['Cod_Dpto'];
            $Columnas[13]="Tercero_Cod_Mcipio";		$Valores[13]=$DatosCliente['Cod_Mcipio'];
            $Columnas[14]="Tercero_Pais_Domicilio";     $Valores[14]=$DatosCliente['Pais_Domicilio'];
            $Columnas[15]="CuentaPUC";			$Valores[15]=$CuentaPUC;
            $Columnas[16]="NombreCuenta";		$Valores[16]=$NombreCuenta;
            $Columnas[17]="Detalle";			$Valores[17]="Ingresos";
            $Columnas[18]="Debito";			$Valores[18]=$Total;
            $Columnas[19]="Credito";			$Valores[19]=0;
            $Columnas[20]="Neto";			$Valores[20]=$Valores[18];
            $Columnas[21]="Mayor";			$Valores[21]="NO";
            $Columnas[22]="Esp";			$Valores[22]="NO";
            $Columnas[23]="Concepto";			$Valores[23]=$Concepto;
            $Columnas[24]="idCentroCosto";		$Valores[24]=$CentroCosto;
            $Columnas[25]="idEmpresa";			$Valores[25]=$DatosCentro["EmpresaPro"];

            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);


            ///////////////////////Registramos contra partida del anticipo

            $CuentaPUC=$CuentaPUCContraPartida; 
            $NombreCuenta=$NombreCuentaContraPartida;

            $Valores[15]=$CuentaPUC;
            $Valores[16]=$NombreCuenta;
            $Valores[18]=0;
            $Valores[19]=$Total; 			//Credito se escribe el total de la venta menos los impuestos
            $Valores[20]=$Valores[19]*(-1);  											//Credito se escribe el total de la venta menos los impuestos

            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		
            return($idIngreso);
	}
        
/*
 * Funcion Registra Pago de una factura
 * 
 */

    public function RegistrePagoFactura($idFactura,$fecha,$Pago,$CuentaDestino,$Retefuente,$ReteIVA,$ReteICA,$idUser,$Vector){
        
        $DatosFactura=$this->DevuelveValores("facturas","idFacturas",$idFactura);
        $CentroCostos=$DatosFactura["CentroCosto"]; 
        $idEmpresaPro=$DatosFactura["EmpresaPro_idEmpresaPro"];
        $DatosCliente=$this->DevuelveValores("clientes","idClientes",$DatosFactura["Clientes_idClientes"]);
        $DatosCuentasFrecuentes=$this->DevuelveValores("cuentasfrecuentes","CuentaPUC",$CuentaDestino);
        $NIT=$DatosCliente["Num_Identificacion"];
        $RazonSocialC=$DatosCliente["RazonSocial"];
        $Detalle="Pago de Factura $DatosFactura[Prefijo] $DatosFactura[NumeroFactura]";
        $ValorIngreso=$Pago-$Retefuente-$ReteIVA-$ReteICA;
        //////Creo el comprobante de Ingreso

        $tab="comprobantes_ingreso";
        $NumRegistros=6;

        $Columnas[0]="Fecha";               $Valores[0]=$fecha;
        $Columnas[1]="Clientes_idClientes"; $Valores[1]=$DatosFactura["Clientes_idClientes"];
        $Columnas[2]="Valor";               $Valores[2]=$ValorIngreso;
        $Columnas[3]="Tipo";                $Valores[3]="EFECTIVO";
        $Columnas[4]="Concepto";            $Valores[4]=$Detalle;
        $Columnas[5]="Usuarios_idUsuarios"; $Valores[5]=$idUser;

        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);

        $idIngreso=$this->ObtenerMAX($tab,"ID", 1,"");

        ////Registro el anticipo en el libro diario
        
        $tab="librodiario";
        $NumRegistros=26;
        $CuentaPUC="130505".$NIT;
        $NombreCuenta="Clientes Nacionales $RazonSocialC $NIT";
        
        $Columnas[0]="Fecha";			$Valores[0]=$fecha;
        $Columnas[1]="Tipo_Documento_Intero";	$Valores[1]="ComprobanteIngreso";
        $Columnas[2]="Num_Documento_Interno";	$Valores[2]=$idIngreso;
        $Columnas[3]="Tercero_Tipo_Documento";	$Valores[3]=$DatosCliente['Tipo_Documento'];
        $Columnas[4]="Tercero_Identificacion";	$Valores[4]=$NIT;
        $Columnas[5]="Tercero_DV";		$Valores[5]=$DatosCliente['DV'];
        $Columnas[6]="Tercero_Primer_Apellido";	$Valores[6]=$DatosCliente['Primer_Apellido'];
        $Columnas[7]="Tercero_Segundo_Apellido";$Valores[7]=$DatosCliente['Segundo_Apellido'];
        $Columnas[8]="Tercero_Primer_Nombre";	$Valores[8]=$DatosCliente['Primer_Nombre'];
        $Columnas[9]="Tercero_Otros_Nombres";	$Valores[9]=$DatosCliente['Otros_Nombres'];
        $Columnas[10]="Tercero_Razon_Social";	$Valores[10]=$RazonSocialC;
        $Columnas[11]="Tercero_Direccion";	$Valores[11]=$DatosCliente['Direccion'];
        $Columnas[12]="Tercero_Cod_Dpto";	$Valores[12]=$DatosCliente['Cod_Dpto'];
        $Columnas[13]="Tercero_Cod_Mcipio";	$Valores[13]=$DatosCliente['Cod_Mcipio'];
        $Columnas[14]="Tercero_Pais_Domicilio"; $Valores[14]=$DatosCliente['Pais_Domicilio'];
        $Columnas[15]="CuentaPUC";		$Valores[15]=$CuentaPUC;
        $Columnas[16]="NombreCuenta";		$Valores[16]=$NombreCuenta;
        $Columnas[17]="Detalle";		$Valores[17]="Pago";
        $Columnas[18]="Debito";			$Valores[18]=0;
        $Columnas[19]="Credito";		$Valores[19]=$Pago;
        $Columnas[20]="Neto";			$Valores[20]=$Valores[19]*(-1);
        $Columnas[21]="Mayor";			$Valores[21]="NO";
        $Columnas[22]="Esp";			$Valores[22]="NO";
        $Columnas[23]="Concepto";		$Valores[23]=$Detalle;
        $Columnas[24]="idCentroCosto";		$Valores[24]=$CentroCostos;
        $Columnas[25]="idEmpresa";		$Valores[25]=$idEmpresaPro;

        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);


        ///////////////////////Registramos contra partida del anticipo

        $CuentaPUC=$CuentaDestino; 
               
        $Valores[15]=$CuentaPUC;
        $Valores[16]=$DatosCuentasFrecuentes["Nombre"];
        $Valores[18]=$ValorIngreso;
        $Valores[19]=0; 			//Credito se escribe el total de la venta menos los impuestos
        $Valores[20]=$Valores[18];  											//Credito se escribe el total de la venta menos los impuestos

        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        //Si hay retefuente se registra
        if($Retefuente>0){
            
            $DatosCuenta=$this->DevuelveValores("tiposretenciones","ID",1);
                                        
            $NombreCuenta=$DatosCuenta["NombreCuentaActivo"];
            $CuentaPUC=$DatosCuenta["CuentaActivo"];

            $Valores[15]=$CuentaPUC;
            $Valores[16]=$NombreCuenta;
            $Valores[18]=$Retefuente;
            $Valores[19]=0; 						
            $Valores[20]=$Retefuente;  											//Credito se escribe el total de la venta menos los impuestos

            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores); //Registro el credito
        }
        //Si hay reteIVA se registra
        if($ReteIVA>0){
            
            $DatosCuenta=$this->DevuelveValores("tiposretenciones","ID",2);
                                        
            $NombreCuenta=$DatosCuenta["NombreCuentaActivo"];
            $CuentaPUC=$DatosCuenta["CuentaActivo"];

            $Valores[15]=$CuentaPUC;
            $Valores[16]=$NombreCuenta;
            $Valores[18]=$ReteIVA;
            $Valores[19]=0; 						
            $Valores[20]=$ReteIVA;  											//Credito se escribe el total de la venta menos los impuestos

            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores); //Registro el credito
        }
        //Si hay reteICA se registra
        if($ReteICA>0){
            
            $DatosCuenta=$this->DevuelveValores("tiposretenciones","ID",3);
                                        
            $NombreCuenta=$DatosCuenta["NombreCuentaActivo"];
            $CuentaPUC=$DatosCuenta["CuentaActivo"];

            $Valores[15]=$CuentaPUC;
            $Valores[16]=$NombreCuenta;
            $Valores[18]=$ReteICA;
            $Valores[19]=0; 						
            $Valores[20]=$ReteICA;  											//Credito se escribe el total de la venta menos los impuestos

            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores); //Registro el credito
        }
        $this->ActualizaRegistro("facturas", "SaldoFact", 0, "idFacturas", $idFactura);
        return($idIngreso);
    }        
////////////////////////////////////////////////////////////////////
//////////////////////Funcion calcular peso de una remision
///////////////////////////////////////////////////////////////////
public function CalculePesoRemision($idCotizacion)
  {		
        $Peso=0;
        $Consulta=$this->ConsultarTabla("cot_itemscotizaciones", "WHERE NumCotizacion=$idCotizacion");
        while($DatosItems=  mysql_fetch_array($Consulta)){
            if($DatosItems["TablaOrigen"]=="productosalquiler"){
                $Producto=  $this->DevuelveValores("productosalquiler", "Referencia", $DatosItems["Referencia"]);
                $Peso=$Peso+($Producto["PesoUnitario"]*$DatosItems["Cantidad"]);
            }

        }

        return($Peso);
	}
        
        
/*
 * 
 * Funcion para sumar dias a una fecha
 */

    public function SumeDiasFecha($Datos){		
        $Fecha=$Datos["Fecha"]; 
        $Dias=$Datos["Dias"]; 
        $nuevafecha = date('Y-m-d', strtotime($Fecha) + 86400);
        $nuevafecha = date('Y-m-d', strtotime("$Fecha + $Dias day"));

        return($nuevafecha);

    }
   
    
/*
 * 
 * Funcion para sumar dias a una fecha
 */

    public function ActualiceDiasCartera(){		
        $FechaActual=date("Y-m-d");
        //$FechaActual='2016-05-10';
        $sql="UPDATE `cartera` SET `DiasCartera`= DATEDIFF('$FechaActual', `FechaVencimiento`)";
        $this->Query($sql);
        $SumatoriaDias=$this->Sume("cartera", 'DiasCartera', '');
        $sql="SELECT COUNT(idCartera) as NumRegistros FROM cartera";
        $Consulta=$this->Query($sql);
        $DatosCartera=$this->FetchArray($Consulta);
        $NumRegistros=$DatosCartera["NumRegistros"];
        if($NumRegistros>0){
            $Promedio=$SumatoriaDias/$NumRegistros;
        }else{
            $Promedio="";
        }
        return($Promedio);
    }    
    /*
 * 
 * Funcion evitar la inyeccion de codigo sql
 */

    public function normalizar($string){		
        $str=str_replace("'", "", $string);
        $str=str_replace(";", ",", $str);
        //$str=filter_var($string, FILTER_SANITIZE_STRING);
        
        return($str);
    }
    
    
    /*
 * 
 * Funcion ingresa factura a cartera
 */

    public function InsertarFacturaEnCartera($Datos){		
        $idFactura=$Datos["idFactura"]; 
        $FechaIngreso=$Datos["FechaFactura"]; 
        $FechaVencimiento=$Datos["FechaVencimiento"];
        $idCliente=$Datos["idCliente"];
        $DatosCliente=$this->DevuelveValores("clientes", "idClientes", $idCliente);
        $DatosFactura=$this->DevuelveValores("facturas", "idFacturas", $idFactura);
        $RazonSocial=$DatosCliente["RazonSocial"];
        $Telefono=$DatosCliente["Telefono"];
        $Contacto=$DatosCliente["Contacto"];
        $TelContacto=$DatosCliente["TelContacto"];
        $TotalFactura=$DatosFactura["Total"];
        $tab="cartera";       
        $NumRegistros=12; 
                
        $Columnas[0]="Facturas_idFacturas";         $Valores[0]=$idFactura;
        $Columnas[1]="FechaIngreso";                $Valores[1]=$FechaIngreso;
        $Columnas[2]="FechaVencimiento";            $Valores[2]=$FechaVencimiento;
        $Columnas[3]="DiasCartera";                 $Valores[3]=0;
        $Columnas[4]="idCliente";                   $Valores[4]=$idCliente;
        $Columnas[5]="RazonSocial";                 $Valores[5]=$RazonSocial;
        $Columnas[6]="Telefono";                    $Valores[6]=$Telefono;
        $Columnas[7]="Contacto";                    $Valores[7]=$Contacto;
        $Columnas[8]="TelContacto";                 $Valores[8]=$TelContacto;
        $Columnas[9]="TotalFactura";                $Valores[9]=$TotalFactura;
        $Columnas[10]="TotalAbonos";                $Valores[10]=0;
        $Columnas[11]="Saldo";                      $Valores[11]=$TotalFactura;
        
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
                
        
    }
/*
 * Funcion Agregar items de devolucion a una factura peso de una remision
 */
    
    public function InsertarItemsDevolucionAItemsFactura($Datos){
        $idDevolucion=$Datos["NumDevolucion"];
        $NumFactura=$Datos["ID"];
        $FechaFactura=$Datos["FechaFactura"];
        
        $sql="SELECT rd.Cantidad, rd.ValorUnitario,rd.Subtotal,rd.Dias,rd.Total,"
                        . "ci.Referencia,ci.TablaOrigen,ci.TipoItem"
                        . " FROM rem_devoluciones rd INNER JOIN cot_itemscotizaciones ci ON rd.idItemCotizacion=ci.ID"
                        . " WHERE rd.NumDevolucion='$idDevolucion' ";
        $Consulta=$this->Query($sql);
        $TotalSubtotal=0;
        $TotalIVA=0;
        $GranTotal=0;
        $TotalCostos=0;
        while($DatosDevolucion=  mysql_fetch_array($Consulta)){

            $DatosProducto=$this->DevuelveValores($DatosDevolucion["TablaOrigen"], "Referencia", $DatosDevolucion["Referencia"]);
            ////Empiezo a insertar en la tabla items facturas
            ///
            ///
            $IVA=$DatosProducto["IVA"];
            $IVAItem=round($IVA*$DatosDevolucion['Total']);
            $TotalIVA=$TotalIVA+$IVAItem; //se realiza la sumatoria del iva
            $TotalItem=$DatosDevolucion['Total']+$IVAItem;
            $TotalSubtotal=$TotalSubtotal+$DatosDevolucion['Total'];//se realiza la sumatoria del subtotal
            $GranTotal=$GranTotal+$TotalItem;//se realiza la sumatoria del total
            $SubtotalCosto=round($DatosProducto['CostoUnitario']*$DatosDevolucion['Cantidad']);
            $TotalCostos=$TotalCostos+$SubtotalCosto;//se realiza la sumatoria de los costos
            
            //$ID=date("YmdHis").microtime(true);
            $tab="facturas_items";
            $NumRegistros=25;
            $Columnas[0]="ID";			$Valores[0]="";
            $Columnas[1]="idFactura";           $Valores[1]=$NumFactura;
            $Columnas[2]="TablaItems";          $Valores[2]=$DatosDevolucion["Tabla"];
            $Columnas[3]="Referencia";          $Valores[3]=$DatosDevolucion["Referencia"];
            $Columnas[4]="Nombre";              $Valores[4]=$DatosProducto["Nombre"];
            $Columnas[5]="Departamento";	$Valores[5]=$DatosProducto["Departamento"];
            $Columnas[6]="SubGrupo1";           $Valores[6]=$DatosProducto['Sub1'];
            $Columnas[7]="SubGrupo2";           $Valores[7]=$DatosProducto['Sub2'];
            $Columnas[8]="SubGrupo3";           $Valores[8]=$DatosProducto['Sub3'];
            $Columnas[9]="SubGrupo4";           $Valores[9]=$DatosProducto['Sub4'];
            $Columnas[10]="SubGrupo5";          $Valores[10]=$DatosProducto['Sub5'];
            $Columnas[11]="ValorUnitarioItem";	$Valores[11]=$DatosDevolucion['ValorUnitario'];
            $Columnas[12]="Cantidad";		$Valores[12]=$DatosDevolucion['Cantidad'];
            $Columnas[13]="Dias";		$Valores[13]=$DatosDevolucion['Dias'];
            $Columnas[14]="SubtotalItem";       $Valores[14]=$DatosDevolucion['Total'];
            $Columnas[15]="IVAItem";		$Valores[15]=$IVAItem;
            $Columnas[16]="TotalItem";		$Valores[16]=$TotalItem;
            $Columnas[17]="PorcentajeIVA";	$Valores[17]=($IVA*100)."%";
            $Columnas[18]="PrecioCostoUnitario";$Valores[18]=$DatosProducto['CostoUnitario'];
            $Columnas[19]="SubtotalCosto";	$Valores[19]=$SubtotalCosto;
            $Columnas[20]="TipoItem";		$Valores[20]=$DatosDevolucion["TipoItem"];
            $Columnas[21]="CuentaPUC";		$Valores[21]=$DatosProducto['CuentaPUC'];
            $Columnas[22]="GeneradoDesde";	$Valores[22]="rem_devoluciones";
            $Columnas[23]="NumeroIdentificador";$Valores[23]=$idDevolucion;
            $Columnas[24]="FechaFactura";       $Valores[24]=$FechaFactura;
            
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        }
        $ID=$Datos["ID"]; 
        $TotalSubtotal=round($TotalSubtotal);
        $TotalIVA=round($TotalIVA);
        $GranTotal=round($GranTotal);
        $TotalCostos=round($TotalCostos);
        $sql="UPDATE facturas SET Subtotal='$TotalSubtotal', IVA='$TotalIVA', Total='$GranTotal', "
                . "SaldoFact='$GranTotal', TotalCostos='$TotalCostos' WHERE idFacturas='$ID'";
        $this->Query($sql);
    }
             
    
/*
 * Funcion Agregar items de una cotizacion a una factura
 */
    
    public function InsertarItemsCotizacionAItemsFactura($Datos){
        
        $idCotizacion=$Datos["NumCotizacion"];
        $NumFactura=$Datos["ID"];
        $FechaFactura=$Datos["FechaFactura"];
        
        $sql="SELECT * FROM cot_itemscotizaciones WHERE NumCotizacion='$idCotizacion'";
        $Consulta=$this->Query($sql);
        $TotalSubtotal=0;
        $TotalIVA=0;
        $GranTotal=0;
        $TotalCostos=0;
        while($DatosCotizacion=  mysql_fetch_array($Consulta)){

            $DatosProducto=$this->DevuelveValores($DatosCotizacion["TablaOrigen"], "Referencia", $DatosCotizacion["Referencia"]);
            ////Empiezo a insertar en la tabla items facturas
            ///
            ///
            $SubtotalItem=$DatosCotizacion["Subtotal"];
            $TotalSubtotal=$TotalSubtotal+$SubtotalItem; //se realiza la sumatoria del subtotal
            
            $IVAItem=$DatosCotizacion["IVA"];
            $TotalIVA=$TotalIVA+$IVAItem; //se realiza la sumatoria del iva
            
            $TotalItem=$DatosCotizacion['Total'];
            $GranTotal=$GranTotal+$TotalItem;//se realiza la sumatoria del total
            
            $SubtotalCosto=$DatosCotizacion['SubtotalCosto'];
            $TotalCostos=$TotalCostos+$SubtotalCosto;//se realiza la sumatoria de los costos
            
            //$ID=date("YmdHis").microtime(false);
            $tab="facturas_items";
            $NumRegistros=25;
            $Columnas[0]="ID";			$Valores[0]="";
            $Columnas[1]="idFactura";           $Valores[1]=$NumFactura;
            $Columnas[2]="TablaItems";          $Valores[2]=$DatosCotizacion["TablaOrigen"];
            $Columnas[3]="Referencia";          $Valores[3]=$DatosCotizacion["Referencia"];
            $Columnas[4]="Nombre";              $Valores[4]=$DatosProducto["Nombre"];
            $Columnas[5]="Departamento";	$Valores[5]=$DatosProducto["Departamento"];
            $Columnas[6]="SubGrupo1";           $Valores[6]=$DatosProducto['Sub1'];
            $Columnas[7]="SubGrupo2";           $Valores[7]=$DatosProducto['Sub2'];
            $Columnas[8]="SubGrupo3";           $Valores[8]=$DatosProducto['Sub3'];
            $Columnas[9]="SubGrupo4";           $Valores[9]=$DatosProducto['Sub4'];
            $Columnas[10]="SubGrupo5";          $Valores[10]=$DatosProducto['Sub5'];
            $Columnas[11]="ValorUnitarioItem";	$Valores[11]=$DatosCotizacion['ValorUnitario'];
            $Columnas[12]="Cantidad";		$Valores[12]=$DatosCotizacion['Cantidad'];
            $Columnas[13]="Dias";		$Valores[13]=$DatosCotizacion['Multiplicador'];
            $Columnas[14]="SubtotalItem";       $Valores[14]=$SubtotalItem;
            $Columnas[15]="IVAItem";		$Valores[15]=$IVAItem;
            $Columnas[16]="TotalItem";		$Valores[16]=$TotalItem;
            $Columnas[17]="PorcentajeIVA";	$Valores[17]=($DatosProducto['IVA']*100)."%";
            $Columnas[18]="PrecioCostoUnitario";$Valores[18]=$DatosProducto['CostoUnitario'];
            $Columnas[19]="SubtotalCosto";	$Valores[19]=$SubtotalCosto;
            $Columnas[20]="TipoItem";		$Valores[20]=$DatosCotizacion["TipoItem"];
            $Columnas[21]="CuentaPUC";		$Valores[21]=$DatosProducto['CuentaPUC'];
            $Columnas[22]="GeneradoDesde";	$Valores[22]="cotizacionesv5";
            $Columnas[23]="NumeroIdentificador";$Valores[23]=$idCotizacion;
            $Columnas[24]="FechaFactura";       $Valores[24]=$FechaFactura;
            
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
            if($DatosCotizacion["TipoItem"]=="PR"){
                
                $DatosKardex["Cantidad"]=$DatosCotizacion['Cantidad'];
                $DatosKardex["idProductosVenta"]=$DatosProducto["idProductosVenta"];
                $DatosKardex["CostoUnitario"]=$DatosProducto['CostoUnitario'];
                $DatosKardex["Existencias"]=$DatosProducto['Existencias'];
                $DatosKardex["Detalle"]="Factura";
                $DatosKardex["idDocumento"]=$NumFactura;
                $DatosKardex["TotalCosto"]=$SubtotalCosto;
                $DatosKardex["Movimiento"]="SALIDA";
                
                $this->InserteKardex($DatosKardex);
            }
        }
        $ID=$Datos["ID"]; 
        $TotalSubtotal=round($TotalSubtotal);
        $TotalIVA=round($TotalIVA);
        $GranTotal=round($GranTotal);
        $TotalCostos=round($TotalCostos);
        $sql="UPDATE facturas SET Subtotal='$TotalSubtotal', IVA='$TotalIVA', Total='$GranTotal', "
                . "SaldoFact='$GranTotal', TotalCostos='$TotalCostos' WHERE idFacturas='$ID'";
        $this->Query($sql);
        
    }   
    
    
    public function InserteKardex($DatosKardex){
        $Fecha=date("Y-m-d");
        $Saldo=$DatosKardex["Existencias"]-$DatosKardex["Cantidad"];
        $TotalCostoSaldo=$Saldo*$DatosKardex["CostoUnitario"];
        
        /*
         * Inserto el kardex del producto primer movimiento 
         */
        $tab="kardexmercancias";
        $NumRegistros=8;
        $Columnas[0]="Fecha";                           $Valores[0]=$Fecha;
        $Columnas[1]="Movimiento";                      $Valores[1]=$DatosKardex["Movimiento"];
        $Columnas[2]="Detalle";                         $Valores[2]=$DatosKardex["Detalle"];
        $Columnas[3]="idDocumento";                     $Valores[3]=$DatosKardex["idDocumento"];
        $Columnas[4]="Cantidad";                        $Valores[4]=$DatosKardex["Cantidad"];
        $Columnas[5]="ValorUnitario";                   $Valores[5]=$DatosKardex["CostoUnitario"];
        $Columnas[6]="ValorTotal";                      $Valores[6]=$DatosKardex["TotalCosto"];
        $Columnas[7]="ProductosVenta_idProductosVenta"; $Valores[7]=$DatosKardex['idProductosVenta'];
        
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        
        /*
         * Inserto el kardex del producto segundo movimiento SALDOS 
         */
        
        $Columnas[1]="Movimiento";                      $Valores[1]="SALDOS";
        $Columnas[4]="Cantidad";                        $Valores[4]=$Saldo;
        $Columnas[6]="ValorTotal";                      $Valores[6]=$TotalCostoSaldo;
              
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        /*
         * Actualizo inventarios
         */
        $sql="UPDATE productosventa SET Existencias='$Saldo', CostoTotal='$TotalCostoSaldo'"
                . "WHERE idProductosVenta=$DatosKardex[idProductosVenta]";
        $this->Query($sql);
        
    }
    
    public function RegistreComprobanteContable($idComprobante){
        
        
        $DatosGenerales=$this->DevuelveValores("comprobantes_contabilidad","ID",$idComprobante);
        $Consulta=$this->ConsultarTabla("comprobantes_contabilidad_items", "WHERE idComprobante=$idComprobante");
        while($DatosComprobante=$this->FetchArray($Consulta)){
            $Fecha=$DatosComprobante["Fecha"];
            
            $tab="librodiario";
            $NumRegistros=26;
            $CuentaPUC=$DatosComprobante["CuentaPUC"];
            $NombreCuenta=$DatosComprobante["NombreCuenta"];
            $DatosCliente=$this->DevuelveValores("proveedores", "Num_Identificacion", $DatosComprobante["Tercero"]);
            $DatosCentro=$this->DevuelveValores("centrocosto", "ID", $DatosComprobante["CentroCostos"]);
            
            $Columnas[0]="Fecha";			$Valores[0]=$Fecha;
            $Columnas[1]="Tipo_Documento_Intero";	$Valores[1]="COMPROBANTE CONTABLE";
            $Columnas[2]="Num_Documento_Interno";	$Valores[2]=$idComprobante;
            $Columnas[3]="Tercero_Tipo_Documento";	$Valores[3]=$DatosCliente['Tipo_Documento'];
            $Columnas[4]="Tercero_Identificacion";	$Valores[4]=$DatosCliente['Num_Identificacion'];
            $Columnas[5]="Tercero_DV";                  $Valores[5]=$DatosCliente['DV'];
            $Columnas[6]="Tercero_Primer_Apellido";	$Valores[6]=$DatosCliente['Primer_Apellido'];
            $Columnas[7]="Tercero_Segundo_Apellido";    $Valores[7]=$DatosCliente['Segundo_Apellido'];
            $Columnas[8]="Tercero_Primer_Nombre";	$Valores[8]=$DatosCliente['Primer_Nombre'];
            $Columnas[9]="Tercero_Otros_Nombres";	$Valores[9]=$DatosCliente['Otros_Nombres'];
            $Columnas[10]="Tercero_Razon_Social";	$Valores[10]=$DatosCliente['RazonSocial'];
            $Columnas[11]="Tercero_Direccion";          $Valores[11]=$DatosCliente['Direccion'];
            $Columnas[12]="Tercero_Cod_Dpto";           $Valores[12]=$DatosCliente['Cod_Dpto'];
            $Columnas[13]="Tercero_Cod_Mcipio";         $Valores[13]=$DatosCliente['Cod_Mcipio'];
            $Columnas[14]="Tercero_Pais_Domicilio";     $Valores[14]=$DatosCliente['Pais_Domicilio'];

            $Columnas[15]="CuentaPUC";                  $Valores[15]=$CuentaPUC;
            $Columnas[16]="NombreCuenta";		$Valores[16]=$NombreCuenta;
            $Columnas[17]="Detalle";                    $Valores[17]=$DatosGenerales["Concepto"];
            $Columnas[18]="Debito";			$Valores[18]=$DatosComprobante["Debito"];
            $Columnas[19]="Credito";                    $Valores[19]=$DatosComprobante["Credito"];
            $Columnas[20]="Neto";			$Valores[20]=$Valores[18]-$Valores[19];
            $Columnas[21]="Mayor";			$Valores[21]="NO";
            $Columnas[22]="Esp";			$Valores[22]="NO";
            $Columnas[23]="Concepto";                   $Valores[23]=$DatosComprobante["Concepto"];
            $Columnas[24]="idCentroCosto";		$Valores[24]=$DatosComprobante["CentroCostos"];
            $Columnas[25]="idEmpresa";                  $Valores[25]=$DatosCentro["EmpresaPro"];

            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
            
            
        }
        $this->ActualizaRegistro("comprobantes_contabilidad", "Estado", "C", "ID", $idComprobante);
        $this->ActualizaRegistro("comprobantes_pre", "Estado", "C", "idComprobanteContabilidad", $idComprobante);
    }
    
    public function ReingreseItemsInventario($idFactura){
        $Consulta=$this->ConsultarTabla("facturas_items", "WHERE idFactura='$idFactura'");
        while($DatosItems=$this->FetchArray($Consulta)){
            if($DatosItems["TipoItem"]=="PR"){
                $Referencia=$DatosItems["Referencia"];
                $DatosProducto=$this->DevuelveValores($DatosItems["TablaItems"], "Referencia", $Referencia);
                $DatosKardex["Cantidad"]=$DatosItems['Cantidad']*(-1);
                $DatosKardex["idProductosVenta"]=$DatosProducto["idProductosVenta"];
                $DatosKardex["CostoUnitario"]=$DatosItems['PrecioCostoUnitario'];
                $DatosKardex["Existencias"]=$DatosProducto['Existencias'];
                $DatosKardex["Detalle"]="Anulacion de Factura";
                $DatosKardex["idDocumento"]=$idFactura;
                $DatosKardex["TotalCosto"]=$DatosKardex["CostoUnitario"]*$DatosKardex["Cantidad"];
                $DatosKardex["Movimiento"]="SALIDA";
                
                $this->InserteKardex($DatosKardex);
            }
        }
    }
    
    /*
     * Funcion para registrar un abono
     * 2016-06-10 JULIAN ALVARAN
     */
    
    public function RegistreAbonoLibro($idLibro,$TablaAbonos,$CuentaDestino,$PageReturn,$TotalAbono,$Datos){
        
        $NomIdCentroCostos="idCentroCosto"; //Nombre de las columnas, se coloca porque en algunas versiones es diferente
        $NomIdEmpresa="idEmpresa";
        $Fecha=$Datos["Fecha"];
        $TipoAbono=$Datos["TipoAbono"];
        $idUser=$Datos["idUser"];
        $hora=date("H:i");
        if($TipoAbono=="CuentasXCobrar"){
            $Factor=1;
            $Page="CuentasXCobrar.php";
        }
        if($TipoAbono=="CuentasXPagar"){
            $Factor="-1";
            $Page="CuentasXPagar.php";
        }
        $DatosLibro=$this->DevuelveValores("librodiario", "idLibroDiario", $idLibro);
        $AbonosActuales=$this->Sume("abonos_libro", "Cantidad", "WHERE idLibroDiario='$idLibro' AND TipoAbono='$TipoAbono'");
        $AbonosActuales=$AbonosActuales+$TotalAbono;
        $SaldoTotal=$DatosLibro["Neto"]*$Factor;
        if($AbonosActuales>$SaldoTotal){
            echo "<script>alert('Abono incorrecto, supera el saldo total')</script>";
            exit(" <a href='$Page'> Volver</a> ");
        }
        $DatosCuentasFrecuentes=$this->DevuelveValores("cuentasfrecuentes", "CuentaPUC", $CuentaDestino);
        $Debitos1=0;
        $Creditos1=0;
        $Neto1=0;
        $Debitos2=0;
        $Creditos2=0;
        $Neto2=0;
        if($TipoAbono=="CuentasXPagar"){
            $Concepto="ABONO A LA CUENTA POR PAGAR ESPECIFICADA EN EL LIBRO DIARIO CON ID=$idLibro";
            $Debitos1=$TotalAbono;
            $Neto1=$TotalAbono;
            $Neto2=$TotalAbono*(-1);
            
            $Creditos2=$TotalAbono;
        }
        
        if($TipoAbono=="CuentasXCobrar"){
            $Concepto="ABONO A LA CUENTA POR COBRAR ESPECIFICADA EN EL LIBRO DIARIO CON ID=$idLibro";
            $Debitos1=0;
            $Creditos1=$TotalAbono;
            $Neto1=$TotalAbono*(-1);
            $Neto2=$TotalAbono;
            
            $Debitos2=$TotalAbono;
        }
        /*
         * Abro un nuevo comprobante de abono
         */
        
        $tab="comprobantes_contabilidad";
        $NumRegistros=4; 

        $Columnas[0]="Fecha";                   $Valores[0]=$Fecha;
        $Columnas[1]="Concepto";                $Valores[1]=$Concepto;
        $Columnas[2]="Hora";                    $Valores[2]=$hora;
        $Columnas[3]="Usuarios_idUsuarios";     $Valores[3]=$idUser;

        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        $idComprobante=$this->ObtenerMAX($tab, "ID", 1, "");
                
        /*
         * Inserto los datos a la tabla de abonos correspondiente 
         */
        
        $tab=$TablaAbonos;
        $NumRegistros=5;
        $Columnas[0]="Fecha";                           $Valores[0]=$Fecha;
        $Columnas[1]="Cantidad";                        $Valores[1]=$TotalAbono;
        $Columnas[2]="idLibroDiario";                   $Valores[2]=$idLibro;
        $Columnas[3]="idComprobanteContable";           $Valores[3]=$idComprobante;
        $Columnas[4]="TipoAbono";                       $Valores[4]=$TipoAbono;
        
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        
        /*
         * Se registra en el libro diario
         * 
         */
                        
        $tab="librodiario";
        $NumRegistros=26;
                
        $Columnas[0]="Fecha";			$Valores[0]=$Fecha;
        $Columnas[1]="Tipo_Documento_Intero";	$Valores[1]="COMPROBANTE CONTABLE";
        $Columnas[2]="Num_Documento_Interno";	$Valores[2]=$idComprobante;
        $Columnas[3]="Tercero_Tipo_Documento";	$Valores[3]=$DatosLibro['Tercero_Tipo_Documento'];
        $Columnas[4]="Tercero_Identificacion";	$Valores[4]=$DatosLibro['Tercero_Identificacion'];
        $Columnas[5]="Tercero_DV";		$Valores[5]=$DatosLibro['Tercero_DV'];
        $Columnas[6]="Tercero_Primer_Apellido";	$Valores[6]=$DatosLibro['Tercero_Primer_Apellido'];
        $Columnas[7]="Tercero_Segundo_Apellido";$Valores[7]=$DatosLibro['Tercero_Segundo_Apellido'];
        $Columnas[8]="Tercero_Primer_Nombre";	$Valores[8]=$DatosLibro['Tercero_Primer_Nombre'];
        $Columnas[9]="Tercero_Otros_Nombres";	$Valores[9]=$DatosLibro['Tercero_Otros_Nombres'];
        $Columnas[10]="Tercero_Razon_Social";	$Valores[10]=$DatosLibro['Tercero_Razon_Social'];
        $Columnas[11]="Tercero_Direccion";	$Valores[11]=$DatosLibro['Tercero_Direccion'];
        $Columnas[12]="Tercero_Cod_Dpto";	$Valores[12]=$DatosLibro['Tercero_Cod_Dpto'];
        $Columnas[13]="Tercero_Cod_Mcipio";	$Valores[13]=$DatosLibro['Tercero_Cod_Mcipio'];
        $Columnas[14]="Tercero_Pais_Domicilio"; $Valores[14]=$DatosLibro['Tercero_Pais_Domicilio'];
        $Columnas[15]="CuentaPUC";		$Valores[15]=$DatosLibro["CuentaPUC"];
        $Columnas[16]="NombreCuenta";		$Valores[16]=$DatosLibro["NombreCuenta"];
        $Columnas[17]="Detalle";		$Valores[17]=$TipoAbono;
        $Columnas[18]="Debito";			$Valores[18]=$Debitos1;
        $Columnas[19]="Credito";		$Valores[19]=$Creditos1;
        $Columnas[20]="Neto";			$Valores[20]=$Neto1;
        $Columnas[21]="Mayor";			$Valores[21]="NO";
        $Columnas[22]="Esp";			$Valores[22]="NO";
        $Columnas[23]="Concepto";		$Valores[23]=$Concepto;
        $Columnas[24]=$NomIdCentroCostos;       $Valores[24]=$DatosLibro[$NomIdCentroCostos];
        $Columnas[25]=$NomIdEmpresa;		$Valores[25]=$DatosLibro[$NomIdEmpresa];

        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);


        ///////////////////////Registramos contra partida del anticipo

        $CuentaPUC=$CuentaDestino; 
               
        $Valores[15]=$CuentaPUC;
        $Valores[16]=$DatosCuentasFrecuentes["Nombre"];
        $Valores[18]=$Debitos2;
        $Valores[19]=$Creditos2; 			//Credito se escribe el total de la venta menos los impuestos
        $Valores[20]=$Neto2;  											//Credito se escribe el total de la venta menos los impuestos

        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        
        
        if($AbonosActuales==$SaldoTotal){
           $this->ActualizaRegistro("librodiario", "Estado", "CO", "idLibroDiario", $idLibro);
        }
        
        return ($idComprobante);
    }
    
    /*
     * revisa si hay resultados tras una consulta
     * 
     */
    
    public function NumRows($consulta){
  		
	$NR=mysql_num_rows($consulta);
	return ($NR);	
		
	}
        
        /*
     * Registra una Venta Rapida
     * 
     */
    
    public function RegistreVentaRapida($idPreventa, $idCliente, $TipoPago, $Paga, $Devuelta, $CuentaDestino, $DatosVentaRapida){
  	
        $sql="SELECT * FROM preventa WHERE VestasActivas_idVestasActivas='$idPreventa'";
        $Consulta=$this->Query($sql);
        if($this->NumRows($Consulta)<1){
            header("location:$myPage?CmbPreVentaAct=$idPreventa");
            exit();    
        }
        
        $CentroCostos=1;
        $ResolucionDian=1;
        
        $CuentaDestino=$_REQUEST["CmbCuentaDestino"];
        $OrdenCompra="";
        $OrdenSalida="";
        $ObservacionesFactura="";
        $FechaFactura=date("Y-m-d");
        
        $Consulta=$this->DevuelveValores("centrocosto", "ID", $CentroCostos);
        $EmpresaPro=$Consulta["EmpresaPro"];
        if($TipoPago=="Contado"){
            $SumaDias=0;
        }else{
            $SumaDias=$TipoPago;
        }
        ////////////////////////////////Preguntamos por disponibilidad
        ///////////
        ///////////
        $ID="";
        $DatosResolucion=$this->DevuelveValores("empresapro_resoluciones_facturacion", "ID", $ResolucionDian);
        if($DatosResolucion["Completada"]=="NO"){           ///Pregunto si la resolucion ya fue completada
            $Disponibilidad=$DatosResolucion["Estado"];
                                              //si entra a verificar es porque estaba ocupada y cambiará a 1
            while($Disponibilidad=="OC"){                   //miro que esté disponible para facturar, esto para no crear facturas dobles
                print("Esperando disponibilidad<br>");
                usleep(300);
                $DatosResolucion=$this->DevuelveValores("empresapro_resoluciones_facturacion", "ID", $ResolucionDian);
                $Disponibilidad=$DatosResolucion["Estado"];
                
            }
            
            $DatosResolucion=$this->DevuelveValores("empresapro_resoluciones_facturacion", "ID", $ResolucionDian);
            if($DatosResolucion["Completada"]<>"SI"){
                $this->ActualizaRegistro("empresapro_resoluciones_facturacion", "Estado", "OC", "ID", $ResolucionDian); //Ocupo la resolucion
                
                $sql="SELECT MAX(NumeroFactura) as FacturaActual FROM facturas WHERE Prefijo='$DatosResolucion[Prefijo]' "
                        . "AND TipoFactura='$DatosResolucion[Tipo]' AND idResolucion='$ResolucionDian'";
                $Consulta=$this->Query($sql);
                $Consulta=$this->FetchArray($Consulta);
                $FacturaActual=$Consulta["FacturaActual"];
                $idFactura=$FacturaActual+1;
                
                //Verificamos si ya se completó el numero de la resolucion y si es así se cambia su estado
                if($DatosResolucion["Hasta"]==$idFactura){ 
                    $this->ActualizaRegistro("empresapro_resoluciones_facturacion", "Completada", "SI", "ID", $ResolucionDian);
                }
                //Verificamos si es la primer factura que se creará con esta resolucion
                //Si es así se inicia desde el numero autorizado
                if($idFactura==1){
                   $idFactura=$DatosResolucion["Desde"];
                }
                //Convertimos los dias en credito
                $FormaPagoFactura=$TipoPago;
                if($TipoPago<>"Contado"){
                    $FormaPagoFactura="Credito a $TipoPago dias";
                }
                ////////////////Inserto datos de la factura
                /////
                ////
                $ID=date("YmdHis").microtime(false);
                $tab="facturas";
                $NumRegistros=27; 
                
                $Columnas[0]="TipoFactura";		    $Valores[0]=$DatosResolucion["Tipo"];
                $Columnas[1]="Prefijo";                     $Valores[1]=$DatosResolucion["Prefijo"];
                $Columnas[2]="NumeroFactura";               $Valores[2]=$idFactura;
                $Columnas[3]="Fecha";                       $Valores[3]=$FechaFactura;
                $Columnas[4]="OCompra";                     $Valores[4]=$OrdenCompra;
                $Columnas[5]="OSalida";                     $Valores[5]=$OrdenSalida;
                $Columnas[6]="FormaPago";                   $Valores[6]=$FormaPagoFactura;
                $Columnas[7]="Subtotal";                    $Valores[7]="";
                $Columnas[8]="IVA";                         $Valores[8]="";
                $Columnas[9]="Descuentos";                  $Valores[9]="";
                $Columnas[10]="Total";                      $Valores[10]="";
                $Columnas[11]="SaldoFact";                  $Valores[11]="";
                $Columnas[12]="Cotizaciones_idCotizaciones";$Valores[12]="";
                $Columnas[13]="EmpresaPro_idEmpresaPro";    $Valores[13]=$EmpresaPro;
                $Columnas[14]="Usuarios_idUsuarios";        $Valores[14]=$this->idUser;
                $Columnas[15]="Clientes_idClientes";        $Valores[15]=$idCliente;
                $Columnas[16]="TotalCostos";                $Valores[16]="";
                $Columnas[17]="CerradoDiario";              $Valores[17]="";
                $Columnas[18]="FechaCierreDiario";          $Valores[18]="";
                $Columnas[19]="HoraCierreDiario";           $Valores[19]="";
                $Columnas[20]="ObservacionesFact";          $Valores[20]=$ObservacionesFactura;
                $Columnas[21]="CentroCosto";                $Valores[21]=$CentroCostos;
                $Columnas[22]="idResolucion";               $Valores[22]=$ResolucionDian;
                $Columnas[23]="idFacturas";                 $Valores[23]=$ID;
                $Columnas[24]="Hora";                       $Valores[24]=date("H:i:s");
                $Columnas[25]="Paga";                       $Valores[25]=$Paga;
                $Columnas[26]="Devuelve";                   $Valores[26]=$Devuelta;
                $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
                
                //libero la resolucion
                $this->ActualizaRegistro("empresapro_resoluciones_facturacion", "Estado", "", "ID", $ResolucionDian);
                
                //////////////////////Agrego Items a la Factura desde la devolucion
                /////
                /////
                
                
                $Datos["idPreventa"]=$idPreventa;
                $Datos["NumFactura"]=$idFactura;
                $Datos["FechaFactura"]=$FechaFactura;
                $Datos["ID"]=$ID;
                $Datos["CuentaDestino"]=$CuentaDestino;
                $Datos["EmpresaPro"]=$EmpresaPro;
                $Datos["CentroCostos"]=$CentroCostos;
                $this->InsertarItemsPreventaAItemsFactura($Datos);///Relaciono los items de la factura
                
                $this->InsertarFacturaLibroDiario($Datos);///Inserto Items en el libro diario
               
                if($TipoPago<>"Contado"){                   //Si es a Credito
                    $Datos["Fecha"]=$FechaFactura; 
                    $Datos["Dias"]=$SumaDias;
                    $FechaVencimiento=$this->SumeDiasFecha($Datos);
                    $Datos["idFactura"]=$Datos["ID"]; 
                    $Datos["FechaFactura"]=$FechaFactura; 
                    $Datos["FechaVencimiento"]=$FechaVencimiento;
                    $Datos["idCliente"]=$idCliente;
                    $this->InsertarFacturaEnCartera($Datos);///Inserto La factura en la cartera
                }
                 
            }    
          
        }else{
            exit("La Resolucion de facturacion fue completada");
        }
	return ($ID);	
		
	}

        /*
 * Funcion Agregar items de una preventa a una factura
 */
    
    public function InsertarItemsPreventaAItemsFactura($Datos){
        
        $idPreventa=$Datos["idPreventa"];
        $NumFactura=$Datos["ID"];
        $FechaFactura=$Datos["FechaFactura"];
        
        $sql="SELECT * FROM preventa WHERE VestasActivas_idVestasActivas='$idPreventa'";
        $Consulta=$this->Query($sql);
        $TotalSubtotal=0;
        $TotalIVA=0;
        $GranTotal=0;
        $TotalCostos=0;
        
        while($DatosCotizacion=  mysql_fetch_array($Consulta)){

            $DatosProducto=$this->DevuelveValores($DatosCotizacion["TablaItem"], "idProductosVenta", $DatosCotizacion["ProductosVenta_idProductosVenta"]);
            ////Empiezo a insertar en la tabla items facturas
            ///
            ///
            $SubtotalItem=round($DatosCotizacion["Subtotal"]);
            $TotalSubtotal=$TotalSubtotal+$SubtotalItem; //se realiza la sumatoria del subtotal
            
            $IVAItem=round($DatosCotizacion["Impuestos"]);
            $TotalIVA=$TotalIVA+$IVAItem; //se realiza la sumatoria del iva
            
            $TotalItem=round($DatosCotizacion['TotalVenta']);
            $GranTotal=$GranTotal+$TotalItem;//se realiza la sumatoria del total
            
            $SubtotalCosto=$DatosCotizacion['Cantidad']*$DatosProducto["CostoUnitario"];
            $TotalCostos=$TotalCostos+$SubtotalCosto;//se realiza la sumatoria de los costos
            
            //$ID=date("YmdHis").microtime(false);
            $tab="facturas_items";
            $NumRegistros=25;
            $Columnas[0]="ID";			$Valores[0]="";
            $Columnas[1]="idFactura";           $Valores[1]=$NumFactura;
            $Columnas[2]="TablaItems";          $Valores[2]=$DatosCotizacion["TablaItem"];
            $Columnas[3]="Referencia";          $Valores[3]=$DatosProducto["Referencia"];
            $Columnas[4]="Nombre";              $Valores[4]=$DatosProducto["Nombre"];
            $Columnas[5]="Departamento";	$Valores[5]=$DatosProducto["Departamento"];
            $Columnas[6]="SubGrupo1";           $Valores[6]=$DatosProducto['Sub1'];
            $Columnas[7]="SubGrupo2";           $Valores[7]=$DatosProducto['Sub2'];
            $Columnas[8]="SubGrupo3";           $Valores[8]=$DatosProducto['Sub3'];
            $Columnas[9]="SubGrupo4";           $Valores[9]=$DatosProducto['Sub4'];
            $Columnas[10]="SubGrupo5";          $Valores[10]=$DatosProducto['Sub5'];
            $Columnas[11]="ValorUnitarioItem";	$Valores[11]=$DatosCotizacion['ValorAcordado'];
            $Columnas[12]="Cantidad";		$Valores[12]=$DatosCotizacion['Cantidad'];
            $Columnas[13]="Dias";		$Valores[13]=1;
            $Columnas[14]="SubtotalItem";       $Valores[14]=$SubtotalItem;
            $Columnas[15]="IVAItem";		$Valores[15]=$IVAItem;
            $Columnas[16]="TotalItem";		$Valores[16]=$TotalItem;
            $Columnas[17]="PorcentajeIVA";	$Valores[17]=($DatosProducto['IVA']*100)."%";
            $Columnas[18]="PrecioCostoUnitario";$Valores[18]=$DatosProducto['CostoUnitario'];
            $Columnas[19]="SubtotalCosto";	$Valores[19]=$SubtotalCosto;
            $Columnas[20]="TipoItem";		$Valores[20]=$DatosCotizacion["TipoItem"];
            $Columnas[21]="CuentaPUC";		$Valores[21]=$DatosProducto['CuentaPUC'];
            $Columnas[22]="GeneradoDesde";	$Valores[22]="cotizacionesv5";
            $Columnas[23]="NumeroIdentificador";$Valores[23]="";
            $Columnas[24]="FechaFactura";       $Valores[24]=$FechaFactura;
            
            $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
            if($DatosCotizacion["TipoItem"]=="PR"){
                
                $DatosKardex["Cantidad"]=$DatosCotizacion['Cantidad'];
                $DatosKardex["idProductosVenta"]=$DatosProducto["idProductosVenta"];
                $DatosKardex["CostoUnitario"]=$DatosProducto['CostoUnitario'];
                $DatosKardex["Existencias"]=$DatosProducto['Existencias'];
                $DatosKardex["Detalle"]="Factura";
                $DatosKardex["idDocumento"]=$NumFactura;
                $DatosKardex["TotalCosto"]=$SubtotalCosto;
                $DatosKardex["Movimiento"]="SALIDA";
                
                $this->InserteKardex($DatosKardex);
            }
        }
        $ID=$Datos["ID"]; 
        $TotalSubtotal=round($TotalSubtotal);
        $TotalIVA=round($TotalIVA);
        $GranTotal=round($GranTotal);
        $TotalCostos=round($TotalCostos);
        $sql="UPDATE facturas SET Subtotal='$TotalSubtotal', IVA='$TotalIVA', Total='$GranTotal', "
                . "SaldoFact='$GranTotal', TotalCostos='$TotalCostos' WHERE idFacturas='$ID'";
        $this->Query($sql);
        
    } 
    
    public function ImprimeFacturaPOS($idFactura,$COMPrinter,$Copias){

        if(($handle = @fopen("$COMPrinter", "w")) === FALSE){
            die('ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA');
        }
       $DatosFactura=$this->DevuelveValores("facturas", "idFacturas", $idFactura);
       $DatosEmpresa=$this->DevuelveValores("empresapro", "idEmpresaPro", $DatosFactura["EmpresaPro_idEmpresaPro"]);
       $DatosResolucion=$this->DevuelveValores("empresapro_resoluciones_facturacion", "ID", $DatosFactura["idResolucion"]);
       $DatosUsuario=$this->DevuelveValores("usuarios", "idUsuarios", $DatosFactura["Usuarios_idUsuarios"]);
       $DatosCliente=$this->DevuelveValores("clientes", "idClientes", $DatosFactura["Clientes_idClientes"]);
        $RazonSocial=$DatosEmpresa["RazonSocial"];
        $NIT=$DatosEmpresa["NIT"];
        $Direccion=$DatosEmpresa["Direccion"];
        $Ciudad=$DatosEmpresa["Ciudad"];
        
        $ResolucionDian1="RES DIAN: $DatosResolucion[NumResolucion] del $DatosResolucion[Fecha]";
        $ResolucionDian2="FACTURA AUT. $DatosResolucion[Prefijo] - $DatosResolucion[Desde] HASTA $DatosResolucion[Prefijo] - $DatosResolucion[Hasta]";
        $ResolucionDian3="Autoriza impresion en:  $DatosResolucion[Factura]";
        $Telefono=$DatosEmpresa["Telefono"];

        $impuesto=$DatosFactura["IVA"];
        $Descuento=$DatosFactura["Descuentos"];
        $TotalVenta=$DatosFactura["Total"];
        $Subtotal=$DatosFactura["Subtotal"];
        $TotalFinal=$DatosFactura["Total"];

        $Fecha=$DatosFactura["Fecha"];
        $Hora=$DatosFactura["Hora"];
        $NumFact=$DatosFactura["Prefijo"]." - ".$DatosFactura["NumeroFactura"];
        for($i=1; $i<=$Copias;$i++){
        fwrite($handle,chr(27). chr(64));//REINICIO
        fwrite($handle, chr(27). chr(112). chr(48));//ABRIR EL CAJON
        fwrite($handle, chr(27). chr(100). chr(0));// SALTO DE CARRO VACIO
        fwrite($handle, chr(27). chr(33). chr(8));// NEGRITA
        fwrite($handle, chr(27). chr(97). chr(1));// CENTRADO
        fwrite($handle,"*************************************");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$RazonSocial); // ESCRIBO RAZON SOCIAL
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$NIT);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$ResolucionDian1);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$ResolucionDian2);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$ResolucionDian3);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Direccion);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Ciudad);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,$Telefono);
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA

        fwrite($handle,"Cajero:.$DatosUsuario[Nombre] $DatosUsuario[Apellido]");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"*************************************");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"Cliente: $DatosCliente[RazonSocial]");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"NIT: $DatosCliente[Num_Identificacion]");
        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle,"*************************************");
        /////////////////////////////FECHA Y NUM FACTURA

        fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
        fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA
        fwrite($handle,"FECHA: $Fecha");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"FACTURA DE VENTA No $NumFact");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
        fwrite($handle,"_____________________________________");
        fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

        /////////////////////////////ITEMS VENDIDOS

        fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA

        $sql = "SELECT * FROM facturas_items WHERE idFactura='$idFactura'";
	
        $consulta=$this->Query($sql);
								
	while($DatosVenta=$this->FetchArray($consulta)){
		
            //$Descuentos=$DatosVenta["Descuentos"];
            //$Impuestos=$DatosVenta["Impuestos"];
            $SubTotalITem=$DatosVenta["SubtotalItem"];
            //$SubTotalITem=$TotalVenta-$Impuestos;


            fwrite($handle,str_pad($DatosVenta["Cantidad"],4," ",STR_PAD_RIGHT));

            fwrite($handle,str_pad(substr($DatosVenta["Nombre"],0,20),20," ",STR_PAD_BOTH)."   ");

            fwrite($handle,str_pad("$".number_format($SubTotalITem),10," ",STR_PAD_LEFT));

            fwrite($handle, chr(27). chr(100). chr(1));// SALTO DE LINEA
}




    /////////////////////////////TOTALES

    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA

    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"SUBTOTAL         ".str_pad("$".number_format($Subtotal),20," ",STR_PAD_LEFT));

    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"IVA              ".str_pad("$".number_format($impuesto),20," ",STR_PAD_LEFT));

    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"TOTAL A PAGAR    ".str_pad("$".number_format($TotalVenta),20," ",STR_PAD_LEFT));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

    /////////////////////////////Forma de PAGO

    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(97). chr(0));// IZQUIERDA

    fwrite($handle,"Formas de Pago");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"       $DatosFactura[FormaPago] ----> $".str_pad(number_format($DatosFactura["Paga"]),10," ",STR_PAD_LEFT));

    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"       Cambio  ----> $".str_pad(number_format($DatosFactura["Devuelve"]),10," ",STR_PAD_LEFT));

    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

    fwrite($handle,"_____________________________________");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea

    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(97). chr(1));// CENTRO
    fwrite($handle,"***GRACIAS POR SU COMPRA***");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    //fwrite($handle, chr(27). chr(32). chr(0));//ESTACIO ENTRE LETRAS
    //fwrite($handle, chr(27). chr(100). chr(0));
    //fwrite($handle, chr(29). chr(107). chr(4)); //CODIGO BARRAS
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle,"***Factura impresa por SoftConTech***");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle,"Software disenado por Techno Soluciones SAS, 3177740609, www.technosoluciones.com.co");
    //fwrite($handle,"=================================");
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));
    fwrite($handle, chr(27). chr(100). chr(1));//salto de linea
    fwrite($handle, chr(27). chr(100). chr(1));

    fwrite($handle, chr(29). chr(86). chr(49));//CORTA PAPEL
    }
    fclose($handle); // cierra el fichero PRN
    $salida = shell_exec('lpr $COMPrinter');
    
    }
    
     public function ImprimirCodigoBarras($Tabla,$idProducto,$Cantidad,$Puerto,$DatosCB){
        `mode $Puerto: BAUD=9600 PARITY=N data=8 stop=1 xon=off`;  //inicializamos el puerto
        if(($handle = @fopen("$Puerto", "w")) === FALSE){
            die("<script>alert( 'ERROR:\nNo se puedo Imprimir, Verifique la conexion de la IMPRESORA')</script>");
        }
        $sql="SELECT CodigoBarras FROM prod_codbarras WHERE ProductosVenta_idProductosVenta='$idProducto' LIMIT 1";
        $Consulta =  $this->Query($sql);
        $DatosCodigo=  $this->FetchArray($Consulta);  
        $Codigo=$DatosCodigo["CodigoBarras"];
        $Cantidad=$Cantidad/3;
        $Numpages=ceil($Cantidad);
        $idEmpresaPro=$DatosCB["EmpresaPro"];
        $DatosEmpresa=$this->DevuelveValores("empresapro", "idEmpresaPro", $idEmpresaPro);
        $fecha=date("y-m-d");

        $RazonSocial=substr($DatosEmpresa["RazonSocial"],0,17);
        $DatosProducto=$this->DevuelveValores($Tabla, "idProductosVenta", $idProducto);
       
        $Descripcion=substr($DatosProducto["Nombre"],0,16);
        $PrecioVenta= number_format($DatosProducto["PrecioVenta"]);
        $Referencia= $DatosProducto["Referencia"];
        $ID= $DatosProducto["idProductosVenta"];
        $Costo2= substr($DatosProducto["CostoUnitario"], 1, -1);
        $Costo1= substr($DatosProducto["CostoUnitario"], 0, 1);
        $Costo=$Costo1."/".$Costo2;
        $enter="\r\n";
        $DatosConfigCB = $this->DevuelveValores("config_codigo_barras", "ID", 1);
        $L1=$DatosConfigCB["DistaciaEtiqueta1"];
        $L2=$DatosConfigCB["DistaciaEtiqueta2"];
        $L3=$DatosConfigCB["DistaciaEtiqueta3"];
        $AL1=$DatosConfigCB["AlturaLinea1"];
        $AL2=$DatosConfigCB["AlturaLinea2"];
        $AL3=$DatosConfigCB["AlturaLinea3"];
        $AL4=$DatosConfigCB["AlturaLinea4"];
        $AL5=$DatosConfigCB["AlturaLinea5"];
        $AlturaCB=$DatosConfigCB["AlturaCodigoBarras"];
        if(strlen($PrecioVenta)>7){
            $TamPrecio=2;
        }else{
            $TamPrecio=4;
        }
        

        fwrite($handle,"SIZE 4,1.1".$enter);
        fwrite($handle,"GAP 4 mm,0".$enter);
        fwrite($handle,"DIRECTION 1".$enter);
        fwrite($handle,"CLS".$enter);
        fwrite($handle,'TEXT '.$L1.','.$AL1.',"2",0,1,1,"'.$RazonSocial.'"'.$enter);
        fwrite($handle,'TEXT '.$L1.','.$AL2.',"1",0,1,1,"'.$Referencia.' '.$fecha.' '.$Costo.'"'.$enter);
        fwrite($handle,'TEXT '.$L1.','.$AL3.',"1",0,1,1,"'.$ID.' '.$Descripcion.'"'.$enter);
        fwrite($handle,'BARCODE '.$L1.','.$AL4.',"128",'.$AlturaCB.',1,0,2,2,"'.$Codigo.'"'.$enter);
        fwrite($handle,'TEXT '.$L1.','.$AL5.',"'.$TamPrecio.'",0,1,1,"$ '.$PrecioVenta.'"'.$enter);

        fwrite($handle,'TEXT '.$L2.','.$AL1.',"2",0,1,1,"'.$RazonSocial.'"'.$enter);
        fwrite($handle,'TEXT '.$L2.','.$AL2.',"1",0,1,1,"'.$Referencia.' '.$fecha.' '.$Costo.'"'.$enter);
        fwrite($handle,'TEXT '.$L2.','.$AL3.',"1",0,1,1,"'.$ID.' '.$Descripcion.'"'.$enter);
        fwrite($handle,'BARCODE '.$L2.','.$AL4.',"128",'.$AlturaCB.',1,0,2,2,"'.$Codigo.'"'.$enter);
        fwrite($handle,'TEXT '.$L2.','.$AL5.',"'.$TamPrecio.'",0,1,1,"$ '.$PrecioVenta.'"'.$enter);

        fwrite($handle,'TEXT '.$L3.','.$AL1.',"2",0,1,1,"'.$RazonSocial.'"'.$enter);
        fwrite($handle,'TEXT '.$L3.','.$AL2.',"1",0,1,1,"'.$Referencia.' '.$fecha.' '.$Costo.'"'.$enter);
        fwrite($handle,'TEXT '.$L3.','.$AL3.',"1",0,1,1,"'.$ID.' '.$Descripcion.'"'.$enter);
        fwrite($handle,'BARCODE '.$L3.','.$AL4.',"128",'.$AlturaCB.',1,0,2,2,"'.$Codigo.'"'.$enter);
        fwrite($handle,'TEXT '.$L3.','.$AL5.',"'.$TamPrecio.'",0,1,1,"$ '.$PrecioVenta.'"'.$enter);
        fwrite($handle,"PRINT $Numpages".$enter);

        $salida = shell_exec('lpr $Puerto');
        


     }
//////////////////////////////Fin	
}
	
?>