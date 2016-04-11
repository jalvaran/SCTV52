<?php 
session_start();
include_once("../modelo/php_conexion.php");
include_once("css_construct.php");
if (!isset($_SESSION['username']))
{
  exit("No se ha iniciado una sesion <a href='../index.php' >Iniciar Sesion </a>");
  
}
$NombreUser=$_SESSION['nombre'];
$idUser=$_SESSION['idUser'];	

print("<html>");
print("<head>");
$css =  new CssIni("Egresos");

print("</head>");
print("<body>");
    $obVenta = new ProcesoVenta($idUser);
    include_once("procesadores/ProcesaEgresosItems.php");
    $myPage="EgresosItems.php";
    $css->CabeceraIni("Egresos"); //Inicia la cabecera de la pagina
      
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
    print("<br>");
    
    
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center",1,1);
    $css->CrearNotificacionAzul("Crear un Egreso", 18);
    $css->CrearForm2("FrmCreaPreEgreso", $myPage, "post", "_self");
    $css->CrearTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>Fecha</strong>", 1);
            $css->ColTabla("<strong>Cuenta Origen</strong>", 1);
            $css->ColTabla("<strong>Tercero</strong>", 1);
            $css->ColTabla("<strong>Detalle</strong>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            print("<td>");
            $css->CrearInputText("TxtFecha", "date", "", date("Y-m-d"), "Fecha", "black", "", "", 100, 30, 0, 1);
            print("</td>");        
            print("<td>");
            $css->CrearSelect("CmbCuentaOrigen"," Cuenta Origen:<br>","black","",1);
            $css->CrearOptionSelect("","Seleccionar Cuenta Origen",0);
            $DatosCuentaOrigen = $obVenta->ConsultarTabla("cuentasfrecuentes","WHERE ClaseCuenta = 'ACTIVOS'");
            while($CuentaOrigen=mysql_fetch_array($DatosCuentaOrigen)){
                            $css->CrearOptionSelect($CuentaOrigen['CuentaPUC'],$CuentaOrigen['Nombre'],0);							
            }
            $css->CerrarSelect();
            print("</td>");
            print("<td>");
            $VarSelect["Ancho"]="200";
            $VarSelect["PlaceHolder"]="Seleccione el tercero";
            $css->CrearSelectChosen("TxtTercero", $VarSelect);
            $css->CrearOptionSelect("", "Seleccione un tercero" , 0);
            $sql="SELECT * FROM proveedores";
            $Consulta=$obVenta->Query($sql);
            
               while($DatosProveedores=$obVenta->FetchArray($Consulta)){
                   $Sel=0;
                   
                   $css->CrearOptionSelect($DatosProveedores["idProveedores"], "$DatosProveedores[RazonSocial] $DatosProveedores[Num_Identificacion]" , $Sel);
               }
            $css->CerrarSelect();
        print("</td>");
        print("<td>");
        $css->CrearTextArea("TxtConceptoEgreso","","","Escriba el detalle del Egreso","black","","",300,100,0,1);
        print("</td>");
        $css->CierraFilaTabla();
    $css->CerrarTabla();
   
    $css->CrearNotificacionRoja("Agregar Conceptos a Un Egreso", 18);
    $css->CerrarForm();
    $css->CrearForm2("FrmAgregaItemE", "pre_egreso.php", "post", "FramePreEgreso");
    $css->CrearTabla();
    $css->FilaTabla(16);
    print("<td style='text-align:center'>");
    
        $css->CrearSelect("CmbEgresoPre", "MuestreDesdeCombo('CmbEgresoPre','DivDatosItemEgreso');CargueIdEgreso()");
        
            $css->CrearOptionSelect("","Seleccionar Un Egreso",0);
            
            $consulta = $obVenta->ConsultarTabla("egresos_pre","");
            while($DatosPreEgreso=mysql_fetch_array($consulta)){
                $css->CrearOptionSelect($DatosPreEgreso['idEgreso'],$DatosPreEgreso['idEgreso']." ".$DatosPreEgreso['Concepto'],0);							
            }
        $css->CerrarSelect();
    print("</td>");
    $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CrearDiv("DivDatosItemEgreso", "", "center", 0, 1);
    $css->CrearTabla();
    $css->FilaTabla(16);
    $css->ColTabla("<strong>Egreso:</strong>", 1);
    print("<td>");
            $css->CrearInputText("TxtidEgreso", "text", "", "", "idEgreso", "black", "", "", 100, 30, 1, 1);
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
                   
                   $css->CrearOptionSelect($DatosProveedores["idProveedores"], "$DatosProveedores[RazonSocial] $DatosProveedores[Num_Identificacion]" , $Sel);
               }
            $css->CerrarSelect();
        print("</td>");
        print("<td>");
            $VarSelect["Ancho"]="200";
            $VarSelect["PlaceHolder"]="Seleccione la cuenta destino";
            $css->CrearSelectChosen("CmbCuentaDestino", $VarSelect);
            $css->CrearOptionSelect("", "Seleccione la cuenta destino" , 0);
            $sql="SELECT * FROM subcuentas";
            $Consulta=$obVenta->Query($sql);
            
               while($DatosProveedores=$obVenta->FetchArray($Consulta)){
                   $Sel=0;
                   
                   $css->CrearOptionSelect($DatosProveedores["PUC"], "$DatosProveedores[PUC] $DatosProveedores[Nombre]" , $Sel);
               }
            
            //Solo para cuando el PUC no está todo en subcuentas
            $sql="SELECT * FROM cuentas";
            $Consulta=$obVenta->Query($sql);
            
               while($DatosProveedores=$obVenta->FetchArray($Consulta)){
                   $Sel=0;
                   
                   $css->CrearOptionSelect($DatosProveedores["idPUC"], "$DatosProveedores[idPUC] $DatosProveedores[Nombre]" , $Sel);
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
        $css->CrearTextArea("TxtConceptoEgreso","<strong>Concepto:</strong><br>","","Escriba el detalle del Egreso","black","","",300,100,0,1);
        print("</td>");
        print("<td>");
        $css->CrearInputText("TxtNumFactura","text",'Numero de Comprobante:<br>',"","Numero de Comprobante","black","","",300,30,0,1);
        echo"<br>";
        $css->CrearUpload("foto");
        
        print("</td>");
        
    $css->CierraFilaTabla();
    
    
    
    $css->CerrarTabla();
    $css->CerrarForm();
    $css->CerrarDiv();//Cerramos Div con los datos de los preitems
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    $css->AnchoElemento("CmbTerceroItem_chosen", 200);
    $css->AnchoElemento("CmbCuentaDestino_chosen", 200);
    print("</body></html>");
?>