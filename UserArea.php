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
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
<script type="text/javascript" src="AJAX.js"></script>
</head>
<body>
<ul>
<li><a href="http://localhost:85/seven/logOff.php">Log off</a></li>
</ul>
<?php if($message!=''){
	echo "<p>$message</p><br>";
}?>

<a href='#' id="tryAJAX">Try AJAX</a>
<table width='150px' border="1" id="mainTable">
<tr>
<th>From</th>
</tr>
<?php 
foreach($arr as $subkey=>$subarr){
if($subarr['isRead']==0){
$style='style="background-color:green;"';
}else{
$style="";
}
echo "<tr $style>";
echo "<td><a href=#>{$subarr['name']}</a></td>";
//echo "<td><a href=#>{$subarr['body']}</a></td>";
echo '</tr>';
}
?>
<tr>
<th>From</th>
</tr>
</table>
</body>
</html>