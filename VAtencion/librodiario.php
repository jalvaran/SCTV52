<?php
session_start();
if (!isset($_SESSION['username']))
{
  exit("No se ha iniciado una sesion <a href='../index.php' >Iniciar Sesion </a>");
  
}

////////// Paginacion
$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);

    	$limit = 10;
    	$startpoint = ($page * $limit) - $limit;
		
/////////


        
        
include_once ('funciones/function.php');  //En esta funcion está la paginacion

include_once("../modelo/php_tablas.php");  //Clases de donde se escribirán las tablas
include_once("Configuraciones/librodiario.ini.php");  //Clases de donde se escribirán las tablas
$obTabla = new Tabla($db);
$obVenta = new ProcesoVenta(1);

$statement = $obTabla->CreeFiltro($Vector);
//print($statement);
$Vector["statement"]=$statement;   //Filtro necesario para la paginacion


$obTabla->VerifiqueExport($Vector);

include_once("css_construct.php");
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
$css->CrearImageLink("../VMenu/Menu.php", "../images/librodiario.png", "_self",200,200);


////Paginacion
////
$Ruta="";
print("<div style='height: 50px;'>");   //Dentro de un DIV para no hacerlo tan grande
print(pagination($Ruta,$statement,$limit,$page));
print("</div>");
////
///Dibujo la tabla
////
///
/*
 * Verifico que haya balance
 */
$Consulta=$obVenta->Query("SELECT SUM(Neto) as Suma FROM $statement");
$Neto=$obVenta->FetchArray($Consulta);
$Neto=  number_format($Neto["Suma"]);
$css->CrearTabla();
$css->CrearFilaNotificacion("Debitos - Creditos = $Neto", 16);
$css->CerrarTabla();
$obTabla->DibujeTabla($Vector);
$css->CerrarDiv();//Cerramos contenedor Principal
$css->AgregaJS(); //Agregamos javascripts
//$css->AgregaSubir();    
////Fin HTML  
print("</body></html>");


?>