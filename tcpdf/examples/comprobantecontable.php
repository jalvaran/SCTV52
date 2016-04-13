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
/////////////Obtengo el ID del comprobante a que se imprimirá 
////////////////////////////////////////////
$idComprobante = $_REQUEST["idComprobante"];
////////////////////////////////////////////
/////////////Obtengo valores de la Remision
////////////////////////////////////////////
			
$obVenta=new ProcesoVenta(1);
$DatosGenerales=$obVenta->DevuelveValores("comprobantes_contabilidad","ID",$idComprobante);
$DatosComprobante=$obVenta->DevuelveValores("comprobantes_contabilidad_items","idComprobante",$idComprobante);
$DatosCentroCostos=$obVenta->DevuelveValores("centrocosto","ID",$DatosComprobante["CentroCostos"]);
$DatosEmpresaPro=$obVenta->DevuelveValores("empresapro","idEmpresaPro",$DatosCentroCostos["EmpresaPro"]);
$fecha=$DatosGenerales["Fecha"];
$Concepto=$DatosGenerales["Concepto"];
$Usuarios_idUsuarios=$DatosGenerales["Usuarios_idUsuarios"];

		  
$nombre_file=$idComprobante."_Comprobante_Contabilidad_".$fecha;
		   
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
$pdf->SetTitle('Comprobante Contabilidad TS');
$pdf->SetSubject('Comprobante Contabilidad');
$pdf->SetKeywords('Techno Soluciones, PDF, Ingresos, CCTV, Alarmas, Computadores, Software');
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
$pdf->SetFont('helvetica', '', 9);
///////////////////////////////////////////////////////
//////////////encabezado//////////////////
////////////////////////////////////////////////////////
$tbl = <<<EOD
<hr id="Line1" style="margin:0;padding:0;position:absolute;left:0px;top:44px;width:625px;height:2px;z-index:1;">
<div id="wb_Text5" style="position:absolute;left:334px;top:127px;width:335px;height:18px;z-index:7;text-align:left;">
<span style="color:#000000;font-family:'Bookman Old Style';font-size:13px;">Buga $fecha</span></div>
<div id="wb_Text1" style="position:absolute;left:380px;top:72px;width:150px;height:16px;text-align:rigth;z-index:2;">
<span style="font-family:'Bookman Old Style';font-size:13px;"><strong><em>COMPROBANTE DE CONTABILIDAD No. $idComprobante
</em></strong></span></div>
</div>
EOD;
$pdf->writeHTML($tbl, false, false, false, false, '');
/////////////////Datos del Comprobante
//
//
//

$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2" align="left" style="border-radius: 10px;">
    <tr>
        <td><strong>Ciudad:</strong> $DatosEmpresaPro[Ciudad]</td>
        <td><strong>Fecha:</strong> $fecha</td>
        <td><strong>No.:</strong> $idComprobante</td>
    </tr>
    <tr>
        <td colspan="3"><strong>Razon Social de la Empresa:</strong> $DatosEmpresaPro[RazonSocial] $DatosEmpresaPro[NIT]</td>
        
    </tr>
    <tr>
        <td colspan="3"><strong>Concepto:</strong> $Concepto</td>
        
    </tr>
    
</table>
        
<br>
<hr id="Line3" style="margin:0;padding:0;position:absolute;left:0px;top:219px;width:625px;height:2px;z-index:9;">
  
EOD;
$pdf->writeHTML($tbl, false, false, false, false, '');

////////////////////////////////////////
///Dibujo movientos contables

$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2" align="left" style="border-radius: 10px;">
    <tr align="center">
        <td><strong>Codigo PUC</strong></td>
        <td><strong>Cuenta</strong></td>
        <td><strong>Débitos</strong></td>
        <td><strong>Créditos</strong></td>
    </tr>
    
</table>
       
  
EOD;
$pdf->writeHTML($tbl, false, false, false, false, '');


$Consulta=$obVenta->ConsultarTabla("librodiario", "WHERE Tipo_Documento_Intero='COMPROBANTE CONTABLE' AND Num_Documento_Interno='$idComprobante'");
$TotalDebitos=0;
$TotalCreditos=0;
while($DatosLibro=  mysql_fetch_array($Consulta)){
    $TotalDebitos=$TotalDebitos+$DatosLibro["Debito"];
    $TotalCreditos=$TotalCreditos+$DatosLibro["Credito"];
    $Debito=  number_format($DatosLibro["Debito"]);
    $Credito=  number_format($DatosLibro["Credito"]);
$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2" align="left" style="border-radius: 10px;">
    <tr align="left">
        <td>$DatosLibro[CuentaPUC]</td>
        <td>$DatosLibro[NombreCuenta]</td>
        <td>$Debito</td>
        <td>$Credito</td>
    </tr>
    
</table>
       
  
EOD;
$pdf->writeHTML($tbl, false, false, false, false, '');
}

///////////
///////Espacio para firmas
//
//
$TotalDebitos= number_format($TotalDebitos);
$TotalCreditos= number_format($TotalCreditos);
$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="2" align="left">
    <tr align="left" >
    <td colspan="2" align="center"><strong>TOTALES: </strong></td>  
    <td align="center"><strong>$TotalDebitos</strong></td> 
    <td align="center"><strong>$TotalCreditos</strong></td>  
    </tr>    
    <tr align="left" >
        <td style="height: 100px;" >Preparado:</td>
        <td style="height: 100px;" >Revisado:</td>
        <td style="height: 100px;" >Aprobado:</td>
        <td style="height: 100px;" >Contabilizado:</td>
    </tr>
   
</table>
       
  
EOD;
$pdf->writeHTML($tbl, false, false, false, false, '');

//Close and output PDF document
$pdf->Output($nombre_file.'.pdf', 'I');
//============================================================+
// END OF FILE
//============================================================+
?>