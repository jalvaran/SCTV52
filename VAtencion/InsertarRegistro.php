<?php

/* Desarrollado por Julian Alvaran, Techno Soluciones SAS
 * Este archivo se encargará de insertar un registro nuevo a una tabla
 * 
 */
$Parametros = json_decode(urldecode($_REQUEST['TxtParametros']));  //Decodifico el Vector y llega como un objeto

$myPage="InsertarRegistro.php";
$myTitulo="Nuevo Registro En ".$Parametros->Titulo;


echo ("<pre>");
print_r($Parametros);
print($Parametros->CodigoBarras->TablaVinculo);
echo ("</pre>");

include_once("../modelo/php_tablas.php");  //Clases de donde se escribirán las tablas
include_once("css_construct.php");
$obTabla = new Tabla($db);
$obVenta = new ProcesoVenta(1);
print("<html>");
print("<head>");

$css =  new CssIni($myTitulo);
print("</head>");
print("<body>");
//Cabecera
$css->CabeceraIni($myTitulo); //Inicia la cabecera de la pagina
$css->CabeceraFin(); 

///////////////Creamos el contenedor
    /////
    /////
$css->CrearDiv("principal", "container", "center",1,1);
//print($statement);
///////////////Creamos la imagen representativa de la pagina
    /////
    /////	
$css->CrearImageLink("../VMenu/Menu.php", "../images/agregar.png", "_self",200,200);
$obTabla->FormularioInsertRegistro($Parametros);

$css->CerrarDiv();//Cerramos contenedor Principal

$css->AgregaJS(); //Agregamos javascripts
$css->AgregaSubir();    
////Fin HTML  
///Verifico si hay peticiones para exportar
///
///

print("</body></html>");



?>