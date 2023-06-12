<?php
	class  Utilisateur{
	
		private $idUtilisateur;
		private $nomUtilisateur;
		private $prenom;
		private $mail;
		private $password;
		private $administrateur;
		private $valide;
		private $jeton;
		
		
		public function __construct(int $idUtilisateur=null, string $nomUtilisateur='', string $prenom='', string $mail='', string $password='', bool $administrateur=FALSE,$valide=0,$jeton=''){
		
		
		$this->idUtilisateur=$idUtilisateur;
		$this->nomUtilisateur=$nomUtilisateur;
		$this->prenom=$prenom;
		$this->mail=$mail;
		$this->password=$password;
		$this->administrateur=$administrateur;
		$this->valide=$valide;
		$this->jeton=$jeton;
	
	
	
	}
	
	
	public function getIdUtilisateur():int{
	
		return $this->idUtilisateur;
	}
	public function getNomUtilisateur():string{
	
		return $this->nomUtilisateur;
	}
	public function getPrenom():string{
	
		return $this-> prenom;
	}
	public function getMail():string{
	
		return $this->mail;
	}
	public function getPassword():string{
	
		return $this->password;
	}
	public function getAdministrateur():bool{
	
		return $this->administrateur;
	}
	
	public function getValide()
	{
		return $this->valide;
	}
	public function getJeton()
	{
		return $this->jeton;
	}

	//setters
	
	public function setIdUtilisateur(int $id)
	{
		$this->idUtilisateur=$id;
	}
	public function setNomUtilisateur(string $nom)
	{
		$this->nomUtilisateur=$nom;
	}
	public function setPrenom(string $prenom)
	{
		$this-> prenom=$prenom;
	}
	public function setMail(string $mail)
	{
		$this->mail=$mail;
	}
	
	public function setAdministrateur(bool $admin)
	{
	
		$this->administrateur=$admin;
	}
	
	
	public function setPassword(string $password){
	
		$this->password=$password;
	}

	public function setValide($valide){

		$this->valide=$valide;
	}

	public function setJeton($jeton)
	{
		$this->jeton=$jeton;
	}
}
?>
