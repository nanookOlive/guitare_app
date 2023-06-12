<?php
	
class Modele{


	private $idModele;
	private $modele;
	
	
	public function __construct(int $idModele, string $modele){
	
		$this->idModele=$idModele;
		$this->modele=$modele;
	
	
	
	}
	
	
	public function getIdModel() : int
	{
		return $this->idModele;
	}
	
	public function getModel() : string
	{
		return $this->modele;
	} 
	
	public function setModel(string $modele)
	{
		$this->modele=$modele;
	
	}
	
	public function setIdModel(int $id){

		$this->idModele=$id;
	
	}


}

?>
