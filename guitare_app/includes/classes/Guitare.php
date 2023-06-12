<?php

class Guitare{

	//les variables de la classe
	
	private $idGuitare;
	private $nomGuitare;
	private $prix;
	private $nbCordes;
	private $description;
	private $cheminPhoto;
	private $dateFab;
	private $etui;
	

	//constructeur 
	
	public function __construct(int $idGuitare, string $nomGuitare, int $prix=null, int $nbCordes=null, string $description=null, string $cheminPhoto=null, string $dateFab=null, $etui=null){
	
	
	$this->idGuitare=$idGuitare;
	$this->nomGuitare=$nomGuitare;
	$this->prix=$prix;
	$this->nbCordes=$nbCordes;
	$this->description=$description;
	$this->cheminPhoto=$cheminPhoto;
	$this->dateFab=$dateFab;
	$this->etui=$etui;
	
	
	
	}
	
	//get
	
	public function getIdGuitare():int
	{
		return $this->idGuitare;
	}
	
	public function getNomGuitare()
	{
		return $this->nomGuitare;
	}
	
	public function getPrix() :int
	{
		return $this->prix;
	}
	
	public function getNbCordes()
	{
		return $this->nbCordes;
	}
	public function getDescription()
	{
		return $this->description;
	}
	
	public function getCheminPhoto()
	{
		return $this->cheminPhoto;
	}
	public function getDateFab()
	{
		return $this->dateFab;
	}
	public function getEtui() 
	{
		return $this->etui;
	}
	
	///////////////set
	
	
	public function setIdGuitare(int $id)
	{
		$this->idGuitare=$id;
	}
	
	public function setNomGuitare(string $nom)
	{
		$this->nomGuitare=$nom;
	}
	
	public function setPrix(int $prix)
	{
		$this->prix=$prix;
	}
	
	public function setNbCordes(int $nb)
	{
		$this->nbCordes=$nb;
	}
	public function setDescription(string $descri)
	{
		$this->description=$descri;
	}
	
	public function setCheminPhoto(string $path)
	{
		$this->cheminPhoto=$path;
	}
	public function setDateFab($dateFab)
	{
		 $this->dateFab=$dateFab;
	}
	public function setEtui($etui) 
	{
		$this->etui=$etui;
	}
	



}


?>
