<?php
session_start();
/*
if(isset($_SESSION['val'])){
	$_SESSION['val']++;
}else{
	$_SESSION['val']=1;
}
print $_SESSION['val'];
*/
$message=&$_SESSION['message'];
if(!isset($_SESSION['user'])){
if( $_SERVER['REQUEST_METHOD'] == 'POST'){
	$name=$_POST['name'];
	$password=$_POST['password'];
	require_once 'Db.php';
	$db=new Db();
	$result=$db->newUser($name, $password);
	if($result==1){
		$name=$db->getName();
		$message="User $name registered.";
		$message.= 'Please, <a href="http://localhost:85/seven/LogIn.php">Log in</a> to use the system';
	}
	else if($result==2){
		$message="User already exists. Type some other name, please";
	}else{
		$message="Result=$result. Something wrong, try ones more...";
	}
}
}else{
	header("Location:http://localhost:85/seven/LogIn.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>LogOn</title>
</head>
<body>
<ul>
<li><a href="http://localhost:85/seven/logIn.php">Log in</a></li>
<li><a href="http://localhost:85/seven/logOn.php">Log on</a></li>
</ul>
<?php
 if($message!=''){
	echo "<p>$message</p><br>";
}?>
<form action="<?php print $_SERVER['PHP_SELF']?>" method="post">
	<label>Enter Username</label>
	<br>
	<input type="text" name="name" id="name">
	<br>
	<label>Enter Password</label>
	<br>
	<input type="password" name="password" id="password">
	<br>
	<label>Enter Password again</label>
	<br>
	<input type="password" name="password2" id="password2">
	<br>
	<input type="submit" id="submit" value="submit">
</form>
</body>
</html>