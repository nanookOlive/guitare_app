<?php

class Genre{

	private $idGenre;
	private $genre;

	public function __construct(int $idGenre, string $genre){
	
		$this->idGenre=$idGenre;
		$this->genre=$genre;
	
	}
	
	
	function getIdGenre():int
	{
		return $this->idGenre;
	}

	function getGenre():string
	{
		return $this->genre;
	}
	function setIdGenre(int $id)
	{
		$this->idgenre=$id;
	}
	function setGenre(string $genre)
	{
		$this->genre=$genre;
	}

}

?>
