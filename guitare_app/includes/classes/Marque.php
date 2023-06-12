<?php

class Marque{ 

	private $idMarque;
	private $nom_marque;
	
	public function __construct(int $idMarque, string $nom_marque){
	
		$this->idMarque=$idMarque;
		$this->nom_marque=$nom_marque;
	}
	
	
	public function getIdMarque():int
	{
		return $this->idMarque;
	}
	
	public function getNomMarque():string
	{
		return $this->nom_marque;
	}
	
	public function setIdMarque(int $id)
	{
		$this->idMarque=$id;
	}
	
	public function setNomMarque(string $nom)
	{
		$this->nom_marque=$nom;
	}
}
