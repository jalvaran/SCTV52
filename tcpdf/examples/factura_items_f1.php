<?php
$pdf->writeHTML("<br>", true, false, false, false, '');
$tbl = <<<EOD
<table cellspacing="1" cellpadding="2" border="1">
    <tr>
        <td align="center" ><strong>Referencia</strong></td>
        <td align="center" colspan="3"><strong>Producto o Servicio</strong></td>
        <td align="center" ><strong>Cantidad</strong></td>
        <td align="center" ><strong>Dias</strong></td>
        <td align="center" ><strong>Precio Unitario</strong></td>
        <td align="center" ><strong>Valor Total</strong></td>
    </tr>
    
         
EOD;

$sql="SELECT fi.Referencia, fi.Nombre, fi.ValorUnitarioItem, fi.Cantidad, fi.Dias, fi.SubtotalItem"
        . " FROM facturas_items fi WHERE fi.idFactura='$idFactura'";
$Consulta=$obVenta->Query($sql);
   
while($DatosItemFactura=mysql_fetch_array($Consulta)){
    $ValorUnitario=  number_format($DatosItemFactura["ValorUnitarioItem"]);
    $SubTotalItem=  number_format($DatosItemFactura["SubtotalItem"]);
      
    $tbl .= <<<EOD
    
    <tr>
        <td align="left" >$DatosItemFactura[Referencia]</td>
        <td align="left" colspan="3">$DatosItemFactura[Nombre]</td>
        <td align="center" >$DatosItemFactura[Cantidad]</td>
        <td align="center" >$DatosItemFactura[Dias]</td>
        <td align="right" >$ValorUnitario</td>
        <td align="right" >$SubTotalItem</td>
    </tr>
    
     
    
        
EOD;
    
}

$tbl .= <<<EOD
        </table>
EOD;

$pdf->MultiCell(180, 160, $tbl, 0, 'C', 1, 0, '', '', true,0, true, true, 10, 'M');

?>