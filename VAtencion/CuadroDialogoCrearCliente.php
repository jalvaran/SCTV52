<?php

/* 
 * Archivo donde se incluyen las clases para crear un cuadro de dialogo para crear un cliente
 */

/////////////////Cuadro de dialogo de Clientes create
	 $css->CrearCuadroDeDialogo("DialCliente","Crear Crear Cliente"); 
	 
		 $css->CrearForm("FrmCrearCliente",$myPage,"post","_self");
		 $css->CrearSelect("CmbTipoDocumento","Oculta()");
		 $css->CrearOptionSelect('13','Cedula',1);
		 $css->CrearOptionSelect('31','NIT',0);
		 $css->CerrarSelect();
		 //$css->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",0,0,0,0);
		 $css->CrearInputText("TxtNIT","number","","","Identificacion","black","","",200,30,0,1);
		 $css->CrearInputText("TxtPA","text","","","Primer Apellido","black","onkeyup","CreaRazonSocial()",200,30,0,0);
		 $css->CrearInputText("TxtSA","text","","","Segundo Apellido","black","onkeyup","CreaRazonSocial()",200,30,0,0);
		 $css->CrearInputText("TxtPN","text","","","Primer Nombre","black","onkeyup","CreaRazonSocial()",200,30,0,0);
		 $css->CrearInputText("TxtON","text","","","Otros Nombres","black","onkeyup","CreaRazonSocial()",200,30,0,0);
		 $css->CrearInputText("TxtRazonSocial","text","","","Razon Social","black","","",200,30,0,1);
		 $css->CrearInputText("TxtDireccion","text","","","Direccion","black","","",200,30,0,1);
		 $css->CrearInputText("TxtTelefono","text","","","Telefono","black","","",200,30,0,1);
                 
		 $css->CrearInputText("TxtEmail","text","","","Email","black","","",200,30,0,1);
                 
                 $VarSelect["Ancho"]="200";
                 $VarSelect["PlaceHolder"]="Seleccione el municipio";
                 $css->CrearSelectChosen("CmbCodMunicipio", $VarSelect);
                 
                 $sql="SELECT * FROM cod_municipios_dptos";
                 $Consulta=$obVenta->Query($sql);
                    while($DatosMunicipios=$obVenta->FetchArray($Consulta)){
                        $Sel=0;
                        if($DatosMunicipios["ID"]==1011){
                            $Sel=1;
                        }
                        $css->CrearOptionSelect($DatosMunicipios["ID"], $DatosMunicipios["Ciudad"], $Sel);
                    }
                 $css->CerrarSelect();
                 echo '<br><br>';
		 $css->CrearBoton("BtnCrearCliente", "Crear Cliente");
		 $css->CerrarForm();
	 
	 $css->CerrarCuadroDeDialogo(); 
         
         
         /////////////////Cuadro de dialogo de separados
	 $css->CrearCuadroDeDialogo("DialSeparado","Crear Separado"); 
	 
	 $DatosPreventa=$obVenta->DevuelveValores("vestasactivas","idVestasActivas", $idPreventa);
	 
        $css->CrearForm("FrmCrearSeparado",$myPage,"post","_self");
        $VarSelect["Ancho"]="200";
        $VarSelect["PlaceHolder"]="Seleccione un Cliente";
        $VarSelect["Required"]=1;
        $VarSelect["Title"]="Cliente: ";
        $css->CrearSelectChosen("CmbClientes", $VarSelect);

        $sql="SELECT * FROM clientes";
        $Consulta=$obVenta->Query($sql);
        $css->CrearOptionSelect("", "Seleccione Un Cliente" , 0);
           while($DatosCliente=$obVenta->FetchArray($Consulta)){
               
               $css->CrearOptionSelect($DatosCliente["idCliente"], "$DatosCliente[Num_Identificacion] - $DatosCliente[RazonSocial]" , 0);
           }
        $css->CerrarSelect();
        echo '<br><br>';
        $css->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",0,0,0,0);
        $css->CrearInputText("TxtAbono","number","Abono:<br>","","Digite el Abono del cliente","black","","",200,30,0,0);
        $css->CrearBotonConfirmado("BtnCrearSeparado", "Crear Separado");
        $css->CerrarForm();
	 
	 $css->CerrarCuadroDeDialogo();