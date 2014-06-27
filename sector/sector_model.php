<?php
require_once('../core/db_abstract_model.php');

class Sector extends DBAbstractModel{
	protected $sCveSector;
	public $sLocalidad;
	public $sMunicipio;
	public $sJurisdiccion;
	public $sEstado;
	public $sRegionSanitaria;

	function __construct(){
		$this->db_name='bdVectores';
	}

	public function get($sector_clave=''){
		if($sector_clave != ''){
			$this->query ="
				SELECT 	sCveSector, sLocalidad , sMunicipio, sJurisdiccion, sEstado, sRegionSanitaria
				FROM 	Sector
				WHERE 	sCveSector = '$sector_clave'
			";
			$this->get_results_from_query();
		}
		if(count($this->rows)==1){
			foreach($this->rows[0] as $propiedad=>$valor){
				$this->$propiedad=$valor;
			}
			$this->mensaje ='Usuario encontrado';
		}else {
			$this->mensaje ='Usuario no encontrado';
		}
	}

	public function set($sector_data=array()){
		if(array_key_exists('sCveSector', $sector_data)){
			$this->get($sector_data['sCveSector']);
			if($sector_data['sCveSector']!= $this->sCveSector){
				foreach ($sector_data as $campo=>$valor):
					$$campo = $valor;
				endforeach;
				$this->query="
					INSERT INTO Sector
					(sCveSector, sLocalidad , sMunicipio, sJurisdiccion, sEstado, sRegionSanitaria)
					VALUES
					('$sCveSector' , '$sLocalidad', '$sMunicipio' , '$sJurisdiccion' , 'sEstado' , '$sRegionSanitaria')
				";
				$this->execute_single_query();
				$this->mensaje = 'Usuario Agregado Exitosamente';
			}else{
				$this->mensaje='El usuario ya existe';
			}
		} else{
			$this->mensaje='No se ha agregado al usuario';
		}
	}
	
	public function edit($sector_data=array()){
		foreach ($sector_data as $campo=>$valor):
			$$campo=$valor;
		endforeach;
		$this->query = "
			UPDATE 		Sector
			SET 		sCveSector='$sCveSector',
						sLocalidad='$sLocalidad',
						sMunicipio='$sMunicipio',
						sJurisdiccion='$sJurisdiccion',
						sEstado='$sEstado',
						sRegionSanitaria='$sRegionSanitaria'
			WHERE 		sCveSector='$sCveSector'
		";
		$this->execute_single_query();
		$this->mensaje='Usuario Modificado';

	}

		public function delete($sector_clave=''){
		$this->query="
			DELETE FROM 	Sector
			WHERE 			sCveSector='$sector_clave'
		";
		$this->execute_single_query();
		$this->mensaje='Usuario Eliminado';
	}
	function __destruct(){
		unset($this);
	} 
}

?>