<?php
require_once ('EncuestaDAO.class.php');

session_start();
if ($_SESSION['Enc_Acceso'] != 'S'){
	session_destroy();
	echo "<script LANGUAGE='JavaScript'>";
	echo "parent.location.href = 'cerrar.php';";
	echo "</script>";
}
//Parámetros de entrada
$id_encuesta = 1;
//$_SESSION['usuario'] = 1;
$msj="";
//verifica que exista el usuario en la tabla de respuestas
$encuestaDAO = new EncuestaDAO();
$preguntas = $encuestaDAO->guardarPreguntasInicial($id_encuesta, $_SESSION['Enc_IdUsuario']);

if(!$_GET['id_seccion']){
	$id_seccion=1;
}else{
	$id_seccion= $_GET['id_seccion'];
}

if ($_SESSION['Enc_Pregunta'] == 1){
	$id_seccion=1;
}elseif ($_SESSION['Enc_Pregunta'] == 2 || $_SESSION['Enc_Pregunta'] == 3){
	$id_seccion=2;
}elseif ($_SESSION['Enc_Pregunta'] == 4 || $_SESSION['Enc_Pregunta'] == 5){
	$id_seccion=3;
}elseif ($_SESSION['Enc_Pregunta'] == 6 || $_SESSION['Enc_Pregunta'] == 7){
	$id_seccion=4;	
}elseif ($_SESSION['Enc_Pregunta'] == 8){
	$id_seccion=5;	
}elseif ($_SESSION['Enc_Pregunta'] == 9 || $_SESSION['Enc_Pregunta'] == 10){
	$id_seccion=6;		
}	
$_SESSION['Enc_Pregunta'] = 0;

