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

$obTabla = new Tabla($db);
$obVenta = new ProcesoVenta(1);
$myTabla="productosventa";
$myPage="Devoluciones.php";
$myTitulo="Productos Venta";
$Vector["Tabla"]=$myTabla;
$statement = $obTabla->CreeFiltro($Vector);

/////Asigno Datos necesarios para la visualizacion de la tabla en el formato que se desea
////
///
//print($statement);
$Vector["Tabla"]=$myTabla;          //Tabla
$Vector["Titulo"]=$myTitulo;        //Titulo
$Vector["VerDesde"]=$startpoint;    //Punto desde donde empieza
$Vector["Limit"]=$limit;            //Numero de Registros a mostrar

///Columnas excluidas
//
//
$Vector["Excluir"]["ImagenesProductos_idImagenesProductos"]=1;   //Indico que esta columna tendra un vinculo
//
//
//Selecciono las Columnas que tendran valores de otras tablas
//
//
$Vector["CodigoBarras"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["CodigoBarras"]["TablaVinculo"]="prod_codbarras";  //tabla de donde se vincula
$Vector["CodigoBarras"]["IDTabla"]="ProductosVenta_idProductosVenta"; //id de la tabla que se vincula
$Vector["CodigoBarras"]["Display"]="CodigoBarras";                    //Columna que quiero mostrar

$Vector["Bodega_idBodega"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Bodega_idBodega"]["TablaVinculo"]="bodega";  //tabla de donde se vincula
$Vector["Bodega_idBodega"]["IDTabla"]="idBodega"; //id de la tabla que se vincula
$Vector["Bodega_idBodega"]["Display"]="Nombre";                    //Columna que quiero mostrar

$Vector["Departamento"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Departamento"]["TablaVinculo"]="prod_departamentos";  //tabla de donde se vincula
$Vector["Departamento"]["IDTabla"]="idDepartamentos"; //id de la tabla que se vincula
$Vector["Departamento"]["Display"]="Nombre";                    //Columna que quiero mostrar

$Vector["Sub1"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Sub1"]["TablaVinculo"]="prod_sub1";  //tabla de donde se vincula
$Vector["Sub1"]["IDTabla"]="idSub1"; //id de la tabla que se vincula
$Vector["Sub1"]["Display"]="NombreSub1";                    //Columna que quiero mostrar

$Vector["Sub2"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Sub2"]["TablaVinculo"]="prod_sub2";  //tabla de donde se vincula
$Vector["Sub2"]["IDTabla"]="idSub2"; //id de la tabla que se vincula
$Vector["Sub2"]["Display"]="NombreSub2";                    //Columna que quiero mostrar

$Vector["Sub3"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Sub3"]["TablaVinculo"]="prod_sub3";  //tabla de donde se vincula
$Vector["Sub3"]["IDTabla"]="idSub3"; //id de la tabla que se vincula
$Vector["Sub3"]["Display"]="NombreSub3";                    //Columna que quiero mostrar

$Vector["Sub4"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Sub4"]["TablaVinculo"]="prod_sub4";  //tabla de donde se vincula
$Vector["Sub4"]["IDTabla"]="idSub4"; //id de la tabla que se vincula
$Vector["Sub4"]["Display"]="NombreSub4";                    //Columna que quiero mostrar
//
$Vector["Sub5"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Sub5"]["TablaVinculo"]="prod_sub5";  //tabla de donde se vincula
$Vector["Sub5"]["IDTabla"]="idSub5"; //id de la tabla que se vincula
$Vector["Sub5"]["Display"]="NombreSub5";                    //Columna que quiero mostrar
///Filtros y orden

$Vector["statement"]=$statement;   //Filtro necesario para la paginacion

$Vector["Order"]=" idProductosVenta DESC ";   //Orden
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
$css->CrearImageLink("../VMenu/Menu.php", "../images/productos.png", "_self",200,200);


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

$obTabla->DibujeTabla($Vector);


$css->CerrarDiv();//Cerramos contenedor Principal

$css->AgregaJS(); //Agregamos javascripts
$css->AgregaSubir();    
////Fin HTML  
///Verifico si hay peticiones para exportar
///
///

print("</body></html>");


?>