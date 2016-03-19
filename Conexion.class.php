<?php
/*****************************************
Autor 		: Enrique Quijon
Objetivo	: Capa de Conexión
Creación	: 01/06/2014. 
******************************************/

class Conexion{
     private $hilo;
     private $resultSet;

     public function  __construct($server = 'localhost',
                                            $username = 'mzcontro',
                                            $password = 'fx62A63oTr',
                                            $database = 'mzcontro_encuestas') {
        $this->hilo = mysql_pconnect($server,$username,$password);

        if(!$this->hilo){
            die('No se pudo conectar a la Base de Datos:' . mysql_error());
        }

        if(!mysql_select_db($database,$this->hilo)){
            die('No se pudo conectar a la BD '.$database.':'.  mysql_error());
        }
    }


    public function ejecutar($sql){
        $this->resultSet=mysql_query($sql);

        if(!$this->resultSet){
            die('No se pudo realzizar la consulta:<br />'.$sql.'<br />'.  mysql_error());
        }

        return $this->resultSet;
    }

    public function  __destruct() {
        if(!$this->hilo)mysql_close($this->hilo);
    }

}
?>
