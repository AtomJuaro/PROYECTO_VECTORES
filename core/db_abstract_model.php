<?php
abstract class DBAbstractModel{
	private static $db_host = 'localhost';
	private static $db_user = 'AdminVectores';
	private static $db_pass = 'VectoresAdmin';
	protected $db_name = 'mydb';
	protected $query;
	protected $rows = array();
	private $conn;
	public $mensaje = 'Hecho';

	#métodos abstactos para ABM de clases que hereden
	abstract protected function get();
	abstract protected function set();
	abstract protected function edit();
	abstract protected function delete();

	#metodos no abstractos
	#conectar db
	private function open_connection() {
		$this->conn = new mysqli(self::$db_host, self::$db_user, 
										self::$db_pass, $this->db_name);
	}
	#desconectar db
	private function close_connection(){
		$this->conn->close();
	}
	#ejecutar query simple (INSERT DELETE UPDATE)
	###necesita arreglo pagina 56 bahitpoo
	protected function execute_single_query(){
		$this->open_connection();
		$this->conn->query($this->query);
		$this->close_connection();
	}
	#resultados de consulta en un Array

	protected function get_results_from_query() { 
		//print "<br>abrir conexion";
		$this->open_connection();
		//print "<br>conexion abierta";
		$result = $this->conn->query($this->query); 
		while ($this->rows[] = $result->fetch_assoc()); 
		$result->close();
        $this->close_connection();
        array_pop($this->rows);
     }

     function get_rows(){
     	return $this->rows;
     }
	protected function numero_de_filas($result){
  		if(!is_resource($result)) 
  			return false;
  		return mysql_num_rows($result);
 }
}
?>