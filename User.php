<?php 
class User{
	protected $id;
	protected $name;
	
	function __construct($arr){
		if(is_array($arr)){
			$this->id=$arr[0]['id'];
			$this->name=$arr[0]['name'];
		}
	}
	
	function getId(){
		return $this->id;
	}
	
	function getName(){
		return $this->name;
	}
}
?>