<?PHP
require_once('../core/db_abstract_model.php');

class CL1 extends DBAbstractModel{
	public $CveBrigada;
	public $sRfc;
	public $sObservaciones;
	public $sOrden;
	public $sDomicilio;
	public $sCveManzana;
	public $bLote;
	public $sCasa;
	public $nRevisados;
	public $nAbatizados;
	public $nEliminados;
	public $nControlados;
	public $nTratados;
	public $nNoTratados;
	public $nLarvicidaConsumido;
	public $nVolumenTratado;
	public $nHabitantes;

	function __construct(){
		$this->db_name='bdVectores';
	}
	public function get($rfc_aplicativo=''){

	if($rfc_aplicativo!=''){
		$this->query ="
			SELECT 	CveBrigada, sRfc
			FROM 	CL1
			WHERE 	sRfc='$rfc_aplicativo' AND CveBrigada IN (SELECT CveBrigada FROM Brigada WHERE sEstado='Activo')
		";
		$this->get_results_from_query();
		//print_r($this->rows);
	}
		if(count($this->rows)==1){
		foreach($this->rows[0] as $propiedad=>$valor){
			$this->$propiedad=$valor;
		}
		$this->mensaje='CL1 encontrado';
		} else {
		$this->mensaje='CL1 no encontrado';
		}
	}
	public function getCL1($CveBrigada='', $rfc_aplicativo=''){
		print $rfc_aplicativo.$CveBrigada;
	if($rfc_aplicativo!=''){
		$this->query ="
			SELECT 	CveBrigada, sRfc
			FROM 	CL1
			WHERE 	sRfc='$rfc_aplicativo' AND CveBrigada='$CveBrigada'
		";
		$this->get_results_from_query();
		//print_r($this->rows);
	}
		if(count($this->rows)==1){
		foreach($this->rows[0] as $propiedad=>$valor){
			$this->$propiedad=$valor;
		}
		$this->mensaje='CL1 encontrado';
		} else {
		$this->mensaje='CL1 no encontrado';
		}
	}

	public function set($cl1_data=array()){
		if(array_key_exists('CveBrigada', $cl1_data) && array_key_exists('sRfc', $cl1_data)){
			$this->get($cl1_data['CveBrigada'], $cl1_data['sRfc']);
			if($cl1_data['CveBrigada']!= $this->CveBrigada && $cl1_data['sRfc']!=$this->sRfc){
				foreach ($cl1_data as $campo=>$valor){
					$$campo = $valor;
				}
				$this->query="
					INSERT INTO CL1
					(CveBrigada, sRfc, sObservaciones)
					VALUES
					('$CveBrigada' , '$sRfc', '$sObservaciones')
				";
				$this->execute_single_query();
				$this->mensaje = 'CL1 Agregada Exitosamente';
			}else{
				$this->mensaje='CL1 ya existe';
			}
		}else{
			$this->mensaje='No se ha agregado el CL1';
		}
	}

	public function edit($cl1_data=array()){
		if($cl1_data['CveBrigada']!='' && $cl1_data['sRfc']!=''){
			foreach ($cl1_data as $campo=>$valor):
			$$campo=$valor;
			endforeach;
		}
		$this->query = "
			UPDATE 		CL1 
			SET 		sObservaciones = '$sObservaciones' 
			WHERE 		CveBrigada = $CveBrigada AND sRfc = '$sRfc'
		";
		$this->execute_single_query();
		$this->mensaje='CL1 guardado';
	}

	public function delete($brigada_cve='', $rfc_aplicativo=''){
		$this->getCL1($brigada_cve, $rfc_aplicativo);
		if($this->mensaje=='CL1 encontrado'){
		$this->query="
			DELETE FROM 	CL1Datos
			WHERE 			CveBrigada='$brigada_cve' AND sRfc='$rfc_aplicativo'
		";
		$this->execute_single_query();
		$this->query="
			DELETE FROM 	CL1
			WHERE 			CveBrigada='$brigada_cve' AND sRfc='$rfc_aplicativo'
		";
		$this->execute_single_query();
		$this->mensaje='CL1 Eliminado';
		}
	}

