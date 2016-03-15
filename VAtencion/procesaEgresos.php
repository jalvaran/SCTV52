
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
	if(!empty($_REQUEST['BtnGuardarEgreso'])){
		
		$tabla=new ProcesoVenta($idUser);
		$CuentaOrigen=$_POST["CmbCuentaOrigen"];
		$CuentaDestino=$_POST["CmbCuentaDestino"];
		$idProveedor=$_POST["CmbProveedor"];
		$Concepto=$_POST["TxtConcepto"];
		$TipoEgreso=$_REQUEST['TxtTipoEgreso'];
		$idUsuario=$idUser;
		$IVA=0;
		if($TipoEgreso==3){
			
			$Sanciones=$_POST["TxtSancion"];
			$Intereses=$_POST["TxtIntereses"];
			$TotalSanciones=$Sanciones+$Intereses;
			$Impuestos=$_POST["TxtImpuesto"];
			$Subtotal=$Impuestos;
			
								
		}elseif($TipoEgreso==1){
			$Subtotal=$_POST["TxtTotal"];
				
		
		}else{
			$Subtotal=$_POST["TxtSubtotal"];
			$IVA=$_POST["TxtIVA"];
			
		}
		$Total=$_POST["TxtTotal"];
		$Valor=$_POST["TxtTotal"];
		$NumFact=$_POST["TxtNumFactura"];		
		//////registramos en egresos
		
		$NumRegistros=18;
		
		$DatosProveedor=$tabla->DevuelveValores("proveedores","idProveedores",$idProveedor);
		$CentroCostos=$tabla->DevuelveValores("centrocosto","ID",$_REQUEST["CmbCentroCosto"]);
		$DatosTipoEgreso=$tabla->DevuelveValores("egresos_tipo","id",$TipoEgreso);
		$RazonSocial=$DatosProveedor["RazonSocial"];
		$NIT=$DatosProveedor["Num_Identificacion"];
		$idEmpresa=$CentroCostos["EmpresaPro"];
		$idCentroCostos=$CentroCostos["ID"];
		
		
		$Columnas[0]="Fecha";				$Valores[0]=$fecha;
		$Columnas[1]="Beneficiario";		$Valores[1]=$RazonSocial;
		$Columnas[2]="NIT";					$Valores[2]=$NIT;
		$Columnas[3]="Concepto";			$Valores[3]=$Concepto;
		$Columnas[4]="Valor";				$Valores[4]=$Valor;
		$Columnas[5]="Usuario_idUsuario";	$Valores[5]=$idUsuario;
		$Columnas[6]="PagoProg";			$Valores[6]=$_POST["TipoPago"];
		$Columnas[7]="FechaPagoPro";		$Valores[7]=$_POST["TxtFechaProgram"];
		$Columnas[8]="TipoEgreso";			$Valores[8]=$DatosTipoEgreso["Nombre"];
		$Columnas[9]="Direccion";			$Valores[9]=$DatosProveedor["Direccion"];
		$Columnas[10]="Ciudad";				$Valores[10]=$DatosProveedor["Ciudad"];
		$Columnas[11]="Subtotal";			$Valores[11]=$Subtotal;
		$Columnas[12]="IVA";				$Valores[12]=$IVA;
		$Columnas[13]="NumFactura";			$Valores[13]=$NumFact;
		$Columnas[14]="idProveedor";		$Valores[14]=$idProveedor;
		$Columnas[15]="Cuenta";				$Valores[15]=$CuentaOrigen;
		$Columnas[16]="CentroCostos";			$Valores[16]=$idCentroCostos;	
		$Columnas[17]="EmpresaPro";		$Valores[17]= $idEmpresa ;	
		
		$tabla->InsertarRegistro("egresos",$NumRegistros,$Columnas,$Valores);
		
		/////////////////////////////////////////////////////////////////
		//////registramos en libro diario
		
		$tab="librodiario";
		$NumEgreso=$tabla->ObtenerMAX("egresos","idEgresos", 1, "");
		$NumRegistros=26;
		$CuentaPUC=$CuentaDestino;  			 /////Servicios
		if($TipoEgreso==3) //Si es pago de impuestos
			$DatosCuenta=$tabla->DevuelveValores("cuentas","idPUC",$CuentaPUC);	
		else
			$DatosCuenta=$tabla->DevuelveValores("subcuentas","PUC",$CuentaPUC);
		
		$NombreCuenta=$DatosCuenta["Nombre"];
		
		
		
		$Columnas[0]="Fecha";					$Valores[0]=$fecha;
		$Columnas[1]="Tipo_Documento_Intero";	$Valores[1]="CompEgreso";
		$Columnas[2]="Num_Documento_Interno";	$Valores[2]=$NumEgreso;
		$Columnas[3]="Tercero_Tipo_Documento";	$Valores[3]=$DatosProveedor['Tipo_Documento'];
		$Columnas[4]="Tercero_Identificacion";	$Valores[4]=$NIT;
		$Columnas[5]="Tercero_DV";				$Valores[5]=$DatosProveedor['DV'];
		$Columnas[6]="Tercero_Primer_Apellido";	$Valores[6]=$DatosProveedor['Primer_Apellido'];
		$Columnas[7]="Tercero_Segundo_Apellido";$Valores[7]=$DatosProveedor['Segundo_Apellido'];
		$Columnas[8]="Tercero_Primer_Nombre";	$Valores[8]=$DatosProveedor['Primer_Nombre'];
		$Columnas[9]="Tercero_Otros_Nombres";	$Valores[9]=$DatosProveedor['Otros_Nombres'];
		$Columnas[10]="Tercero_Razon_Social";	$Valores[10]=$RazonSocial;
		$Columnas[11]="Tercero_Direccion";		$Valores[11]=$DatosProveedor['Direccion'];
		$Columnas[12]="Tercero_Cod_Dpto";		$Valores[12]=$DatosProveedor['Cod_Dpto'];
		$Columnas[13]="Tercero_Cod_Mcipio";		$Valores[13]=$DatosProveedor['Cod_Mcipio'];
		$Columnas[14]="Tercero_Pais_Domicilio"; $Valores[14]=$DatosProveedor['Pais_Domicilio'];
		$Columnas[15]="CuentaPUC";				$Valores[15]=$CuentaPUC;
		$Columnas[16]="NombreCuenta";			$Valores[16]=$NombreCuenta;
		$Columnas[17]="Detalle";				$Valores[17]="egresos";		
		$Columnas[18]="Debito";					$Valores[18]=$Subtotal;
		$Columnas[19]="Credito";				$Valores[19]="0";
		$Columnas[20]="Neto";					$Valores[20]=$Subtotal;
		$Columnas[21]="Mayor";					$Valores[21]="NO";
		$Columnas[22]="Esp";					$Valores[22]="NO";
		$Columnas[23]="Concepto";				$Valores[23]=$Concepto;
		$Columnas[24]="idCentroCosto";				$Valores[24]=$idCentroCostos;
		$Columnas[25]="idEmpresa";			$Valores[25]=$idEmpresa;
							
		$tabla->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		
		/////////////////////////////////////////////////////////////////
		//////contra partida
		if($_POST["TipoPago"]=="Contado"){
			
			
			$CuentaPUC=$CuentaOrigen; //cuenta de donde sacaremos el valor del egreso
			
			$DatosCuenta=$tabla->DevuelveValores("cuentasfrecuentes","CuentaPUC",$CuentaPUC);
			$NombreCuenta=$DatosCuenta["Nombre"];
		}
		if($_POST["TipoPago"]=="Programado"){
			$CuentaPUC="2205$NIT";
			$NombreCuenta="Proveedores Nacionales $RazonSocial $NIT";
		}
		
		
		$Valores[15]=$CuentaPUC;
		$Valores[16]=$NombreCuenta;
		$Valores[18]="0";
		$Valores[19]=$Valor; 						//Credito se escribe el total de la venta menos los impuestos
		$Valores[20]=$Valor*(-1);  											//Credito se escribe el total de la venta menos los impuestos
		
		$tabla->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		
		/////////////////////////////////////////////////////////////////
		//////Si hay IVA
		if($IVA<>0){
			$CuentaPUC=$_POST["CmbIVADes"]; //cuenta de donde sacaremos el valor del egreso
			if($CuentaPUC>2408)
				$DatosCuenta=$tabla->DevuelveValores("subcuentas","PUC",$CuentaPUC);
			else
				$DatosCuenta=$tabla->DevuelveValores("cuentas","idPUC",$CuentaPUC);
			
			$NombreCuenta=$DatosCuenta["Nombre"];
			
			$Valores[15]=$CuentaPUC;
			$Valores[16]=$NombreCuenta;
			$Valores[18]=$IVA;
			$Valores[19]=0; 						
			$Valores[20]=$IVA;  											//Credito se escribe el total de la venta menos los impuestos
			
			$tabla->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		}
		
		//////Si hay IVA
		if(!empty($TotalSanciones)){
		
			$CuentaPUC=539520; //Multas, sanciones y litigios
			
			$DatosCuenta=$tabla->DevuelveValores("subcuentas","PUC",$CuentaPUC);
			$NombreCuenta=$DatosCuenta["Nombre"];
			
			$Valores[15]=$CuentaPUC;
			$Valores[16]=$NombreCuenta;
			$Valores[18]=$TotalSanciones;
			$Valores[19]=0; 						
			$Valores[20]=$TotalSanciones;  											//Credito se escribe el total de la venta menos los impuestos
			
			$tabla->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
		}
		$RutaPrintComp="../tcpdf/examples/imprimircomp.php?ImgPrintComp=$NumEgreso";
		//print("<script>window.open('$RutaPrintComp','_blank');</script>");
		
	}
	
