<?php 

////////////////////////////////////(///////////////////////////////
//////////////////////FUNCIONES CALCULAR DIGITO DE VERIFICACION/////////////////////////////////////
///////////////////////////////////////////////////////////////////

    
    function calcularDV($nit) {
        if (! is_numeric($nit)) {
            return false;
        }
     
        $arr = array(1 => 3, 4 => 17, 7 => 29, 10 => 43, 13 => 59, 2 => 7, 5 => 19, 
        8 => 37, 11 => 47, 14 => 67, 3 => 13, 6 => 23, 9 => 41, 12 => 53, 15 => 71);
        $x = 0;
        $y = 0;
        $z = strlen($nit);
        $dv = '';
        
        for ($i=0; $i<$z; $i++) {
            $y = substr($nit, $i, 1);
            $x += ($y*$arr[$z-$i]);
        }
        
        $y = $x%11;
        
        if ($y > 1) {
            $dv = 11-$y;
            return $dv;
        } else {
            $dv = $y;
            return $dv;
        }
        
    }
    
    
   
	

	//////Creo una Preventa
	if(!empty($_REQUEST['BtnAgregarPreventa'])){
		
		$obVenta=new ProcesoVenta($idUser);
		$obVenta->CrearPreventa($idUser);// Crea otra preventa
		header("location:$myPage");
	}
	
	if(!empty($_REQUEST['TxtCodigoBarras'])){
		
		$CodBar=$_POST['TxtCodigoBarras'];
		$obVenta=new ProcesoVenta($idUser);
                $TablaItem="productosventa";
		$DatosCodigo=$obVenta->DevuelveValores('prod_codbarras',"CodigoBarras",$CodBar);
		//$DatosPreventa=$obVenta->DevuelveValores('vestasactivas',"idVestasActivas",$idPreventa);
		
		if($DatosCodigo['ProductosVenta_idProductosVenta']>0){
			$fecha=date("Y-m-d");
			$Cantidad=1;
			$obVenta->AgregaPreventa($fecha,$Cantidad,$idPreventa,$DatosCodigo['ProductosVenta_idProductosVenta'],$TablaItem);
		}else{
			
			print('<script language="JavaScript">alert("Este producto no esta en la base de datos por favor no lo entregue")</script>');
			
		}
		header("location:VentasRapidas.php?CmbPreVentaAct=$idPreventa");	
	}
	
	if(!empty($_REQUEST['del'])){
		$id=$_REQUEST['del'];
		$Tabla=$_REQUEST['TxtTabla'];
		$IdTabla=$_REQUEST['TxtIdTabla'];
		$IdPre=$_REQUEST['TxtIdPre'];
		mysql_query("DELETE FROM $Tabla WHERE $IdTabla='$id'") or die(mysql_error());
		header("location:$myPage?CmbPreVentaAct=$IdPre");
	}
		
	if(!empty($_REQUEST['CmbIDProducto'])){
		
		$DatosBuscar=  explode(";", $_REQUEST['CmbIDProducto']);
		$idItem=$DatosBuscar[0];
                $TablaItem=$DatosBuscar[1];
		$fecha=date("Y-m-d");
		$Cantidad=1;
		
		$obVenta=new ProcesoVenta($idUser);
		
		$Cantidad=1;
		$obVenta->AgregaPreventa($fecha,$Cantidad,$idPreventa,$idItem,$TablaItem);
		
		header("location:VentasRapidas.php?CmbPreVentaAct=$idPreventa");
			
	}
	
	////Se recibe edicion
	
	if(!empty($_REQUEST['TxtEditar'])){
		$obVenta=new ProcesoVenta($idUser);
		$idItem=$_REQUEST['TxtPrecotizacion'];
		//$idClientes=$_REQUEST['TxtIdCliente'];
                $idPreventa=$_REQUEST['CmbPreVentaAct'];
		
		$Cantidad=$_REQUEST['TxtEditar'];
                echo " $Cantidad $idItem";
		//$ValorAcordado=$_REQUEST['TxtValorUnitario'];
                $DatosPreventa=$obVenta->DevuelveValores("preventa", "idPrecotizacion", $idItem);
		$ValorAcordado=$DatosPreventa["ValorAcordado"];
		$idProducto=$DatosPreventa["ProductosVenta_idProductosVenta"];
		$Tabla=$DatosPreventa["TablaItem"];
		$Subtotal=$ValorAcordado*$Cantidad;
		$DatosProductos=$obVenta->DevuelveValores($Tabla,"idProductosVenta",$idProducto);
		$IVA=$Subtotal*$DatosProductos["IVA"];
		$SubtotalCosto=$DatosProductos["CostoUnitario"]*$Cantidad;
		$Total=$Subtotal+$IVA;
		$filtro="idPrecotizacion";
		
		$obVenta->ActualizaRegistro("preventa","Subtotal", $Subtotal, $filtro, $idItem);
		$obVenta->ActualizaRegistro("preventa","Impuestos", $IVA, $filtro, $idItem);
		$obVenta->ActualizaRegistro("preventa","TotalVenta", $Total, $filtro, $idItem);
		$obVenta->ActualizaRegistro("preventa","Cantidad", $Cantidad, $filtro, $idItem);
		
		
		header("location:$myPage?CmbPreVentaAct=$idPreventa");
			
	}
	
	////Se guarda la Cotizacion
	
	if(!empty($_REQUEST['BtnGuardar'])){
            $obVenta=new ProcesoVenta($idUser);
            $fecha=date("Y-m-d");
            $idCliente=$_REQUEST["TxtCliente"];
            $idPreventa=$_REQUEST["CmbPreVentaAct"];
            $Paga=$_REQUEST["TxtPaga"];
            $Devuelta=$_REQUEST["TxtDevuelta"];
            $CuentaDestino="110510";
            $TipoPago="Contado";
            $Observaciones="";
            $DatosVentaRapida["Fut"]="";
            $obVenta->RegistreVentaRapida($idPreventa, $idCliente, $TipoPago, $Paga, $Devuelta, $CuentaDestino, $DatosVentaRapida);

            $obVenta->BorraReg("preventa","VestasActivas_idVestasActivas",$idPreventa);
            $obVenta->ActualizaRegistro("vestasactivas","SaldoFavor", 0, "idVestasActivas", $idPreventa);
            header("location:$myPage?CmbPreVentaAct=$idPreventa");
		
		
		
			
	}
	
	////Se guarda un separado
	
	if(!empty($_REQUEST['TxtAbono']) or !empty($_REQUEST['BtnCrearSeparado'])){
		$fecha=date("Y-m-d");
		$Hora=date("H:i:s");
		
		$idPreventa=$_REQUEST['CmbPreVentaAct'];
		$Paga=0;
		$Devuelta=0;
		$Abono=$_REQUEST['TxtAbono'];
		$TipoVenta="Credito";
		
		$obVenta=new ProcesoVenta($idUser);
		list($NumCotizacion, $NumVenta, $NumFactura)=$obVenta->ObtengaDatosEspacio(); //Verifico si hay espacios en venta activa para empezar a vender
		
		if(!$NumCotizacion>0){
			list($NumCotizacion, $NumVenta, $NumFactura)=$obVenta->ObtengaEspacioVenta();// si no hay espacio lo crea
		}
		$DatosPreventa=$obVenta->DevuelveValores('vestasactivas',"idVestasActivas",$idPreventa);
		
		$obVenta->RegVenta($fecha,$Hora,$idPreventa,$NumCotizacion,$NumVenta,$NumFactura,$TipoVenta,$DatosPreventa["Clientes_idClientes"],$idUser);
		list($Subtotal,$Impuestos,$Total,$TotalCostos,$GranTotal)=$obVenta->ObtengaTotalesVenta($NumVenta);
		

		///////////////////////////Ingresar a Facturas 
			
		$Saldo=$Total;
		$EmpresaPro=1;
		$idCliente=$DatosPreventa["Clientes_idClientes"];
		$tab="facturas";
		$NumRegistros=14;  
							
		
		$Columnas[0]="Fecha";						$Valores[0]=$fecha;
		$Columnas[1]="FormaPago";					$Valores[1]=$TipoVenta;
		$Columnas[2]="Subtotal";					$Valores[2]=$Subtotal;
		$Columnas[3]="IVA";							$Valores[3]=$Impuestos;
		$Columnas[4]="Descuentos";					$Valores[4]=0;
		$Columnas[5]="Total";						$Valores[5]=$Total;
		$Columnas[6]="SaldoFact";					$Valores[6]=$Saldo;
		$Columnas[7]="Cotizaciones_idCotizaciones";	$Valores[7]=$NumCotizacion;
		$Columnas[8]="EmpresaPro_idEmpresaPro";		$Valores[8]=$EmpresaPro;
		$Columnas[9]="Usuarios_idUsuarios";			$Valores[9]=$idUser;
		$Columnas[10]="Clientes_idClientes";		$Valores[10]=$idCliente;
		$Columnas[11]="OSalida";					$Valores[11]=$NumVenta;
		$Columnas[12]="TotalCostos";			    $Valores[12]=$TotalCostos;
		$Columnas[13]="idFacturas";			    	$Valores[13]=$NumFactura;
		
		
		$obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		
		///////////////////////////Ingresar a Facturas Formas Pago 
		
		
		$tab="facturas_formapago";
		$NumRegistros=5;  
							
		
		$Columnas[0]="Total";						$Valores[0]=$Total;
		$Columnas[1]="Paga";						$Valores[1]=$Paga;
		$Columnas[2]="Devuelve";					$Valores[2]=$Devuelta;
		$Columnas[3]="FormaPago";					$Valores[3]="SEPARADO";
		$Columnas[4]="Facturas_idFacturas";			$Valores[4]=$NumFactura;
			
		
		$obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		
		///////////////////////////////////////////////////////////////////////////////////////////////////
		
		//////////////////////////////////////////////////////////////////////77
		/////////////////////Ingreso a Cartera/////
		////////////////////////////////////////////////////////////////////////
		
		$DatosCliente=$obVenta->DevuelveValores("clientes","idClientes",$idCliente);
		$NIT=$DatosCliente["Num_Identificacion"];
		$RazonSocialC=$DatosCliente["RazonSocial"];
		$TelefonoC=$DatosCliente["Telefono"];
		$ContactoC=$DatosCliente["Contacto"];
		$TelContacto=$DatosCliente["TelContacto"];
		
		$tab="cartera";
		$NumRegistros=9;  
							
		
		$Columnas[0]="FechaVencimiento";			$Valores[0]=$fecha;
		$Columnas[1]="Cliente";						$Valores[1]=$RazonSocialC;
		$Columnas[2]="Telefono";					$Valores[2]=$TelefonoC;
		$Columnas[3]="Contacto";					$Valores[3]=$ContactoC;
		
		$Columnas[4]="TelContacto";					$Valores[4]=$TelContacto;
		$Columnas[5]="Saldo";						$Valores[5]=$Saldo;
		$Columnas[6]="DiasCartera";					$Valores[6]="0";
		$Columnas[7]="Observaciones";				$Valores[7]="Entra desde ventas locales por el usuario: $idUser";
		$Columnas[8]="Facturas_idFacturas";			$Valores[8]=$NumFactura;
		
		
		$obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		
		
		//////////////////////////////////////////////////////////////////////77
		/////////////////////Ingreso a Ventas_Separados/////
		////////////////////////////////////////////////////////////////////////
	
		$tab="ventas_separados";
		$NumRegistros=2;  
							
		
		$Columnas[0]="Facturas_idFacturas";			$Valores[0]=$NumFactura;
		$Columnas[1]="Retirado";					$Valores[1]="NO";
							
		$obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		
		
		
		
		
		///se registra en el libro diario, las Variables estan inicializadas en el archivo php_conexion
		
		$obVenta->RegFactLibroDiario($NumFactura,$CuentaDestino,$CuentaIngresos,$TablaCuentaIngreso,$CuentaIVAGen, $TablaIVAGen, $CuentaCostoMercancia,$CuentaInventarios,$AjustaInventario,$RegCREE);
		$obVenta->BorraReg("preventa","VestasActivas_idVestasActivas",$idPreventa);
		$obVenta->ReiniciarPreventa($idPreventa);
		
		
		//////////////////////////////////////////////////////////////////////77
		/////////////////////Registramos el Abono/////
		////////////////////////////////////////////////////////////////////////
		
		$tab="facturas_abonos";
		$NumRegistros=6;  
							
		
		$Columnas[0]="Fecha";						$Valores[0]=$fecha;
		$Columnas[1]="Monto";						$Valores[1]=$Abono;
		$Columnas[2]="CuentaIngreso";				$Valores[2]=110510;
		$Columnas[3]="NombreCuenta";				$Valores[3]="CAJA MENOR";
		$Columnas[4]="Usuarios_idUsuarios";			$Valores[4]=$idUser;
		$Columnas[5]="Facturas_idFacturas";			$Valores[5]=$NumFactura;
		
		
		
		$obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		
		$Saldo=$Saldo-$Abono;
		$RutaRetorno="../VAtencion/VentaFacil.php?CmbPreVentaAct=$idPreventa";
		print("<script language='JavaScript'>alert('Se ha creado un separado para el cliente $RazonSocialC por el Total de: $Total, Abona: $Abono, Resta: $Saldo ')</script>");
		//$obVenta->ImprimeFactura($NumFactura,$COMPrinter,$PrintCuenta,$RutaRetorno);
		
			
	}
	
	
	////Se Crea un Cliente
	
	if(!empty($_REQUEST['BtnCrearCliente'])){
		
		
		//$idPreventa=$_REQUEST['CmbPreVentaAct'];
		$NIT=$_REQUEST['TxtNIT'];
                $idMun=$_REQUEST['CmbCodMunicipio'];
		$obVenta=new ProcesoVenta($idUser);
		$DatosClientes=$obVenta->DevuelveValores('clientes',"Num_Identificacion",$NIT);
                
                $DatosMunicipios=$obVenta->DevuelveValores('cod_municipios_dptos',"ID",$idMun);
		$DV="";
		
		
		if($DatosClientes["Num_Identificacion"]<>$NIT){
			
			///////////////////////////Ingresar a Clientes 
			
			if($_REQUEST['CmbTipoDocumento']==31){
			
				$DV=calcularDV($NIT);
		
			}
		
			$tab="clientes";
			$NumRegistros=15;  
								
			
			$Columnas[0]="Tipo_Documento";						$Valores[0]=$_REQUEST['CmbTipoDocumento'];
			$Columnas[1]="Num_Identificacion";					$Valores[1]=$_REQUEST['TxtNIT'];
			$Columnas[2]="DV";							$Valores[2]=$DV;
			$Columnas[3]="Primer_Apellido";						$Valores[3]=$_REQUEST['TxtPA'];
			$Columnas[4]="Segundo_Apellido";					$Valores[4]=$_REQUEST['TxtSA'];
			$Columnas[5]="Primer_Nombre";						$Valores[5]=$_REQUEST['TxtPN'];
			$Columnas[6]="Otros_Nombres";						$Valores[6]=$_REQUEST['TxtON'];
			$Columnas[7]="RazonSocial";						$Valores[7]=$_REQUEST['TxtRazonSocial'];
			$Columnas[8]="Direccion";						$Valores[8]=$_REQUEST['TxtDireccion'];
			$Columnas[9]="Cod_Dpto";						$Valores[9]=$DatosMunicipios["Cod_Dpto"];
			$Columnas[10]="Cod_Mcipio";						$Valores[10]=$DatosMunicipios["Cod_mcipio"];
			$Columnas[11]="Pais_Domicilio";						$Valores[11]=169;
			$Columnas[12]="Telefono";			    			$Valores[12]=$_REQUEST['TxtTelefono'];
			$Columnas[13]="Ciudad";			    				$Valores[13]=$DatosMunicipios["Ciudad"];
			$Columnas[14]="Email";			    				$Valores[14]=$_REQUEST['TxtEmail'];
			
			$obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
				
			print("<script language='JavaScript'>alert('Se ha creado el Cliente $_REQUEST[TxtRazonSocial]')</script>");
			
		}else{
			
			print("<script language='JavaScript'>alert('El cliente con Identificacion: $NIT, ya existe y no se puede crear nuevamente')</script>");
		}	

		//header("location:VentaFacil.php?CmbPreVentaAct=$idPreventa");
		
			
	}
        
	?>