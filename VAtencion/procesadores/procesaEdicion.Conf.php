<?php
/*
 * Parametros de configuracion productosventa
 * Columnas Excluidas
 */
$TablaConfig="productosventa";
$VarEdit[$TablaConfig]["CodigoBarras"]["Excluir"]=1;
$VarEdit[$TablaConfig]["Existencias"]["Excluir"]=1;
$VarEdit[$TablaConfig]["Referencia"]["Excluir"]=1;
$VarEdit[$TablaConfig]["Especial"]["Excluir"]=1;
$VarEdit[$TablaConfig]["ImagenesProductos_idImagenesProductos"]["Excluir"]=1;


/*
 * Parametros de configuracion Tabla facturas_items
 * Columnas Excluidas
 */

$TablaConfig="facturas_items";
$VarEdit[$TablaConfig]["SubGrupo1"]["Excluir"]=1;
$VarEdit[$TablaConfig]["SubGrupo2"]["Excluir"]=1;
$VarEdit[$TablaConfig]["SubGrupo3"]["Excluir"]=1;
$VarEdit[$TablaConfig]["SubGrupo4"]["Excluir"]=1;
$VarEdit[$TablaConfig]["SubGrupo5"]["Excluir"]=1;
$VarEdit[$TablaConfig]["SubtotalItem"]["Excluir"]=1;
$VarEdit[$TablaConfig]["IVAItem"]["Excluir"]=1;
$VarEdit[$TablaConfig]["TotalItem"]["Excluir"]=1;
$VarEdit[$TablaConfig]["PorcentajeIVA"]["Excluir"]=1;
$VarEdit[$TablaConfig]["PrecioCostoUnitario"]["Excluir"]=1;
$VarEdit[$TablaConfig]["SubtotalCosto"]["Excluir"]=1;
$VarEdit[$TablaConfig]["TipoItem"]["Excluir"]=1;
$VarEdit[$TablaConfig]["CuentaPUC"]["Excluir"]=1;
$VarEdit[$TablaConfig]["GeneradoDesde"]["Excluir"]=1;
$VarEdit[$TablaConfig]["NumeroIdentificador"]["Excluir"]=1;
$VarEdit[$TablaConfig]["FechaFactura"]["Excluir"]=1;
$VarEdit[$TablaConfig]["idFactura"]["Excluir"]=1;
$VarEdit[$TablaConfig]["TablaItems"]["Excluir"]=1;
$VarEdit[$TablaConfig]["Referencia"]["Excluir"]=1;
$VarEdit[$TablaConfig]["Departamento"]["Excluir"]=1;
$VarEdit[$TablaConfig]["ValorUnitarioItem"]["Excluir"]=1;
$VarEdit[$TablaConfig]["Cantidad"]["Excluir"]=1;

/*
 * Campos Requridos
 */

$VarEdit[$TablaConfig]["Dias"]["Required"]=1;


?>