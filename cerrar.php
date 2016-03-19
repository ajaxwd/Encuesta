<?session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Sistema de Encuestas Importadora BBB</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="image/x-icon" href="images/encuesta.ico" rel="shortcut icon" />
<link type="image/x-icon" href="images/encuesta.ico" rel="icon" />
<link href="css/estilos.css" type="text/css" rel="stylesheet" media="screen"  />
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
		<?if ($_SESSION['finalizar'] == 1){
			session_destroy();?>
			</br>
			<span align="center"><h1>&iexcl;&iexcl;&iexcl; Gracias por haber participado en nuestra Encuesta !!!<h1></span>
		<?}else{?>
			</br>
			<h1><span align="center">&iexcl;&iexcl;&iexcl; No ha Iniciado su Sesión !!!</span><h1>
			<h4>Usted no ha iniciado Sesi&oacute;n, favor presione bot&oacute;n iniciar sesi&oacute;n</h4>
		
			<div class="clear"></div>
			<input type="button" class="link_button" value="Iniciar Sesi&oacute;n" name="enviar" onclick="window.location='index.php'" />
		<?}?>
	</div>	
</div>
</body>	  

</html>