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
    $css->CrearNotificacionAzul("Agregar Conceptos a Un Egreso", 18);
    $css->CerrarForm();
    $css->CrearForm2("FrmAgregaItemE", "pre_egreso.php", "post", "FramePreEgreso");
    $css->CrearTabla();
    $css->FilaTabla(16);
    print("<td style='text-align:center'>");
    
        $css->CrearSelect("CmbEgresoPre", "MuestreDesdeCombo('CmbEgresoPre','DivDatosItemEgreso');prueba12()");
        
            $css->CrearOptionSelect("","Seleccionar Un Egreso",0);
            
            $consulta = $obVenta->ConsultarTabla("egresos_pre","");
            while($DatosPreEgreso=mysql_fetch_array($consulta)){
                $css->CrearOptionSelect($DatosPreEgreso['idEgreso'],$DatosPreEgreso['idEgreso']." ".$DatosPreEgreso['Concepto'],0);							
            }
        $css->CerrarSelect();
    print("</td>");
    $css->CierraFilaTabla();
    $css->CerrarTabla();
    $css->CrearDiv("DivDatosItemEgreso", "container", "center", 0, 1);
    $css->CrearTabla();
    $css->FilaTabla(16);
        $css->ColTabla("<strong>Fecha</strong>", 1);
        $css->ColTabla("<strong>Cuenta Origen</strong>", 1);
        $css->ColTabla("<strong>Tercero</strong>", 1);
        $css->ColTabla("<strong>Detalle</strong>", 1);
    $css->CierraFilaTabla();
    
    
    $css->CerrarTabla();
    $css->CerrarForm();
    $css->CerrarDiv();//Cerramos Div con los datos de los preitems
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    print("</body></html>");
?>