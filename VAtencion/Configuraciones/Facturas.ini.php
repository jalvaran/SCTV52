<?php

$myTabla="facturas";
$MyID="idFacturas";
$myPage="facturas.php";
$myTitulo="Facturas";



/////Asigno Datos necesarios para la visualizacion de la tabla en el formato que se desea
////
///
//print($statement);
$Vector["Tabla"]=$myTabla;          //Tabla
$Vector["Titulo"]=$myTitulo;        //Titulo
$Vector["VerDesde"]=$startpoint;    //Punto desde donde empieza
$Vector["Limit"]=$limit;            //Numero de Registros a mostrar

/*
 * Opciones en Acciones
 * 
 */

$Vector["NuevoRegistro"]["Deshabilitado"]=1;            
//$Vector["VerRegistro"]["Deshabilitado"]=1;                      
$Vector["EditarRegistro"]["Deshabilitado"]=1; 

//Link para la accion ver
$Ruta="../tcpdf/examples/imprimirFactura.php?ImgPrintFactura=";
$Vector["VerRegistro"]["Link"]=$Ruta;
$Vector["VerRegistro"]["ColumnaLink"]="idFacturas";
/*
 * 
 * Selecciono las Columnas que tendran valores de otras tablas
 */


$Vector["CentroCosto"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["CentroCosto"]["TablaVinculo"]="centrocosto";  //tabla de donde se vincula
$Vector["CentroCosto"]["IDTabla"]="ID"; //id de la tabla que se vincula
$Vector["CentroCosto"]["Display"]="Nombre"; 
$Vector["CentroCosto"]["Predeterminado"]=1;

$Vector["EmpresaPro_idEmpresaPro"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["EmpresaPro_idEmpresaPro"]["TablaVinculo"]="empresapro";  //tabla de donde se vincula
$Vector["EmpresaPro_idEmpresaPro"]["IDTabla"]="idEmpresaPro"; //id de la tabla que se vincula
$Vector["EmpresaPro_idEmpresaPro"]["Display"]="RazonSocial"; 
$Vector["EmpresaPro_idEmpresaPro"]["Predeterminado"]=1;
///Filtros y orden
$Vector["Order"]=" $MyID DESC ";   //Orden
?>