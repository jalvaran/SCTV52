<?php
require_once('tcpdf_include.php');
include("../../modelo/php_conexion.php");
////////////////////////////////////////////
/////////////Verifico que haya una sesion activa
////////////////////////////////////////////
session_start();
if(!isset($_SESSION["username"]))
   header("Location: ../../index.php");
////////////////////////////////////////////
/////////////Obtengo el ID de la cotizacion a que se imprimirá 
////////////////////////////////////////////
$idDevolucion = $_REQUEST["ImgPrintDevolucion"];
////////////////////////////////////////////
/////////////Obtengo valores de la Remision
////////////////////////////////////////////
			
$obVenta=new ProcesoVenta(1);
$DatosDevolucion=$obVenta->DevuelveValores("rem_devoluciones_totalizadas","ID",$idDevolucion);
$Fecha=$DatosDevolucion["FechaDevolucion"];
$Hora=$DatosDevolucion["HoraDevolucion"];
$observaciones=$DatosDevolucion["ObservacionesDevolucion"];
$Clientes_idClientes=$DatosDevolucion["Clientes_idClientes"];
$Usuarios_idUsuarios=$DatosDevolucion["Usuarios_idUsuarios"];

$DatosRemision=$obVenta->DevuelveValores("remisiones","ID",$DatosDevolucion["idRemision"]);
////////////////////////////////////////////
/////////////Obtengo datos del cliente
////////////////////////////////////////////
$DatosCentroCostos=$obVenta->DevuelveValores("centrocosto","ID",$DatosRemision["CentroCosto"]);

$DatosCliente=$obVenta->DevuelveValores("clientes","idClientes",$Clientes_idClientes);
////////////////////////////////////////////
/////////////Obtengo datos del Usuario creador y de la empresa propietaria
////////////////////////////////////////////
$DatosUsuario=$obVenta->DevuelveValores("usuarios","idUsuarios",$Usuarios_idUsuarios);
$nombreUsuario=$DatosUsuario["Nombre"];
$ApellidoUsuario=$DatosUsuario["Apellido"];
$registros2=$obVenta->DevuelveValores("empresapro","idEmpresaPro",$DatosCentroCostos["EmpresaPro"]);
$RazonSocialEP=$registros2["RazonSocial"];
$DireccionEP=$registros2["Direccion"];
$TelefonoEP=$registros2["Celular"];
$CiudadEP=$registros2["Ciudad"];
$NITEP=$registros2["NIT"];
		  
$nombre_file="Decoluvion_".$Fecha."_".$DatosCliente["RazonSocial"];
		   
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	//Page header
	public function Header() {
		// get the current page break margin
		$bMargin = $this->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $this->AutoPageBreak;
		// disable auto-page-break
		$this->SetAutoPageBreak(false, 0);
		// set bacground image
		$img_file = K_PATH_IMAGES.'tsfondo.jpg';
		$this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
		// restore auto-page-break status
		$this->SetAutoPageBreak($auto_page_break, $bMargin);
		// set the starting point for the page content
		$this->setPageMark();
	}
}
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Techno Soluciones');
$pdf->SetTitle('Devoluciones TS');
$pdf->SetSubject('Devoluiones');
$pdf->SetKeywords('Techno Soluciones, PDF, Remisiones, CCTV, Alarmas, Computadores, Software');
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);
// remove default footer
$pdf->setPrintFooter(false);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/spa.php')) {
	require_once(dirname(__FILE__).'/lang/spa.php');
	$pdf->setLanguageArray($l);
}
// ---------------------------------------------------------
// set font
//$pdf->SetFont('helvetica', 'B', 6);
// add a page
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 7);
///////////////////////////////////////////////////////
//////////////encabezado//////////////////
////////////////////////////////////////////////////////
$tbl = <<<EOD
<hr id="Line1" style="margin:0;padding:0;position:absolute;left:0px;top:44px;width:625px;height:2px;z-index:1;">
<div id="wb_Text5" style="position:absolute;left:334px;top:127px;width:335px;height:18px;z-index:7;text-align:left;">
<span style="color:#000000;font-family:'Bookman Old Style';font-size:13px;">Buga $Fecha</span></div>
<div id="wb_Text1" style="position:absolute;left:380px;top:72px;width:150px;height:16px;text-align:rigth;z-index:2;">
<span style="font-family:'Bookman Old Style';font-size:13px;"><strong><em>Devolucion No. $idDevolucion
</em></strong></span></div>
</div>
EOD;
$pdf->writeHTML($tbl, false, false, false, false, '');
/////////////////Datos de la Devolucion
//
//
//
$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2" align="left">
    <tr nobr="true">
        <th><strong>Cliente:</strong> $DatosCliente[RazonSocial]</th>
        <th><strong>Nombre Obra:</strong> $DatosRemision[Obra]</th>
    </tr>
    <tr nobr="true">
        <th><strong>Dirección:</strong> $DatosCliente[Direccion]</th>
        <th><strong>Dirección:</strong> $DatosRemision[Direccion] $DatosRemision[Ciudad]</th>
    </tr>
    <tr nobr="true">
        <th><strong>Teléfono:</strong> $DatosCliente[Telefono]</th>
        <th><strong>Remision:</strong> $DatosRemision[ID]</th>
    </tr>
    <tr nobr="true">
        <th><strong>Ciudad:</strong> $DatosCliente[Ciudad]</th>
        <th><strong>Factura:</strong> $DatosDevolucion[Facturas_idFacturas]</th>
    </tr> 
    <tr nobr="true">
        <th><strong>NIT:</strong> $DatosCliente[Num_Identificacion]</th>
        <th><strong>Fecha y Hora de Devolucion:</strong> $DatosDevolucion[FechaDevolucion] $DatosDevolucion[HoraDevolucion]</th>
    </tr>
