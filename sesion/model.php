<?php
require_once('../core/db_abstract_model.php');

class Login extends DBAbstractModel{
############################### PROPIEDADES ################################
	public $sPassword;
	public $sTipoUsuario;
	public $sNombre;
	public $sRfc;
################################# MÉTODOS ##################################

	function __construct(){
		$this->db_name='bdVectores';
	}

	public function get($rfc_usuario='',$sector_clave=''){
		if($sector_clave != '' && $rfc_usuario != ''){
			$this->query ="
				SELECT 	sPassword, sTipoUsuario, sNombre, sRfc
				FROM 	Usuario
				WHERE 	sRfc='$rfc_usuario' AND sPassword='$sector_clave'
			";
			$this->get_results_from_query();
		}
		if(count($this->rows)==1){
			foreach($this->rows[0] as $propiedad=>$valor){
				$this->$propiedad=$valor;
			}
			$this->mensaje ='Usuario encontrado';
			return TRUE;
		}else {
			$this->mensaje ='Usuario no encontrado';
			return FALSE;
		}
		return FALSE;
	}
				

	public function set($sector_data=array()){
		
	} 
	
	public function edit($sector_data=array()){

	}

	public function delete($sector_clave='', $sector_localidad=''){

	}
	public function getRfc(){
		return $this->sRfc;
	}
	public function getNombre(){
		return $this->sNombre;
	}
	public function getTipo(){
		return $this->sTipoUsuario;
	}
	function __destruct(){
		unset($this);
	} 
}

?>