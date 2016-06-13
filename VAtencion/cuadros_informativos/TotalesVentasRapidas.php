<?php

/* 
 * Aqui se mostrará el total de una venta Rapida
 */

/////////////////////////////////////Se muestra el Cuadro con los valores de la preventa actual
    
    //$obVenta=new ProcesoVenta($idUser);
    $Subtotal=$obVenta->SumeColumna("preventa","Subtotal", "VestasActivas_idVestasActivas",$idPreventa);
    $IVA=$obVenta->SumeColumna("preventa","Impuestos", "VestasActivas_idVestasActivas",$idPreventa);
    $DatosPreventa=$obVenta->DevuelveValores("vestasactivas","idVestasActivas", $idPreventa);
    $SaldoFavor=$DatosPreventa["SaldoFavor"];
    if($SaldoFavor>0)
            $SaldoFavor=$SaldoFavor;
    else
            $SaldoFavor=0;

    $Total=$Subtotal+$IVA;
    $GranTotal=$Total-$SaldoFavor;
    $css->CrearForm2("FrmGuarda",$myPage,"post","_self");
    $css->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",150,30,0,0);
    $css->CrearInputText("TxtSaldoFavor","hidden","",$SaldoFavor,"","","","",150,30,0,0);
    $css->ColTablaInputText("TxtTotalH","hidden",$Total,"","","","","",150,30,0,0);
    $css->ColTablaInputText("TxtGranTotalH","hidden",$GranTotal,"","","","","",150,30,0,0);
    $css->CrearTabla();
    $css->FilaTabla(14);
    $css->ColTabla("Esta Venta:",3);
    $css->CierraFilaTabla();
    $css->FilaTabla(18);
    $css->ColTabla("SUBTOTAL:",1);
    $css->ColTabla(number_format($Subtotal),2);
    $css->CierraFilaTabla();
    $css->FilaTabla(18);
    $css->ColTabla("IMPUESTOS:",1);
    $css->ColTabla(number_format($IVA),2);
    $css->CierraFilaTabla();
    if($SaldoFavor>0){
            $css->FilaTabla(18);
            $css->ColTabla("SALDO A FAVOR:",1);
            $css->ColTabla(number_format($SaldoFavor),2);
            $css->CierraFilaTabla();

    }
    $css->FilaTabla(40);
    $css->ColTabla("TOTAL:",1);
    $css->ColTabla(number_format($Total),2);
    $css->CierraFilaTabla();
    if($SaldoFavor>0){
            $css->FilaTabla(40);
            $css->ColTabla("GRAN TOTAL:",1);
            $css->ColTabla(number_format($GranTotal),2);
            $css->CierraFilaTabla();
    }
    $css->FilaTabla(18);
    $css->ColTabla("PAGA:",1);
    $css->ColTablaInputText("TxtPaga","number","","","Paga","","onkeyup","CalculeDevuelta()",150,30,0,0);

    $css->CierraFilaTabla();

    $css->FilaTabla(18);
    $css->ColTabla("DEVOLVER:",1);
    $css->ColTablaInputText("TxtDevuelta","text","","","Devuelta","","","",150,50,1,0);
    $css->ColTablaBoton("BtnGuardar","Guardar");
    $css->CierraFilaTabla();

    $css->CerrarTabla(); 
    $css->CerrarForm();
    
    /*
     * Dibujo los items en la preventa
     */
    
    $css->CrearTabla();
								
								
    $sql="SELECT * FROM preventa WHERE VestasActivas_idVestasActivas='$idPreventa' ORDER BY idPrecotizacion DESC";
    $pa=$obVenta->Query($sql);
    if($obVenta->NumRows($pa)){	
        $css->CrearNotificacionVerde("Items en Esta Preventa",16);
            $css->FilaTabla(18);
            $css->ColTabla('Referencia',1);
            $css->ColTabla('Nombre',1);
            $css->ColTabla('Cantidad',1);
            $css->ColTabla('ValorUnitario',1);
            $css->ColTabla('Subtotal',1);
            $css->ColTabla('Borrar',1);
            $css->CierraFilaTabla();

    while($DatosPreventa=$obVenta->FetchArray($pa)){
            $css->FilaTabla(16);
            $DatosProducto=$obVenta->DevuelveValores($DatosPreventa["TablaItem"],"idProductosVenta",$DatosPreventa["ProductosVenta_idProductosVenta"]);
            $css->ColTabla($DatosProducto['Referencia'],1);
            $css->ColTabla($DatosProducto['Nombre'],1);
            $css->ColTablaFormInputText("FrmEdit$DatosPreventa[idPrecotizacion]",$myPage,"post","_self","TxtEditar","Number",$DatosPreventa['Cantidad'],"","","","","","150","30","","","TxtPrecotizacion",$DatosPreventa['idPrecotizacion'],$idPreventa);
            $css->ColTabla(number_format($DatosPreventa['ValorUnitario']),1);
            $css->ColTabla(number_format($DatosPreventa['Subtotal']),1);
            $css->ColTablaDel($myPage,"preventa","idPrecotizacion",$DatosPreventa['idPrecotizacion'],$idPreventa);
            //$css->CierraColTabla();
            $css->CierraFilaTabla();
    }
    }else{
      $css->CrearNotificacionRoja("No hay items en esta preventa",20);  
    }
    $css->CerrarTabla();