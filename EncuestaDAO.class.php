<?php
/*****************************************
Autor 		: Enrique Quijon
Objetivo	: Capa de Datos
Creación	: 01/06/2014. 
******************************************/

require_once ('Encuesta.class.php');
require_once ('Conexion.class.php');
	
class EncuestaDAO{
    public $conexion;

    public function  __construct() {
        $this->conexion = new Conexion();
    }
	
//********************************************************************************//
//*********************** D A T O S   E N C U E S T A S **************************//
//********************************************************************************//
	
	public function obtenerPreguntas($id_encuesta, $id_seccion){
        $preguntas = array();
		$sql="SELECT p.id_pregunta_encuesta, s.id_seccion, p.id_encuesta, p.pregunta, p.opcion_1, p.opcion_2, p.opcion_3, p.opcion_4, p.opcion_5, p.opcion_6, p.opcion_7, p.opcion_8, p.valores FROM pregunta_encuestas p, seccion s WHERE p.id_encuesta = s.id_encuesta AND p.id_pregunta_encuesta = s.id_pregunta AND p.id_encuesta = ".$id_encuesta." AND s.id_seccion = ".$id_seccion." ORDER BY p.id_pregunta_encuesta";
		$result = $this->conexion->ejecutar($sql);
		while($array = mysql_fetch_array($result)){
		    //Creo una sola instancia que será devuelta..
            $preguntas[] = new Preguntas($array['id_pregunta_encuesta'],$array['id_seccion'],$array['id_encuesta'],$array['pregunta'],$array['opcion_1'],$array['opcion_2'],$array['opcion_3'],$array['opcion_4'],$array['opcion_5'],$array['opcion_6'],$array['opcion_7'],$array['opcion_8'],$array['valores']);
        }
        return $preguntas;
    }
	
	public function obtenerRespuestas($id_encuesta, $usuario){
        $respuestas = array();
		$sql="SELECT ID_Pregunta_1, ID_Pregunta_2, ID_Pregunta_3, ID_Pregunta_4, ID_Pregunta_5, ID_Pregunta_6, ID_Pregunta_7, ID_Pregunta_8, ID_Pregunta_9, ID_Pregunta_10 FROM Pond_Encuesta WHERE ID_Encuesta = ".$id_encuesta." AND ID_Persona = ".$usuario."";
		//echo $sql;
		//exit;
		$result = $this->conexion->ejecutar($sql);
		
		while($array = mysql_fetch_array($result)){
		    //Creo una sola instancia que será devuelta..
            $respuestas[] = new Respuestas($array['ID_Pregunta_1'],$array['ID_Pregunta_2'],$array['ID_Pregunta_3'],$array['ID_Pregunta_4'],$array['ID_Pregunta_5'],$array['ID_Pregunta_6'],$array['ID_Pregunta_7'],$array['ID_Pregunta_8'],$array['ID_Pregunta_9'],$array['ID_Pregunta_10']);
        }
        return $respuestas;
    }
	
	public function obtenerSecciones($id_encuesta, $id_seccion){
        $secciones = array();
		if ($id_seccion == 0){
			$sql="SELECT id_encuesta, id_seccion, id_pregunta FROM seccion ORDER BY id_encuesta, id_seccion, id_pregunta";
		}else{
			$sql="SELECT id_encuesta, id_seccion, id_pregunta FROM seccion WHERE id_seccion = ".$id_seccion." ORDER BY id_encuesta, id_seccion, id_pregunta";
		}	
		$result = $this->conexion->ejecutar($sql);
		while($array = mysql_fetch_array($result)){
		    //Creo una sola instancia que será devuelta..
            $secciones[] = new Secciones($array['id_encuesta'],$array['id_seccion'],$array['id_pregunta']);
        }
        return $secciones;
    }
	
	public function obtenerPorRespuesta($id_encuesta, $usuario, $id_pregunta){
        $respuesta = 0;
		$sql="SELECT ID_Pregunta_".$id_pregunta." FROM Pond_Encuesta WHERE ID_Encuesta = ".$id_encuesta." AND ID_Persona = ".$usuario."";
		$result = $this->conexion->ejecutar($sql);
		if($array = mysql_fetch_array($result)){
		    $respuesta = $array[0];
        }
        return $respuesta;
    }
	
