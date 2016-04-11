<?php 
session_start();
include_once("../modelo/php_tablas.php");
include_once("css_construct.php");
if (!isset($_SESSION['username']))
{
  exit("No se ha iniciado una sesion <a href='../index.php' >Iniciar Sesion </a>");
  
}
$idComprobante=0;
if(isset($_REQUEST["idComprobante"])){
    $idComprobante=$_REQUEST["idComprobante"];
}
$NombreUser=$_SESSION['nombre'];
$idUser=$_SESSION['idUser'];	

print("<html>");
print("<head>");
$css =  new CssIni("Egresos");

print("</head>");
print("<body>");
    $obVenta = new ProcesoVenta($idUser);
    $obTabla = new Tabla($db);
    include_once("procesadores/ProcesaComprobanteContable.php");
    $myPage="CreaComprobanteCont.php";
    $css->CabeceraIni("Comprobantes de Contabilidad"); //Inicia la cabecera de la pagina
    $css->CreaBotonDesplegable("CrearComprobante","Nuevo");  
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
    
    
    
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
     /////////////////Cuadro de dialogo de Clientes create
    $css->CrearCuadroDeDialogo("CrearComprobante","Crear un Comprobante"); 
        $css->CrearForm2("FrmCreaPreMovimiento", $myPage, "post", "_self");
        $css->CrearTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Fecha</strong>", 1);
            $css->ColTabla("<strong>Detalle</strong>", 1);
            $css->ColTabla("<strong>Crear</strong>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        print("<td>");
        $css->CrearInputText("TxtFecha", "date", "", date("Y-m-d"), "Fecha", "black", "", "", 100, 30, 0, 1);
        print("</td>");        
            
        print("<td>");
        $css->CrearTextArea("TxtConceptoComprobante","","","Escriba el detalle","black","","",300,100,0,1);
        print("</td>");
        print("<td>");
        $css->CrearBotonConfirmado("BtnCrearComC", "Crear");
        print("</td>");   
        $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CerrarCuadroDeDialogo(); 
    $css->CrearNotificacionAzul("Agregar Conceptos al Comprobante", 18);
    $css->CerrarForm();
    $css->CrearForm2("FrmSeleccionaCom", $myPage, "post", "_self");
    $css->CrearTabla();
    $css->FilaTabla(16);
    print("<td style='text-align:center'>");
    
        $css->CrearSelect("CmbComprobante", "EnviaForm('FrmSeleccionaCom')");
        
            $css->CrearOptionSelect("","Seleccionar un Movimiento",0);
            
            $consulta = $obVenta->ConsultarTabla("comprobantes_pre","");
            while($DatosPreEgreso=mysql_fetch_array($consulta)){
                if($idComprobante==$DatosPreEgreso['idComprobanteContabilidad']){
                    $Sel=1;
                    
                }else{
                    
                    $Sel=0;
                }
                $css->CrearOptionSelect($DatosPreEgreso['idComprobanteContabilidad'],$DatosPreEgreso['idComprobanteContabilidad']." ".$DatosPreEgreso['Concepto'],$Sel);							
            }
        $css->CerrarSelect();
    print("</td>");
    $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CerrarForm();
    
    $css->CrearForm2("FrmAgregaItemE", $myPage, "post", "_self");
    $Visible=0;
    if($idComprobante>0){
        $Visible=1;
    }
    $css->CrearDiv("DivDatosItemEgreso", "", "center", $Visible, 1);
    $css->CrearTabla();
    $css->FilaTabla(16);
    $css->ColTabla("<strong>Comprobante:</strong>", 1);
    print("<td>");
       $css->CrearInputText("TxtIdCC", "text", "", $idComprobante, "idEgreso", "black", "", "", 100, 30, 1, 1);
    print("</td>");  
    $css->CierraFilaTabla();   
    $css->FilaTabla(16);
        
        $css->ColTabla("<strong>Centro de Costo</strong>", 1);
        $css->ColTabla("<strong>Tercero</strong>", 1);
        $css->ColTabla("<strong>Cuenta Destino</strong>", 1);
        
    $css->CierraFilaTabla();    
    $css->FilaTabla(16);
        
        
        print("<td>");
					
            $css->CrearSelect("CmbCentroCosto"," Centro de Costos:<br>","black","",1);
            $css->CrearOptionSelect("","Seleccionar Centro de Costos",0);

            $Consulta = $obVenta->ConsultarTabla("centrocosto","");
            while($CentroCosto=mysql_fetch_array($Consulta)){
                            $css->CrearOptionSelect($CentroCosto['ID'],$CentroCosto['Nombre'],0);							
            }
            $css->CerrarSelect();

        print("</td>");
        print("<td>");
            $VarSelect["Ancho"]="200";
            $VarSelect["PlaceHolder"]="Seleccione el tercero";
            $css->CrearSelectChosen("CmbTerceroItem", $VarSelect);
            $css->CrearOptionSelect("", "Seleccione un tercero" , 0);
            $sql="SELECT * FROM proveedores";
            $Consulta=$obVenta->Query($sql);
            
               while($DatosProveedores=$obVenta->FetchArray($Consulta)){
                   $Sel=0;
                   
                   $css->CrearOptionSelect($DatosProveedores["Num_Identificacion"], "$DatosProveedores[RazonSocial] $DatosProveedores[Num_Identificacion]" , $Sel);
               }
            $css->CerrarSelect();
        print("</td>");
        print("<td>");
            $VarSelect["Ancho"]="200";
            $VarSelect["PlaceHolder"]="Seleccione la cuenta destino";
            $css->CrearSelectChosen("CmbCuentaDestino", $VarSelect);
            $css->CrearOptionSelect("", "Seleccione la cuenta destino" , 0);
            
            //Solo para cuando el PUC no está todo en subcuentas
            $sql="SELECT * FROM cuentas";
            $Consulta=$obVenta->Query($sql);
            
               while($DatosProveedores=$obVenta->FetchArray($Consulta)){
                   $Sel=0;
                   
                   $css->CrearOptionSelect($DatosProveedores["idPUC"], "$DatosProveedores[idPUC] $DatosProveedores[Nombre]" , $Sel);
               }
            
            //En subcuentas se debera cargar todo el PUC
            $sql="SELECT * FROM subcuentas";
            $Consulta=$obVenta->Query($sql);
            
               while($DatosProveedores=$obVenta->FetchArray($Consulta)){
                   $Sel=0;
                   
                   $css->CrearOptionSelect($DatosProveedores["PUC"], "$DatosProveedores[PUC] $DatosProveedores[Nombre]" , $Sel);
               }
            
            $css->CerrarSelect();
        print("</td>");
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        print("<td>");
        $css->CrearInputNumber("TxtValorItem", "number", "<strong>Valor:</strong><br>", "", "Valor", "black", "", "", 220, 30, 0, 1, 1, "", 1);
        print("<br>");
       
        $css->CrearSelect("CmbDebitoCredito", "");
            $css->CrearOptionSelect("D", "Debito", 1);
            $css->CrearOptionSelect("C", "Credito", 0);
        $css->CerrarSelect();
        print("</td>");
    
       
        print("<td>");
        $css->CrearTextArea("TxtConceptoEgreso","<strong>Concepto:</strong><br>","","Escriba el Concepto","black","","",300,100,0,1);
        print("</td>");
        print("<td>");
        $css->CrearInputText("TxtNumFactura","text",'Numero del Documento soporte:<br>',"","Numero del documento","black","","",300,30,0,1);
        echo"<br>";
        $css->CrearUpload("foto");
        echo"<br>";
        echo"<br>";
        
        $css->CrearBotonConfirmado("BtnAgregarItemMov", "Agregar Concepto");
        print("</td>");
        
    $css->CierraFilaTabla();
    
    
    
    $css->CerrarTabla();
    $css->CerrarForm();
    ////Se dibujan los items del movimiento
    $css->CrearSelect("CmbMostrarItems", "MuestraOculta('DivItems')");
        $css->CrearOptionSelect("SI", "Mostrar Movimientos", 0);
        $css->CrearOptionSelect("NO", "Ocultar Movimientos", 0);
    $css->CerrarSelect();
    $css->CrearDiv("DivItems", "", "center", 1, 1);
    $Vector["Tabla"]="comprobantes_contabilidad_items";
    $Columnas=$obTabla->ColumnasInfo($Vector);
    $css->CrearTabla();
    $css->FilaTabla(12);
    
    $i=0;
    $ColNames[]="";
    foreach($Columnas["Field"] as $NombresCol ){
        $css->ColTabla("<strong>$NombresCol</strong>", 1);
        $ColNames[$i]=$NombresCol;
        $i++;
    }
    $NumCols=$i-1;
    $css->CierraFilaTabla();
    
    $i=0;
    $sql="SELECT * FROM comprobantes_contabilidad_items WHERE idComprobante='$idComprobante'";
    $consulta=$obVenta->Query($sql);
    
    while($DatosItems=$obVenta->FetchArray($consulta)){
        
        $css->FilaTabla(12);
        for($z=0;$z<=$NumCols;$z++){
            $NombreCol=$ColNames[$z];
            print("<td>");
            if($NombreCol=="Soporte"){
                $link=$DatosItems[$NombreCol];
                if($link<>""){
                    $css->CrearLink($link, "_blank", "Ver");
                }
            }else{
                print($DatosItems[$NombreCol]);
            }
            
            print("</td>");
        }
        $i=0;
        $css->CierraFilaTabla();
        
    }
    
    $css->CerrarTabla();
    $css->CerrarDiv();//Cerramos Div con los items agregados
    $css->CerrarDiv();//Cerramos Div con los datos de los preitems
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->AnchoElemento("CmbTerceroItem_chosen", 200);
    $css->AnchoElemento("CmbCuentaDestino_chosen", 200);
    print("</body></html>");
?>