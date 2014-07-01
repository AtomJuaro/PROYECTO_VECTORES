<?php
require_once('../core/db_abstract_model.php');

class Usuario extends DBAbstractModel{
############################### PROPIEDADES ################################
	//propiedades protegida sRfc, privada sEmail
	public $sRfc;
	public $sApeMaterno;
	public $sApePaterno;
	public $sNombre;
	public $sEmail;
	public $sPassword;
	public $sTipoUsuario;
################################# MÉTODOS ##################################


	function __construct(){
		$this->db_name='bdVectores';
	}

	public function get($user_rfc=''){
		//print "ESTOY EN GET DEl MODELO";
		if($user_rfc != ''){
			$this->query ="
				SELECT 	sRfc, sApeMaterno, sApePaterno, sNombre, sEmail, sPassword, sTipoUsuario
				FROM 	Usuario
				WHERE 	sRfc='$user_rfc'
			";
			$this->get_results_from_query();
		}
		if(count($this->rows)==1){
			foreach($this->rows[0] as $propiedad=>$valor){
				$this->$propiedad=$valor;
			}
			$this->mensaje='Usuario encontrado';
		} else {
			$this->mensaje='Usuario no encontrado';
		}
	}

	public function set($user_data=array()){
		if(array_key_exists('sRfc', $user_data)){
			$this->get($user_data['sRfc']);
			if($user_data['sRfc']!= $this->sRfc){
				foreach ($user_data as $campo=>$valor){
					$$campo = $valor;
				}
				$this->query="
					INSERT INTO Usuario
					(sRfc, sApeMaterno, sApePaterno, sNombre, sTipoUsuario, sEmail, sPassword)
					VALUES
					('$sRfc' , '$sApeMaterno', '$sApePaterno' , '$sNombre' , '$sTipoUsuario' , '$sEmail' , '$sPassword')
				";
				$this->execute_single_query();
				$this->mensaje = 'Usuario Agregado Exitosamente';
			}else{
				$this->mensaje='El usuario ya existe';
			}
		}else{
			$this->mensaje='No se ha agregado al usuario';
		}
	} 

	public function edit($user_data=array()){
        foreach ($user_data as $campo=>$valor) {
            $$campo = $valor;
        }
		$this->query = "
			UPDATE 		Usuario
			SET 		sApeMaterno='$sApeMaterno',
						sApePaterno='$sApePaterno',
						sNombre='$sNombre',
						sEmail='$sEmail',
						sTipoUsuario='$sTipoUsuario',
						sPassword='$sPassword'
			WHERE 		sRfc='$sRfc'
		";
		$this->execute_single_query();
		$this->mensaje='Usuario Modificado';
	}

	public function delete($user_rfc=''){
		$this->query="
			DELETE FROM 	Usuario
			WHERE 			sRfc='$user_rfc'
		";
		$this->execute_single_query();
		$this->mensaje='Usuario Eliminado';
	}

	public function get_AllUsers($user_tipo=''){
		$this->query ="
			SELECT 		sRfc, sNombre, sApePaterno, sApeMaterno, sEmail, sTipoUsuario, sPassword
			FROM 		Usuario
			WHERE 		sTipoUsuario='$user_tipo'

		";
		$this->get_results_from_query();
		$this->mensaje='Resultados: ';
	}

	function __destruct(){
		unset($this);
	}

}
?>