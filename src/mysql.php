<?php

namespace mysqlconnect;

class mysql{

    private $link;
	
	public function _limpiar($texto)
	{
		return $this->link->real_escape_string($texto);
	}
	
	public function __construct($host,$user,$passwd,$port,$db)
	{
		$V_principal['_BD'] = array();
		//HOSTING BASE DE DATOS.
		$V_principal['_BD']['BD_HOST']      = $host;
		//USUARIO BASE DE DATOS.
		$V_principal['_BD']['BD_USUARIO']   = $user;
		//CONTRASENA BASE DE DATOS.
		$V_principal['_BD']['BD_PASSWORD']  = $passwd;
		//PUERTO BASE DE DATOS.
		$V_principal['_BD']['BD_PUERTO']    = $port;
		//BASE DE DATOS.
        $V_principal['_BD']['BD_BD']        = $db;
        

		$this->link = new \mysqli($V_principal['_BD']['BD_HOST'], $V_principal['_BD']['BD_USUARIO'], $V_principal['_BD']['BD_PASSWORD'], $V_principal['_BD']['BD_BD'], $V_principal['_BD']['BD_PUERTO']);
		$this->link->set_charset("utf8");
	}
	
	public function __destruct() 
	{
		$this->link->close();
	}
	
	public function _ultimo_id(){
		return $this->link->insert_id;
	}
	
	public function _db_consulta($sql)
	{
		
		
		$result = $this->link->query($sql);
		if($result instanceof \mysqli_result)
		{
				$data = array();

				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				
				$result1 = new \stdClass();
				$result1->num_rows = $result->num_rows;
				$result1->row = isset($data[0]) ? $data[0] : array();
				$result1->rows = $data;
				
		}
		else
		{  	
			return false;
		}
		//$this->link->close();
		return $result1;
	}

}