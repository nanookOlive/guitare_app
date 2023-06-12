<?php

class Favoris{

    private $idFavoris;
    private $nomFavoris;
    private $fkIdUtilisateur;



    public function __construct(int $idFavoris,string $nomFavoris, int $fkIdUtilisateur){

        $this->idFavoris=$idFavoris;
        $this->nomFavoris=$nomFavoris;
        $this->fkIdUtilisateur=$fkIdUtilisateur;
    }

    public function getIdFavoris():int
    {
        return $this->idFavoris;
    }

    public function getNomFavoris():string 
    {
        return $this->nomFavoris;
    }
    
    public function getFkId():int
    {
    	return $this->fkIdUtilisateur;
    }
    
    public function setIdFavoris(int $id)
    {
    	$this->idFavoris=$id;
    }
    
     public function setNomFavoris(string $nom)
    {
    	$this->nomFavoris=$nom;
    }
    
     public function setFkId(int $id)
    {
    	$this->fkIdUtilisateur=$id;
    }


}