	public function get_Datos($brigada_clave='', $rfc_aplicativo=''){

	if($brigada_clave != '' && $rfc_aplicativo!=''){
		$this->query ="
			SELECT 		Brigada.sCveSector, CL1Datos.CveBrigada, CL1Datos.sRfc, CL1Datos.sOrden, CL1Datos.sDomicilio, CL1Datos.sCveManzana, CL1Datos.bLote, CL1Datos.sCasa, CL1Datos.nRevisados, CL1Datos.nAbatizados, CL1Datos.nEliminados, CL1Datos.nControlados, CL1Datos.nNoTratados, CL1Datos.nLarvicidaConsumido, CL1Datos.nVolumenTratado, CL1Datos.nHabitantes
			FROM 		CL1Datos 	
			INNER JOIN 	Brigada
			WHERE 		CL1Datos.CveBrigada='$brigada_clave' AND CL1Datos.sRfc='$rfc_aplicativo' 
			GROUP BY 	CL1Datos.sOrden

		";
		$this->get_results_from_query();
		//print_r($this->rows);
	}
		if(count($this->rows)==1){
		foreach($this->rows[0] as $propiedad=>$valor){
			$this->$propiedad=$valor;
		}
		$this->mensaje='CL1 encontrado';
		} else {
		$this->mensaje='CL1 no encontrado';
		}
	}

	public function set_Datos($cl1_data=array()){
		if(array_key_exists('CveBrigada', $cl1_data)&& array_key_exists('sRfc', $cl1_data)){
			//$this->get($cl1_data['CveBrigada'], $cl1_data['sRfc']);
			if(array_key_exists('CveBrigada', $cl1_data)&& array_key_exists('sRfc', $cl1_data)){
				foreach ($cl1_data as $campo=>$valor){
					$$campo = $valor;
				}
				$this->query="
					INSERT INTO CL1Datos
					(CveBrigada, sRfc, sOrden, sDomicilio, sCveManzana, bLote, sCasa, nRevisados, nAbatizados,
						nEliminados, nControlados, nNoTratados, nLarvicidaConsumido, nVolumenTratado, nHabitantes)
					VALUES
					('$CveBrigada' , '$sRfc', '$sOrden', '$sDomicilio', '$sCveManzana', '$bLote','$sCasa','$nRevisados', '$nAbatizados',
						'$nEliminados', '$nControlados', '$nNoTratados', '$nLarvicidaConsumido', '$nVolumenTratado', '$nHabitantes')
				";
				$this->execute_single_query();
				$this->mensaje = 'Datos agregados: '.$sDomicilio.', Manzana: '.$sCveManzana;
			}else{
				$this->mensaje='CL1 no existente';
			}
		}else{
			$this->mensaje='No se han agregado los datos al CL1';
		}
	}
		public function edit_Datos($cl1_data=array()){
		$this->getFila($cl1_data['sRfc'], $cl1_data['CveBrigada'], $cl1_data['sOrden']);
		if($cl1_data['CveBrigada']==$this->CveBrigada && $cl1_data['sRfc']==$this->sRfc){
			foreach ($cl1_data as $campo=>$valor):
			$$campo=$valor;
			endforeach;
		}
		//print 'ESTADO DENTRO DEL MODELO'.$sEstado;
		$this->query = "
			UPDATE 		CL1Datos 
			SET 		 
						sDomicilio = '$sDomicilio', 
						sCveManzana = '$sCveManzana', 
						bLote = '$bLote', 
						sCasa = '$sCasa', 
						nRevisados = '$nRevisados', 
						nAbatizados = '$nAbatizados', 
						nEliminados = '$nEliminados', 
						nControlados = '$nControlados', 
						nNoTratados = '$nNoTratados', 
						nLarvicidaConsumido = '$nLarvicidaConsumido', 
						nVolumenTratado = '$nVolumenTratado', 
						nHabitantes = '$nHabitantes' 
			WHERE 		CveBrigada = $CveBrigada AND sRfc = '$sRfc' AND sOrden = '$sOrden'
		";
		$this->execute_single_query();
		$this->mensaje='Datos modificados para: '.$sDomicilio.', Manzana: '.$sCveManzana;
	}
	
