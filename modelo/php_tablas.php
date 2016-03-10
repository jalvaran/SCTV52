<?php

include_once("php_conexion.php");

/*
 * Esta clase contiene los datos necesarios para tratar y dibujar las tablas
 * 
 */

class Tabla{
    public $DataBase;
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
    
public function Columnas($Vector){
    
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
   
/*
 *Funcion devolver todas los atributos de las columnas de una tablas
 */
    
public function ColumnasInfo($Vector){
    
    $Tabla=$Vector["Tabla"];
    $sql="SHOW COLUMNS FROM `$this->DataBase`.`$Tabla`;";
    $Results=$this->obCon->Query($sql);
    $i=0;
    while($Columnas = $this->obCon->FetchArray($Results) ){
        $Nombres["Field"][$i]=$Columnas["Field"];
        $Nombres["Type"][$i]=$Columnas["Type"];
        $Nombres["Null"][$i]=$Columnas["Null"];
        $Nombres["Key"][$i]=$Columnas["Key"];
        $Nombres["Default"][$i]=$Columnas["Default"];
        $Nombres["Extra"][$i]=$Columnas["Extra"];
        $i++;
        
    }
    return($Nombres);
}


/*
 *Funcion devolver el ultimo autoincremento
 */
    
public function ObtengaAutoIncrement($Vector){
    
    $Tabla=$Vector["Tabla"];
    $sql="SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA='$this->DataBase' and TABLE_NAME='$Tabla'";
    $Results=$this->obCon->Query($sql);
    $Results=$this->obCon->FetchArray($Results);
    return($Results["AUTO_INCREMENT"]);
}


/*
 *Funcion devolver un ID Unico
 */
    
public function ObtengaID(){
    
    $ID=date("YmdHis").microtime(false);
    return($ID);
}

/*
 * Funcion arme filtros
 */
    
public function CreeFiltro($Vector){
       
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
/*
 * 
 * Funcion para crear una tabla con los datos de una tabla
 * 
 */
  
public function DibujeTabla($Vector){
    //print_r($Vector);
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
    if(!isset($Vector["NuevoRegistro"]["Deshabilitado"])){
        $this->css->CrearFormularioEvento("FrmAgregar", "InsertarRegistro.php", "post", "_self", "");
        $this->css->CrearInputText("TxtParametros", "hidden", "", urlencode(json_encode($Vector)), "", "", "", "", "", "", "", "");
        $this->css->CrearBotonNaranja("BtnAgregar", "Agregar Nuevo Registro");
        $this->css->CerrarForm();
    }
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
        $this->css->ColTabla("<strong>Acciones</strong>","");
        foreach($Columnas as $NombreCol){
            
            if(!isset($Vector["Excluir"][$NombreCol])){
                
                print("<td><strong>$NombreCol</strong><br>");
                $Ancho=strlen($NombreCol)."0";
                if($Ancho<50){
                    $Ancho=50;
                }
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
                print("<br>");
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
        $Parametros=urlencode(json_encode($Vector));
        while($DatosProducto=$this->obCon->FetchArray($Consulta)){
            $this->css->FilaTabla(12);
            print("<td>");
            if(!isset($Vector["VerRegistro"]["Deshabilitado"])){
                $Ruta="";
                if(isset($Vector["VerRegistro"]["Link"]) and isset($Vector["VerRegistro"]["ColumnaLink"])){
                    $Ruta=$Vector["VerRegistro"]["Link"];
                    $ColumnaLink=$Vector["VerRegistro"]["ColumnaLink"];
                    $Ruta.=$DatosProducto[$ColumnaLink];
                }
                
                $this->css->CrearLink($Ruta,"_blank", "Ver // ");
            }
            if(!isset($Vector["EditarRegistro"]["Deshabilitado"])){
                $Ruta="EditarRegistro.php?&TxtIdEdit=$DatosProducto[0]&TxtParametros=$Parametros";
                $this->css->CrearLink($Ruta, "_self", "Editar // ");
            }
            print("</td>");
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
 
/*
 * Verificamos si hay peticiones de exportacion
 */
    
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

/*
 * 
 * Funcion para crear un formulario para crear un nuevo registro en una tabla
 * 
 */

    
public function FormularioInsertRegistro($Parametros,$VarInsert)  {
    //print_r($Vector);
    $this->css=new CssIni("");
    $Tabla["Tabla"]=$Parametros->Tabla;
    $tbl=$Tabla["Tabla"];
    $Titulo=$Parametros->Titulo;
    
    $Columnas=$this->Columnas($Tabla); //Se debe disenar la base de datos colocando siempre la llave primaria de primera
    $ColumnasInfo=$this->ColumnasInfo($Tabla); //Se debe disenar la base de datos colocando siempre la llave primaria de primera
    
    $myPage="$Tabla[Tabla]".".php";
    $NumCols=count($Columnas);
    
    $this->css->CrearFormularioEvento("FrmGuardarRegistro", "procesadores/procesaInsercion.php", "post", "_self", "");
    $this->css->CrearInputText("TxtTablaInsert", "hidden", "", $tbl, "", "", "", "", "", "", "", "");
    $this->css->CrearTabla();
    $this->css->FilaTabla(18);
    print("<td style='text-align: center'><strong>$Titulo</strong>");
    print("</td>");
    $this->css->CierraFilaTabla();
    
    
    $i=0;
        
    foreach($Columnas as $NombreCol){
        $this->css->FilaTabla(14);
        $excluir=0;
        
        if(isset($VarInsert[$tbl][$NombreCol]["Excluir"])){
            $excluir=1;
        }
        $TipoText="text";
        if(isset($VarInsert[$tbl][$NombreCol]["TipoText"])){
            $TipoText=$VarInsert[$tbl][$NombreCol]["TipoText"];
        }
        if(!$excluir){  //Si la columna no está excluida
           $lengCampo=preg_replace('/[^0-9]+/', '', $ColumnasInfo["Type"][$i]); //Determinamos la longitud del campo
           if($lengCampo<1){
               $lengCampo=45;
           }
           if($ColumnasInfo["Type"][$i]=="text"){
               $lengCampo=100;
           }
           $Value=$ColumnasInfo["Default"][$i];
           
           if($ColumnasInfo["Key"][$i]=="PRI"){ //Verificamos si la llave es primaria
                $ReadOnly=1;
                
                if(!$ColumnasInfo["Extra"][$i]=="auto_increment"){ //Verificamos si tiene auto increment
                    $Value = $this->ObtengaID(); //Obtiene un timestamp para crear un id unico
                }
           }else{
                $ReadOnly=0;
           }
           $Required=0;
           if(isset($VarInsert[$tbl][$NombreCol]["Required"])){
               $Required=1;
           }
            
            print("<td style='text-align: center'>");
            
            print($NombreCol."<br>");
            if(property_exists($Parametros,$NombreCol)){
                $Display=$Parametros->$NombreCol->Display;
                $IDTabla=$Parametros->$NombreCol->IDTabla;
                $TablaVinculo=$Parametros->$NombreCol->TablaVinculo;
                if($Display<>"CodigoBarras"){
                    $sql="SELECT * FROM $TablaVinculo";
                    //print($sql);
                    $Consulta=$this->obCon->Query($sql);
                    $VectorSel["Nombre"]="$NombreCol";
                    $VectorSel["Evento"]="";
                    $VectorSel["Funcion"]="";
                    $VectorSel["Required"]=$Required;
                    $this->css->CrearSelect2($VectorSel);
                    $this->css->CrearOptionSelect("", "Seleccione Una Opcion", 0);
                    while($Opciones=$this->obCon->FetchArray($Consulta)){
                        $pre=0;
                        if($Parametros->$NombreCol->Predeterminado==$Opciones[$IDTabla]){
                            $pre=1;
                        }
                        $this->css->CrearOptionSelect($Opciones[$IDTabla], $Opciones[$IDTabla]."-".$Opciones[$Display]."-".$Opciones[2], $pre);              
                    }
                    $this->css->CerrarSelect(); 
                }else{
                  
                    $this->css->CrearInputText("$NombreCol", $TipoText, "", "", "$NombreCol", "black", "", "", $lengCampo."0", 30, 1, $Required);
                              
                }
            }else{
                if($lengCampo<100){

                    $this->css->CrearInputText("$NombreCol", $TipoText, "", $Value, "$NombreCol", "black", "", "", $lengCampo."0", 30, $ReadOnly, $Required);
                }else{
                    $this->css->CrearTextArea("$NombreCol", "", $Value, "", "$NombreCol", "black", "", "","100",$lengCampo."0", $ReadOnly, 1);
                }
            }
                print("<td></tr>");    

        }

        $i++;
    }
    $this->css->FilaTabla(18);
    print("<td style='text-align: center'>");
    $this->css->CrearBotonConfirmado("BtnGuardarRegistro", "Guardar Registro"); 
    print("</td>");
    $this->css->CierraFilaTabla();
    $this->css->CerrarTabla();
    $this->css->CerrarForm();    
    //return($sql);
}

/*
 * 
 * Funcion para crear un formulario de edicion de un registro
 * 
 */

    
public function FormularioEditarRegistro($Parametros,$VarEdit)  {
    //print_r($Vector);
    $this->css=new CssIni("");
    $Tabla["Tabla"]=$Parametros->Tabla;
    $tbl=$Tabla["Tabla"];
    $Titulo=$Parametros->Titulo;
    $IDEdit=$VarEdit["ID"];
    
    $Columnas=$this->Columnas($Tabla); //Se debe disenar la base de datos colocando siempre la llave primaria de primera
    $ColumnasInfo=$this->ColumnasInfo($Tabla); //Se debe disenar la base de datos colocando siempre la llave primaria de primera
    
    $myPage="$Tabla[Tabla]".".php";
    $NumCols=count($Columnas);
    
    $this->css->CrearFormularioEvento("FrmGuardarRegistro", "procesadores/procesaEdicion.php", "post", "_self", "");
    $this->css->CrearInputText("TxtTablaEdit", "hidden", "", $tbl, "", "", "", "", "", "", "", "");
    $this->css->CrearInputText("TxtIDEdit", "hidden", "", $IDEdit, "", "", "", "", "", "", "", "");
    $this->css->CrearTabla();
    $this->css->FilaTabla(18);
    print("<td style='text-align: center'><strong>$Titulo</strong>");
    print("</td>");
    $this->css->CierraFilaTabla();
    
    
    $i=0;
       
    foreach($Columnas as $NombreCol){
        $this->css->FilaTabla(14);
        $excluir=0;
        $TipoText="text";
        if(isset($VarEdit[$tbl][$NombreCol]["TipoText"])){
            $TipoText=$VarEdit[$tbl][$NombreCol]["TipoText"];
        }
        if(isset($VarEdit[$tbl][$NombreCol]["Excluir"])){
            $excluir=1;
        }
        if(!$excluir){  //Si la columna no está excluida
           $lengCampo=preg_replace('/[^0-9]+/', '', $ColumnasInfo["Type"][$i]); //Determinamos la longitud del campo
           if($lengCampo<1){
               $lengCampo=45;
           }
           if($ColumnasInfo["Type"][$i]=="text"){
               $lengCampo=100;
           }
           $ColID=$Columnas[0];
           $Condicion=" $ColID='$IDEdit'";
           $SelColumnas=$NombreCol;
           $DatosRegistro =  $this->obCon->ValorActual($tbl, $SelColumnas, $Condicion);
           $Value=$DatosRegistro[$NombreCol];
           if($ColumnasInfo["Key"][$i]=="PRI"){ //Verificamos si la llave es primaria
                $ReadOnly=1;
                
                
           }else{
                $ReadOnly=0;
           }
           $Required=0;
           if(isset($VarEdit[$tbl][$NombreCol]["Required"])){
               $Required=1;
           }
            
            print("<td style='text-align: center'>");
            
            print($NombreCol."<br>");
            if(property_exists($Parametros,$NombreCol)){
                $Display=$Parametros->$NombreCol->Display;
                $IDTabla=$Parametros->$NombreCol->IDTabla;
                $TablaVinculo=$Parametros->$NombreCol->TablaVinculo;
                
                $sql="SELECT * FROM $TablaVinculo";

                $Consulta=$this->obCon->Query($sql);
                $VectorSel["Nombre"]="$NombreCol";
                $VectorSel["Evento"]="";
                $VectorSel["Funcion"]="";
                $VectorSel["Required"]=$Required;
                $this->css->CrearSelect2($VectorSel);
                $this->css->CrearOptionSelect("", "Seleccione Una Opcion", 0);
                while($Opciones=$this->obCon->FetchArray($Consulta)){
                    $pre=0;
                    if($Value==$Opciones[$IDTabla]){
                        $pre=1;
                    }
                    $this->css->CrearOptionSelect($Opciones[$IDTabla], $Opciones[$IDTabla]."-".$Opciones[$Display]."-".$Opciones[2], $pre);              
                }
                $this->css->CerrarSelect(); 
                
            }else{
                if($lengCampo<100){

                    $this->css->CrearInputText("$NombreCol", $TipoText, "", $Value, "$NombreCol", "black", "", "", $lengCampo."0", 30, $ReadOnly, $Required);
                }else{
                    $this->css->CrearTextArea("$NombreCol", "", $Value, "", "$NombreCol", "black", "", "","100",$lengCampo."0", $ReadOnly, 1);
                }
            }
                print("<td></tr>");    

        }

        $i++;
    }
    $this->css->FilaTabla(18);
    print("<td style='text-align: center'>");
    $this->css->CrearBotonConfirmado("BtnEditarRegistro", "Editar Registro"); 
    print("</td>");
    $this->css->CierraFilaTabla();
    $this->css->CerrarTabla();
    $this->css->CerrarForm();    
    //return($sql);
}



// FIN Clases	
}

?>