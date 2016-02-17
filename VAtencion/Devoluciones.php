<script src="../shortcuts.js" type="text/javascript">
</script>
<script src="js/funciones.js"></script>
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
	
	
?>
 
<!DOCTYPE html>
<html>
  
	<head>
	
	 <?php $css =  new CssIni("Devoluciones"); ?>
	</head>
 
	<body>
   
	 <?php 
	 $obVenta=new ProcesoVenta($idUser);
	 $myPage="Devoluciones.php";
	 $css->CabeceraIni("SoftConTech Devoluciones"); 
	 
	 	
	 $css->CrearForm("FrmBuscarRemision",$myPage,"post","_self");
	 $css->CrearInputText("TxtBuscarRemision","text","Buscar Remision: ","","Digite el numero de una Remision","white","","",300,30,0,0);
	 $css->CrearBoton("BtnBuscarRemision", "Buscar");
	 $css->CerrarForm();
	 
	 $css->CabeceraFin(); 
	 
	 ?>
	

	

	
    <div class="container" align="center">
	<br>
	<?php	
	
        $css->CrearImageLink("../VMenu/MnuVentas.php", "../images/devolucion2.png", "_self",200,200);
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
	
	
	
	?>	
	
     	  
	  <div id="Productos Agregados" class="container" >
	
		<h2 align="center">
                <?php 
										
					////////////////////////////////////Si se solicita buscar una Remision
	
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
					
	if(!empty($idRemision)){
                //print("<script>alert('entra')</script>");
		$DatosRemision=$obVenta->DevuelveValores("remisiones","ID",$idRemision);
		$DatosCliente=$obVenta->DevuelveValores("clientes","idClientes",$DatosRemision["Clientes_idClientes"]);
		
                print("DEVOLUCION<br><br>");
                        
			$css->CrearTabla();
			$css->FilaTabla(18);
                        print("<td colspan=3>");
			print("FECHA: ");
                        $css->CrearInputText("TxtFechaDevolucion","text","",date("Y-m-d"),"","black","","",150,30,0,1); 
                        print("</td>"); 
			$css->ColTabla("REMISION:",1);
			$css->ColTablaInputText("TxtIdRemision","text",$DatosRemision["ID"],"","","black","","",150,30,1,1);
			$css->CierraFilaTabla();
			$css->FilaTabla(16);
			$css->ColTabla('CLIENTE:',1);
			$css->ColTabla($DatosCliente["RazonSocial"],1);
			$css->ColTabla(' ',1);
			$css->ColTabla('OBRA:',1);
			$css->ColTabla($DatosRemision["Obra"],1);
			$css->CierraFilaTabla();
			
			$css->FilaTabla(16);
			$css->ColTabla('DIRECCION:',1);
			$css->ColTabla($DatosCliente["Direccion"],1);
			$css->ColTabla(' ',1);
			$css->ColTabla('DIRECCION OBRA:',1);
			$css->ColTabla($DatosRemision["Direccion"],1);
			$css->CierraFilaTabla();
			
			$css->FilaTabla(16);
			$css->ColTabla('TELEFONO:',1);
			$css->ColTabla($DatosCliente["Telefono"],1);
			$css->ColTabla(' ',1);
			$css->ColTabla('CIUDAD Y TELEFONO:',1);
			
			$css->ColTabla($DatosRemision["Ciudad"].' '.$DatosRemision["Telefono"],1);
			
			
			$css->CierraFilaTabla();
			
			$css->FilaTabla(16);
			$css->ColTabla('CIUDAD:',1);
			$css->ColTabla($DatosCliente["Ciudad"],1);
			$css->ColTabla(' ',1);
			$css->ColTabla('RETIRÓ:',1);
			$css->ColTabla($DatosRemision["Retira"],1);
			$css->CierraFilaTabla();
			
			$css->FilaTabla(16);
			$css->ColTabla('NIT:',1);
			$css->ColTabla($DatosCliente["Num_Identificacion"],1);
			$css->ColTabla(' ',1);
			$css->ColTabla('FECHA Y HORA DEVOLUCION:',1);
			$Fecha=date("Y-m-d");
			$Hora=date("H:i:s");
			print("<td>");
			$css->CrearInputText("TxtFecha","text","",$Fecha,"Fecha y Hora","black","","",150,30,0,1);
			$css->CrearInputText("TxtHora","text","",$Hora,"Fecha y Hora","black","","",150,30,0,1);
			print("</td>");
			$css->CierraFilaTabla();
			
			$css->FilaTabla(16);
			print("<td colspan=5 style='text-align: center'>");
			$css->CrearTextArea("TxtObservacionesDevolucion","","","Observaciones","black","","",500,150,0,0);
			print("</td>");
			$css->CierraFilaTabla();
			
			$css->CerrarTabla();
			
			$css->CrearTabla();
			$Consulta=$obVenta->ConsultarTabla("rem_relaciones", "WHERE idRemision='$idRemision'");
			
			$css->FilaTabla(16);
			$css->ColTabla('REFERENCIA',1);
			$css->ColTabla('DESCRIPCION',1);
                        $css->ColTabla('FECHA ENTREGA',1);
			$css->ColTabla('CANTIDAD ENTREGADA',1);
			$css->ColTabla('VALOR',1);
                        $css->ColTabla('DIAS',1);
                        $css->ColTabla('CANTIDAD DEVOLUCION',1);
                        $css->ColTabla('PENDIENTE X DEVOLVER ',1);
                        $css->ColTabla('SUBTOTAL',1);
			$css->CierraFilaTabla();
			
			$Total=0;
			$Subtotal=0;
			$IVA=0;
			while($DatosItemRemision=mysql_fetch_array($Consulta)){
				
				$DatosItems=$obVenta->DevuelveValores("cot_itemscotizaciones", "ID", $DatosItemRemision["idItemCotizacion"]);
				$Subtotal=$Subtotal+$DatosItems["Subtotal"];
				$IVA=round($IVA+$DatosItems["IVA"]);
				$Total=round($Total+$DatosItems["Total"]);
				$TotalFila=$DatosItemRemision["CantidadDevolucion"]*$DatosRemision["Dias"]*$DatosItems["Subtotal"];
                                $PendienteDevolver=$DatosItemRemision["CantidadEntregada"]-$DatosItemRemision["CantidadDevolucion"];
                                ///////////////Creo Formulario para edicion
                                
				$css->FilaTabla(14);
				$css->ColTabla($DatosItems["Referencia"],1);
				$css->ColTabla($DatosItems["Descripcion"],1);
                                $css->ColTabla($DatosItemRemision["FechaEntrega"],1);
				$css->ColTabla($DatosItemRemision["CantidadEntregada"],1);
				 print("<td colspan=3 style='width:500px;'>");
                                 $css->CrearFormularioEvento("FrmEditar$DatosItems[ID]",$myPage,"post","_self","");
                                $css->CrearInputText("TxtIdItem","hidden","",$DatosItems["ID"],"","black","","",150,30,0,0);
                                $css->CrearInputNumber("TxtSubtotalUnitario","number","",$DatosItems["Subtotal"],"Subtotal","black","onkeyup","calculetotalItems()",80,30,0,1,'','',"any");
                               
                                $css->CrearInputNumber("TxtDias","number","",$DatosRemision["Dias"],"Dias","black","onchange","calculetotalItems()",80,30,0,0,1,1000,"any");
                                
                                $css->CrearInputNumber("TxtCantidadDevolucion","number","",0,"Devuelve","black","","",80,30,0,1,0,$PendienteDevolver,"any");
                                $css->CrearBotonVerde("BtnEditar","E");
                                $css->CerrarForm();
                                print("</td>");
                                $css->ColTabla($PendienteDevolver,1);
                                print("<td>");
                                $css->CrearInputNumber("TxtSubtotalItem","number","",$TotalFila,"SubtotalDias","black","","",80,30,1,1,"","","any");
                                print("</td>");
				$css->CierraFilaTabla();
				
			}
			
			$css->CrearFormularioEvento("FrmCrearDevolucion",$myPage,"post","_self","onKeypress='DeshabilitaEnter()'");
			$css->FilaTabla(16);
			
			$css->ColTabla('DIAS',3);
			print("<td>");
			$css->CrearInputText("TxtSubtotalH","hidden","",$Subtotal,"","","","",300,30,0,1);
			$css->CrearInputText("TxtIVAH","hidden","",$IVA,"","","","",300,30,0,1);
			$css->CrearInputText("TxtTotalH","hidden","",$Total,"","","","",300,30,0,1);
			$css->CrearInputNumber("TxtDias","number","",1,"Dias","black","onchange","calculetotaldias()",80,30,0,1,1,1000,"any");
			print("</td>");
			
			$css->CierraFilaTabla();
			
			
			$css->FilaTabla(16);
			$css->ColTabla('SUBTOTAL',3);
			print("<td>");
			$css->CrearInputNumber("TxtSubtotal","number","",$Subtotal,"Subtotal","black","","",200,30,1,1,0,"","any");
			print("</td>");
			$css->CierraFilaTabla();
			$css->FilaTabla(16);
			$css->ColTabla('IVA',3);
			print("<td>");
			$css->CrearInputNumber("TxtIVA","number","",$IVA,"IVA","black","","",200,30,1,1,0,"","any");
			print("</td>");
			$css->CierraFilaTabla();
			$css->FilaTabla(16);
			$css->ColTabla('TOTAL',3);
			print("<td>");
			$css->CrearInputNumber("TxtTotal","number","",$Total,"Subtotal","black","","",200,30,1,1,0,"","any");
			print("</td>");
			$css->CierraFilaTabla();
			
			$css->FilaTabla(16);
			$css->ColTabla('ANTICIPO:',3);
			print("<td>");
			$css->CrearInputNumber("TxtAnticipo","number","",0,"Anticipo","black","onkeyup","calculetotaldias()",200,30,0,1,0,"","any");
                        print("<br>Seleccione una Cuenta destino para el anticipo:<br>");
                        $css->CrearSelect("CmbCuentaDestino", "");
                            $Consulta=$obVenta->ConsultarTabla("cuentasfrecuentes","WHERE ClaseCuenta='ACTIVOS'");
                            while($DatosCuentasFrecuentes=mysql_fetch_array($Consulta)){
                                if($DatosCuentasFrecuentes["CuentaPUC"]=='110510')
                                    $Sel=1;
                                else
                                    $Sel=0;
                                $css->CrearOptionSelect($DatosCuentasFrecuentes["CuentaPUC"], $DatosCuentasFrecuentes["Nombre"], $Sel);
                                
                            }
                        $css->CerrarSelect(); 
                        print("<br>Seleccione un Centro de Costos:<br>");
                        $css->CrearSelect("CmbCentroCostos", "");
                            $Consulta=$obVenta->ConsultarTabla("centrocosto","");
                            while($DatosCentroCostos=mysql_fetch_array($Consulta)){
                               
                                $css->CrearOptionSelect($DatosCentroCostos["ID"], $DatosCentroCostos["Nombre"], 0);
                                
                            }
                        $css->CerrarSelect(); 
                            
			print("</td>");
			$css->CierraFilaTabla();
			
			$css->FilaTabla(16);
			$css->ColTabla('SALDO:',3);
			print("<td>");
			$css->CrearInputNumber("TxtSaldo","number","",$Total,"Saldo","black","","",200,30,1,1,0,"","any");
                                               
			print("<br>");
			$css->CrearBotonConfirmado("BtnGuardarRemision","Guardar");
			print("</td>");
			$css->CierraFilaTabla();
			
			$css->CerrarTabla();
		$css->CerrarForm();	
	}else{
		$css->CrearTabla();
		$css->CrearFilaNotificacion("Por favor busque y asocie una remision",16);
		$css->CerrarTabla();
	}
					
				
					?></h2>
               		<table class="table table-bordered" >
                      <tr>
                        <td>
                        	
                            <?php 
							
								
							?>
                              
                                
                              </tr>
                           
                            	
                            
                           
                        </td>
                      </tr>
		

    </div>
	
      			
</div> <!-- /container -->
     

    

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>
	

   
		
<a style="display:scroll; position:fixed; bottom:10px; right:10px;" href="#" title="Volver arriba"><img src="../images/up1_amarillo.png" /></a>

	
 
  </body>
  
  
</html>

<script language="JavaScript"> 
atajos();
posiciona('TxtCodigoBarras');
</script> 