if(isset ($_GET['action'])){
    $id_encuesta= $_GET['id_encuesta'];
	$id_pregunta= $_GET['id_pregunta'];
	$radio= $_GET['radio'];
	$valor= $_GET['valor'];
	switch ($_GET['action']){
        case 'guardar':
            $encuestaDAO = new EncuestaDAO();
			$preguntas = $encuestaDAO->guardarPreguntas($id_encuesta, $_SESSION['Enc_IdUsuario'], $radio, $valor);
            header('Location: encuestas.php?$id_encuesta='.$id_encuesta.'&id_seccion='.$id_seccion);
			break;
		case 'validar':
			$id_seccion= $_GET['id_seccion'];
			$encuestaDAO = new EncuestaDAO();
			$secciones = $encuestaDAO->obtenerSecciones($id_encuesta, $id_seccion);
			$siguiente = 1;
			foreach ($secciones as $seccion){
				$res = $encuestaDAO->obtenerPorRespuesta($id_encuesta, $_SESSION['Enc_IdUsuario'], $seccion->id_pregunta);
				//echo " - Respuesta: ".$res, " para la pregunta: ".$seccion->id_pregunta. " de la seccion: ".$id_seccion;
				if($res == 0) $siguiente = 0;
			}
			if ($siguiente == 1){
				$id_seccion = $id_seccion +1;
				$msj="";
			}else{
				$msj="Para continuar, debe marcar una opci&oacute;n de cada pregunta";
			}
            break;
    }
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link type="image/x-icon" href="images/encuesta.ico" rel="shortcut icon" />
<link type="image/x-icon" href="images/encuesta.ico" rel="icon" />
<link rel="stylesheet" type="text/css" href="css/estilos.css">
<title>..:: Sistema de Encuestas Importadora BBB</title>
<script type="text/javascript">
	function validarRadio(id_seccion){
		opciones = document.form.getElementById("ID_Pregunta_1").checked;
		if (opciones == "") {
			alert('Debe seleccionar una opcion');
		}else{
			document.form.action="'encuestas.php?id_seccion="+id_seccion;
			document.form.submit();
		}
	
	}
	
	function validarRadio2(id_seccion){
       opciones = document.form.getElementById("ID_Pregunta_1").checked;
		if (opciones == "") {
			alert('Debe seleccionar una opcion');
		}else{
			document.form.action="'encuestas.php?id_seccion="+id_seccion;
			document.form.submit();
		}
	}
 
</script>
</head>
<body id="dwHome">
<!--cabecera-->
<div id="fondoBlanco">
	<!--inicio content-->
	<div class="content">	
	<header>
	<div id="header">  
		<a href="index.php"><img src="images/logo.jpg" alt="Encuestas" width="210" height="46" border="0" class="head_logo" /></a>
	</div>
	</header> 
	
	<form name="form" action="" method="post">
		<?if ($id_seccion >= 1 && $id_seccion <= 6){?>
			<h1>Queremos conocer tu opini&oacute;n</h1>
			<h4>Considerando esta visita, cu&eacute;ntanos que tan satisfecho estas con el servicio otorgado por parte de nuestra importadora<br>utilice una escala de 1 a 7, donde 1 es la "Peor Nota" y 7 la "mejor Nota"</h4>
			<?
			//Obtener Preguntas
			$encuestaDAO = new EncuestaDAO();
			$preguntas = $encuestaDAO->obtenerPreguntas($id_encuesta, $id_seccion);
			$j=1;
			foreach ($preguntas as $pregunta){
				if ($j == 1){?>
					<h3><? echo $encuestaDAO->obtenerNombreSeccion($id_seccion);?></h3>
				<?}?>
				<p><?echo $pregunta->pregunta;?></p>
				<?for ($i = 1; $i <= $pregunta->valores; $i++) {
					$respuestas = $encuestaDAO->obtenerRespuestas($id_encuesta, $_SESSION['Enc_IdUsuario']);
					$campo = "opcion_".$i;
					$valor_resultado = 0;
					
					foreach ($respuestas as $respuesta){
					if ($valor_resultado == 0){	
						for ($x = 1; $x <= 10; $x++) {
							if ($x == $pregunta->id_pregunta_encuesta){	
								if ($x == 1) $valor_resultado = $respuesta->ID_Pregunta_1;
								if ($x == 2) $valor_resultado = $respuesta->ID_Pregunta_2;
								if ($x == 3) $valor_resultado = $respuesta->ID_Pregunta_3;
								if ($x == 4) $valor_resultado = $respuesta->ID_Pregunta_4;
								if ($x == 5) $valor_resultado = $respuesta->ID_Pregunta_5;
								if ($x == 6) $valor_resultado = $respuesta->ID_Pregunta_6;
								if ($x == 7) $valor_resultado = $respuesta->ID_Pregunta_7;
								if ($x == 8) $valor_resultado = $respuesta->ID_Pregunta_8;
								if ($x == 9) $valor_resultado = $respuesta->ID_Pregunta_9;
								if ($x == 10) $valor_resultado = $respuesta->ID_Pregunta_10;
								//echo "muestra x: ".$x;
								//echo "   - muestra valor: ".$valor_resultado;
							}
						}
					}
					$nombre_control= "ID_Pregunta_".$pregunta->id_pregunta_encuesta;
					//echo $nombre_control;
					//exit;
					if ($i == $valor_resultado){?>
						<input type="radio" name="<? echo $nombre_control;?>" value="<?echo $i?>" checked="checked"
						onclick="window.location='encuestas.php?action=guardar&id_encuesta=<?php echo $id_encuesta?>&id_seccion=<?php echo $id_seccion?>&id_pregunta=<?echo $pregunta->id_pregunta_encuesta;?>&radio=ID_Pregunta_<? echo $pregunta->id_pregunta_encuesta?>&valor=<? echo $i?>'"><?echo $pregunta->$campo;?>
					<?}else{?>
						<input type="radio" name="<? echo $nombre_control;?>" value="<?echo $i?>" 
						onclick="window.location='encuestas.php?action=guardar&id_encuesta=<?php echo $id_encuesta?>&id_seccion=<?php echo $id_seccion?>&id_pregunta=<?echo $pregunta->id_pregunta_encuesta;?>&radio=ID_Pregunta_<? echo $pregunta->id_pregunta_encuesta?>&valor=<? echo $i?>'"><?echo $pregunta->$campo;?>
					<?}?>
					<?
					
					}
				}?><div class="clear"></div></br>
			<?$j=$j+1;
			}
			if ($id_seccion==1){?>
				<input type="button" class="link_button" value="Siguiente" onclick="window.location='encuestas.php?action=validar&id_encuesta=<?php echo $id_encuesta?>&id_seccion=<?php echo $id_seccion?>'">
			<?}if ($id_seccion >= 2 && $id_seccion <= 5){?>
				<input type="button" class="link_button" value="Atras" onclick="window.location='encuestas.php?id_seccion=<?php echo $id_seccion - 1?>'">
				<input type="button" class="link_button" value="Siguiente" onclick="window.location='encuestas.php?action=validar&id_encuesta=<?php echo $id_encuesta?>&id_seccion=<?php echo $id_seccion?>'">
			<?}if ($id_seccion==6){?>
				<input type="button" class="link_button" value="Atras" onclick="window.location='encuestas.php?id_seccion=<?php echo $id_seccion - 1?>'">
				<input type="button" class="link_button" value="Terminar" onclick="window.location='encuestas.php?action=validar&id_encuesta=<?php echo $id_encuesta?>&id_seccion=<?php echo $id_seccion?>'">
			<?}?>
			<p><span class="alerta_mensaje"><? echo $msj ?></span></p>
			<?exit;
		}
		if ($id_seccion == 7){
			$_SESSION['finalizar'] = 1;
			echo "<script type='text/javascript'>";
			echo "parent.location.href = 'cerrar.php';";
			echo "</script>";
			exit;
		}?>
		<h1>&iexcl;&iexcl;&iexcl; La opci&oacute;n ingresada no es valida !!!</h1>
		<input type="button" class="link_button" value="Iniciar" onclick="window.location='encuestas.php?id_seccion=1'">
	</form>
	</div>
</div>
</body>
</html>
