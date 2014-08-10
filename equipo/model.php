<?php
require_once('../core/db_abstract_model.php');

class EquipoBrigada extends DBAbstractModel{
############################### PROPIEDADES ################################
	//propiedades protegida sRfc, privada sEmail
	public $CveBrigada;
	public $sRfc;
	public $mensaje;

################################# MÉTODOS ##################################


	function __construct(){
		$this->db_name='bdVectores';
	}

	public function get($CveBrigada=''){
		//print "ESTOY EN GET DEl MODELO";
		if($CveBrigada != ''){
			$this->query ="
				SELECT 		CveBrigada, EquipoBrigada.sRfc, sNombre, sApeMaterno, sApePaterno, sTipoUsuario 
				FROM 		EquipoBrigada 
				INNER JOIN 	Usuario ON EquipoBrigada.sRfc = Usuario.sRfc 
				WHERE 		CveBrigada='$CveBrigada'
				ORDER BY 	sTipoUsuario DESC
			";
			$this->get_results_from_query();
			if(count($this->rows)!=0){
			$this->mensaje='Equipo encontrado';
			}else{
				$this->mensaje='Equipo no encontrado';
			}
		} else {
			$this->mensaje='Equipo no encontrado';
		}
	}

	public function set($CveBrigada='', $sRfc=''){
		//print 'dentro de set en el modelo:  '.$CveBrigada.$sRfc;
		if($CveBrigada && $sRfc != ''){
				$this->query="
					INSERT INTO EquipoBrigada
					(CveBrigada, sRfc)
					VALUES
					('$CveBrigada', '$sRfc')
				";
				$this->execute_single_query();
				$this->mensaje = 'Agregado a equipo ';
		}else{
			$this->mensaje='No se ha agregado al usuario al equipo';
		}
	} 


	public function delete_Equipo($CveBrigada=''){
		$this->get($CveBrigada);
		if($this->mensaje=='Equipo encontrado'){
		$this->query="
			DELETE FROM 	EquipoBrigada
			WHERE 			CveBrigada='$CveBrigada'
		";
		$this->execute_single_query();
		$this->mensaje='Usuario Eliminado';

		}else{
			$this->mensaje='Equipo no encontrado';
		}
	}	

	public function delete($user_rfc=''){

		$this->query="
			DELETE FROM 	EquipoBrigada
			WHERE 			sRfc='$user_rfc'
		";
		$this->execute_single_query();
		$this->mensaje='Equipo Eliminado';
		
	
	}
	public function get_AllUsers($user_tipo=''){
		//print 'USER TIPO'.$user_tipo;
		$this->query ="
			SELECT sRfc, sNombre, sApePaterno, sApeMaterno, sTipoUsuario
			FROM Usuario
			WHERE 	sTipoUsuario='$user_tipo' AND Usuario.sRfc NOT IN(SELECT sRfc FROM EquipoBrigada)

		";
		$this->get_results_from_query();
		//if(count($this->rows)==1){ ORIGINAL
		if(count($this->rows)==1){
			foreach($this->rows[0] as $propiedad=>$valor){
				$this->$propiedad=$valor;
			}
			$this->mensaje='Usuarios encontrados de tipo '.$user_tipo;
		} else {
			$this->mensaje='Usuario no encontrados para el tipo '.$user_tipo;
		}
	}
	public function edit(){

	}
	public function get_AllEquipos($user_estado=''){
		//print 'USER TIPO'.$user_tipo;
		$this->query ="
			SELECT 		EquipoBrigada.CveBrigada 
			FROM 		EquipoBrigada 
			INNER JOIN 	Brigada ON EquipoBrigada.CveBrigada = Brigada.CveBrigada 
			WHERE 		Brigada.sEstado='$user_estado' 
			GROUP BY EquipoBrigada.CveBrigada

		";
		$this->get_results_from_query();
		//if(count($this->rows)==1){ ORIGINAL
		if(count($this->rows)>1){
			$this->mensaje='Equipos encontrados';
		} else {
			$this->mensaje='Equipos no encontrados ';
		}
	}


	public function brigada_by_estado($sEstado=''){
		if($sEstado !=''){
		$this->query ="
			SELECT 	CveBrigada, sCveSector, sLocalidad, dFecha, sCiclo, sSemEpidemio, sEstrategia, sEstado
			FROM 	Brigada
			WHERE 	sEstado='$sEstado' AND Brigada.CveBrigada NOT IN(SELECT CveBrigada FROM EquipoBrigada)
		";
		$this->get_results_from_query();
		$this->mensaje='Brigadas encontradas';
		}else {
			$this->mensaje='Brigadas no encontradas';
		}
	}
	public function set_CveBrigada($CveBrigada){
		$this->CveBrigada=$CveBrigada;
	}
	public function get_CveBrigada(){
		return $this->CveBrigada;
	}
	function __destruct(){
		unset($this);
	}

}
?>