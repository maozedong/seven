<?php 
include_once 'Db.php';
include_once 'User.php';
session_start();
$message=&$_SESSION['message'];
$db = new Db();
$id=$_SESSION['user']->getId();
$arr=$db->getGroupsTo($id, 10);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<script language="JavaScript" type="text/javascript" src="http://jqueryjs.googlecode.com/files/jquery-1.2.6.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
<link href="style.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="AJAX.js"></script>
</head>
<body>
<ul>
<li><a href="http://localhost:85/seven/logOff.php">Log off</a></li>
</ul>
<?php if($message!=''){
	echo "<p>$message</p><br>";
}?>

<div id="usersDiv"><ul id="usersUl"></ul></div>
<a href='#' id="tryAJAX"> Posts to me </a><br>
<a href='#' id="myPosts"> My Posts </a>
<div id="mainDiv">
<table width='150px' border="1" id="mainTable">

</table>
</div>
</body>
</html>