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
$idRemision="";
//////Si recibo un cliente
	if(!empty($_REQUEST['TxtAsociarRemision'])){
		
		$idRemision=$_REQUEST['TxtAsociarRemision'];
	}
include_once("procesaDevolucion.php");
	
print("<html>");
print("<head>");
$css =  new CssIni("Devoluciones");
print("</head>");
print("<body>");
    $obVenta=new ProcesoVenta($idUser);
    $myPage="Devoluciones.php";
    $css->CabeceraIni("SoftConTech Devoluciones"); //Inicia la cabecera de la pagina
    
    //////////Creamos el formulario de busqueda de remisiones
    /////
    /////
    
    $css->CrearForm("FrmBuscarRemision",$myPage,"post","_self");
        $css->CrearInputText("TxtBuscarRemision","text","Buscar Remision: ","","Digite el numero de una Remision","white","","",300,30,0,0);
        $css->CrearBoton("BtnBuscarRemision", "Buscar");
    $css->CerrarForm();
    
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center");
    print("<br>");
    ///////////////Creamos la imagen representativa de la pagina
    /////
    /////	
    $css->CrearImageLink("../VMenu/MnuVentas.php", "../images/devolucion2.png", "_self",200,200);
    
    ///////////////Si se crea una devolucion o una factura
    /////
    /////
    if(!empty($_REQUEST["TxtidDevolucion"])){
        $RutaPrintCot="../tcpdf/examples/imprimirDevolucion.php?ImgPrintDevolucion=".$_REQUEST["TxtidDevolucion"];			
        $css->CrearTabla();
        $css->CrearFilaNotificacion("Devolucion almacenada Correctamente <a href='$RutaPrintCot' target='_blank'>Imprimir Devolucion No. $_REQUEST[TxtidDevolucion]</a>",16);
        $css->CerrarTabla();
        if(!empty($_REQUEST["TxtidFactura"])){
            $RutaPrint="../tcpdf/examples/imprimirFacturaAlquiler.php?ImgPrintFactura=".$_REQUEST["TxtidFactura"];			
            $css->CrearTabla();
            $css->CrearFilaNotificacion("Factura Creada Correctamente <a href='$RutaPrint' target='_blank'>Imprimir Factura No. $_REQUEST[TxtidIngreso]</a>",16);
            $css->CerrarTabla();
        }
    }
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearDiv("Secundario", "container", "center");
   										
    ////////////////////////////////////Si se solicita buscar una Remision
    /////
    /////
    if(!empty($_REQUEST["TxtBuscarRemision"])){

        $Key=$_REQUEST["TxtBuscarRemision"];
        $pa=mysql_query("SELECT * FROM remisiones r INNER JOIN clientes cl ON r.Clientes_idClientes = cl.idClientes "
                . "WHERE r.Estado<>'C' AND(cl.RazonSocial LIKE '%$Key%' OR r.ID = '$Key' OR r.Obra LIKE '%$Key%' OR r.FechaDespacho LIKE '%$Key%') ORDER BY r.ID DESC LIMIT 20") or die(mysql_error());
        if(mysql_num_rows($pa)){
            print("<br>");
            $css->CrearTabla();
            $css->FilaTabla(18);
            $css->ColTabla("Remisiones Encontradas:",4);
            $css->CierraFilaTabla();

            $css->FilaTabla(18);
                $css->ColTabla("ID",1);
                $css->ColTabla('Fecha',1);
                $css->ColTabla('Razon Social',1);
                $css->ColTabla('Obra',1);
                $css->ColTabla('Fecha Despacho',1);
                $css->ColTabla('Hora Despacho',1);
                $css->ColTabla('Observaciones Remision',1);
                $css->ColTabla('Anticipo',1);
                $css->ColTabla('Asociar',1);
            $css->CierraFilaTabla();
            while($DatosRemision=mysql_fetch_array($pa)){
                $css->FilaTabla(14);
                $css->ColTabla($DatosRemision['ID'],1);
                $css->ColTabla($DatosRemision['Fecha'],1);
                $css->ColTabla($DatosRemision['RazonSocial'],1);
                $css->ColTabla($DatosRemision['Obra'],1);
                $css->ColTabla($DatosRemision['FechaDespacho'],1);
                $css->ColTabla($DatosRemision['HoraDespacho'],1);
                $css->ColTabla($DatosRemision['ObservacionesRemision'],1);
                print("<td>");
                $RutaPrint="../tcpdf/examples/imprimiremision.php?ImgPrintRemi=".$DatosRemision["ID"];
                $css->CrearLink($RutaPrint,"_blank","Ver");
                print("</td>");
                $css->ColTablaVar($myPage,"TxtAsociarRemision",$DatosRemision['ID'],"","Asociar Remision");
                $css->CierraFilaTabla();
            }

            $css->CerrarTabla(); 
        }else{
                print("<h3>No hay resultados</h3>");
        }

    }
					
    //////////////////////////Se dibujan los campos para crear la remision
    /////
    /////
    if(!empty($idRemision)){
        //print("<script>alert('entra')</script>");
        $DatosRemision=$obVenta->DevuelveValores("remisiones","ID",$idRemision);
        $DatosCliente=$obVenta->DevuelveValores("clientes","idClientes",$DatosRemision["Clientes_idClientes"]);

            $css->CrearTabla();
            $css->CrearFilaNotificacion("Items Disponibles en esta remision",18);
            $css->FilaTabla(16);
            $css->ColTabla('REMISION:',1);
            $css->ColTabla($idRemision,1);
            $css->ColTabla('CLIENTE:',1);
            $css->ColTabla($DatosCliente["RazonSocial"],1);
            $css->ColTabla('OBRA:',1);
            $css->ColTabla($DatosRemision["Obra"],1);
            $css->CierraFilaTabla();
            $css->CerrarTabla();
            $css->CrearTabla();
            $Consulta=$obVenta->ConsultarTabla("rem_relaciones", "WHERE idRemision='$idRemision' GROUP BY idItemCotizacion");

            $css->FilaTabla(16);
            $css->ColTabla('<strong>REFERENCIA</strong>',1);
            $css->ColTabla('<strong>DESCRIPCION</strong>',1);
            $css->ColTabla('<strong>FECHA ENTREGA</strong>',1);
            $css->ColTabla('<strong>CANTIDAD ENTREGADA</strong>',1);
            $css->ColTabla('<strong>AJUSTE</strong>',1);

            $css->ColTabla('<strong>PENDIENTE X DEVOLVER</strong>',1);

            $css->CierraFilaTabla();

            $Total=0;
            $Subtotal=0;
            $IVA=0;
            while($DatosItemRemision=mysql_fetch_array($Consulta)){

                $DatosItems=$obVenta->DevuelveValores("cot_itemscotizaciones", "ID", $DatosItemRemision["idItemCotizacion"]);
                $Entregas=$obVenta->Sume('rem_relaciones', "CantidadEntregada", " WHERE idItemCotizacion=$DatosItemRemision[idItemCotizacion] AND idRemision=$idRemision");
                $Salidas=$obVenta->Sume("rem_pre_devoluciones", "Cantidad", " WHERE idItemCotizacion=$DatosItemRemision[idItemCotizacion] AND idRemision=$idRemision");
                $Salidas2=$obVenta->Sume("rem_devoluciones", "Cantidad", " WHERE idItemCotizacion=$DatosItemRemision[idItemCotizacion] AND idRemision=$idRemision");
                $PendienteDevolver=$Entregas-$Salidas-$Salidas2;
                ///////////////Creo Formulario para edicion
                $css->FilaTabla(14);
                $css->ColTabla($DatosItems["Referencia"],1);
                $css->ColTabla($DatosItems["Descripcion"],1);
                $css->ColTabla($DatosItemRemision["FechaEntrega"],1);
                $css->ColTabla($Entregas,1);
                print("<td width='40%'>");
                $css->CrearFormularioEvento("FrmEditar$DatosItems[ID]",$myPage,"post","_self","");
                $css->CrearInputText("TxtIdItem","hidden","",$DatosItems["ID"],"","black","","",150,30,0,0);
                $css->CrearInputText("TxtAsociarRemision","hidden","",$idRemision,"","black","","",150,30,0,0);


                $css->CrearInputNumber("TxtSubtotalUnitario","number","Valor: ",$DatosItems["ValorUnitario"],"Valor Unitario","black","","",80,30,0,1,'','',"any");
                $css->CrearInputNumber("TxtCantidadDevolucion","number"," Cantidad: ",$PendienteDevolver,"Devuelve","black","","",70,30,0,1,1,$PendienteDevolver,"any");
                $css->CrearInputNumber("TxtDias","number"," Dias: ",$DatosRemision["Dias"],"Dias","black","","",70,30,0,1,1,1000,"any");
                $css->CrearBotonVerde("BtnEditar","+");
                $css->CerrarForm();
                print("</td>");

                if($PendienteDevolver>0){
                    $cstyle="color:RED;";
                }else{
                     $cstyle="color:Black;";
                }        
                print("<td style=$cstyle><h4>$PendienteDevolver</h4></td>");

                $css->CierraFilaTabla();
            }
    $css->CerrarTabla();
			
    ///////////////////////////////////////////
    /////////////Visualizamos la pre Devolucion
    ///
    ///
    ///
    $sql="SELECT pre.ID as ID, cot.Referencia as Referencia, cot.Descripcion as Descripcion, pre.Cantidad as Cantidad,"
            . " pre.Subtotal as Subtotal, pre.Dias as Dias, pre.Total as Total FROM rem_pre_devoluciones pre";
    $sql.=" INNER JOIN cot_itemscotizaciones cot ON cot.ID=pre.idItemCotizacion";
    $sql.=" WHERE pre.idRemision='$idRemision'";
    $consulta=$obVenta->Query($sql);              

    if(mysql_affected_rows()){


        $css->CrearTabla();
        $css->CrearFilaNotificacion("PRE-DEVOLUCION",18);
        $css->FilaTabla(16);
        $css->ColTabla("<strong>Referencia</strong>", 1);
        $css->ColTabla("<strong>Descripcion</strong>", 1);
        $css->ColTabla("<strong>Cantidad</strong>", 1);
        $css->ColTabla("<strong>SubTotal</strong>", 1);
        $css->ColTabla("<strong>Dias</strong>", 1);
        $css->ColTabla("<strong>Total</strong>", 1);
        $css->ColTabla("<strong>Borrar</strong>", 1);
        $css->CierraFilaTabla();

        while($DatosPreDevolucion=mysql_fetch_array($consulta)){
            $css->FilaTabla(16);
            $css->ColTabla($DatosPreDevolucion["Referencia"], 1);
            $css->ColTabla($DatosPreDevolucion["Descripcion"], 1);
            $css->ColTabla($DatosPreDevolucion["Cantidad"], 1);
            $css->ColTabla(number_format($DatosPreDevolucion["Subtotal"]), 1);
            $css->ColTabla($DatosPreDevolucion["Dias"], 1);
            $css->ColTabla(number_format($DatosPreDevolucion["Total"]), 1);
            $css->ColTablaDel($myPage,"rem_pre_devoluciones","ID",$DatosPreDevolucion['ID'],$idRemision);
            $css->CierraFilaTabla();
        }

        $css->CerrarTabla();
        /////////////////Mostramos Totales y Se crea el formulario para guardar la devolucion
        ////
        ////
        
        $TotalDevolucion=$obVenta->Sume("rem_pre_devoluciones", "Total", "WHERE idRemision='$idRemision'");
        $css->CrearFormularioEvento("FormGuardaDevolucion", $myPage, "post", "_self","");
        $css->CrearInputText("TxtIdRemision","hidden","",$idRemision,"","black","","",150,30,0,0);
        $css->CrearInputText("TxtTotalDevolucion","hidden","",$TotalDevolucion,"","black","","",150,30,0,0);
        
        $css->CrearTabla();
        $css->FilaTabla(16);
        $css->ColTabla("<h3 align='right'>Total</h3>", 1);
        $css->ColTabla("<h3 align='right'>".number_format($TotalDevolucion)."</h3>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        print("<td colspan=2 style='text-align:center'>");
        $css->CrearInputText("TxtFechaDevolucion","text","",date("Y-m-d"),"Fecha","black","","",150,30,0,1);
	$css->CrearInputText("TxtHoraDevolucion","text","",date("H:i:s"),"Hora","black","","",150,30,0,1);
        print("<br>");
        $css->CrearTextArea("TxtObservacionesDevolucion","","","Observaciones para esta Devolucion","black","","",300,100,0,0);
        print("<br>Facturar: ");
        $css->CrearSelect("CmbFactura", "");
            $css->CrearOptionSelect("NO", "NO", 0);
            $css->CrearOptionSelect("SI", "SI", 1);
        $css->CerrarSelect();
        print("<br>");
        $css->CrearBotonConfirmado("BtnGuardarDevolucion","Guardar");
        print("</td>");
        $css->CierraFilaTabla();

        $css->CerrarTabla();
        $css->CerrarForm();
    }


    }else{
            $css->CrearTabla();
            $css->CrearFilaNotificacion("Por favor busque y asocie una remision",16);
            $css->CerrarTabla();
    }
    $css->CerrarDiv();//Cerramos contenedor Secundario
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaSubir();
    print("</body></html>");
?>