////Se Crea un Proveedor
	
	if(!empty($_REQUEST['BtnCrearProveedor'])){
		
		$NIT=$_REQUEST['TxtNIT'];
                $idCodMunicipio=$_REQUEST['CmbCodMunicipio'];
		$obVenta=new ProcesoVenta($idUser);
		$DatosClientes=$obVenta->DevuelveValores('proveedores',"Num_Identificacion",$NIT);
		$DV="";
		$DatosMunicipios=$obVenta->DevuelveValores('cod_municipios_dptos',"ID",$idCodMunicipio);		
		if($DatosClientes["Num_Identificacion"]<>$NIT){
			
			///////////////////////////Ingresar a Clientes 
			
			if($_REQUEST['CmbTipoDocumento']==31){
			
				$DV=calcularDV($NIT);
		
			}
		
			$tab="proveedores";
			$NumRegistros=15;  
								
			
			$Columnas[0]="Tipo_Documento";						$Valores[0]=$_REQUEST['CmbTipoDocumento'];
			$Columnas[1]="Num_Identificacion";					$Valores[1]=$_REQUEST['TxtNIT'];
			$Columnas[2]="DV";                                                      $Valores[2]=$DV;
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
			$Columnas[13]="Ciudad";			    				$Valores[13]="BUGA";
			$Columnas[14]="Email";			    				$Valores[14]=$_REQUEST['TxtEmail'];
			
			$obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
			
			print("<script language='JavaScript'>alert('Se ha creado el Proveedor $_REQUEST[TxtRazonSocial]')</script>");
			
		}else{
			
			print("<script language='JavaScript'>alert('El cliente con Identificacion: $NIT, ya existe y no se puede crear nuevamente')</script>");
		}	

		//header("location:VentaFacil.php?CmbPreVentaAct=$idPreventa");
		
			
	}
	?>