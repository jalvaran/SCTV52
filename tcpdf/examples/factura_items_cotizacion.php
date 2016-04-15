<?php
/*
 * Archivo con la informacion de una factura generada desde remisiones
 * 
 */

$pdf->writeHTML("<br>", true, false, false, false, '');
$tbl = <<<EOD
<table cellspacing="1" cellpadding="2" border="1">
    <tr>
        <td align="center" ><strong>Referencia</strong></td>
        <td align="center" colspan="3"><strong>Producto o Servicio</strong></td>
        <td align="center" ><strong>Precio Unitario</strong></td>
        <td align="center" ><strong>Cantidad</strong></td>
        <td align="center" ><strong>Valor Total</strong></td>
    </tr>
    
         
EOD;

$sql="SELECT fi.Dias, fi.Referencia, fi.Nombre, fi.ValorUnitarioItem, fi.Cantidad, fi.SubtotalItem"
        . " FROM facturas_items fi WHERE fi.idFactura='$idFactura'";
$Consulta=$obVenta->Query($sql);
   
while($DatosItemFactura=mysql_fetch_array($Consulta)){
    $ValorUnitario=  number_format($DatosItemFactura["ValorUnitarioItem"]);
    $SubTotalItem=  number_format($DatosItemFactura["SubtotalItem"]);
    $Multiplicador=$DatosItemFactura["Dias"];
    if($DatosItemFactura["Dias"]>1){
        $Multiplicador="$DatosItemFactura[Cantidad] X $DatosItemFactura[Dias]";
    }
    $tbl .= <<<EOD
    
    <tr>
        <td align="left" >$DatosItemFactura[Referencia]</td>
        <td align="left" colspan="3">$DatosItemFactura[Nombre]</td>
        <td align="right" >$ValorUnitario</td>
        <td align="center" >$Multiplicador</td>
        <td align="right" >$SubTotalItem</td>
    </tr>
    
     
    
        
EOD;
    
}

$tbl .= <<<EOD
        </table>
EOD;

$pdf->MultiCell(180, 170, $tbl, 0, 'C', 1, 0, '', '', true,0, true, true, 10, 'M');
$pdf->writeHTML("<br><br>", true, false, false, false, '');

?>