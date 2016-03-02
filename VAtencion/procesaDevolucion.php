<?php 
//print("<script>alert('entra');</script>");		
if(!empty($_REQUEST["TxtDias"])){
    //print("<script>alert('entra');</script>");
    $obVenta=new ProcesoVenta($idUser);
    $idItem=$_REQUEST["TxtIdItem"];
    $FechaDevolucion=$_REQUEST["TxtFechaDevolucion"];
    $HoraDevolucion=$_REQUEST["TxtHoraDevolucion"];
    $CantidadDevolucion=$_REQUEST["TxtCantidadDevolucion"];
    $idRemision=$_REQUEST["TxtAsociarRemision"];
    $Dias=$_REQUEST["TxtDias"];
    $ValorUnitario=$_REQUEST["TxtSubtotalUnitario"];
    $SubTotal=$ValorUnitario*$CantidadDevolucion;
    $Total=$SubTotal*$Dias;
    
    $tab="rem_pre_devoluciones";
    $NumRegistros=8; 
    $Columnas[0]="idRemision";		$Valores[0]=$idRemision;
    $Columnas[1]="idItemCotizacion";	$Valores[1]=$idItem;
    $Columnas[2]="Cantidad";		$Valores[2]=$CantidadDevolucion;
    $Columnas[3]="Usuarios_idUsuarios"; $Valores[3]=$idUser;
    $Columnas[4]="ValorUnitario";       $Valores[4]=$ValorUnitario;
    $Columnas[5]="Subtotal";            $Valores[5]=$SubTotal;
    $Columnas[6]="Dias";                $Valores[6]=$Dias;
    $Columnas[7]="Total";               $Valores[7]=$Total;
    
    $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
   
    header("location:Devoluciones.php?TxtAsociarRemision=$idRemision");
}

///////////////////////////////
////////Si se solicita borrar algo
////
////

if(!empty($_REQUEST['del'])){
        $id=$_REQUEST['del'];
        $Tabla=$_REQUEST['TxtTabla'];
        $IdTabla=$_REQUEST['TxtIdTabla'];
        $IdPre=$_REQUEST['TxtIdPre'];
        mysql_query("DELETE FROM $Tabla WHERE $IdTabla='$id'") or die(mysql_error());
        header("location:Devoluciones.php?TxtAsociarRemision=$IdPre");
	}
	
if(!empty($_REQUEST["BtnGuardarDevolucion"])){
   
    $obVenta=new ProcesoVenta($idUser);
    $FechaDevolucion=$_REQUEST["TxtFechaDevolucion"];
    $HoraDevolucion=$_REQUEST["TxtHoraDevolucion"];
    $idRemision=$_REQUEST["TxtIdRemision"];
    $Observaciones=$_REQUEST["TxtObservacionesDevolucion"];
    $TotalDevolucion=$_REQUEST["TxtTotalDevolucion"];
    
    $DatosRemision=$obVenta->DevuelveValores("remisiones", "ID", $idRemision);
    ////Guardamos en la tabla devoluciones
    ////
    ////
    
    $tab="rem_devoluciones_totalizadas";
    $NumRegistros=8; 
    $Columnas[0]="FechaDevolucion";         $Valores[0]=$FechaDevolucion;
    $Columnas[1]="idRemision";              $Valores[1]=$idRemision;
    $Columnas[2]="TotalDevolucion";         $Valores[2]=$TotalDevolucion;
    $Columnas[3]="ObservacionesDevolucion"; $Valores[3]=$Observaciones;
    $Columnas[4]="Usuarios_idUsuarios";     $Valores[4]=$idUser;
    $Columnas[5]="Clientes_idClientes";     $Valores[5]=$DatosRemision["Clientes_idClientes"];
    $Columnas[6]="Facturas_idFacturas";     $Valores[6]="";
    $Columnas[7]="HoraDevolucion";          $Valores[7]=$HoraDevolucion;
    
    $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    
    $idDevolucion=$obVenta->ObtenerMAX("rem_devoluciones_totalizadas", "ID", 1, "");
    
    $Consulta=$obVenta->ConsultarTabla("rem_pre_devoluciones", " WHERE idRemision='$idRemision'");
    
    while($DatosPreDevolucion= mysql_fetch_array($Consulta)){
        
        $tab="rem_devoluciones";
        $NumRegistros=11; 
        $Columnas[0]="idRemision";          $Valores[0]=$idRemision;
        $Columnas[1]="idItemCotizacion";    $Valores[1]=$DatosPreDevolucion["idItemCotizacion"];
        $Columnas[2]="Cantidad";            $Valores[2]=$DatosPreDevolucion["Cantidad"];
        $Columnas[3]="ValorUnitario";       $Valores[3]=$DatosPreDevolucion["ValorUnitario"];
        $Columnas[4]="Subtotal";            $Valores[4]=$DatosPreDevolucion["Subtotal"];
        $Columnas[5]="Dias";                $Valores[5]=$DatosPreDevolucion["Dias"];
        $Columnas[6]="Total";               $Valores[6]=$DatosPreDevolucion["Total"];
        $Columnas[7]="NumDevolucion";       $Valores[7]=$idDevolucion;
        $Columnas[8]="FechaDevolucion";     $Valores[8]=$FechaDevolucion;
        $Columnas[9]="HoraDevolucion";      $Valores[9]=$HoraDevolucion;
        $Columnas[10]="Usuarios_idUsuarios";$Valores[10]=$DatosPreDevolucion["Usuarios_idUsuarios"];
        
        $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    }
    $obVenta->BorraReg("rem_pre_devoluciones", "idRemision", $idRemision);
    
    ////Iniciamos registro de facturas si aplica
    ////
    ////
    
    if($_REQUEST["CmbFactura"]=="SI"){
        
    }
    header("location:Devoluciones.php?TxtidDevolucion=$idDevolucion&TxtidFactura=$idFactura");
}        


///////////////fin
?>
