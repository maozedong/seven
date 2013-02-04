<?php 
include_once 'Db.php';
include_once 'User.php';
session_start();
$db=new Db();
$obj=json_decode($_GET['obj']);
switch($obj->request){
	case 'getGroups':
		$id=$_SESSION['user']->getId();
		$responce=$db->getGroupsTo($id, 10);
		$responce=json_encode($responce);
		echo $responce;
		return;
	case 'getPosts':
		$to_id=$_SESSION['user']->getId();
		$from_id=$obj->from_id;
		$responce=$db->getPostsTo(1, 2, 10);
		$responce=json_encode($responce);
		echo $responce;
		return;
	default: 
		echo "default from switch";
		return;
}

?>