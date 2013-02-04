<?php 
require_once 'Zend/Loader/Autoloader.php';
class Db{
	protected $db;
	protected $name;
	protected $password;
	protected $nameCol;
	protected $passwordCol;
	
	function __construct(){
		$this->nameCol='name';
		$this->passwordCol='password';
	}
	
	function getName($id){
		return $this->name;
	}
	
	function getUser($name,$password){
		if(!empty($name)&&!empty($password)){
		require_once 'Zend/Loader/Autoloader.php';
		$loader = Zend_Loader_Autoloader::getInstance();
    	$db = new Zend_Db_Adapter_Pdo_Mysql(array(
    		'host'     => 'localhost',
    		'username' => 'root',
    		'password' => 'atlzatlz1',
    		'dbname'   => 'test'
    	));
    	$this->name=$name;
    	$this->password=$password;
    	$query="SELECT * FROM users WHERE $this->nameCol='$name' AND $this->passwordCol='$password'";
    	$result=$db->fetchAll($query);
    	if(empty($result)){
    		return 0;
    	}
		return $result;
		}else{
			return 0;//empty $name or $password
		}
	}
	
	function newUser($name,$password){
		if(!empty($name)&&!empty($password)){
		require_once 'Zend/Loader/Autoloader.php';
		$loader = Zend_Loader_Autoloader::getInstance();
		$db = new Zend_Db_Adapter_Pdo_Mysql(array(
				'host'     => 'localhost',
				'username' => 'root',
				'password' => 'atlzatlz1',
				'dbname'   => 'test'
		));
		$this->name=$name;
		$this->password=$password;
		
		$query="SELECT COUNT(*) FROM users WHERE name='$name'";
		$arr=$db->fetchOne($query);
		if($arr=="1"){
			return 2;//user already exists
		}else{
			$arr=array('name'=>"$name", 'password'=>"$password");
			$result=$db->insert('users', $arr);
			return $result;
		}
		}else{
			return 0;//empty $name or $password
		}
	}

	function getGroupsTo($id, $limit){
		if(!empty($id)&&!empty($limit)){
			require_once 'Zend/Loader/Autoloader.php';
			$loader = Zend_Loader_Autoloader::getInstance();
			$db = new Zend_Db_Adapter_Pdo_Mysql(array(
					'host'     => 'localhost',
					'username' => 'root',
					'password' => 'atlzatlz1',
					'dbname'   => 'test'
			));

			$query="select posts.from_id, users.name from posts
					join users on posts.from_id=users.id
					where posts.to_id='$id'
					group by users.name
					LIMIT $limit";
			$arr=$db->fetchAll($query);
			return $arr;
		}else{
			return 0;//empty $id
		}
	}
	function getPostsTo($to_id, $from_id, $limit){
		if(!empty($to_id)&&!empty($from_id)&&!empty($limit)){
			require_once 'Zend/Loader/Autoloader.php';
			$loader = Zend_Loader_Autoloader::getInstance();
			$db = new Zend_Db_Adapter_Pdo_Mysql(array(
					'host'     => 'localhost',
					'username' => 'root',
					'password' => 'atlzatlz1',
					'dbname'   => 'test'
			));
		
			$query="select posts.*, users.name from posts
			join users on posts.from_id=users.id
			where posts.from_id='$from_id' and posts.to_id='$to_id'
			LIMIT $limit";
			$arr=$db->fetchAll($query);
			return $arr;
		}else{
			return 0;//empty parameters
		}
	}
}
?>