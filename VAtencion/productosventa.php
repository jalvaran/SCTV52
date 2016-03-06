<?php
session_start();
if (!isset($_SESSION['username']))
{
  exit("No se ha iniciado una sesion <a href='../index.php' >Iniciar Sesion </a>");
  
}

include_once("../modelo/php_tablas.php");
include_once("css_construct.php");
$obTabla=new Tabla($db);
$myTabla="productosventa";
$myPage="Devoluciones.php";
$myTitulo="Productos Venta";

print("<html>");
print("<head>");
$css =  new CssIni($myTitulo);
print("</head>");
print("<body>");
//Cabecera
$css->CabeceraIni($myTitulo); //Inicia la cabecera de la pagina
$css->CabeceraFin(); 

///Empiezo a dibujar la tabla
    $Vector["Tabla"]=$myTabla;
    $Columnas=$obTabla->Columnas($Vector); //Se debe disenar la base de datos colocando siempre la llave primaria de primera
    foreach($Columnas as $NombreCol){
        print($NombreCol);
        print("<br>");
    }

$css->AgregaJS(); //Agregamos javascripts
$css->AgregaSubir();    
////Fin HTML  
print("</body></html>");
?>