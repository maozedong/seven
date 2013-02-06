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
		$responce=$db->getPostsTo($to_id, $from_id, 10);
		$responce=json_encode($responce);
		echo $responce;
		return;
	case 'getMyPosts':
		$from_id=$_SESSION['user']->getId();
		$to_id=$obj->to_id;
		$responce=$db->getPostsFrom($to_id, $from_id, 10);
		$responce=json_encode($responce);
		echo $responce;
		return;
	case 'newPost':
		$to_id=$obj->to_id;
		$from_id=$_SESSION['user']->getId();
		$postBody=$obj->postBody;
		$fromPostId=$obj->fromPostId;
		$response=$db->newPost($to_id, $from_id, $postBody);
		if($response=='1' && !empty($obj->fromPostId)){
			$response=$db->isRead($fromPostId);
			$response=json_encode($response);
		}
		echo $response;
		return;
	case 'getUsers':
		$from_id=$_SESSION['user']->getId();
		$response=$db->getUsers($from_id);
		$response=json_encode($response);
		echo $response;
		return;
	case 'getIsRead':
		$to_id=$_SESSION['user']->getId();
		$from_id=$obj->from_id;
		$response=$db->getIsRead($to_id, $from_id);
		$response=json_encode($response);
		echo $response;
		return;
	case 'deletePosts':
		$user_id=$_SESSION['user']->getId();
		$idArray=&$obj->idArray;
		$idArrayLength=count($idArray);
		foreach($idArray as $post_id){
			$response= $db->deletePost($user_id, $post_id);
		};
		$response=json_encode($response);
		echo $response;
		return;
	case 'requestMyGroups':
		$id=$_SESSION['user']->getId();
		$responce=$db->getGroupsFrom($id, 10);
		$responce=json_encode($responce);
		echo $responce;
		return;
	default: 
		echo "default from switch";
		return;
}

?>