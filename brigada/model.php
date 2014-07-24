<?PHP
require_once('../core/db_abstract_model.php');

class Brigada extends DBAbstractModel{
	public $CveBrigada;
	public $sCveSector;
	public $sLocalidad;
	public $dFecha;
	public $sCiclo;
	public $sSemEpidemio;
	public $sEstrategia;
	public $mensaje;

	function __construct(){
		$this->db_name='bdVectores';
	}
	public function get($brigada_clave=''){

	if($brigada_clave != ''){
		$this->query ="
			SELECT 	CveBrigada, sCveSector, sLocalidad, dFecha, sCiclo, sSemEpidemio, sEstrategia
			FROM 	Brigada
			WHERE 	CveBrigada='$brigada_clave'
		";
		$this->get_results_from_query();
	}
		if(count($this->rows)==1){
		foreach($this->rows[0] as $propiedad=>$valor){
			$this->$propiedad=$valor;
		}
		$this->mensaje='Brigada encontrada';
		} else {
		$this->mensaje='Brigada no encontrada';
		}
	}

	public function get_by_date($fecha1='', $fecha2=''){
	if($fecha1 && $fecha2 != ''){
		$this->query ="
			SELECT 	CveBrigada, sCveSector, sLocalidad, dFecha, sCiclo, sSemEpidemio, sEstrategia
			FROM 	Brigada
			WHERE 	dFecha  BETWEEN '$fecha1' AND '$fecha2'
		";
		$this->get_results_from_query();
	}
		if(count($this->rows)==1){
		foreach($this->rows[0] as $propiedad=>$valor){
			$this->$propiedad=$valor;
		}
		$this->mensaje='Brigada encontrada';
		} else {
		$this->mensaje='Brigada no encontrada';
		}
	}

	public function set($brigada_data=array()){
		//print_r($brigada_data);
		if(array_key_exists('CveBrigada', $brigada_data)){
			//print "dentro de if";
			$this->get($brigada_data['CveBrigada']);
			if($brigada_data['CveBrigada']!= $this->CveBrigada){
				foreach ($brigada_data as $campo=>$valor){
					$$campo = $valor;
				}
				$this->query="
					INSERT INTO Brigada
					(CveBrigada, sCveSector, sLocalidad, dFecha, sCiclo, sSemEpidemio, sEstrategia)
					VALUES
					('$CveBrigada' , '$sCveSector', '$sLocalidad','$dFecha' , '$sCiclo' , '$sSemEpidemio' , '$sEstrategia')
				";
				$this->execute_single_query();
				$this->mensaje = 'Brigada Agregada Exitosamente';
			}else{
				$this->mensaje='La brigada ya existe';
			}
		}else{
			$this->mensaje='No se ha agregado la brigada';
		}
	}

	public function edit($brigada_data=array()){
		foreach ($brigada_data as $campo=>$valor):
			$$campo=$valor;
		endforeach;
		$this->query = "
			UPDATE 		Brigada
			SET 		CveBrigada='$CveBrigada', 
						sCveSector='$sCveSector', 
						sLocalidad='$sLocalidad',
						dFecha='$dFecha', 
						sCiclo='$sCiclo', 
						sSemEpidemio='$sSemEpidemio',
						sEstrategia='$sEstrategia'
			WHERE 		CveBrigada='$CveBrigada'
		";
		$this->execute_single_query();
		$this->mensaje='Brigada Modificada';
	}

	public function delete($brigada_cve=''){
		$this->get($brigada_cve);
		if($this->mensaje=='Brigada encontrada'){
		$this->query="
			DELETE FROM 	Brigada
			WHERE 			CveBrigada='$brigada_cve'
		";
		$this->execute_single_query();
		$this->mensaje='Brigada Eliminada';
		}
	}

	function __destruct(){
		unset($this);
	} 

}

?>