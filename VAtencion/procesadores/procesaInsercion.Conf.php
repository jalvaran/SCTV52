<?php

/*
 * Tabla productos venta
 * Columnas excluidas
 */
$TablaConfig="productosventa";
$VarInsert[$TablaConfig]["CodigoBarras"]["Excluir"]=1;
$VarInsert[$TablaConfig]["Existencias"]["Excluir"]=1;
$VarInsert[$TablaConfig]["Referencia"]["Excluir"]=1;
$VarInsert[$TablaConfig]["idProductosVenta"]["Excluir"]=1;
$VarInsert[$TablaConfig]["CostoTotal"]["Excluir"]=1;
$VarInsert[$TablaConfig]["ImagenesProductos_idImagenesProductos"]["Excluir"]=1;

/*
 * Tabla Usuarios
 * Tipo de Texto
 */
$TablaConfig="usuarios";
$VarInsert[$TablaConfig]["Password"]["TipoText"]="password";


/*
 * Tabla Usuarios
 * Tipo de librodiario
 * Campos Requridos
 */
$TablaConfig="librodiario";
$VarInsert[$TablaConfig]["idEmpresa"]["Required"]=1;
$VarInsert[$TablaConfig]["idCentroCosto"]["Required"]=1;



/*
 * Tabla subcuentas
 * Columnas excluidas
 */
$TablaConfig="subcuentas";
$VarInsert[$TablaConfig]["Valor"]["Excluir"]=1;

/*
 * Parametros de configuracion subcuentas
 * Columnas Excluidas
 */
$TablaConfig="cuentasfrecuentes";
$VarInsert[$TablaConfig]["ClaseCuenta"]["Required"]=1;
$VarInsert[$TablaConfig]["UsoFuturo"]["Excluir"]=1;

?>
