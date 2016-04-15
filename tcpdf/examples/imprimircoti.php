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

$IDCoti = $_REQUEST["ImgPrintCoti"];

////////////////////////////////////////////
/////////////Obtengo valores de la cotizacion
////////////////////////////////////////////
			
		$obVenta=new ProcesoVenta(1);
		
		
		  $SubTotal=number_format($obVenta->SumeColumna("cot_itemscotizaciones","Subtotal", "NumCotizacion",$IDCoti));
		  $IVACoti=number_format($obVenta->SumeColumna("cot_itemscotizaciones","IVA", "NumCotizacion",$IDCoti));
		  $Total=number_format($obVenta->SumeColumna("cot_itemscotizaciones","Total", "NumCotizacion",$IDCoti));
		  $DatosCotizacion=$obVenta->DevuelveValores("cotizacionesv5","ID",$IDCoti);
		  $fecha=$DatosCotizacion["Fecha"];
		  $observaciones=$DatosCotizacion["Observaciones"];
		  $Clientes_idClientes=$DatosCotizacion["Clientes_idClientes"];
		  $Usuarios_idUsuarios=$DatosCotizacion["Usuarios_idUsuarios"];
		  
////////////////////////////////////////////
/////////////Obtengo datos del cliente
////////////////////////////////////////////

		  		  
		  $registros2=$obVenta->DevuelveValores("clientes","idClientes",$Clientes_idClientes);
		  $nombre=$registros2["RazonSocial"];
		  $direccion=$registros2["Direccion"];
		  $telefono=$registros2["Telefono"];
		  $email=$registros2["Email"];
		  $ciudad=$registros2["Ciudad"];
		  $contacto=$registros2["Contacto"];
		  $TelContacto=$registros2["TelContacto"];
		  $nit=$registros2["Num_Identificacion"];
		  
	////////////////////////////////////////////
/////////////Obtengo datos del Usuario creador
////////////////////////////////////////////

		  		  
		  $registros2=$obVenta->DevuelveValores("usuarios","idUsuarios",$Usuarios_idUsuarios);
		  $nombreUsuario=$registros2["Nombre"];
		  $ApellidoUsuario=$registros2["Apellido"];
		   
		  $registros2=$obVenta->DevuelveValores("empresapro","idEmpresaPro",1);
		  
		  $RazonSocialEP=$registros2["RazonSocial"];
		  $DireccionEP=$registros2["Direccion"];
		  $TelefonoEP=$registros2["Celular"];
		  $CiudadEP=$registros2["Ciudad"];
		  $NITEP=$registros2["NIT"];
		  
		  $nombre_file=$fecha."_".$nombre;
		   
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
$pdf->SetTitle('Cotizacion TS');
$pdf->SetSubject('Cotizacion');
$pdf->SetKeywords('Techno Soluciones, PDF, cotizacion, CCTV, Alarmas, Computadores');

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
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
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
<div id="wb_Text1" style="position:absolute;left:380px;top:72px;width:150px;height:10px;text-align:center;z-index:2;">

</em></strong></span><br><span style="color:#00008B;font-family:'Bookman Old Style';font-size:14px;"><em>$RazonSocialEP
</em><br></span>
<span style="color:#00008B;font-family:'Bookman Old Style';font-size:11px;"><strong><em>$NITEP
</em></strong></span><br>
<span style="color:#00008B;font-family:'Bookman Old Style';font-size:11px;"><strong><em>$DireccionEP
</em></strong></span><br><span style="color:#00008B;font-family:'Bookman Old Style';font-size:11px;"><strong><em>$CiudadEP
</em></strong></span><br>

</div>

