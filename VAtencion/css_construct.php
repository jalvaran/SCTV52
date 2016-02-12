<style type="text/css">
			
			* {
				margin:0px;
				padding:0px;
			}
			
			#MenuBasico {
				margin:0px;
				width:auto;
				font-family:Arial, Helvetica, sans-serif;
			}
			
			ul, ol {
				list-style:none;
			}
			
			.nav > li {
				float:left;
			}
			
			.nav li a {
				background-color:#000;
				color:#fff;
				text-decoration:none;
				padding:10px 12px;
				display:block;
			}
			
			.nav li a:hover {
				background-color:#434343;
			}
			
			.nav li ul {
				display:none;
				position:absolute;
				min-width:140px;
			}
			
			.nav li:hover > ul {
				display:block;
			}
			
			.nav li ul li {
				position:relative;
			}
			
			.nav li ul li ul {
				right:-140px;
				top:0px;
			}
			
		</style>


<?php
	

//////////////////////////////////////////////////////////////////////////
////////////Clase para iniciar css ///////////////////////////////////
////////////////////////////////////////////////////////////////////////

class CssIni{
	private $Titulo;
	
	
	function __construct($Titulo){
		
		print("
		<meta charset='utf-8'>
		<title>$Titulo</title>
		<meta name='viewport' content='width=device-width, initial-scale=1.0'>
		<meta name='description' content='Software de Techno Soluciones Ordenes Activos'>
		<meta name='author' content='Techno Soluciones SAS'>

		<!-- Le styles -->
		<link href='css/bootstrap.css' rel='stylesheet'>
		<link href='css/pagination.css' rel='stylesheet' type='text/css' />
		<link href='css/B_blue.css' rel='stylesheet' type='text/css' />
		<style type='text/css'>
		  body {
			padding-top: 60px;
			padding-bottom: 40px;
		  }
		</style>
		<link href='css/bootstrap-responsive.css' rel='stylesheet'>

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		  <script src='../assets/js/html5shiv.js'></script>
		<![endif]-->

		<!-- Fav and touch icons -->
		
		<link rel='apple-touch-icon-precomposed' sizes='144x144' href='ico/apple-touch-icon-144-precomposed.png'>
		<link rel='apple-touch-icon-precomposed' sizes='114x114' href='ico/apple-touch-icon-114-precomposed.png'>
		  <link rel='apple-touch-icon-precomposed' sizes='72x72' href='ico/apple-touch-icon-72-precomposed.png'>
						<link rel='apple-touch-icon-precomposed' href='ico/apple-touch-icon-57-precomposed.png'>
									   <link rel='shortcut icon' href='../images/technoIco.ico'>
		
		
		");
		
	}
	
	/////////////////////Inicio una cabecera
	
	function CabeceraIni($Title){
		
		print('
			 <div class="navbar navbar-inverse navbar-fixed-top" >
			  <div class="navbar-inner">
				<div class="container">
				  <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
				  <a class="brand" href="../VMenu/Menu.php">'.$Title.'</a>
				  <div class="nav-collapse collapse">
					<ul class="nav">
					<li>
					
		');
	}
	
	/////////////////////Cierro la Cabecera de la pagina
	
	function CabeceraFin(){
		
		print('
				</li>
				</ul>
				  </div><!--/.nav-collapse -->
				</div>
			  </div>
			</div>
		
		');
	}
	
	
	/////Crea botones con despliegue
		
	function CreaBotonDesplegable($NombreBoton,$TituloBoton)
  {
	
		
	print('<li><a href="#'.$NombreBoton.'" role="button" class="btn" data-toggle="modal" title="'.$TituloBoton.'">
			<span class="badge badge-success">'.$TituloBoton.'</span></a></li>');

	}	
	
	function CreaBotonAgregaPreventa($Page,$idUser)
  {
		
	print('	<a class="brand" href="'.$Page.'?BtnAgregarPreventa='.$idUser.'">Agregar Preventa</a>');

	}	
	
	
	/////////////////////Crea un Formulario
	
	function CrearForm($nombre,$action,$method,$target){
		print('<li><form name= "'.$nombre.'" action="'.$action.'" id="'.$nombre.'" method="'.$method.'" target="'.$target.'">');
		
	}
	
	/////////////////////Crea un Formulario
	
	function CrearFormularioEvento($nombre,$action,$method,$target,$evento){
		print('<li><form name= "'.$nombre.'" action="'.$action.'" id="'.$nombre.'" method="'.$method.'" target="'.$target.'">');
		
	}
	
	
	/////////////////////Cierra un Formulario
	
	function CerrarForm(){
		print('</li></form>');
		
	}
	
	
	/////////////////////Crea un Select
	
	function CrearSelect($nombre,$evento){
		print('<select name="'.$nombre.'" onchange="'.$evento.'">');
		
	}
	
	/////////////////////Cierra un Select
	
	function CerrarSelect(){
		print('</select>');
		
	}
	
	
	/////////////////////Crea un Option Select
	
	function CrearOptionSelect($value,$label,$selected){
		
		if($selected==1)
			print('<option value='.$value.' selected>'.$label.'</option>');
		else
			print('<option value='.$value.'>'.$label.'</option>');
		
	}
	
	
	/////////////////////Crea un Cuadro de texto input
	
	function CrearInputText($nombre,$type,$label,$value,$placeh,$color,$TxtEvento,$TxtFuncion,$Ancho,$Alto,$ReadOnly,$Required){
		
		if($ReadOnly==1)
			$ReadOnly="readonly";
		else
			$ReadOnly="";
		
		if($Required==1)
			$Required="required";
		else
			$Required="";
		
			print('<strong style="color:'.$color.'">'.$label.'<input name="'.$nombre.'" value="'.$value.'" type="'.$type.'" id="'.$nombre.'" placeholder="'.$placeh.'" '.$TxtEvento.' = "'.$TxtFuncion.'" 
			'.$ReadOnly.' '.$Required.' autocomplete="off" style="width: '.$Ancho.'px;height: '.$Alto.'px;"></strong>');
		
	}
	
	/////////////////////Crea un text area
	
	function CrearTextArea($nombre,$label,$value,$placeh,$color,$TxtEvento,$TxtFuncion,$Ancho,$Alto,$ReadOnly,$Required){
		
		if($ReadOnly==1)
			$ReadOnly="readonly";
		else
			$ReadOnly="";
		
		if($Required==1)
			$Required="required";
		else
			$Required="";
		
			print('<strong style="color:'.$color.'">'.$label.'<textarea name="'.$nombre.'" id="'.$nombre.'" placeholder="'.$placeh.'" '.$TxtEvento.' = "'.$TxtFuncion.'" 
			'.$ReadOnly.' '.$Required.' autocomplete="off" style="width: '.$Ancho.'px;height: '.$Alto.'px;">'.$value.'</textarea></strong>');
		
	}
	
	/////////////////////Crea un Cuadro de texto input
	
	function CrearInputNumber($nombre,$type,$label,$value,$placeh,$color,$TxtEvento,$TxtFuncion,$Ancho,$Alto,$ReadOnly,$Required,$Min,$Max,$Step){
		
		if($ReadOnly==1)
			$ReadOnly="readonly";
		else
			$ReadOnly="";
		
		if($Required==1)
			$Required="required";
		else
			$Required="";
		
			print('<strong style="color:'.$color.'">'.$label.'<input name="'.$nombre.'" value="'.$value.'" type="'.$type.'" id="'.$nombre.'" placeholder="'.$placeh.'" '.$TxtEvento.' = "'.$TxtFuncion.'" 
			'.$ReadOnly.' '.$Required.' min="'.$Min.'"   max="'.$Max.'" step="'.$Step.'" autocomplete="off" style="width: '.$Ancho.'px;height: '.$Alto.'px;"></strong>');
		
	}
	
	/////////////////////Crea un Boton Submit
	
	function CrearBoton($nombre,$value){
		print('<input type="submit" id="'.$nombre.'"  name="'.$nombre.'" value="'.$value.'" class="btn btn-primary">');
		
	}
	
	/////////////////////Crea un Cuadro de Dialogo
	
	function CrearCuadroDeDialogo($id,$title){
		
		print('<div id="'.$id.'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       
          	
            <div class="modal-header">
	            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    	        <h3 id="myModalLabel">'.$title.'</h3>
            </div>
            <div class="modal-body">
           	    <div class="row-fluid">
	               
    	            <div class="span6">
                    	
						
                   
            
        ');
		
	}
		
	/////////////////////Cierra un Cuadro de Dialogo
	
	function CerrarCuadroDeDialogo(){
		print(' </div>
                </div>
            </div>
            <div class="modal-footer">
        	    <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> <strong>Cerrar</strong></button>
            	
            </div></div>');
		
	}
	
	
	/////////////////////Crear una Tabla
	
	function CrearTabla(){
		print('<table class="table table-bordered table table-hover" >');
		
	}
	
	/////////////////////Crear una fila para una tabla
	
	function FilaTabla($FontSize){
		print('<tr style="font-size:'.$FontSize.'px">');
		
	}
	
	function CierraFilaTabla(){
		print('</tr>');
		
	}
	
	/////////////////////Crear una columna para una tabla
	
	function ColTabla($Contenido,$ColSpan){
		print('<td colspan="'.$ColSpan.'">'.$Contenido.'</td>');
		
	}
	
	function CierraColTabla(){
		print('</td>');
		
	}
	/////////////////////Cierra una tabla
	
	function CerrarTabla(){
		print('</table>');
		
	}
	
	/////////////////////Crear una columna para una tabla
	
	function ColTablaDel($Page,$tabla,$IdTabla,$ValueDel,$idPre){
		print('<td>
                  	<a href="'.$Page.'?del='.$ValueDel.'&TxtTabla='.$tabla.'&TxtIdTabla='.$IdTabla.'&TxtIdPre='.$idPre.'" title="Eliminar de la Lista">
               		<i class="icon-remove"></i>
                                    </a>
                                </td>');
		
	}
	
	/////////////////////Crear una columna para enviar una variable por URL
	
	function ColTablaVar($Page,$Variable,$Value,$idPre,$Title){
		print('<td><a href="'.$Page.'?'.$Variable.'='.$Value.'&TxtIdPre='.$idPre.'" title="'.$Title.'">'.$Title.'</a></td>');
                               
		
	}
	
	/////////////////////Crear una columna con un formulario
	
	function ColTablaFormInputText($FormName,$Action,$Method,$Target,$TxtName,$TxtType,$TxtValue,$TxtLabel,$TxtPlaceh,$TxtColor,$TxtEvento,$TxtFuncion,$TxtAncho,$TxtAlto,$ReadOnly,$Required,$TxtHide,$ValueHide,$idPreventa){
				
		print('<td>');
		$this->CrearForm($FormName,$Action,$Method,$Target);
		$this->CrearInputText($TxtHide,"hidden","",$ValueHide,"","","","","","","","");
		$this->CrearInputText("CmbPreVentaAct","hidden","",$idPreventa,"","","","",0,0,0,0);
		$this->CrearInputText($TxtName,$TxtType,$TxtLabel,$TxtValue,$TxtPlaceh,$TxtColor,$TxtEvento,$TxtFuncion,$TxtAncho,$TxtAlto,$ReadOnly,$Required);
		print("<input type='submit' name='BtnEditar' value='' style='width: 10px;height: 10px;'>");
		$this->CerrarForm();
		print('</td>');
                               
		
	}
	
	
	/////////////////////Crear una columna con un formulario
	
	function ColTablaInputText($TxtName,$TxtType,$TxtValue,$TxtLabel,$TxtPlaceh,$TxtColor,$TxtEvento,$TxtFuncion,$TxtAncho,$TxtAlto,$ReadOnly,$Required){
		print('<td>');
		
		$this->CrearInputText($TxtName,$TxtType,$TxtLabel,$TxtValue,$TxtPlaceh,$TxtColor,$TxtEvento,$TxtFuncion,$TxtAncho,$TxtAlto,$ReadOnly,$Required);
		
		print('</td>');
                               
		
	}
	
	/////////////////////Crear una columna con un formulario
	
	function ColTablaBoton($nombre,$value){
		print('<td>');
		
		$this->CrearBoton($nombre,$value);
		
		print('</td>');
                               
		
	}
	
	
	function CreaMenuBasico($Title){
		print('<div id="MenuBasico">
			<ul class="nav">
				
				<li><a href="">'.$Title.'</a>
					<ul>
						
						
						
					
				
	');
		
		                              
		
	}
	
	function CreaSubMenuBasico($Title,$Link){
		print('<li><a href="'.$Link.'" target="_blank">'.$Title.'</a></li>');
	}
	
	function CierraMenuBasico(){
		print('</ul></li></ul></div>');
	}
	
	function CrearImageLink($page,$imagerute,$target){
		print('<a href="'.$page.'" target="'.$target.'"><img src="'.$imagerute.'"></a>');
	}
	function CrearLink($link,$target,$Titulo){
		print('<a href="'.$link.'" target="'.$target.'">'.$Titulo.'</a>');
	}
	
	/////////////////////Crear una fila para una tabla
	function CrearFilaNotificacion($Mensaje,$FontSize){
		print('<tr><div class="alert alert-success" align="center" style="font-size:'.$FontSize.'px"><strong>'.$Mensaje.'</strong></div></tr>');
		
	}
	
	
	//////////////////////////////////FIN
}
	
	

?>