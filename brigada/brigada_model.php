<?PHP
require_once('../core/db_abstract_model.php');

class Brigada extends DBAbstractModel{
	protected $CveBrigada;
	public $sCveSector;
	public $dFecha;
	public $sCiclo;
	public $sSemEpidemio;
	public $sEstrategia;

	function __construct(){
		$this->db_name='bdVectores';
	}
		public function get($brigada_clave=''){
		if($brigada_clave != ''){
			$this->query ="
				SELECT 	CveBrigada, sCveSector, dFecha, sCiclo, sSemEpidemio, sEstrategia
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

	public function set($brigada_data=array()){
		if(array_key_exists('CveBrigada', $brigada_data)){
			$this->get($brigada_data['CveBrigada']);
			if($brigada_data['CveBrigada']!= $this->CveBrigada){
				foreach ($brigada_data as $campo=>$valor){
					$$campo = $valor;
				}
				$this->query="
					INSERT INTO Brigada
					(CveBrigada, sCveSector, dFecha, sCiclo, sSemEpidemio, sEstrategia)
					VALUES
					('$CveBrigada' , '$sCveSector', '$dFecha' , '$sCiclo' , '$sSemEpidemio' , '$sEmail' , '$sEstrategia')
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
		$this->query="
			DELETE FROM 	Brigada
			WHERE 			CveBrigada='$brigada_cve'
		";
		$this->execute_single_query();
		$this->mensaje='Brigada Eliminada';
	}
	function __destruct(){
		unset($this);
	} 

}

?>