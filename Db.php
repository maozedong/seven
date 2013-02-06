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
	function getUsers($from_id){
		if(!empty($from_id)){
			require_once 'Zend/Loader/Autoloader.php';
			$loader = Zend_Loader_Autoloader::getInstance();
			$db = new Zend_Db_Adapter_Pdo_Mysql(array(
					'host'     => 'localhost',
					'username' => 'root',
					'password' => 'atlzatlz1',
					'dbname'   => 'test'
			));
	
			$query="select * from users where users.id not in ($from_id) limit 50";
			$arr=$db->fetchAll($query);
			return $arr;
		}else{
			return 0;//empty parameters
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
					AND posts.is_deleted_to NOT IN (1)
					group by users.name
					LIMIT $limit";
			$arr=$db->fetchAll($query);
			return $arr;
		}else{
			return 0;//empty $id
		}
	}
	function getGroupsFrom($id, $limit){
		if(!empty($id)&&!empty($limit)){
			require_once 'Zend/Loader/Autoloader.php';
			$loader = Zend_Loader_Autoloader::getInstance();
			$db = new Zend_Db_Adapter_Pdo_Mysql(array(
					'host'     => 'localhost',
					'username' => 'root',
					'password' => 'atlzatlz1',
					'dbname'   => 'test'
			));
	
			$query="select posts.to_id, users.name from posts
			join users on posts.to_id=users.id
			where posts.from_id='$id'
			AND posts.is_deleted_from NOT IN (1)
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
			AND posts.is_deleted_to NOT IN (1)
			ORDER BY posts.date_sent DESC
			LIMIT $limit";
			$arr=$db->fetchAll($query);
			return $arr;
		}else{
			return 0;//empty parameters
		}
	}
	function getPostsFrom($to_id, $from_id, $limit){
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
			AND posts.is_deleted_from NOT IN (1)
			ORDER BY posts.date_sent DESC
			LIMIT $limit";
			$arr=$db->fetchAll($query);
			return $arr;
		}else{
			return 0;//empty parameters
		}
	}
	function newPost($to_id, $from_id, $postBody){
		if(!empty($to_id)&&!empty($from_id)&&!empty($postBody)){
			require_once 'Zend/Loader/Autoloader.php';
			$loader = Zend_Loader_Autoloader::getInstance();
			$db = new Zend_Db_Adapter_Pdo_Mysql(array(
					'host'     => 'localhost',
					'username' => 'root',
					'password' => 'atlzatlz1',
					'dbname'   => 'test'
			));
			$date=date("Y-m-d h:i:s");
			$arr=array('from_id'=>"$from_id", 'to_id'=>"$to_id",
					'is_deleted_from'=>"0",
					'is_deleted_to'=>"0",
					'body'=>"$postBody", 'date_sent'=>"$date",
					'isRead'=>"0");
			$result=$db->insert('posts', $arr);
			return $result;
		}else{
			return 0;//empty parameters
		}
	}
	function isRead($post_id){
		if(!empty($post_id)){
			require_once 'Zend/Loader/Autoloader.php';
			$loader = Zend_Loader_Autoloader::getInstance();
			$db = new Zend_Db_Adapter_Pdo_Mysql(array(
					'host'     => 'localhost',
					'username' => 'root',
					'password' => 'atlzatlz1',
					'dbname'   => 'test'
			));
			$query="UPDATE posts SET isRead='1' WHERE posts.post_id='$post_id'";
			$result=$db->query($query);
			return $result;
		}else{
			return 0;//empty parameters
		}
	}	
	function getIsRead($to_id, $from_id){
		if(!empty($to_id)&&!empty($from_id)){
			require_once 'Zend/Loader/Autoloader.php';
			$loader = Zend_Loader_Autoloader::getInstance();
			$db = new Zend_Db_Adapter_Pdo_Mysql(array(
					'host'     => 'localhost',
					'username' => 'root',
					'password' => 'atlzatlz1',
					'dbname'   => 'test'
			));
			$query="select count(posts.isRead) from posts where posts.isRead='1' and posts.to_id='$to_id' and posts.from_id='$from_id'";
			$result=$db->query($query);
			return $result;
		}else{
			return 0;//empty parameters
		}
	}	
	function deletePost($user_id, $post_id){
		$test="not edited";
		if(!empty($post_id)&&!empty($user_id)){
			require_once 'Zend/Loader/Autoloader.php';
			$loader = Zend_Loader_Autoloader::getInstance();
			$db = new Zend_Db_Adapter_Pdo_Mysql(array(
					'host'     => 'localhost',
					'username' => 'root',
					'password' => 'atlzatlz1',
					'dbname'   => 'test'
			));
			$query1="SELECT * FROM posts WHERE posts.post_id='$post_id'";
			$result=$db->fetchAll($query1);
			if(($result[0]['is_deleted_from']==1) && ($result[0][is_deleted_to]==1)){
				$test="from if(1,1)";
				//$deleteQuery="DELETE FROM posts WHERE posts.post_id='$post_id'";
				$test=$db->delete('posts',"post_id='$post_id'");
				return $test;
			}else{
			if($user_id==$result[0]['from_id']){
				$query2="UPDATE posts SET is_deleted_from='1' WHERE post_id='$post_id'";	
			}else{
				$query2="UPDATE posts SET is_deleted_to='1' WHERE post_id='$post_id'";
			}
			$result=$db->query($query2);
			if($result!='0'){
				return $test;
			}else{
				return 'all bad';
			}
			}
		}else{
			return 'first return';//empty parameters
		}
	}
}
?>