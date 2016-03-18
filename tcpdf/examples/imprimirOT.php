<?php
require_once('tcpdf_include.php');
//require_once('../../librerias/numerosletras.php');
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
$idOT = $_REQUEST["idOT"];
////////////////////////////////////////////
/////////////Obtengo valores de la Remision
////////////////////////////////////////////
			
$obVenta=new ProcesoVenta(1);
$DatosOT=$obVenta->DevuelveValores("ordenesdetrabajo","ID",$idOT);
$Fecha=$DatosOT["FechaOT"];
$Hora=$DatosOT["Hora"];
$Actividad=$DatosOT["Descripcion"];
$Clientes_idClientes=$DatosOT["idCliente"];
$Usuarios_idUsuarios=$DatosOT["idUsuarioCreador"];

////////////////////////////////////////////
/////////////Obtengo datos del cliente y centro de costos
////////////////////////////////////////////

$DatosCliente=$obVenta->DevuelveValores("clientes","idClientes",$Clientes_idClientes);
////////////////////////////////////////////
/////////////Obtengo datos del Usuario creador y de la empresa propietaria
////////////////////////////////////////////
$DatosUsuario=$obVenta->DevuelveValores("usuarios","idUsuarios",$Usuarios_idUsuarios);
$nombreUsuario=$DatosUsuario["Nombre"]." ".$DatosUsuario["Apellido"] ;
$DatosEmpresaPro=$obVenta->DevuelveValores("empresapro","idEmpresaPro",1);
$RazonSocialEP=$DatosEmpresaPro["RazonSocial"];
$DireccionEP=$DatosEmpresaPro["Direccion"];
$TelefonoEP=$DatosEmpresaPro["Celular"];
$CiudadEP=$DatosEmpresaPro["Ciudad"];
$NITEP=$DatosEmpresaPro["NIT"];
		  
$nombre_file="OT_".$Fecha."_".$DatosCliente["RazonSocial"];
		   
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Techno Soluciones SAS');
$pdf->SetTitle('OT TS');
$pdf->SetSubject('Ordenes de Trabajo');
$pdf->SetKeywords('Techno Soluciones, PDF, Ordenes trabajo, CCTV, Alarmas, Computadores, Software');
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, 60, PDF_HEADER_TITLE.'', "");

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(10, 35, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(10);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 10);

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
$txt="<h3>ORDEN DE TRABAJO $idOT</h3>";
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
        <td colspan="2"><strong>Fecha de la Orden de Trabajo:</strong></td>
        <td colspan="2"><strong>Hora:</strong></td>
    </tr>
    <tr>
        <td colspan="2">$Fecha</td>
        <td colspan="2">$Hora</td>
        
    </tr>
</table>
EOD;


$pdf->MultiCell(180, 25, $tbl, 0, 'C', 1, 0, '', '', true,0, true, true, 10, 'M');



////Descripcion de los Items En la OT

$pdf->writeHTML("<br>", true, false, false, false, '');
$tbl = <<<EOD
<table cellspacing="1" cellpadding="2" border="1">
    <tr>
        <td align="center" colspan="3" ><strong>Actividad</strong></td>
        <td align="center" ><strong>Fecha Inicio</strong></td>
        <td align="center" ><strong>Fecha Fin</strong></td>
        <td align="center" ><strong>Tiempo X Hora</strong></td>
        <td align="center" ><strong>Colaborador</strong></td>
        <td align="center" ><strong>Observaciones</strong></td>
        <td align="center" ><strong>Realizado</strong></td>
    </tr>
    
         
EOD;

$sql="SELECT * FROM ordenesdetrabajo_items WHERE idOT='$idOT'";
$Consulta=$obVenta->Query($sql);
   
while($DatosItemOT=mysql_fetch_array($Consulta)){
     
    $DatosColaborador=$obVenta->DevuelveValores("colaboradores", "idColaboradores", $DatosItemOT["idColaborador"]);
    $tbl .= <<<EOD
    
    <tr>
        <td align="left" colspan="3">$DatosItemOT[Actividad]</td>
        <td align="left" >$DatosItemOT[FechaInicio]</td>
        <td align="center" >$DatosItemOT[FechaFin]</td>
        <td align="center" >$DatosItemOT[TiempoEstimadoHoras]</td>
        <td align="right" >$DatosColaborador[Nombre]</td>
        <td align="right" >$DatosItemOT[Observaciones]</td>
        <td align="right" > </td>
    </tr>
    
     
    
        
EOD;
    
}

$tbl .= <<<EOD
        </table>
EOD;

$pdf->MultiCell(180, 170, $tbl, 0, 'C', 1, 0, '', '', true,0, true, true, 10, 'M');
$pdf->writeHTML("<br><br>", true, false, false, false, '');





$tbl = <<<EOD
<table cellspacing="1" cellpadding="2" border="1">
    <tr>
        <td colspan="4" height="50" align="left">Observaciones:</td> 
       
        
    </tr>
    <tr>
        <td colspan="2" height="50" align="center"><br/><br/><br/><br/><br/>Firma Colaborador</td> 
        <td colspan="2" height="50" align="center"><br/><br/><br/><br/><br/>Firma Cliente</td> 
        
    </tr>
     
</table>

        
EOD;

$pdf->MultiCell(180, 30, $tbl, 0, 'L', 1, 0, '', '', true,0, true, true, 10, 'M');

//Close and output PDF document
$pdf->Output($nombre_file.'.pdf', 'I');
//============================================================+
// END OF FILE
//============================================================+
?>