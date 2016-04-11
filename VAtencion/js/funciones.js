var idEgreso=0;

function EnviaFormSC() {

	document.FormMesa.submit();
		
}

function EnviaForm(idForm) {
	
	document.getElementById(idForm).submit();
		
}

function EnviaFormDepar() {

	document.FormDepar.submit();
		
}

function EnviaFormOrden() {

	document.FormOrden.submit();
		
}

function incrementa(id) {

	document.getElementById(id).value++;
	

}

function decrementa(id) {

if(document.getElementById(id).value > 1)
	document.getElementById(id).value--;

}
function cargar(){

$("#contenido").load("contpedidos.php");

}

function refresca(seg) {
	setTimeout("cargar()",seg);
}


function cargarMesas(){

$("#contenidoMesas").load("contMesas.php");

}

function refrescaMesas(seg) {
	setTimeout("cargarMesas()",seg);
}

function posiciona(id){ 
   
   document.getElementById(id).focus();
}

function CalculeDevuelta() {

	var total;
	var paga;
	var devuelta;
	
	total =  parseInt(document.getElementById("TxtGranTotalH").value);
	paga =  parseInt(document.getElementById("TxtPaga").value);
	
	devuelta= paga - total;
	
	document.getElementById("TxtDevuelta").value=devuelta;

}

function atajos()
{


shortcut("Ctrl+Q",function()
{
document.getElementById("TxtPaga").focus();
});
shortcut("Ctrl+E",function()
{
document.getElementById("TxtCodigoBarras").focus();
});
shortcut("Ctrl+B",function()
{
document.getElementById("TxtBuscarItem").focus();
});

shortcut("Ctrl+D",function()
{
document.getElementById("TxtBuscarCliente").focus();
});

shortcut("Ctrl+S",function()
{
document.getElementById("BtnGuardar").click();
});

}

function CreaRazonSocial() {

    campo1=document.getElementById('TxtPA').value;
    campo2=document.getElementById('TxtSA').value;
	campo3=document.getElementById('TxtPN').value;
    campo4=document.getElementById('TxtON').value;
	

    Razon=campo3+" "+campo4+" "+campo1+" "+campo2;

    document.getElementById('TxtRazonSocial').value=Razon;


}

function calculetotaldias() {
	
	var Subtotal=document.getElementById("TxtSubtotalH").value;
	var IVA=document.getElementById("TxtIVAH").value;
	var Total=document.getElementById("TxtTotalH").value;
	var Dias=document.getElementById("TxtDias").value;
	var Anticipo=document.getElementById("TxtAnticipo").value;
	
	Saldo=Total*Dias-Anticipo;
	document.getElementById("TxtSubtotal").value=Subtotal*Dias;
	document.getElementById("TxtIVA").value=IVA*Dias;
	document.getElementById("TxtTotal").value=Total*Dias;
	document.getElementById("TxtSaldo").value=Saldo;

}

// esta funcion no permite enviar un formulario con el enter
function DeshabilitaEnter(){
    
    if(event.keyCode == 13) event.returnValue = false;
}

// esta funcion permite confirmar el envio de un formulario
function Confirmar(){
	
	if (confirm('¿Estas seguro que deseas realizar esta accion?')){ 
      this.form.submit();
      
    } 
}

// esta funcion permite mostrar u ocultar un elemento
function MuestraOculta(id){
    
    estado=document.getElementById(id).style.display;
    if(estado=="none" | estado==""){
        document.getElementById(id).style.display="block";
    }
    if(estado=="block"){
        document.getElementById(id).style.display="none";
    }
    
}


// esta funcion permite deshabilitar o habilitar un elemento
function Habilita(id,estado){
    
    document.getElementById(id).disabled=estado;
       
}

function CalculeTotal() {

	var Subtotal;
	var IVA;
	var Total;
	
	Subtotal = parseInt(document.getElementById("TxtSubtotal").value);
	IVA = parseInt(document.getElementById("TxtIVA").value);
	Total= parseInt(Subtotal) + parseInt(IVA);
	
	document.getElementById("TxtTotal").value=Total;

}

function CalculeTotalImpuestos() {

	var TxtSancion;
	var TxtIntereses;
	var TxtImpuesto;
	var Total;
	
	TxtSancion = parseInt(document.getElementById("TxtSancion").value);
	TxtIntereses = parseInt(document.getElementById("TxtIntereses").value);
	TxtImpuesto = parseInt(document.getElementById("TxtImpuesto").value);
	Total= parseInt(TxtSancion) + parseInt(TxtIntereses) + parseInt(TxtImpuesto);
	
	document.getElementById("TxtTotal").value=Total;

}

// esta funcion permite deshabilitar o habilitar un elemento
function CambiaLinkKit(idProducto,idLink,idCantidad,idkit,page){
    
    
    Cantidad=document.getElementById(idCantidad).value;
    
    Kit=document.getElementsByName(idkit)[0].value;
    
    link="procesadores/ProcesadorAgregaKits.php?Tabla=productosventa&IDProducto="+idProducto+"&TxtCantidad="+Cantidad+"&idKit="+Kit+"&Page="+page;
    
    document.getElementById(idLink).href=link;
    
}

function CalculeTotalPagoIngreso() {

	var Retefuente;
	var ReteIVA;
	var ReteICA;
	var Total;
	var TotalPago;
        
	Retefuente = document.getElementById("TxtRetefuente").value;
	ReteIVA = document.getElementById("TxtReteIVA").value;
	ReteICA = document.getElementById("TxtReteICA").value;
        Total = document.getElementById("TxtPagoH").value;
        
	TotalPago= Total - Retefuente - ReteIVA - ReteICA;
	
	document.getElementById("TxtPago").value = TotalPago;

}

// esta funcion permite mostrar u ocultar un elemento
function MuestreDesdeCombo(idCombo,idElement,idCarga){
    
    estado=document.getElementsByName(idCombo)[0].value;
    idEgreso=estado;
    if(estado==""){
        document.getElementById(idElement).style.display="none";
    }else{
        document.getElementById(idElement).style.display="block";
    }
    
}

// esta funcion permite mostrar u ocultar un elemento
function CargueIdEgreso(){
    
    document.getElementById('TxtidEgreso').value=idEgreso;
    
}

// esta funcion permite mostrar u ocultar un elemento
function ObtengaValor(id){
    
    valor=document.getElementById(id).value;
    return valor;
}