<?php 
require_once ('EncuestaDAO.class.php');
session_start();

//Parámetros de entrada
$id_encuesta = 1;

$_SESSION['Enc_Acceso'] = false;
$_SESSION['msj'] = "";
if(isset ($_GET['action'])){
    //Si el cliente ha seleccionado un producto
	switch ($_GET['action']){
        case 'entrar':
			$encuestaDAO = new EncuestaDAO();
			$usuarios = $encuestaDAO->obtenerUsuario(0, $_POST['email'], $_POST['clave']);
			foreach ($usuarios as $usuario){
				//verifico que no haya completado el formulario_acceso
				$respuestas = $encuestaDAO->obtenerRespuestas($id_encuesta, $usuario->id_usuario);
				$entra = 0;
				$_SESSION['Enc_Pregunta'] = 0;
				foreach ($respuestas as $respuesta){
					$entra = 1;
					if ($respuesta->ID_Pregunta_1 == 0){ 
						$_SESSION['Enc_Pregunta'] = 1;
					}else{
						if ($respuesta->ID_Pregunta_2 == 0){
							$_SESSION['Enc_Pregunta'] = 2;
						}else{
							if ($respuesta->ID_Pregunta_3 == 0){ 
								$_SESSION['Enc_Pregunta'] = 3;
							}else{
								if ($respuesta->ID_Pregunta_4 == 0){ 
									$_SESSION['Enc_Pregunta'] = 4;
								}else{
									if ($respuesta->ID_Pregunta_5 == 0){ 
										$_SESSION['Enc_Pregunta'] = 5;
									}else{
										if ($respuesta->ID_Pregunta_6 == 0){ 
											$_SESSION['Enc_Pregunta'] = 6;
										}else{
											if ($respuesta->ID_Pregunta_7 == 0){ 
												$_SESSION['Enc_Pregunta'] = 7;
											}else{
												if ($respuesta->ID_Pregunta_8 == 0){ 
													$_SESSION['Enc_Pregunta'] = 8;
												}else{
													if ($respuesta->ID_Pregunta_9 == 0){ 
														$_SESSION['Enc_Pregunta'] = 9;
													}else{
														if ($respuesta->ID_Pregunta_10 == 0){ 
															$_SESSION['Enc_Pregunta'] = 10;
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
				if ($_SESSION['Enc_Pregunta'] == 0 && $entra==1){	
					$_SESSION['finalizar'] = 1;
					echo "<script type='text/javascript'>";
					echo "parent.location.href = 'cerrar.php';";
					echo "</script>";
					exit;
				}else{
					$_SESSION['Enc_Acceso'] = true;
					$_SESSION['Enc_IdUsuario'] = $usuario->id_usuario;
					$_SESSION['Enc_NomUsuario'] = $usuario->nombre;
					$_SESSION['Enc_EmailUsuario'] = $usuario->email;
					$_SESSION['msj'] = "";
				
					echo "<script type='text/javascript'>";
					echo "parent.location.href = 'encuestas.php';";
					echo "</script>";
				}
			}
					
			if (!$_SESSION['Enc_Acceso']){
				$_SESSION['msj'] = "Los datos ingresados no son válidos";
			}
			break;
		case 'cerrar':
			
			session_destroy();
			echo "<script type='text/javascript'>";
			echo "parent.location.href = 'index.php';";
			echo "</script>";
	
            break;
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Sistema de Encuestas Importadora BBB</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="image/x-icon" href="images/encuesta.ico" rel="shortcut icon" />
<link type="image/x-icon" href="images/encuesta.ico" rel="icon" />
<link href="css/estilos.css" type="text/css" rel="stylesheet" media="screen"  />
<script language="javascript" type="text/javascript" src="js/md5.js"></script>
<script type="text/javascript" src="js/funcion.js"></script>
<script type="text/javascript">
function Validaciones(){
	theForm	= document.formulario_acceso;
	
	if (email(theForm.email.value,'Error: Su Email es incorrecto') == false){
	theForm.email.focus();
	}else{
		if (vacio(theForm.clave.value,'Error: Debe ingresar su Clave') == false){
		theForm.clave.focus();
		}else{
			theForm.action="index.php?action=entrar";
			theForm.submit();
		}
	}	
}
</script>
</head>

<body id="dwHome">
<!--cabecera-->
<div id="fondoBlanco">
	<!--inicio content-->
	<div class="content_access">
	<header>
    <div id="header">  
     	<a href="index.php"><img src="images/logo.jpg" alt="Encuestas" width="210" height="46" border="0" class="head_logo" /></a>
	</div>
	</header> 
		<span align="center"><h1>Encuesta de Satisfacción<h1></span>
		<h4>Inicio de Sesi&oacute;n</h4>
		<div class="clear"></div>
		<form method="post" id="formulario_acceso" name="formulario_acceso" >	
			<div class="clear"></div><br>
			<label for="finput_principal" class="flabel_principal">&nbsp;EMail</label>
			<input name="email" class="finput_principal" id="email" value="" type="email" maxlength="60">
			<div class="clear"></div><br>
			<label for="finput_principal" class="flabel_principal">&nbsp;Clave</label>
			<input name="clave" class="finput_principal" id="clave" type="password" maxlength="60">
			<p class="texto_pequeño"><?echo $_SESSION['msj']?></p>
			<div class="clear"></div><br>
			<input type="button" class="link_button" value="Iniciar Sesi&oacute;n" name="enviar" onclick="Validaciones();" />
			<div class="clear"></div><br>
			<a href="registro.php">Reg&iacute;strate</a><br>
			<div class="clear"></div><br>
			<a href="registro.php?action=iniciar">¿Olvido su clave?</a><br>
			<div class="clear"></div><br>
	    </form>
	</div>
</div>
</body>	  

</html>