	public function obtenerNombreSeccion($id_seccion){
        $seccion = null;
		if ($id_seccion==1){
			$seccion ="1. Satisfacci&oacute;n Inicial";
		}if ($id_seccion==2){
			$seccion ="2. Satisfacci&oacute;n de compra presencial";
		}if ($id_seccion==3){
			$seccion ="3. Satisfacci&oacute;n de compra on line";
		}if ($id_seccion==4){
			$seccion ="4. Satisfacci&oacute;n con los productos";
		}if ($id_seccion==5){
			$seccion ="5. Satisfacci&oacute;n Final";
		}if ($id_seccion==6){
			$seccion ="6. Recomendaci&oacute;n y recompra";	
		}	
		return $seccion;
    }
	
	function guardarPreguntas($id_encuesta, $usuario, $id_pregunta, $valor){
		//Autocommit = 0
		mysql_query("SET AUTOCOMMIT=0;"); //Para InnoDB, mantener la transaccion abierta
		
		//Inicio de transacción
		mysql_query("BEGIN;");
		
		//Verificamos si Existen datos de la Pregunta 
		$sql = "SELECT * FROM Pond_Encuesta WHERE ID_Encuesta=".$id_encuesta." AND ID_Persona=".$usuario."";
		$result = $this->conexion->ejecutar($sql);
        if($array = mysql_fetch_array($result)){
			//Actualiza el Registro
			$sql = "UPDATE Pond_Encuesta SET";
			$sql .= " $id_pregunta=$valor";
			$sql .= " WHERE ID_Encuesta = ".$id_encuesta." AND"; 
			$sql .= " ID_Persona = ".$usuario.""; 
			
			//echo $sql;
			//exit;
		}else{
			//Inserta Registro
			$date= date('Y-m-d', time());
			$sql = "insert into Pond_Encuesta (ID_Encuesta,ID_Persona,Fec_Ing, $id_pregunta) ";
			$sql .= "values ($id_encuesta, $usuario, '$date', $valor)";
			//echo $sql;
			//exit;
		}
		$rs =$this->conexion->ejecutar($sql);
		
		if(!$rs){
			echo "Error en la Transacción: ".mysql_error();
			mysql_query("ROLLBACK;");    //Terminar la transaccion si hay error
			exit();
		}
		
		$preguntas = mysql_insert_id();

        if ($rs) {
			mysql_query("COMMIT");      //Terminar la transaccion
		}

		return $preguntas;
    }
	
	function guardarPreguntasInicial($id_encuesta, $usuario){
		//Autocommit = 0
		mysql_query("SET AUTOCOMMIT=0;"); //Para InnoDB, mantener la transaccion abierta
		
		//Inicio de transacción
		mysql_query("BEGIN;");
		
		//Verificamos si Existen datos de la Pregunta 
		$sql = "SELECT * FROM Pond_Encuesta WHERE ID_Encuesta=".$id_encuesta." AND ID_Persona=".$usuario."";
		$result = $this->conexion->ejecutar($sql);
        if(!$array = mysql_fetch_array($result)){
			//Inserta Registro
			$date= date('Y-m-d', time());
			$sql = "insert into Pond_Encuesta (ID_Encuesta,ID_Persona,Fec_Ing) ";
			$sql .= "values ($id_encuesta, $usuario, '$date')";
			//echo $sql;
			//exit;
		}
		$rs =$this->conexion->ejecutar($sql);
		
		if(!$rs){
			echo "Error en la Transacción: ".mysql_error();
			mysql_query("ROLLBACK;");    //Terminar la transaccion si hay error
			exit();
		}
		
		$preguntas = mysql_insert_id();

        if ($rs) {
			mysql_query("COMMIT");      //Terminar la transaccion
		}

		return $preguntas;
    }
//********************************************************************************//
//************************* D A T O S   U S U A R I O S **************************//
//********************************************************************************//
	
