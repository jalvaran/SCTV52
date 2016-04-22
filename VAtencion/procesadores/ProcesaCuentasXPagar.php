<?php 
		
if(!empty($_REQUEST["BtnEnviarChk"])){
    
    $obVenta=new ProcesoVenta(1);
    //$Selecciones["ChkID"]=$_REQUEST["ChkID"];
    //print_r($Selecciones["ChkID"]);
    foreach($_REQUEST["ChkID"] as $ids){
        //print($ids."<br>");
    }
    
    //print($_REQUEST["ChkID"][1]);
    /*
    $destino="";
    //echo "<script>alert ('entra')</script>";
    if(!empty($_FILES['foto']['name'])){
        
        $carpeta="../SoportesEgresos/";
        opendir($carpeta);
        $Name=str_replace(' ','_',$_FILES['foto']['name']);  
        $destino=$carpeta.$Name;
        move_uploaded_file($_FILES['foto']['tmp_name'],$destino);
    }
    
    $idComprobante=$_REQUEST["TxtIdCC"];
    $DatosComprobante=$obVenta->DevuelveValores("comprobantes_contabilidad", "ID", $idComprobante);
    $fecha=$DatosComprobante["Fecha"];
    
    $Concepto=$_REQUEST["TxtConceptoEgreso"];
    $CentroCosto=$_REQUEST["CmbCentroCosto"];
    $Tercero=$_REQUEST["CmbTerceroItem"];
    $DatosCuentaDestino=$_REQUEST["CmbCuentaDestino"];
    $DatosCuentaDestino=explode(";",$DatosCuentaDestino);
    $CuentaPUC=$DatosCuentaDestino[0];
    $NombreCuenta=$NombreCuenta=str_replace("_"," ",$DatosCuentaDestino[1]);
    
    $Valor=$_REQUEST["TxtValorItem"];
    $DC=$_REQUEST["CmbDebitoCredito"];
    $NumDocSoporte=$_REQUEST["TxtNumFactura"];
    if($DC=="C"){
        $Debito=0;
        $Credito= $Valor;       
    }else{
       $Debito=$Valor;
       $Credito=0; 
    }
     ////////////////Ingreso el Item
    /////
    ////
    
    $tab="comprobantes_contabilidad_items";
    $NumRegistros=11;

    $Columnas[0]="Fecha";			$Valores[0]=$fecha;
    $Columnas[1]="CentroCostos";		$Valores[1]=$CentroCosto;
    $Columnas[2]="Tercero";			$Valores[2]=$Tercero;
    $Columnas[3]="CuentaPUC";			$Valores[3]=$CuentaPUC;
    $Columnas[4]="Debito";			$Valores[4]=$Debito;
    $Columnas[5]="Credito";                     $Valores[5]=$Credito;
    $Columnas[6]="Concepto";			$Valores[6]=$Concepto;
    $Columnas[7]="NumDocSoporte";		$Valores[7]=$NumDocSoporte;
    $Columnas[8]="Soporte";			$Valores[8]=$destino;
    $Columnas[9]="idComprobante";		$Valores[9]=$idComprobante;
    $Columnas[10]="NombreCuenta";		$Valores[10]=$NombreCuenta;

    $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    //header("location:$myPage?idComprobante=$idComprobante");
     * 
     */
}

if(!empty($_REQUEST["CmbComprobante"])){
    
    $idComprobante=$_REQUEST["CmbComprobante"];
    header("location:$myPage?idComprobante=$idComprobante");
}

// si se requiere guardar y cerrar
if(!empty($_REQUEST["BtnGuardarMovimiento"])){
    
    $idComprobante=$_REQUEST["TxtIdComprobanteContable"];    
    $obVenta->RegistreComprobanteContable($idComprobante);    
    header("location:$myPage?ImprimeCC=$idComprobante");
    
}
///////////////fin
?>