<?php
require_once('../core/db_abstract_model.php');

class Sector extends DBAbstractModel{
############################### PROPIEDADES ################################
//protegida sCveSector
	public $sCveSector;
	public $sLocalidad;
	public $sMunicipio;
	public $sJurisdiccion;
	public $sEstado;
	public $sRegionSanitaria;
	public $mensaje;
################################# MÉTODOS ##################################

	function __construct(){
		$this->db_name='bdVectores';
	}

	public function get($sector_clave='',$sector_localidad=''){
		if($sector_clave != '' && $sector_localidad != ''){
			$this->query ="
				SELECT 	sCveSector, sLocalidad , sMunicipio, sJurisdiccion, sEstado, sRegionSanitaria
				FROM 	Sector
				WHERE 	sCveSector = '$sector_clave' AND sLocalidad LIKE '%$sector_localidad%'
			";
			$this->get_results_from_query();
		}
		if(count($this->rows)==1){
			foreach($this->rows[0] as $propiedad=>$valor){
				$this->$propiedad=$valor;
			}
			$this->mensaje ='Sector encontrado';
		}else {
			$this->mensaje ='Sector no encontrado';
		}
	}
				

	public function set($sector_data=array()){
		if(array_key_exists('sCveSector', $sector_data) && array_key_exists('sLocalidad', $sector_data)){
			$this->get($sector_data['sCveSector'],$sector_data['sLocalidad']);
			if($sector_data['sCveSector']!= $this->sCveSector){
				foreach ($sector_data as $campo=>$valor){
					$$campo = $valor;
				}
				$this->query="	
				INSERT INTO Sector 
				(sCveSector, sLocalidad, sMunicipio, sJurisdiccion, sEstado, sRegionSanitaria) 
				VALUES 
				('$sCveSector', '$sLocalidad', 'Orizaba' , 'Jurisdiccion Sanitaria VII' , 'Veracruz de Ignacio de la Llave' , 'Orizaba VII')
				
					";
				$this->execute_single_query();
				$this->mensaje = 'Sector Agregado Exitosamente';
			}else{
				$this->mensaje='El sector ya existe';
			}
		}else{
			$this->mensaje='No se ha agregado al sector';
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
			WHERE 		sCveSector='$sCveSector' AND sLocalidad LIKE'%$sLocalidad%'
		";
		$this->execute_single_query();
		$this->mensaje='Usuario Modificado';

	}

	public function delete($sector_clave='', $sector_localidad=''){
		$this->get($sector_clave, $sector_localidad);
		if($this->mensaje=='Sector encontrado'){
		$this->query="
			DELETE FROM 	Sector
			WHERE 			sCveSector='$sector_clave' AND sLocalidad LIKE '%$sector_localidad%'
		";
		$this->execute_single_query();
		$this->mensaje='Sector Eliminado';
		}
	}

	public function get_AllSector($sector_localidad=''){
		//print $sector_localidad;
		$this->query ="
			SELECT 		sCveSector, sLocalidad , sMunicipio, sJurisdiccion, sEstado, sRegionSanitaria
			FROM 		Sector
			WHERE 		sLocalidad LIKE '%$sector_localidad%'

		";
		$this->get_results_from_query();
		if(count($this->rows)==1){
			foreach($this->rows[0] as $propiedad=>$valor){
				$this->$propiedad=$valor;
			}
			$this->mensaje='Sectores en encontrados para la localidad '.$sector_localidad;
		} else {
			//print "<br>ELSE";
			$this->mensaje='Sectores no encontrados para la localidad '.$sector_localidad;
		}
	}

	function __destruct(){
		unset($this);
	} 
}

?>