<?php

class Finition{

	private $idFinition;
	private $finition;
	
	
	public function __construct(int $idFinition, string $finition)
	{
		$this->idFinition=$idFinition;
		$this->finition=$finition;
	
	
	} 
	
	public function getIdFinition():int
	{
		return $this->idFinition;
	
	}
	
	public function getFinition() :string 
	{
		return $this->finition;
	}
	
	public function setIdFinition(int $id)
	{
		$this->idFinition=$id;
	}
	public function setFinition(string $finition)
	{
		$this->finition=$finition;
	}


}


?>
