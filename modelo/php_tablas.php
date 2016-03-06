<?php

include_once("php_conexion.php");
include_once("../VAtencion/css_construct.php");
//////////////////////////////////////////////////////////////////////////
////////////Clase para guardar ventas ///////////////////////////////////
////////////////////////////////////////////////////////////////////////

class Tabla{
    private $DataBase;
    public $obCon;
    public $css;
    function __construct($db){
        $this->DataBase=$db;
        $this->obCon=new ProcesoVenta(1);
        $this->css=new CssIni("");;
    }
       
////////////////////////////////////////////////////////////////////
//////////////////////Funcion devolver los nombres de las columnas de una tabla
///////////////////////////////////////////////////////////////////
    
public function Columnas($Vetor)
  {
    
    $Tabla=$Vetor["Tabla"];
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
//////////////////////Funcion para crear una tabla con los datos de una tabla
///////////////////////////////////////////////////////////////////
    
public function DibujeTabla($Vector)
  {
    
    $Tabla["Tabla"]=$Vector["Tabla"];
    $tbl=$Tabla["Tabla"];
    $Titulo=$Vector["Titulo"];
    $VerDesde=$Vector["VerDesde"];
    $Limit=$Vector["Limit"];
    $statement=$Vector["statement"];
    
    $Columnas=$this->Columnas($Tabla); //Se debe disenar la base de datos colocando siempre la llave primaria de primera
    
    $NumCols=count($Columnas);
    $this->css->CrearFormularioEvento("FrmFiltros", "$Tabla[Tabla]".".php", "post", "_self", "");
    $ColFiltro=$NumCols-1;
    $this->css->CrearTabla();
    $this->css->FilaTabla(18);
    print("<td ><strong>$Titulo </strong>");
    print("</td>");
    print("<td style='text-align: center' colspan=$ColFiltro>");
    $this->css->CrearBotonVerde("BtnFiltrar", "Filtrar");
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
                    
                    $this->css->CrearOptionSelect("1", " =", 1);
                    $this->css->CrearOptionSelect("2", " *", 0);
                    $this->css->CrearOptionSelect("3", " >", 0);
                    $this->css->CrearOptionSelect("4", " <", 0);
                    $this->css->CrearOptionSelect("5", ">=", 0);
                    $this->css->CrearOptionSelect("6", "<=", 0);
                    $this->css->CrearOptionSelect("7", "<>", 0);
                $this->css->CerrarSelect();
                $this->css->CrearInputText("Fitro_".$NombreCol, "Text", "", "", "Filtrar", "black", "", "", $Ancho, 30, 0, 0);
                
                print("</td>");
                $VisualizarRegistro[$i]=1;
            }
            if(isset($Vector[$NombreCol]["Vinculo"])){
                $VinculoRegistro[$i]["Vinculado"]=1;
                $VinculoRegistro[$i]["TablaVinculo"]=$Vector[$NombreCol]["TablaVinculo"];
                $VinculoRegistro[$i]["IDTabla"]=$Vector[$NombreCol]["IDTabla"];
                
                $VinculoRegistro[$i]["Display"]=$Vector[$NombreCol]["Display"];
            }
            $i++;
            
        }
        
        $this->css->CierraFilaTabla();
        
        $sql="SELECT * FROM $statement LIMIT $VerDesde,$Limit";
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
    return($sql);
}
  
    
// FIN Clases	
}


// FIN
?>
	