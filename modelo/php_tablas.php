<?php

include_once("php_conexion.php");

//////////////////////////////////////////////////////////////////////////
////////////Clase para guardar ventas ///////////////////////////////////
////////////////////////////////////////////////////////////////////////

class Tabla{
    private $DataBase;
    public $obCon;
    function __construct($db){
        $this->DataBase=$db;
        $this->obCon=new ProcesoVenta(1);
        
    }
       
////////////////////////////////////////////////////////////////////
//////////////////////Funcion devolver estructura de la tabla
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
    

  
    
// FIN Clases	
}


// FIN
?>
	