	//Recupero en un array de todos los Usuarios
    public function obtenerUsuario($id, $email, $clave){
        $usuarios =  array();
		if($id==0){
			$sql = "SELECT id_usuario, nombre, email, clave";
			$sql .= " FROM Pond_Usuario WHERE clave='".$clave."' AND email='".$email."'";
		}else{
			$sql = "SELECT id_usuario, nombre, email, clave";
			$sql .= " FROM Pond_Usuario WHERE id_usuario=".$id."";
		}
		$result = $this->conexion->ejecutar($sql);
		while($array = mysql_fetch_array($result)){
            //Creo una instanacia del cliente y lo almanceo en el array
    		$usuarios[] = new Usuarios($array['id_usuario'],$array['nombre'],$array['email'],$array['clave']);
        }
        return $usuarios;
    }
	
	//Recupero en un array de todos los Usuarios
    public function obtenerClave($email){
       $usuarios =  array();
		
		$sql = "SELECT id_usuario, nombre, email, clave";
		$sql .= " FROM Pond_Usuario WHERE email='".$email."'";
		$result = $this->conexion->ejecutar($sql);
		while($array = mysql_fetch_array($result)){
            //Creo una instanacia del cliente y lo almanceo en el array
    		$usuarios[] = new Usuarios($array['id_usuario'],$array['nombre'],$array['email'],$array['clave']);
        }
        return $usuarios;
    }
	
	
	function guardarUsuario($nombre, $email, $clave){
		//Autocommit = 0
		mysql_query("SET AUTOCOMMIT=0;"); //Para InnoDB, mantener la transaccion abierta
		
		//Inicio de transacción
		mysql_query("BEGIN;");
		
		//Operaciones en pedido
		$sql = "insert into Pond_Usuario (nombre,email,clave) ";
		$sql .= "values ('$nombre','$email','$clave')";
		$rs =$this->conexion->ejecutar($sql);
		
		if(!$rs){
			echo "Error en la Transacción: ".mysql_error();
			mysql_query("ROLLBACK;");           //Terminar la transaccion si hay error
			exit();
		}
		
		$usuarios = mysql_insert_id();

        if ($rs) {
			mysql_query("COMMIT");      //Terminar la transaccion
		}

		return $usuarios;
    }
	
	function modificarUsuario($id, $nombre, $email){
		//Autocommit = 0
		mysql_query("SET AUTOCOMMIT=0;"); //Para InnoDB, mantener la transaccion abierta
		
		//Inicio de transacción
		mysql_query("BEGIN;");
		
		$fec_nac = date("Y-m-d",strtotime($fec_nac));
		
		//Operaciones en pedido
		$sql = "update Pond_Usuario SET";
		$sql .= " nombre = '$nombre',";
		$sql .= " email = '$email'";
		$sql .= " WHERE id_usuario = $id";
		$rs =$this->conexion->ejecutar($sql);
		
		if(!$rs){
			echo "Error en la Transacción: ".mysql_error();
			mysql_query("ROLLBACK;");           //Terminar la transaccion si hay error
			exit();
		}
		
		$usuarios = mysql_insert_id();

        if ($rs) {
			mysql_query("COMMIT");      //Terminar la transaccion
		}

		return $usuarios;
    }
	
	function cambiarClave($id, $clave){
		//Autocommit = 0
		mysql_query("SET AUTOCOMMIT=0;"); //Para InnoDB, mantener la transaccion abierta
		
		//Inicio de transacción
		mysql_query("BEGIN;");
		
		$sql = "update Pond_Usuario SET";
		$sql .= " clave = $clave";
		$sql .= " WHERE id_usuario = $id";
		$rs =$this->conexion->ejecutar($sql);
		
		if(!$rs){
			echo "Error en la Transacción: ".mysql_error();
			mysql_query("ROLLBACK;");           //Terminar la transaccion si hay error
			exit();
		}
		
		$cambio_clave = mysql_insert_id();

        if ($rs) {
			mysql_query("COMMIT");      //Terminar la transaccion
		}

		return $cambio_clave;
    }
	
}
?>
