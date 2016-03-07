<?php

include_once("php_conexion.php");

/*
 * Esta clase contiene los datos necesarios para tratar y dibujar las tablas
 * 
 */

class Tabla{
    private $DataBase;
    public $obCon;
    public $css;
    /*
     * Se utilizará para seleccionar las columnas de la exportacion a excel
     */
    public $Campos = array("A","B","C","D","E","F","G","H","I","J","K","L",
    "M","N","O","P","Q","R","S","T","C","V","W","X","Y","Z","AA","AB");
    public $Condicionales = array(" ","=","*",">","<",">=","<=","<>");
    function __construct($db){
        $this->DataBase=$db;
        $this->obCon=new ProcesoVenta(1);
        //$this->css=new CssIni("");
    }
   
    
/*
 *Funcion devolver los nombres de las columnas de una tabla
 */
    
public function Columnas($Vector)
  {
    
    $Tabla=$Vector["Tabla"];
    $sql="SHOW COLUMNS FROM `$this->DataBase`.`$Tabla`;";
    $Results=$this->obCon->Query($sql);
    $i=0;
    while($Columnas = $this->obCon->FetchArray($Results) ){
        $Nombres[$i]=$Columnas["Field"];
        $i++;
        
    }
    return($Nombres);
}
    

////////////////////////////////////////////////////////////////////
//////////////////////Funcion arme filtros
///////////////////////////////////////////////////////////////////
    
public function CreeFiltro($Vector)
  {
       
    $Columnas=$this->Columnas($Vector);
    $Tabla=$Vector["Tabla"];
    $Filtro=" $Tabla";
    $z=0;
    
    $NumCols=count($Columnas);
    foreach($Columnas as $NombreCol){
        $IndexFiltro="Filtro_".$NombreCol;  //Campo que trae el valor del filtro a aplicar
        $IndexCondicion="Cond_".$NombreCol; // Condicional para aplicacion del filtro
        $IndexTablaVinculo="TablaVinculo_".$NombreCol; // Si hay campos vinculados se encontra la tabla vinculada aqui 
        $IndexIDTabla="IDTabla_".$NombreCol;           // Id de la tabla vinculada
        $IndexDisplay="Display_".$NombreCol;           // Campo que se quiere ver
        if(!empty($_REQUEST[$IndexFiltro])){
            $Valor=$_REQUEST[$IndexFiltro];
            if(!empty($_REQUEST[$IndexTablaVinculo])){
                $sql="SELECT $_REQUEST[$IndexIDTabla] FROM $_REQUEST[$IndexTablaVinculo] "
                        . "WHERE $_REQUEST[$IndexDisplay] = '$Valor'";
                $DatosVinculados=$this->obCon->Query($sql);
                $DatosVinculados=$this->obCon->FetchArray($DatosVinculados);
                //print($sql);
                $Valor=$DatosVinculados[$_REQUEST[$IndexIDTabla]];
            }
            
            if($z==0){
                $Filtro.=" WHERE ";
                $z=1;
            }
            $Filtro.=$NombreCol;
            switch ($_REQUEST[$IndexCondicion]){
                case 1:
                    $Filtro.="='$Valor'";
                    break;
                case 2:
                    $Filtro.=" LIKE '%$Valor%'";
                    break;
                case 3:
                    $Filtro.=">'$Valor'";
                    break;
                case 4:
                    $Filtro.="<'$Valor'";
                    break;
                case 5:
                    $Filtro.=">='$Valor'";
                    break;
                case 6:
                    $Filtro.="<='$Valor'";
                    break;
                case 7:
                    $Filtro.="<>'$Valor'";
                    break;
            }
            $And=" AND ";
            
            
            $Filtro.=$And;
           
        }
       
    }
    if($z>0){
        $Filtro=substr($Filtro, 0, -4);
    }
    return($Filtro);
}
////////////////////////////////////////////////////////////////////
//////////////////////Funcion para crear una tabla con los datos de una tabla
///////////////////////////////////////////////////////////////////
    
public function DibujeTabla($Vector)
  {
    $this->css=new CssIni("");
    $Tabla["Tabla"]=$Vector["Tabla"];
    $tbl=$Tabla["Tabla"];
    $Titulo=$Vector["Titulo"];
    $VerDesde=$Vector["VerDesde"];
    $Limit=$Vector["Limit"];
    $Order=$Vector["Order"];
    $statement=$Vector["statement"];
    
    $Columnas=$this->Columnas($Tabla); //Se debe disenar la base de datos colocando siempre la llave primaria de primera
    $myPage="$Tabla[Tabla]".".php";
    $NumCols=count($Columnas);
    $this->css->CrearFormularioEvento("FrmFiltros", "$Tabla[Tabla]".".php", "post", "_self", "");
    $this->css->CrearInputText("TxtSql", "hidden", "", $statement, "", "", "", "", "", "", "", "");
    $ColFiltro=$NumCols-1;
    $this->css->CrearTabla();
    $this->css->FilaTabla(18);
    print("<td ><strong>$Titulo </strong>");
    print("</td>");
    print("<td style='text-align: left' colspan=$ColFiltro>");
    $this->css->CrearLink("","_self","Limpiar ");
    $this->css->CrearBotonVerde("BtnFiltrar", "Filtrar");
    $this->css->CrearBoton("BtnExportarExcel", "Exportar a Excel");
    print("</td>");
    $this->css->CierraFilaTabla();
        $this->css->FilaTabla(14);
        $i=0;
        
        foreach($Columnas as $NombreCol){
            
            if(!isset($Vector["Excluir"][$NombreCol])){
                print("<td><strong>$NombreCol</strong><br>");
                $Ancho=strlen($NombreCol)."0";
                $DatosSel["Nombre"]="Cond_".$NombreCol;
                $DatosSel["Evento"]="";
                $DatosSel["Ancho"]=50;
                $DatosSel["Alto"]=30;
                $this->css->CrearSelectPers($DatosSel);
                    $IndexCondicion="Cond_".$NombreCol; // Condicional para aplicacion del filtro
                    $Activo=0;
                    for($h=1;$h<=7;$h++){
                        if(isset($_REQUEST[$IndexCondicion])){
                            if($_REQUEST[$IndexCondicion]==$h){
                               $Activo=1; 
                            }else{
                               $Activo=0; 
                            }
                              
                        }
                        
                       $this->css->CrearOptionSelect($h, $this->Condicionales[$h], $Activo);
                    }
                $this->css->CerrarSelect();
                $ValorFiltro="";
                if(!empty($_REQUEST["Filtro_".$NombreCol])){
                    $ValorFiltro=$_REQUEST["Filtro_".$NombreCol];
                }
                $this->css->CrearInputText("Filtro_".$NombreCol, "Text", "", $ValorFiltro, "Filtrar", "black", "", "", $Ancho, 30, 0, 0);
                
                print("</td>");
                $VisualizarRegistro[$i]=1;
            }
            if(isset($Vector[$NombreCol]["Vinculo"])){
                $VinculoRegistro[$i]["Vinculado"]=1;
                $VinculoRegistro[$i]["TablaVinculo"]=$Vector[$NombreCol]["TablaVinculo"];
                $VinculoRegistro[$i]["IDTabla"]=$Vector[$NombreCol]["IDTabla"];  
                $VinculoRegistro[$i]["Display"]=$Vector[$NombreCol]["Display"];
                $this->css->CrearInputText("TablaVinculo_".$NombreCol, "hidden", "", $Vector[$NombreCol]["TablaVinculo"], "", "black", "", "", $Ancho, 30, 0, 0);
                $this->css->CrearInputText("IDTabla_".$NombreCol, "hidden", "", $Vector[$NombreCol]["IDTabla"], "", "black", "", "", $Ancho, 30, 0, 0);
                $this->css->CrearInputText("Display_".$NombreCol, "hidden", "", $Vector[$NombreCol]["Display"], "", "black", "", "", $Ancho, 30, 0, 0);
            }
            $i++;
            
        }
        
        $this->css->CierraFilaTabla();
        
        $sql="SELECT * FROM $statement ORDER BY $Order LIMIT $VerDesde,$Limit ";
        $Consulta=  $this->obCon->Query($sql);
        while($DatosProducto=$this->obCon->FetchArray($Consulta)){
            $this->css->FilaTabla(12);
            for($i=0;$i<$NumCols;$i++){
                if(isset($VisualizarRegistro[$i])){
                    if(!isset($VinculoRegistro[$i]["Vinculado"])){
                        print("<td>$DatosProducto[$i]</td>");
                    }else{
                        $TablaVinculo=$VinculoRegistro[$i]["TablaVinculo"];
                        $ColDisplay=$VinculoRegistro[$i]["Display"];
                        $idTablaVinculo=$VinculoRegistro[$i]["IDTabla"];
                        $ID=$DatosProducto[$i];
                        //print("datos: $TablaVinculo $ColDisplay $idTablaVinculo $ID");                    
                        $sql1="SELECT $ColDisplay FROM $TablaVinculo WHERE $idTablaVinculo='$ID'";
                        $Consul=$this->obCon->Query($sql1);
                        $DatosVinculo=$this->obCon->FetchArray($Consul);
                        print("<td>$DatosVinculo[$ColDisplay]</td>");
                    }
                }
            }
            print("</tr>");
        }
        $this->css->CierraFilaTabla();
    $this->css->CerrarTabla();
    $this->css->CerrarForm();
    
    //return($sql);
}
 
////////////////////////////////////////////////////////////////////
//////////////////////Verificamos si hay peticiones de exportacion
///////////////////////////////////////////////////////////////////
    
public function VerifiqueExport($Vector)  {
    
    if(isset($_REQUEST["BtnExportarExcel"])){
       $statement=$_REQUEST["TxtSql"];
    require_once '../librerias/Excel/PHPExcel.php';
   $objPHPExcel = new PHPExcel();    
        
   $Tabla["Tabla"]=$Vector["Tabla"];
    $tbl=$Tabla["Tabla"];
    $Titulo=$Vector["Titulo"];
    $VerDesde=$Vector["VerDesde"];
    $Limit=$Vector["Limit"];
    $Order=$Vector["Order"];
    
    $tbl=$Vector["Tabla"];
    $Columnas=$this->Columnas($Tabla); //Se debe disenar la base de datos colocando siempre la llave primaria de primera
   
    $i=0;
 $a=0;
 foreach($Columnas as $NombreCol){ 
     if(!isset($Vector["Excluir"][$NombreCol])){
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($this->Campos[$a]."1",$NombreCol);
        $VisualizarRegistro[$i]=1;
        $a++;	
     }
     if(isset($Vector[$NombreCol]["Vinculo"])){
                $VinculoRegistro[$i]["Vinculado"]=1;
                $VinculoRegistro[$i]["TablaVinculo"]=$Vector[$NombreCol]["TablaVinculo"];
                $VinculoRegistro[$i]["IDTabla"]=$Vector[$NombreCol]["IDTabla"];  
                $VinculoRegistro[$i]["Display"]=$Vector[$NombreCol]["Display"];
     }
     $i++;
 }
    
    
   $IndexFiltro="Filtro_".$NombreCol;  //Campo que trae el valor del filtro a aplicar
    $IndexCondicion="Cond_".$NombreCol; // Condicional para aplicacion del filtro
    $IndexTablaVinculo="TablaVinculo_".$NombreCol; // Si hay campos vinculados se encontra la tabla vinculada aqui 
    $IndexIDTabla="IDTabla_".$NombreCol;           // Id de la tabla vinculada
    $IndexDisplay="Display_".$NombreCol;           // Campo que se quiere ver
        
   
    
   //Informacion del excel
   $objPHPExcel->
    getProperties()
        ->setCreator("www.technosoluciones.com")
        ->setLastModifiedBy("www.technosoluciones.com")
        ->setTitle("Exportar $tbl  desde base de datos")
        ->setSubject("$tbl")
        ->setDescription("Documento generado con PHPExcel")
        ->setKeywords("techno soluciones")
        ->setCategory("$tbl");    
 $NumCols=count($Columnas);
 
 
 $i=0;
 $a=0;
 $c=2;
 $sql="SELECT * FROM $statement ";
        $Consulta=  $this->obCon->Query($sql);
        while($DatosTabla=mysql_fetch_object($Consulta)){
            foreach($Columnas as $NombreCol){
                if(isset($VisualizarRegistro[$i])){
                    if(!isset($VinculoRegistro[$i]["Vinculado"])){
                        $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue($this->Campos[$a].$c,$DatosTabla->$NombreCol);
                    }else{
                        $TablaVinculo=$VinculoRegistro[$i]["TablaVinculo"];
                        $ColDisplay=$VinculoRegistro[$i]["Display"];
                        $idTablaVinculo=$VinculoRegistro[$i]["IDTabla"];
                        $ID=$DatosTabla->$NombreCol;
                        //print("datos: $TablaVinculo $ColDisplay $idTablaVinculo $ID");                    
                        $sql1="SELECT $ColDisplay  FROM $TablaVinculo WHERE $idTablaVinculo ='$ID'";
                        $Consul=$this->obCon->Query($sql1);
                        $DatosVinculo=  mysql_fetch_array($Consul);
                        $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue($this->Campos[$a].$c,$DatosVinculo[$ColDisplay]);
                    }
                    $a++;
                    
                }
                
                $i++;
                if($i==$NumCols){
                    $i=0;
                    $c++;
                    $a=0;
                }
            }
        }
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$tbl.'.xls"');
header('Cache-Control: max-age=0');
 
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
$objWriter->save('php://output');
exit; 
   
}

    
}


    
// FIN Clases	
}


// FIN
 
?>