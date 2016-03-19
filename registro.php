<?php 
require_once ('EncuestaDAO.class.php');
session_start();

$_SESSION['existe'] = false;
if(isset ($_GET['action'])){
    //Si el cliente ha seleccionado un producto
	switch ($_GET['action']){
        case 'registrar':
			$encuestaDAO = new EncuestaDAO();
			$nombre= $_POST['nombre'];
			$email= $_POST['email'];
			$clave= $_POST['clave'];
			
			$usuarios = $encuestaDAO->obtenerClave($_POST['email']);
			if ($usuarios){
				$_SESSION['msj'] ="Ya existe un usuario registrado con este Email, intente con otro.";
				$_SESSION['recupera'] = false;
				
				echo "<script LANGUAGE='JavaScript'>";
				echo "parent.location.href = 'registro.php';";
				echo "</script>";
			 break;
			
			}else{
				$usuarios = $encuestaDAO->guardarUsuario($_POST['nombre'],$_POST['email'],$_POST['clave']);
				
				//Enviar correo
				$destinatario = $_POST['email'];
				$remitente = "noreply@importadorabbb.cl";
				$asunto = "Formulario de Encuestas";
					
				$cuerpo = '
				<html>
				<head>
				   <title>Importadora BBB</title>
				</head>
				<body>
				<p><b>Estimado(a) '.$_POST['nombre'].', garcias por su preferencia. </p>
				<br>Favor le rogamos llenar la siguiente encuesta para mejorar nuestra atención y darle un mejor sercicio de calidad.
				<br>
				<br>Para Iniciar la encuesta piche <a href="www.mzcontrol.cl/bbb"><b>Aquí</b></a>
				<br>
				<br>
				<p><b>Saludos Cordiales</p>
				<p><b>Atte,</p>
				<p><b>Importadora BBB</p>
				</body>
				</html>
				';

				//para el envío en formato HTML
				$headers = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
				$headers .= "From: Importadora BBB <$remitente>\r\n";
				$headers .= "Reply-To: $remitente\r\n";
				$headers .= "Return-path: $remitente\r\n";

				mail($destinatario,$asunto,$cuerpo,$headers); 
				
				$_SESSION['msj'] ="";
				$_SESSION['recupera'] = false;
				
				echo "<script LANGUAGE='JavaScript'>";
				echo "alert('Su registro se ha completado exitosamente.');";
				echo "parent.location.href = 'index.php';";
				echo "</script>";
			}
            break;
		
		case 'recuperar':		
			
			$encuestaDAO = new EncuestaDAO();
			$email= $_POST['email'];
			$usuarios = $encuestaDAO->obtenerClave($_POST['email']);
			foreach ($usuarios as $usuario){
				$nombre = $usuario->nombre;
				$clave = $usuario->clave;
				
				//Enviar correo
				$destinatario = $_POST['email'];
				$remitente = "noreply@importadorabbb.cl";
				$asunto = "Obtener Clave Secreta";
					
				$cuerpo = '
				<html>
				<head>
				   <title>Importadora BBB</title>
				</head>
				<body>
				<p><b>Estimado(a) '.$nombre.', su clave secreta es: <b>'.$clave.'</b></p>
				<br>
				<br>Para acceder a la encuesta piche <a href="www.mzcontrol.cl/bbb"><b>Aquí</b></a>
				<br>
				<br>
				<p><b>Saludos Cordiales</p>
				<p><b>Atte,</p>
				<p><b>Importadora BBB</p>
				</body>
				</html>
				';

				//para el envío en formato HTML
				$headers = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
				$headers .= "From: Importadora BBB <$remitente>\r\n";
				$headers .= "Reply-To: $remitente\r\n";
				$headers .= "Return-path: $remitente\r\n";

				mail($destinatario,$asunto,$cuerpo,$headers); 
				
				$_SESSION['recupera'] = true;
				$_SESSION['msj'] ="";
				echo "<script LANGUAGE='JavaScript'>";
				echo "alert('Su clave ha sido enviada a su correo.');";
				echo "parent.location.href = 'registro.php';";
				echo "</script>";
			
			}
			if (!$usuarios){
				$_SESSION['recupera'] = true;
				$_SESSION['msj'] = "El Email ingresado no esta en nuestros registros, favor intente con otro.";
				echo "<script LANGUAGE='JavaScript'>";
				echo "parent.location.href = 'registro.php';";
				echo "</script>";
			}
			break;
			
		case 'volver':
			$_SESSION['recupera'] = false;
			$_SESSION['msj'] ="";
			
			echo "<script LANGUAGE='JavaScript'>";
			echo "parent.location.href = 'index.php';";
			echo "</script>";
			break;
		
		case 'iniciar':
			$_SESSION['recupera'] = true;
			$_SESSION['msj'] ="";
			
			echo "<script LANGUAGE='JavaScript'>";
			echo "parent.location.href = 'registro.php';";
			echo "</script>";
			break;
	}
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Registro de Usuarios</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="image/x-icon" href="images/encuesta.ico" rel="shortcut icon" />
<link type="image/x-icon" href="images/encuesta.ico" rel="icon" />
<link href="css/estilos.css" type="text/css" rel="stylesheet" media="screen"  />
<script language="javascript" type="text/javascript" src="js/md5.js"></script>
<script type="text/javascript" src="js/funcion.js"></script>
<script type="text/javascript">
function ValidarFormulario(){
	if (vacio(document.formulario_registro.nombre.value,'Error: Debe ingresar su nombre') == false){
		document.formulario_registro.nombre.focus();
	}else{
		if (email(document.formulario_registro.email.value,'Error: Debe ingresar email del contacto') == false){
			document.formulario_registro.email.focus();
			return false;
		}else{
			if (vacio(document.formulario_registro.clave.value,'Error: Debe ingresar una Clave') == false){
				document.formulario_registro.clave.focus();
			}else{
				if (document.formulario_registro.clave.value.length < 6){
					alert('Error: Su Clave debe tener por lo menos 6 caracteres');
					document.formulario_registro.clave.focus();
				}else{
					if (document.formulario_registro.clave.value!=document.formulario_registro.clave2.value){
						alert('Error: Su Clave no coinciden con la verificacion');
						document.formulario_registro.clave.focus();
						return false;
					}else{
						document.formulario_registro.action="registro.php?action=registrar";
						document.formulario_registro.submit();
					}
				}	
			}
		}
	}
}	

function ValidarRecupera(){

	theForm	= document.formulario_recupera;


	if (email(theForm.email.value,'Error: Debe ingresar email del contacto') == false){
		theForm.email.focus();
	}else{
		document.formulario_recupera.action="registro.php?action=recuperar";
		document.formulario_recupera.submit();
	}
}

function volver()
{
	document.formulario_recupera.action="registro.php?action=volver";
	document.formulario_recupera.submit();
}
</script>

</head>

<body id="dwContacto">
<!--cabecera-->
<div id="fondoBlanco">
	<!--inicio content-->
	<div class="content">
	<header>
		<div id="header"> 
			<a href="index.php"><img src="images/logo.jpg" alt="Encuestas" width="210" height="46" border="0" class="head_logo" /></a>
		</div>
	</header>

	<?if (!$_SESSION['recupera']){?>

	<h1>Registro de Usuarios</h1>
	<h3>Ingrese sus datos.</h3><br class="clear" />

	<!--cuadro dialogo-->
	<div id="miniContacto">
	</div>
	<p>Nos permitirá conocerte y darte una atención personalizada.</p>
	<!--formulario contacto-->
	<div id="formu1">

	<form method="post" id="formulario_registro" name="formulario_registro" >
	
			<label for="finput" class="flabel">Nombre:</label>
			<input name="nombre" class="finput" type="text" id="nombre" tabindex="1" maxlength="100" value="" /><br />
			<label for="finput" class="flabel">Email:</label>
			<input type="email" class="finput" name="email" id="email" maxlength="60" tabindex="2" value="" /><br />
			<p>Ingrese su clave secreta (debe tener al menos 6 caracteres)</p><br />
			<label for="finput" class="flabel">Clave:</label>
			<input name="clave" class="finput" type="password" id="clave" maxlength="20" tabindex="3" value=""/><br /> 
			<label for="finput" class="flabel">Repita Clave:</label>
			<input name="clave2" class="finput" type="password" id="clave2" maxlength="20" tabindex="4" value=""/><br />
			<br class="clear" />
			<input type="button" class="link_button" value="Registrese" name="botonEnviar" onclick="ValidarFormulario();"/>
			<input type="button" class="link_button" value="Volver" name="botonVolver" onclick="window.location='registro.php?action=volver'" />
			<br class="clear" /><br/>	
			<h3><? echo $_SESSION['msj']?></h3>  	
			<br class="clear" />

	</form>

</div>

<?}else{?>

<h1>Recupera Contrase&ntilde;a</h1>
<!--cuadro dialogo-->
<div id="miniContacto">
</div>
<h3>Favor ingrese el Email con el cual se registro para enviarle su Contrase&ntilde;a.</h3>
<!--formulario contacto-->
<div id="formu1">
<form method="post" name="formulario_recupera" action="registro.php">
<fieldset>
<h4>Obtener Contrase&ntilde;a</h4>

  <label for="email" class="fm1_label">Email:</label>
  <input type="email" name="email" id="email" maxlength="60" tabindex="1" value="" /><br />
  <br class="clear" />
  <input type="image" name="botonEnviar" id="botonEnviar" src="images/botonEnviar.png" tabindex="2" onclick="ValidarRecupera()" />
  <input type="image" name="botonVolver" id="botonVolver" src="images/botonVolver.png" tabindex="3" onclick="volver()" />
  <br class="clear" /><br/>	
  <h3><? echo $_SESSION['msj']?></h3>  
  <br class="clear" />
</fieldset>
</form>

</div>

<?}?>
</div>
</div>
</body>
</html>

