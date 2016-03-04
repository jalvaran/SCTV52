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
$idFactura = $_REQUEST["ImgPrintFactura"];
////////////////////////////////////////////
/////////////Obtengo valores de la Remision
////////////////////////////////////////////
			
$obVenta=new ProcesoVenta(1);
$DatosFactura=$obVenta->DevuelveValores("facturas","idFacturas",$idFactura);
$Fecha=$DatosFactura["Fecha"];
$Hora=$DatosFactura["Hora"];
$observaciones=$DatosFactura["ObservacionesFact"];
$Clientes_idClientes=$DatosFactura["Clientes_idClientes"];
$Usuarios_idUsuarios=$DatosFactura["Usuarios_idUsuarios"];

////////////////////////////////////////////
/////////////Obtengo datos del cliente y centro de costos
////////////////////////////////////////////
$DatosCentroCostos=$obVenta->DevuelveValores("centrocosto","ID",$DatosFactura["CentroCosto"]);

$DatosCliente=$obVenta->DevuelveValores("clientes","idClientes",$Clientes_idClientes);
////////////////////////////////////////////
/////////////Obtengo datos del Usuario creador y de la empresa propietaria
////////////////////////////////////////////
$DatosUsuario=$obVenta->DevuelveValores("usuarios","idUsuarios",$Usuarios_idUsuarios);
$nombreUsuario=$DatosUsuario["Nombre"];
$ApellidoUsuario=$DatosUsuario["Apellido"];
$DatosEmpresaPro=$obVenta->DevuelveValores("empresapro","idEmpresaPro",$DatosCentroCostos["EmpresaPro"]);
$RazonSocialEP=$DatosEmpresaPro["RazonSocial"];
$DireccionEP=$DatosEmpresaPro["Direccion"];
$TelefonoEP=$DatosEmpresaPro["Celular"];
$CiudadEP=$DatosEmpresaPro["Ciudad"];
$NITEP=$DatosEmpresaPro["NIT"];
		  
$nombre_file="Factura_".$DatosFactura["Fecha"]."_".$DatosCliente["RazonSocial"];
		   
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
		//$this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
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
$pdf->SetTitle('Facturas TS');
$pdf->SetSubject('Facturas');
$pdf->SetKeywords('Techno Soluciones, PDF, Facturas, CCTV, Alarmas, Computadores, Software');
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(10, 10, 10);
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
//////
//////
$pdf->SetFillColor(255, 255, 255);

$txt="<h3>".$DatosEmpresaPro["RazonSocial"]."<br>NIT ".$DatosEmpresaPro["NIT"]."</h3>";
$pdf->MultiCell(60, 5, $txt, 0, 'L', 1, 0, '', '', true,0, true, true, 10, 'M');
$txt=$DatosEmpresaPro["Direccion"]."<br>".$DatosEmpresaPro["Telefono"]."<br>".$DatosEmpresaPro["Ciudad"]."<br>".$DatosEmpresaPro["WEB"];
$pdf->MultiCell(60, 5, $txt, 0, 'C', 1, 0, '', '', true,0, true, true, 10, 'M');
$txt="<h3>FACTURA DE VENTA ".$DatosFactura["Prefijo"]." - ".$DatosFactura["NumeroFactura"]."<h3>";
$txt.="<br><h5>Impreso por SOFTCONTECH, Techno Soluciones SAS <BR>NIT 900.833.180 3177740609</h5>";
$pdf->MultiCell(60, 5, $txt, 0, 'R', 1, 0, '', '', true,0, true ,true, 10, 'M');

////Datos del Cliente
////
////
$pdf->writeHTML("<br><br><br>", true, false, false, false, '');
$tbl = <<<EOD
<table cellspacing="1" cellpadding="2" border="1">
    <tr>
        <td><strong>Cliente:</strong></td>
        <td colspan="3">$DatosCliente[RazonSocial]</td>
        
    </tr>
    <tr>
    	<td><strong>NIT:</strong></td>
        <td colspan="3">$DatosCliente[Num_Identificacion] - $DatosCliente[DV]</td>
    </tr>
    <tr>
        <td colspan="2"><strong>Dirección:</strong></td>
        <td><strong>Ciudad:</strong></td>
        <td><strong>Teléfono:</strong></td>
    </tr>
    <tr>
        <td colspan="2">$DatosCliente[Direccion]</td>
        <td>$DatosCliente[Ciudad]</td>
        <td>$DatosCliente[Telefono]</td>
    </tr>
    <tr>
        <td colspan="2"><strong>Fecha de Facturación:</strong></td>
        <td colspan="2"><strong>Hora:</strong></td>
    </tr>
    <tr>
        <td colspan="2">$DatosFactura[Fecha]</td>
        <td colspan="2">$DatosFactura[Hora]</td>
        
    </tr>
</table>
EOD;


$pdf->MultiCell(90, 25, $tbl, 0, 'L', 1, 0, '', '', true,0, true, true, 10, 'M');


////Informacion legal y resolucion DIAN
////
////

$tbl = <<<EOD
<table cellspacing="1" cellpadding="2" border="1">
    <tr>
        <td height="53" align="center" >$DatosEmpresaPro[ResolucionDian]</td> 
    </tr>
     
</table>
<table cellspacing="1" cellpadding="2" border="1">
    <tr>
        <td align="center" ><strong>Vendedor</strong></td>
        <td align="center" ><strong>Forma de Pago</strong></td>
    </tr>
    <tr>
        <td align="center" >$nombreUsuario $ApellidoUsuario</td>
        <td align="center" >$DatosFactura[FormaPago]</td>
    </tr>
     
</table>
        
EOD;

$pdf->MultiCell(90, 25, $tbl, 0, 'R', 1, 0, '', '', true,0, true, true, 10, 'M');


////Descripcion de los Items Facturados
////
////
$pdf->writeHTML("<br>", true, false, false, false, '');
$tbl = <<<EOD
<table cellspacing="1" cellpadding="2" border="1">
    <tr>
        <td align="center" ><strong>Vendedor</strong></td>
        <td align="center" ><strong>Forma de Pago</strong></td>
    </tr>
    <tr>
        <td align="center" >$nombreUsuario $ApellidoUsuario</td>
        <td align="center" >$DatosFactura[FormaPago]</td>
    </tr>
     
</table>
        
EOD;

$pdf->MultiCell(180, 200, $tbl, 1, 'C', 1, 0, '', '', true,0, true, true, 10, 'M');

//Close and output PDF document
$pdf->Output($nombre_file.'.pdf', 'I');
//============================================================+
// END OF FILE
//============================================================+
?>