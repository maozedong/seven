<?php
$message='';
if( $_SERVER['REQUEST_METHOD'] == 'POST'){
	$name=$_POST['name'];
	$password=$_POST['password'];
	require_once 'Db.php';
	$db=new Db();
	$result=$db->getUser($name, $password);
	if(count($result)>0){
		$name=$result[0]['name'];
		$message="User $name is in system.";
	}
	else{
		$message="No such user, try again";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
</head>
<body>
<?php if($message!=''){
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