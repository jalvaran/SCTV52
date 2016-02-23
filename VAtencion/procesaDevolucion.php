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
    
    $tab="rem_relaciones";
    $NumRegistros=6; 
    $Columnas[0]="FechaDevolucion";		$Valores[0]=$FechaDevolucion;
    $Columnas[1]="HoraDevolucion";		$Valores[1]=$HoraDevolucion;
    $Columnas[2]="CantidadDevolucion";		$Valores[2]=$CantidadDevolucion;
    $Columnas[3]="idItemCotizacion";            $Valores[3]=$idItem;
    $Columnas[4]="idRemision";                  $Valores[4]=$idRemision;
    $Columnas[5]="Usuarios_idUsuarios";         $Valores[5]=$idUser;
    
    $obVenta->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
   
    header("location:Devoluciones.php?TxtAsociarRemision=$idRemision");
}
			
?>