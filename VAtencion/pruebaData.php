<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>Fechas</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script>
 $.datepicker.regional["es"] = {
 closeText: "Cerrar",
 prevText: "<Ant",
 nextText: "Sig>",
 currentText: "Hoy",
 monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
 monthNamesShort: ["Ene","Feb","Mar","Abr", "May","Jun","Jul","Ago","Sep", "Oct","Nov","Dic"],
 dayNames: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
 dayNamesShort: ["Dom","Lun","Mar","Mié","Juv","Vie","Sáb"],
 dayNamesMin: ["Do","Lu","Ma","Mi","Ju","Vi","Sá"],
 weekHeader: "Sm",
 dateFormat: "yy-mm-dd",
 firstDay: 0,
 isRTL: false,
 showMonthAfterYear: false,
 yearSuffix: ""
 };
 $.datepicker.setDefaults($.datepicker.regional["es"]);
$(function () {
$("#fecha").datepicker();
});
</script>
</head>
<body>
<label for="fecha">Fecha:
 <input type="text" id="fecha" value="" />
</label>
</body>
</html>