<?php 
//print("<script>alert('entra');</script>");		
if(isset($_REQUEST["BtnEditar"])){
    //print("<script>alert('entra');</script>");
    $obVenta=new ProcesoVenta($idUser);
    $idItem=$_REQUEST["TxtIdItem"];
    $FechaDevolucion=$_REQUEST["TxtFechaDevolucion"];
    $HoraDevolucion=$_REQUEST["TxtHoraDevolucion"];
    $CantidadDevolucion=$_REQUEST["TxtCantidadDevolucion"];
    $idRemision=$_REQUEST["TxtAsociarRemision"];
    
    $tab="rem_pre_devoluciones";
    $NumRegistros=4; 
    $Columnas[0]="idRemision";		$Valores[0]=$idRemision;
    $Columnas[1]="idItemCotizacion";	$Valores[1]=$idItem;
    $Columnas[2]="Cantidad";		$Valores[2]=$CantidadDevolucion;
    $Columnas[3]="Usuarios_idUsuarios"; $Valores[3]=$idUser;
    
    $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
   
    header("location:Devoluciones.php?TxtAsociarRemision=$idRemision");
}
			
?>