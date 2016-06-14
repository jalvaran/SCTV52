<?php 
ob_start();
session_start();
$NombreUser=$_SESSION['nombre'];
$idUser=$_SESSION['idUser'];
include_once("../modelo/php_tablas.php");
include_once("css_construct.php");
if (!isset($_SESSION['username']))
{
  exit("No se ha iniciado una sesion <a href='../index.php' >Iniciar Sesion </a>");
  
}

$idPreventa="";
//////Si recibo una preventa
if(!empty($_REQUEST['CmbPreVentaAct'])){

        $idPreventa=$_REQUEST['CmbPreVentaAct'];
}
       
$myPage="VentasRapidas.php";
$css =  new CssIni("TS5 Ventas");
$css->CabeceraIni("TS5 Ventas"); 
    $css->CreaBotonAgregaPreventa($myPage,$idUser);
    $css->CreaBotonDesplegable("DialCliente","Crear Cliente");

    $css->CrearForm("FrmPreventaSel",$myPage,"post","_self");
    $css->CrearSelect("CmbPreVentaAct","EnviaForm('FrmPreventaSel')");
    $css->CrearOptionSelect('NO','Seleccione una preventa',0);

    $pa=mysql_query("SELECT * FROM vestasactivas WHERE Usuario_idUsuario='$idUser'");	

           while($DatosVentasActivas=mysql_fetch_array($pa)){
                   $label=$DatosVentasActivas["idVestasActivas"]." ".$DatosVentasActivas["Nombre"];

                   if($idPreventa==$DatosVentasActivas["idVestasActivas"])
                           $Sel=1;
                   else
                           $Sel=0;

                   $css->CrearOptionSelect($DatosVentasActivas["idVestasActivas"],$label,$Sel);

           }


    $css->CerrarSelect();
    $css->CerrarForm();
if($idPreventa>1)
    $css->CreaBotonDesplegable("DialSeparado","Crear Separado");
$css->CabeceraFin();
$NombreUser=$_SESSION['nombre'];
$idUser=$_SESSION['idUser'];	
$obTabla = new Tabla($db);
$obVenta = new ProcesoVenta(1);
if(!empty($_REQUEST["TxtidFactura"])){
            
    $idFactura=$_REQUEST["TxtidFactura"];
    if($idFactura<>""){
        $RutaPrint="../tcpdf/examples/imprimirFactura.php?ImgPrintFactura=".$idFactura;
        $DatosFactura=$obVenta->DevuelveValores("facturas", "idFacturas", $idFactura);
        $css->CrearTabla();
        $css->CrearFilaNotificacion("Factura Creada Correctamente <a href='$RutaPrint' target='_blank'>Imprimir Factura No. $DatosFactura[NumeroFactura]</a>",16);
        $css->CerrarTabla();
    }else{

       $css->AlertaJS("No se pudo crear la factura porque no hay resoluciones disponibles", 1, "", ""); 
    }
            
}
include_once("procesadores/procesaVentasRapidas.php");
/*
 * Creo el cuadro de dialogo que perimitirá crear un cliente
 */

include_once 'CuadroDialogoCrearCliente.php';
$Visible=0;
if($idPreventa>0){
    $Visible=1;
}
$css->CrearDiv("Principal", "container", "center", $Visible, 1);
$css->CrearForm2("FrmCodBarras",$myPage,"post","_self");
$css->CrearTabla();
$css->FilaTabla(16);
print("<td style='text-align:center'>");

$css->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",0,0,0,0);
$css->CrearInputText("TxtCodigoBarras","text","Buscar por codigo de Barras:<br>","","Digite un codigo de Barras","black","","",200,30,0,0);

print("</td>");
print("<td style='text-align:center'>");
$VarSelect["Ancho"]="200";
$VarSelect["PlaceHolder"]="Busque un Producto";
$VarSelect["Title"]="Buscar por palabra clave";
$css->CrearSelectChosen("CmbIDProducto", $VarSelect);
    
        $sql="SELECT * FROM productosventa";
        $Consulta=$obVenta->Query($sql);
         $css->CrearOptionSelect("", "Seleccione un producto", 1);
           while($DatosProducto=$obVenta->FetchArray($Consulta)){
               
               $css->CrearOptionSelect("$DatosProducto[idProductosVenta];productosventa", "$DatosProducto[idProductosVenta] / $DatosProducto[Referencia] / $DatosProducto[Nombre] / $DatosProducto[Existencias]" , 0);
           }
     
        $sql="SELECT * FROM servicios";
        $Consulta=$obVenta->Query($sql);
         
           while($DatosProducto=$obVenta->FetchArray($Consulta)){
               
               $css->CrearOptionSelect("$DatosProducto[idProductosVenta];servicios", "$DatosProducto[idProductosVenta] / $DatosProducto[Referencia] / $DatosProducto[Nombre] " , 0);
           }   
        $css->CerrarSelect();
$css->CrearBoton("BtnAgregarItem", "Agregar");
print("</td>");
$css->CerrarTabla();
$css->CerrarForm();

/*
 * Visualizamos Totales y opciones de pago
 */

include_once 'cuadros_informativos/TotalesVentasRapidas.php';

$css->CerrarDiv();
$css->AgregaJS(); //Agregamos javascripts
$css->AnchoElemento("CmbCodMunicipio_chosen", 200);
$css->AnchoElemento("CmbClientes_chosen", 200);
$css->AgregaSubir();
$css->AgregaJSVentaRapida();
$css->Footer();

ob_end_flush();
?>