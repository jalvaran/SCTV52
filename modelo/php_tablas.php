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
                    
                    $this->css->CrearOptionSelect("1", " =", 1);
                    $this->css->CrearOptionSelect("2", " *", 0);
                    $this->css->CrearOptionSelect("3", " >", 0);
                    $this->css->CrearOptionSelect("4", " <", 0);
                    $this->css->CrearOptionSelect("5", ">=", 0);
                    $this->css->CrearOptionSelect("6", "<=", 0);
                    $this->css->CrearOptionSelect("7", "<>", 0);
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
    
public function VerifiqueExport($Vector)
  {
    if(isset($_REQUEST["BtnExportarExcel"])){
        //include("conexion.php");

$con=mysql_connect("localhost","root","pirlo1985") or die("problemas con el servidor");
 mysql_select_db("softcontech_v4",$con) or die("la base de datos no abre");
 
 $sql = "SELECT cli.RazonSocial as RazonSocial, cli.Num_Identificacion as NIT, c.Descripcion as Descripcion, c.Referencia as Referencia, 
 c.Cantidad as Cantidad, c.Subtotal as Subtotal, c.IVA as IVA, c.Total as Total, 
 c.SubtotalCosto as SubtotalCosto, fac.Fecha as Fecha, fac.SaldoFact as Saldo, fac.idFacturas as Factura, cli.Telefono as Telefono
 FROM ventas_separados vs INNER JOIN Facturas fac ON vs.Facturas_idFacturas =fac.idFacturas 
 INNER JOIN Cotizaciones c ON fac.Cotizaciones_idCotizaciones=c.NumCotizacion 
 INNER JOIN clientes cli ON cli.idClientes =fac.Clientes_idClientes 
 WHERE vs.Retirado='NO' ORDER BY fac.idFacturas DESC";          
 $resultado = mysql_query ($sql, $con) or die (mysql_error());
 $registros = mysql_num_rows ($resultado);
 
 
   
   
   if ($registros > 0) {
   require_once '../librerias/Excel/PHPExcel.php';
   $objPHPExcel = new PHPExcel();
    
   //Informacion del excel
   $objPHPExcel->
    getProperties()
        ->setCreator("www.technosoluciones.com")
        ->setLastModifiedBy("www.technosoluciones.com")
        ->setTitle("Exportar tabla separados desde base de datos")
        ->setSubject("ventas_separados")
        ->setDescription("Documento generado con PHPExcel")
        ->setKeywords("techno soluciones")
        ->setCategory("ventas_separados");    
 
 $i = 1;
 
 $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i,'Producto');              
	  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$i, 'Referencia'  );	
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C'.$i, 'Cantidad');	
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('D'.$i, 'Subtotal' );	
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('E'.$i, 'IVA');	
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('F'.$i, 'Total' );
			
			$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('G'.$i, 'Costo');	
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('H'.$i, 'Fecha');	

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('I'.$i, 'Factura');	

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('J'.$i, 'Saldo');	

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('K'.$i, 'Cliente');	

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('L'.$i, 'NIT');

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('M'.$i, 'TELEFONO');			
 
   $i = 2;    
   while ($registro = mysql_fetch_object ($resultado)) {
        		
      $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $registro->Descripcion);
	  $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$i, $registro->Referencia);	
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C'.$i, $registro->Cantidad);	
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('D'.$i, $registro->Subtotal);	
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('E'.$i, $registro->IVA);	
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('F'.$i, $registro->Total);
			
			$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('G'.$i, $registro->SubtotalCosto);	
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('H'.$i, $registro->Fecha);	
			
			$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('I'.$i, $registro->Factura);	
			
			$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('J'.$i, $registro->Saldo);	
			
			$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('K'.$i, $registro->RazonSocial);	
			
			$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('L'.$i, $registro->NIT);	

			$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('M'.$i, $registro->Telefono);	

			
      $i++;
       
   }
}
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Separados.xls"');
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