<div id="wb_Text5" style="position:absolute;left:334px;top:127px;width:335px;height:18px;z-index:7;text-align:left;">
<span style="color:#000000;font-family:'Bookman Old Style';font-size:13px;">$ciudad $fecha</span></div>
<div id="wb_Text1" style="position:absolute;left:380px;top:72px;width:150px;height:16px;text-align:rigth;z-index:2;">
<span style="color:#00008B;font-family:'Bookman Old Style';font-size:13px;"><strong><em>COTIZACION No. $IDCoti
</em></strong></span></div>
<div id="wb_Text2" style="position:absolute;left:37px;top:106px;width:150px;height:16px;z-index:4;text-align:left;">
<span style="color:#000000;font-family:'Bookman Old Style';font-size:13px;"><strong><em>Señores:</em></strong></span></div>
<div id="wb_Text2" style="position:absolute;left:37px;top:106px;width:150px;height:16px;z-index:4;text-align:left;">
<span style="color:#000000;font-family:'Bookman Old Style';font-size:13px;"><strong><em>$nombre</em></strong></span></div>
<div id="wb_Text4" style="position:absolute;left:41px;top:110px;width:368px;height:18px;z-index:6;text-align:left;">
<span style="color:#000000;font-family:'Bookman Old Style';font-size:13px;">Atn. $contacto</span></div>
<div id="wb_Text3" style="position:absolute;left:326px;top:109px;width:150px;height:16px;z-index:5;text-align:left;">
<span style="color:#000000;font-family:'Bookman Old Style';font-size:13px;">$TelContacto</span></div>
<div id="container">
<div id="wb_Text12" style="position:absolute;left:34px;top:184px;width:579px;height:16px;z-index:0;text-align:left;">
<span style="color:#000000;font-family:'Bookman Old Style';font-size:13px;"><strong><em>Techno Soluciones S.A.S. tiene el agrado de presentarle la siguiente propuesta económica:</em></strong></span></div>

<hr id="Line3" style="margin:0;padding:0;position:absolute;left:0px;top:219px;width:625px;height:2px;z-index:9;">
</div>


EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');


// NON-BREAKING ROWS (nobr="true")

$tbl = <<<EOD


<table border="1" cellpadding="2" cellspacing="2" align="center">
  

 <tr nobr="true">
  <th><h3>Ref</h3></th><th colspan="3"><h3>Descripción</h3></th>
  <th ><h3>Valor Unitario</h3></th><th><h3>Cantidad</h3></th><th><h3>Total</h3></th>
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');

////////////////////////////////////////////////////////
 
		  $Consulta=$obVenta->ConsultarTabla("cot_itemscotizaciones","WHERE NumCotizacion='$IDCoti'");
		
	    while($registros2=mysql_fetch_array($Consulta)){
		 
		    
			$registros2["Total"]=number_format($registros2["Total"]);
			$registros2["Subtotal"]=number_format(round($registros2["Subtotal"]));	
			$registros2["ValorUnitario"]=number_format(round($registros2["ValorUnitario"]));
                        $Cantidad=$registros2["Cantidad"];
			if($registros2["Multiplicador"]>1){
                            $Cantidad="$registros2[Cantidad] X $registros2[Multiplicador]";
                        }
			
$tbl = <<<EOD

<table border="1" cellpadding="2" cellspacing="2" align="center">
 <tr nobr="true">
  <td>$registros2[Referencia]</td><td colspan="3">$registros2[Descripcion]</td>
  <td>$$registros2[ValorUnitario]</td><td>$Cantidad</td><td>$$registros2[Subtotal]</td>
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');
			
		  
}

$tbl = <<<EOD

<table border="1" cellpadding="2" cellspacing="2" align="center">
 <tr nobr="true">
  <td colspan="5" align="center"><h3>Observaciones</h3></td></tr>
  <tr nobr="true">
  <td colspan="5" align="left">$observaciones</td></tr>
  <tr nobr="true">
  <td colspan="4" align="rigth"><h3>SubTotal</h3></td><td>$$SubTotal</td></tr>
  <tr nobr="true"><td colspan="4" align="rigth"><h3>IVA</h3></td><td>$$IVACoti</td></tr>
  <tr nobr="true"><td colspan="4" align="rigth"><h3>Total</h3></td><td>$$Total</td>
 </tr>
 </table>
EOD;

$pdf->writeHTML($tbl, false, false, false, false, '');		
		
$tbl = <<<EOD
</br>
 
  <div id="wb_Text6" style="position:absolute;left:35px;top:150px;width:242px;height:18px;z-index:8;text-align:rigth;">
<span style="color:#00008B;font-family:'Bookman Old Style';font-size:10px;"><strong><em>Realizado por: $nombreUsuario $ApellidoUsuario
</em></strong></span></div>

<div id="wb_Text6" style="position:absolute;left:35px;top:150px;width:242px;height:18px;z-index:8;text-align:left;">
<span style="color:#00008B;font-family:'Bookman Old Style';font-size:10px;"><strong><em>Ésta cotización tiene vigencia de 30 días y está sujeta a disponibilidad de equipos y cambios sin previo aviso
</em></strong></span></div><br><br>

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