</table>
        
<br>
<hr id="Line3" style="margin:0;padding:0;position:absolute;left:0px;top:219px;width:625px;height:2px;z-index:9;">
  
EOD;
$pdf->writeHTML($tbl, false, false, false, false, '');
////////////////////Datos de los items
$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2" align="center">
  
 <tr nobr="true">
  <th><h3>Ref</h3></th>
  <th colspan="3"><h3>Descripción</h3></th>
  <th><h3>Cantidad</h3></th>
  <th><h3>Valor Unitario</h3></th>
  <th><h3>Subtotal</h3></th>
  <th><h3>Dias</h3></th>
  <th><h3>Total</h3></th>
 </tr>
 </table>
EOD;
$pdf->writeHTML($tbl, false, false, false, false, '');
////////////////////////////////////////////////////////

$sql="SELECT rd.Total,rd.Subtotal,rd.Dias,rd.ValorUnitario,rd.Cantidad,ci.Referencia,ci.Descripcion"
        . ", rd.idItemCotizacion , rd.idRemision "
        . "FROM rem_devoluciones rd INNER JOIN cot_itemscotizaciones ci ON "
        . "rd.idItemCotizacion=ci.ID WHERE rd.NumDevolucion='$idDevolucion'";
$Consulta=$obVenta->Query($sql);
$GranTotal=0;
        
while($registros2=mysql_fetch_array($Consulta)){
		 
$GranTotal=$GranTotal+$registros2["Total"];
$registros2["Total"]=number_format($registros2["Total"]);
$registros2["Subtotal"]=number_format($registros2["Subtotal"]);	
$registros2["ValorUnitario"]=number_format(round($registros2["ValorUnitario"]));	
			
$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2" align="center">
         
 <tr nobr="true">
  <th>$registros2[Referencia]</th>
  <th colspan="3">$registros2[Descripcion]</th>
  <th>$registros2[Cantidad]</th>
  <th>$$registros2[ValorUnitario]</th>
  <th>$$registros2[Subtotal]</th>
  <th>$registros2[Dias]</th>
  <th>$$registros2[Total]</th>
 </tr>
 </table>
EOD;
$pdf->writeHTML($tbl, false, false, false, false, '');
			
		  
}

//////////////Se dibuja el total de la devolcion
///
///
///
$GranTotal=  number_format($GranTotal);
$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2" align="center">
 <tr nobr="true">
  <td colspan="5" align="center"><h3>Observaciones</h3></td></tr>
  <tr nobr="true">
  <td colspan="5" align="left">Valores Sin IVA, $observaciones</td></tr>
  <tr nobr="true">
  <td colspan="4" align="rigth"><h3>Esta Devolucion: </h3></td><td>$$GranTotal</td>
  
 </tr>
 </table>
