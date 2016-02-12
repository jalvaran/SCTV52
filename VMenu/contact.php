<?php

			$nombre = $_POST['nombre'];
		   
			$email = 'info@decorambientesdelvalle.com';
			$mensaje = $_POST['mensaje'];
			$para = 'jalvaran@gmail.com';
			$titulo = 'Contacto desde la WEB';
			$header = 'From: ' . $email;
			$msjCorreo = "Nombre: $nombre\n E-Mail: $email\n Mensaje:\n $mensaje";

			
			if (mail($para, $titulo, $msjCorreo, $header)) {
			echo "<script>
			alert('Mensaje enviado, muchas gracias, pronto el administrador verá su mensaje y le responderá en el menor tiempo posible');
			window.location.href = 'http://santabrasa.com.co/';
			</script>";
			} else {
			echo 'Falló el envio';
			}
			
			


?>