	public function delete_Datos($cl1_data=array()){
		$this->getCL1($cl1_data['CveBrigada'], $cl1_data['sRfc']);
		if($cl1_data['CveBrigada']==$this->CveBrigada && $cl1_data['sRfc']==$this->sRfc){
			foreach ($cl1_data as $campo=>$valor):
			$$campo=$valor;
			endforeach;
		}
		$this->query="
			DELETE FROM 	CL1Datos
			WHERE 			CveBrigada='$CveBrigada' AND sRfc='$sRfc' AND sOrden='$sOrden'
		";
		$this->execute_single_query();
		$this->mensaje='CL1 Eliminado';
		
	}
	public function get_datosCl1($brigada_cve=''){
		if($brigada_cve != ''){
		$this->query ="
			SELECT 		Brigada.sLocalidad, Sector.sMunicipio, Sector.sJurisdiccion, Sector.sEstado, Sector.sCveSector,
						Brigada.dFecha, Brigada.sCiclo, Brigada.sEstrategia, Brigada.sSemEpidemio 
			FROM 		Brigada INNER JOIN Sector 
			WHERE 		Brigada.CveBrigada='$brigada_cve' GROUP BY CveBrigada
		";
		$this->get_results_from_query();
		//print_r($this->rows);
		}
		if(count($this->rows)==1){
		foreach($this->rows[0] as $propiedad=>$valor){
			$this->$propiedad=$valor;
		}
		$this->mensaje='Datos encontrados';
		} else {
		$this->mensaje='Datos no encontrados';
		}
	}

	public function get_jefe($user_tipo='', $brigada_cve=''){
		if($brigada_cve != '' && $user_tipo!=''){
		$this->query ="
			SELECT 		Usuario.sRfc 
			FROM 		Usuario INNER JOIN EquipoBrigada 
			ON 			Usuario.sRfc=EquipoBrigada.sRfc 
			WHERE 		Usuario.sTipoUsuario='$user_tipo' AND EquipoBrigada.CveBrigada='$brigada_cve' GROUP BY Usuario.sRfc
		";
		$this->get_results_from_query();
		//print_r($this->rows);
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

		public function getBrigadaCL1($user_rfc=''){
		if($user_rfc != ''){
			$this->query ="
				SELECT 	CveBrigada
				FROM 	EquipoBrigada
				WHERE 	sRfc='$user_rfc' AND sRfc NOT IN(SELECT sRfc FROM CL1) AND CveBrigada IN (SELECT CveBrigada FROM Brigada WHERE sEstado='Activo')
			";
			$this->get_results_from_query();
			if(count($this->rows)!=0){
			$this->mensaje='Brigada encontrada';
			}else{
				$this->mensaje='No hay brigadas Disponibles';
			}
		} else {
			$this->mensaje='Brigada no encontrada';
		}
	}
		public function getFila($user_rfc='', $brigada_cve='', $orden=''){
		if($user_rfc != ''){
			$this->query ="
				SELECT 	CveBrigada,	sRfc, sOrden, sDomicilio, sCveManzana, bLote, sCasa, nRevisados, nAbatizados, nEliminados, nControlados,  nNoTratados, nLarvicidaConsumido, nVolumenTratado, nHabitantes 
				FROM 	CL1Datos 
				WHERE 	sRfc='$user_rfc' AND CveBrigada ='$brigada_cve' AND sOrden ='$orden'
			";
			$this->get_results_from_query();
			if(count($this->rows)!=0){
			foreach($this->rows[0] as $propiedad=>$valor){
			$this->$propiedad=$valor;
			}
			$this->mensaje='Brigada encontrada';
			}else{
				$this->mensaje='No hay brigadas Disponibles';
			}
		} else {
			$this->mensaje='Brigada no encontrada';
		}
	}
		public function getObservaciones($user_rfc='', $brigada_cve=''){
		if($user_rfc != ''){
			$this->query ="
				SELECT 	sObservaciones
				FROM 	CL1
				WHERE 	sRfc='$user_rfc' AND CveBrigada='$brigada_cve'
			";
			$this->get_results_from_query();
			if(count($this->rows)!=0){
			$this->mensaje='Encontrado';
			}else{
				$this->mensaje='No encontrado';
			}
		} else {
			$this->mensaje='Error';
		}
	}
	function __destruct(){
		unset($this);
	} 

}

?>