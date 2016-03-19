<?php
/***********************************************
Autor 		: Enrique Quijon
Objetivo	: Definición de Clases Generales 
Creación	: 01/06/2014. 
************************************************/

/* TABLA - PREGUNTAS */
class Preguntas{
    //Atributos
	public $id_pregunta_encuesta;
	public $id_seccion;
	public $id_encuesta;
    public $pregunta;
    public $opcion_1;
	public $opcion_2;
	public $opcion_3;
	public $opcion_4;
	public $opcion_5;
	public $opcion_6;
	public $opcion_7;
	public $opcion_8;
	public $valores;
    
    //Constructor
    public function  __construct($i,$s,$e,$p,$o1,$o2,$o3,$o4,$o5,$o6,$o7,$o8,$v) {
		$this->id_pregunta_encuesta=$i;
		$this->id_seccion=$s;
		$this->id_encuesta=$e;
        $this->pregunta=$p;
        $this->opcion_1=$o1;
		$this->opcion_2=$o2;
		$this->opcion_3=$o3;
		$this->opcion_4=$o4;
		$this->opcion_5=$o5;
		$this->opcion_6=$o6;
		$this->opcion_7=$o7;
		$this->opcion_8=$o8;
		$this->valores=$v;
    }

}

/* TABLA - RESPUESTAS */
class Respuestas{
    //Atributos
	public $ID_Pregunta_1;
	public $ID_Pregunta_2;
	public $ID_Pregunta_3;
    public $ID_Pregunta_4;
    public $ID_Pregunta_5;
	public $ID_Pregunta_6;
	public $ID_Pregunta_7;
	public $ID_Pregunta_8;
	public $ID_Pregunta_9;
	public $ID_Pregunta_10;

    //Constructor
    public function  __construct($r1,$r2,$r3,$r4,$r5,$r6,$r7,$r8,$r9,$r10) {
		$this->ID_Pregunta_1=$r1;
		$this->ID_Pregunta_2=$r2;
		$this->ID_Pregunta_3=$r3;
        $this->ID_Pregunta_4=$r4;
        $this->ID_Pregunta_5=$r5;
		$this->ID_Pregunta_6=$r6;
		$this->ID_Pregunta_7=$r7;
		$this->ID_Pregunta_8=$r8;
		$this->ID_Pregunta_9=$r9;
		$this->ID_Pregunta_10=$r10;
	}

}

/* TABLA - USUARIOS */
class Usuarios{
    //Atributos
	public $id_usuario;
	public $nombre;
	public $email;
    public $clave;
    
    //Constructor
    public function  __construct($u,$n,$e,$c) {
		$this->id_usuario=$u;
		$this->nombre=$n;
		$this->email=$e;
        $this->clave=$c;
    }

}

/* TABLA - SECCION */
class Secciones{
    //Atributos
	public $id_encuesta;
	public $id_seccion;
	public $id_pregunta;
    
    //Constructor
    public function  __construct($e,$s,$p) {
		$this->id_encuesta=$e;
		$this->id_seccion=$s;
		$this->id_pregunta=$p;
    }

}
?>
