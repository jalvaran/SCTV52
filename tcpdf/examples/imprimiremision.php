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
$idRemision = $_REQUEST["ImgPrintRemi"];
////////////////////////////////////////////
/////////////Obtengo valores de la Remision
////////////////////////////////////////////
			
$obVenta=new ProcesoVenta(1);
$DatosRemision=$obVenta->DevuelveValores("remisiones","ID",$idRemision);
$fecha=$DatosRemision["Fecha"];
$observaciones=$DatosRemision["ObservacionesRemision"];
$Clientes_idClientes=$DatosRemision["Clientes_idClientes"];
$Usuarios_idUsuarios=$DatosRemision["Usuarios_idUsuarios"];
////////////////////////////////////////////
/////////////Obtengo valores del centro de costos
////////////////////////////////////////////
		
$DatosCentroCostos=$obVenta->DevuelveValores("centrocosto","ID",$DatosRemision["CentroCosto"]);
////////////////////////////////////////////
/////////////Obtengo datos del cliente
////////////////////////////////////////////
		  		  
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
		  
$nombre_file="Remision_".$fecha."_".$DatosCliente["RazonSocial"];
		   
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
$pdf->SetAuthor('Julian Andres Alvaran Valencia');
$pdf->SetTitle('Remisiones TS');
$pdf->SetSubject('Remisiones');
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
$pdf->SetFont('helvetica', '', 8);
///////////////////////////////////////////////////////
//////////////encabezado//////////////////
////////////////////////////////////////////////////////
$tbl = <<<EOD
<hr id="Line1" style="margin:0;padding:0;position:absolute;left:0px;top:44px;width:625px;height:2px;z-index:1;">
<div id="wb_Text5" style="position:absolute;left:334px;top:127px;width:335px;height:18px;z-index:7;text-align:left;">
<span style="color:#000000;font-family:'Bookman Old Style';font-size:13px;">Buga $fecha</span></div>
<div id="wb_Text1" style="position:absolute;left:380px;top:72px;width:150px;height:16px;text-align:rigth;z-index:2;">
<span style="font-family:'Bookman Old Style';font-size:13px;"><strong><em>REMISION No. $idRemision
</em></strong></span></div>
</div>
EOD;
$pdf->writeHTML($tbl, false, false, false, false, '');
/////////////////Datos de la Remision
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
        <th><strong>Teléfono:</strong> $DatosRemision[Telefono]</th>
    </tr>
    <tr nobr="true">
        <th><strong>Ciudad:</strong> $DatosCliente[Ciudad]</th>
        <th><strong>Retiró:</strong> $DatosRemision[Retira]</th>
    </tr> 
    <tr nobr="true">
        <th><strong>NIT:</strong> $DatosCliente[Num_Identificacion]</th>
        <th><strong>Fecha y Hora de Despacho:</strong> $DatosRemision[FechaDespacho] $DatosRemision[HoraDespacho]</th>
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
  <th><h3>Valor Unitario</h3></th>
  <th><h3>Cantidad</h3></th>
  <th><h3>Dias</h3></th>
  <th><h3>Total</h3></th>
 </tr>
 </table>
EOD;
$pdf->writeHTML($tbl, false, false, false, false, '');
////////////////////////////////////////////////////////
 
$Consulta=$obVenta->ConsultarTabla("cot_itemscotizaciones","WHERE NumCotizacion='$DatosRemision[Cotizaciones_idCotizaciones]'");
	
$Subtotal=0;
$IVA=0;
$Total=0;
        
while($registros2=mysql_fetch_array($Consulta)){
		 
$Subtotal=$Subtotal+($registros2["Subtotal"]*$DatosRemision["Dias"]);
$IVA=$IVA+($registros2["IVA"]*$DatosRemision["Dias"]);
$Total=$Total+($registros2["Total"]*$DatosRemision["Dias"]);
$registros2["Total"]=number_format($registros2["Total"]);
$registros2["Subtotal"]=number_format(round($registros2["Subtotal"]*$DatosRemision["Dias"]));	
$registros2["ValorUnitario"]=number_format(round($registros2["ValorUnitario"]));	
			
			
$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2" align="center">
 <tr nobr="true">
  <td>$registros2[Referencia]</td>
  <td colspan="3">$registros2[Descripcion]</td>
  <td>$$registros2[ValorUnitario]</td>
  <td>$registros2[Cantidad]</td>
  <td>$DatosRemision[Dias]</td>
  <td>$$registros2[Subtotal]</td>
 </tr>
 </table>
EOD;
$pdf->writeHTML($tbl, false, false, false, false, '');
			
		  
}
$Subtotal=  number_format($Subtotal);
$IVA=  number_format($IVA);
$Total=  number_format($Total);
$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2" align="center">
 <tr nobr="true">
  <td colspan="5" align="center"><h3>Observaciones</h3></td></tr>
  <tr nobr="true">
  <td colspan="5" align="left">Cotizacion No.: $DatosRemision[Cotizaciones_idCotizaciones], $observaciones</td></tr>
  <tr nobr="true">
  <td colspan="4" align="rigth"><h3>SubTotal</h3></td><td>$$Subtotal</td></tr>
  <tr nobr="true"><td colspan="4" align="rigth"><h3>IVA</h3></td><td>$$IVA</td></tr>
  <tr nobr="true"><td colspan="4" align="rigth"><h3>Total</h3></td><td>$$Total</td>
 </tr>
 </table>
EOD;
$pdf->writeHTML($tbl, false, false, false, false, '');		
		
$tbl = <<<EOD
</br>
 
  <div id="wb_Text6" style="position:absolute;left:35px;top:150px;width:242px;height:18px;z-index:8;text-align:rigth;">
<span style="font-family:'Bookman Old Style';font-size:10px;"><strong><em>Realizado por: $DatosUsuario[Nombre] $DatosUsuario[Apellido]
</em></strong></span></div>
<div id="wb_Text6" style="position:absolute;left:35px;top:150px;width:242px;height:18px;z-index:8;text-align:left;">
<span style="font-family:'Bookman Old Style';font-size:10px;">Certifico que los equipos remisionados los he recibido en buen estado y funcionamiento por lo cual me hago responsable de los daños,
        faltantes especiales y perdidas que a su devolucion se presenten, así mismo exonero de toda responsabilidad al Sr. Oscar Jimenez G. por cualquier hecho o percance que se llegare a presentar durante el uso de los equipos.
        El transporte corre por cuenta del cliente, los equipos deben entregarse desarmados en la puerta de la obra.
</span></div><br><br>
<div id="wb_Text6" style="position:absolute;left:35px;top:150px;width:242px;height:18px;z-index:8;text-align:left;">
<span style="color:#000000;font-family:'Bookman Old Style';font-size:8px;">Cotización Generada por SOFTCONTECH V2.0, Software Diseñado por TECHNO SOLUCIONES, 317 774 0609, info@technosoluciones.com</div></span>
EOD;
$pdf->writeHTML($tbl, false, false, false, false, '');		
//Close and output PDF document
$pdf->Output($nombre_file.'.pdf', 'I');
//============================================================+
// END OF FILE
//============================================================+
?>