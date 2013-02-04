<?php
include_once 'Db.php';
include_once 'User.php';
session_start();
$message=&$_SESSION['message'];
if(!isset($_SESSION['user'])){
$message='';
if( $_SERVER['REQUEST_METHOD'] == 'POST'){
	$name=$_POST['name'];
	$password=$_POST['password'];	
	$db=new Db();
	$result=$db->getUser($name, $password);
	if(strtolower($result[0]['name'])==strtolower($name)){		
		$_SESSION['user']=new User($result);
		$message="User {$_SESSION['user']->getName()} is in system.";
		header("Location:http://localhost:85/seven/UserArea.php");
	}
	else{
		$message="Username or password is incorrect, please try again";
	}
}
}else{
	header("Location:http://localhost:85/seven/UserArea.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
</head>
<body>
<ul>
<?php
if(!isset($_SESSION['user'])){
echo '<li><a href="http://localhost:85/seven/logIn.php">Log in</a></li>
<li><a href="http://localhost:85/seven/logOn.php">Log on</a></li>';
}else{
echo '<li><a href="http://localhost:85/seven/logOff.php">Log off</a></li>';
}
?>		
</ul>
<?php if($message!== ''){
	echo "<p>$message</p><br>";
}?>
<form action="<?php print $_SERVER['PHP_SELF']?>" method="post">
	<label>Username</label>
	<br>
	<input type="text" name="name" id="name">
	<br>
	<label>Password</label>
	<br>
	<input type="password" name="password" id="password">
	<br>
	<input type="submit" id="submit" value="submit">
</form>
</body>
</html>