EOD;
$pdf->writeHTML($tbl, false, false, false, false, '');		

//////////////////Se dibujan los faltantes
////
////


////////////////////Datos de los items
$tbl = <<<EOD
<br><H3>FALTANTES:</H3><br>
   <table border="1" cellpadding="2" cellspacing="2" align="center">
  
 <tr nobr="true">
  <th><h3>Ref</h3></th>
  <th colspan="3"><h3>Descripción</h3></th>
  <th><h3>Cantidad Entregada</h3></th>
  <th><h3>Devoluciones</h3></th>
  <th><h3>Faltantes</h3></th>
  
 </tr>
 </table>
EOD;
$pdf->writeHTML($tbl, false, false, false, false, '');
////////////////////////////////////////////////////////

$sql="SELECT rr.CantidadEntregada,rr.idItemCotizacion,rr.idRemision, ci.Referencia,ci.Descripcion"
        . " FROM rem_relaciones rr "
        . "INNER JOIN cot_itemscotizaciones ci  "
        . "ON rr.idItemCotizacion=ci.ID"
        . " WHERE rr.idRemision='$DatosRemision[ID]'";
$Consulta=$obVenta->Query($sql);
 $BanderaFaltantes=0;      
while($DatosItemRemision=mysql_fetch_array($Consulta)){

//$Entregas=$obVenta->Sume('rem_relaciones', "CantidadEntregada", " WHERE idItemCotizacion='$registros2[idItemCotizacion]' AND idRemision='$registros2[idRemision]'");
$Devoluciones=$obVenta->Sume("rem_devoluciones", "Cantidad", " WHERE idItemCotizacion='$DatosItemRemision[idItemCotizacion]' AND idRemision='$DatosRemision[ID]'");
$Faltantes=$DatosItemRemision["CantidadEntregada"]-$Devoluciones;
$BanderaFaltantes=$BanderaFaltantes+$Faltantes;
if($Faltantes<>0){    
$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2" align="center">
         
 <tr nobr="true">
  <th>$DatosItemRemision[Referencia]</th>
  <th colspan="3">$DatosItemRemision[Descripcion]</th>
  <th>$DatosItemRemision[CantidadEntregada]</th>
  <th>$Devoluciones</th>
  <th>$Faltantes</th>
  
 </tr>
 </table>
EOD;
$pdf->writeHTML($tbl, false, false, false, false, '');
  
}
    
		  
}
if($BanderaFaltantes==0){
    $pdf->writeHTML("<br><h3>No se encontraron faltantes</h3><br>", false, false, false, false, '');  
}
/////////////////////////////////////////Se dibija el mensaje final
/////
////
////
$tbl = <<<EOD
</br>
 
  <div id="wb_Text6" style="position:absolute;left:35px;top:150px;width:242px;height:18px;z-index:8;text-align:rigth;">
<span style="font-family:'Bookman Old Style';font-size:10px;"><strong><em>Realizado por: $DatosUsuario[Nombre] $DatosUsuario[Apellido]
</em></strong></span></div>
<div id="wb_Text6" style="position:absolute;left:35px;top:150px;width:242px;height:18px;z-index:8;text-align:left;">
<span style="font-family:'Bookman Old Style';font-size:10px;">Los elementos o artículos faltantes se cobrarán por su valor en el comercio.
       Los funcionarios de Alturas no deben recoger ni desarmar equipos.
</span></div><br><br>

<div id="Div_Firmas" style="text-align:left;">
<span style="color:#000000;font-family:'Bookman Old Style';font-size:8px; text-align:left;">Cliente: ______________________________</span>
<span style="color:#000000;font-family:'Bookman Old Style';font-size:8px; text-align:right;"> Despachos: ______________________________</span></div>

        
<div id="wb_Text6" style="position:absolute;left:35px;top:150px;width:242px;height:18px;z-index:8;text-align:left;">
<span style="color:#000000;font-family:'Bookman Old Style';font-size:8px;">Documento Generado por SOFTCONTECH V5.0, Software Diseñado por TECHNO SOLUCIONES SAS, 317 774 0609, info@technosoluciones.com</div></span>
EOD;
$pdf->writeHTML($tbl, false, false, false, false, '');		
//Close and output PDF document
$pdf->Output($nombre_file.'.pdf', 'I');
//============================================================+
// END OF FILE
//============================================================+
?>