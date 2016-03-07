<?php 
		
///////////////////////////////
////////Si se solicita borrar algo
////
////
$statement=" $myTabla WHERE Referencia='NJF4042'";
if(!empty($_REQUEST['del'])){
        $id=$_REQUEST['del'];
        $Tabla=$_REQUEST['TxtTabla'];
        $IdTabla=$_REQUEST['TxtIdTabla'];
        $IdPre=$_REQUEST['TxtIdPre'];
        mysql_query("DELETE FROM $Tabla WHERE $IdTabla='$id'") or die(mysql_error());
        header("location:Devoluciones.php?TxtAsociarRemision=$IdPre");
	}
	


///////////////fin
?>
