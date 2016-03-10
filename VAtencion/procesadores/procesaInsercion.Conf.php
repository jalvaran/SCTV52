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

?>
