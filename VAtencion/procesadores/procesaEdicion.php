<?php
/* 
 * Este archivo se encarga de escuchar las peticiones para editar un registro
 */

if(!empty($_REQUEST["BtnEditarRegistro"])){
    include_once("../../modelo/php_tablas.php");  //Clases de donde se escribirán las tablas
    
    $obTabla = new Tabla($db);
    $obVenta = new ProcesoVenta(1);
    $tab=$_REQUEST["TxtTablaEdit"];
    $IDEdit=$_REQUEST["TxtIDEdit"];
    $Vector["Tabla"]=$tab;
    $NombresColumnas=$obTabla->Columnas($Vector);
    $sql="UPDATE $tab SET ";
    $NumCols=Count($NombresColumnas);
    $i=1;
    foreach($NombresColumnas as $NombreCol){
        if(isset($_REQUEST[$NombreCol]) && !empty($_REQUEST[$NombreCol])){
           
           if($NumCols==$i){
               $sql.=" $NombreCol = '$_REQUEST[$NombreCol]'";
           }else{
               $sql.=" $NombreCol = '$_REQUEST[$NombreCol]' , ";
           }
           
        }
       $i++;
    }
    $sql.=" WHERE $NombresColumnas[0] ='$IDEdit'";
    $obVenta->Query($sql);
    header("location:../$tab.php");
}


?>
