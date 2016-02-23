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
			
?>