var jsonObj;
window.onload=function(){
	var script = document.createElement('script');
	script.src = 'http://jqueryjs.googlecode.com/files/jquery-1.2.6.min.js';
	script.type = 'text/javascript';
	document.getElementsByTagName('head')[0].appendChild(script);

	mainTable();
	users();
	var myPosts = document.getElementById("myPosts");
	myPosts.onclick = function(e){
		e.preventDefault();
		requestMyGroups();
	}
	var submit = document.getElementById("tryAJAX");
	submit.onclick = function(e){	
		e.preventDefault();
		mainTable();
	};
	
	$('ul#usersUl li').click(function(e){ 
		usersClick(e, this.id);
		    });
	//setInterval(refresh, 5000);
}
function usersClick(e, to){
	view="usersClick";
	var mainDiv=document.getElementById("mainDiv");
	mainDiv.innerHTML="";
	var form = '<div id="newPost"><textarea rows="10" cols="60" id="newPostBody"></textarea><br><button id="newPostButton">Send</button></div></div>';
	mainDiv.innerHTML+=form;
	//var to=this.id;
	var newPostButton=document.getElementById("newPostButton");
	var postBody=document.getElementById("newPostBody");
	
	newPostButton.onclick=function(){
		var request = new XMLHttpRequest();
	    request.onreadystatechange=function(){
	    	if (request.readyState==4 && request.status==200)
	        {
	    		jsonObj=JSON.parse(request.responseText);
	    		requestName(null,to);
	        }
	    }
	    ajaxObject={
	    		'request':'newPost',
	    		'to_id':to,
	    		'postBody':postBody.value,
	    }
	    jsonString = JSON.stringify(ajaxObject);
	    request.open("GET", "AJAX.php?obj="+jsonString, false);
	    request.send();
	}
}
function refresh(){
	switch(view){
	case 'makeActions':
		makeActions(jsonObj);
		break;
	case 'showMyGroups':
		showMyGroups(jsonObj);
		break;
	case 'requestName':
		requestName(null, from_id);
		break;
	case 'makeMyPostsTable':
		makeMyPostsTable(jsonObj);
		break;
	case 'postReply':
		break;
	default:
		break;	
	}
}
var view='';
function requestMyGroups(){
	view="requestMyGroups";
	var jsonString;
	
	var request = new XMLHttpRequest();
	request.onreadystatechange=function(){
		if (request.readyState==4 && request.status==200){
			jsonObj=JSON.parse(request.responseText);
			showMyGroups(jsonObj);
		}
	}
	ajaxObject={
		'request':'requestMyGroups'
	}
	jsonString = JSON.stringify(ajaxObject);
	request.open("GET", "AJAX.php?obj="+jsonString, false);
	request.send();
}
function makeActions(jsonObj){
	view="makeActions";
	var mainDiv=document.getElementById("mainDiv");
	mainDiv.innerHTML="";
	var form = '<table id="mainTable" width="150px" border="1"></table>';
	mainDiv.innerHTML+=form;
	var table=document.getElementById("mainTable");
	for(var i = table.rows.length-1; i >= 0; i--){
		table.deleteRow(i);
	}
	var row=table.insertRow(0);
	var cell0 = row.insertCell(0);
    cell0.innerHTML = "From";
    
    for(var i=0;i<jsonObj.length;i++){
    	var row=table.insertRow(table.rows.length);
    	row.id=jsonObj[i].from_id;
    	var cell0 = row.insertCell(0);
        cell0.innerHTML = jsonObj[i].name;
        row.onclick = function(e){
        	var from_id=null;
        	requestName(e, from_id);
        }
    }
    
    var row=table.insertRow(table.rows.length);
	var cell0 = row.insertCell(0);
    cell0.innerHTML = "From"; 
}
function users(){
	var users;
	var str='';
	var request = new XMLHttpRequest();
	request.onreadystatechange=function(){
		if (request.readyState==4 && request.status==200){
			users=JSON.parse(request.responseText);
			var userLength=users.length;
			for(var i=0;i<userLength;i++){
				str+='<li id="'+users[i].id+'"><p>'+users[i].name+' </p></li>';
			}
			var usersUl=document.getElementById("usersUl");
			usersUl.innerHTML=str;			
		}
	}
	ajaxObject={
		'request':'getUsers'
	}
	jsonString = JSON.stringify(ajaxObject);
	request.open("GET", "AJAX.php?obj="+jsonString, false);
	request.send();
}
function mainTable(){
	view="mainTable";
	var jsonString;
	
	var request = new XMLHttpRequest();
	request.onreadystatechange=function(){
		if (request.readyState==4 && request.status==200){
			jsonObj=JSON.parse(request.responseText);
			makeActions(jsonObj);
		}
	}
	ajaxObject={
		'request':'getGroups'
	}
	jsonString = JSON.stringify(ajaxObject);
	request.open("GET", "AJAX.php?obj="+jsonString, false);
	request.send();
}

function showMyGroups(jsonObj){
	view="showMyGroups";
	var mainDiv=document.getElementById("mainDiv");
	mainDiv.innerHTML="";
	var form = '<table id="mainTable" width="150px" border="1"></table>';
	mainDiv.innerHTML+=form;
	var table=document.getElementById("mainTable");
	for(var i = table.rows.length-1; i >= 0; i--){
		table.deleteRow(i);
	}
	var row=table.insertRow(0);
	var cell0 = row.insertCell(0);
    cell0.innerHTML = "To";
    
    for(var i=0;i<jsonObj.length;i++){
    	var row=table.insertRow(table.rows.length);
    	row.id=jsonObj[i].to_id;
    	var cell0 = row.insertCell(0);
        cell0.innerHTML = jsonObj[i].name;
        cell0.onclick = function(e){
        	var to_id=null;
        	requestMyName(e, to_id);
        }
    }
    
    var row=table.insertRow(table.rows.length);
	var cell0 = row.insertCell(0);
    cell0.innerHTML = "To"; 
}

function makePostsTable(jsonObj){
	view="makePostsTable";
	var mainDiv=document.getElementById("mainDiv");
	mainDiv.innerHTML="";
	var form = '<table id="mainTable" width="150px" border="1"></table>';
	mainDiv.innerHTML+=form;
	mainDiv.innerHTML+='<button id="deleteButton">delete messages</button>';
	$('#deleteButton').click(function(){
		deletePosts(jsonObj, false);
	});
	var table=document.getElementById("mainTable");
	for(var i = table.rows.length-1; i >= 0; i--){
		table.deleteRow(i);
	}
	var row=table.insertRow(0);
	var cell0 = row.insertCell(0);
    cell0.innerHTML = "From";
    var cell1 = row.insertCell(1);
    cell1.innerHTML = "Message";
    var cell2 = row.insertCell(2);
    cell2.innerHTML = "";
    
    for(var i=0;i<jsonObj.length;i++){
    	var row=table.insertRow(table.rows.length);
    	row.id=jsonObj[i].post_id;
    	var cell0 = row.insertCell(0);
        cell0.innerHTML = jsonObj[i].name;
        var cell1 = row.insertCell(1);
        cell1.innerHTML = jsonObj[i].body;
        var cell2 = row.insertCell(2);
        cell2.innerHTML = '<input type="checkbox">';
        if(jsonObj[i].isRead=="0"){
        	row.style.backgroundColor = "green";
        }
        
        cell1.onclick = function(e){
        	postReply(e, jsonObj);
        };
    }
    
    var row=table.insertRow(table.rows.length);
	var cell0 = row.insertCell(0);
    cell0.innerHTML = "From";
    var cell1 = row.insertCell(1);
    cell1.innerHTML = "Message"; 
    var cell2 = row.insertCell(2);
    cell2.innerHTML = "";
}
function makeMyPostsTable(jsonObj){
	view="makeMyPostsTable";
	var mainDiv=document.getElementById("mainDiv");
	mainDiv.innerHTML="";
	var form = '<table id="mainTable" width="150px" border="1"></table>';
	mainDiv.innerHTML+=form;
	mainDiv.innerHTML+='<button id="deleteButton">delete messages</button>';
	$('#deleteButton').click(function(){
		deletePosts(jsonObj, true);
	});
	var table=document.getElementById("mainTable");
	for(var i = table.rows.length-1; i >= 0; i--){
		table.deleteRow(i);
	}
	var row=table.insertRow(0);
	var cell0 = row.insertCell(0);
    cell0.innerHTML = "To";
    var cell1 = row.insertCell(1);
    cell1.innerHTML = "Message";
    var cell2 = row.insertCell(2);
    cell2.innerHTML = "";
    
    for(var i=0;i<jsonObj.length;i++){
    	var row=table.insertRow(table.rows.length);
    	row.id=jsonObj[i].post_id;
    	var cell0 = row.insertCell(0);
        cell0.innerHTML = jsonObj[i].name;
        var cell1 = row.insertCell(1);
        cell1.innerHTML = jsonObj[i].body;
        var cell2 = row.insertCell(2);
        cell2.innerHTML = '<input type="checkbox">';
        if(jsonObj[i].isRead=="0"){
        	row.style.backgroundColor = "green";
        }
    }
    
    var row=table.insertRow(table.rows.length);
	var cell0 = row.insertCell(0);
    cell0.innerHTML = "To";
    var cell1 = row.insertCell(1);
    cell1.innerHTML = "Message"; 
    var cell2 = row.insertCell(2);
    cell2.innerHTML = "";
}

function deletePosts(jsonObj, isMyPosts){
	view="deletePosts";
	var checkboxes=$('#mainTable :input[checked]');
	var checkboxesLength=checkboxes.length;
	var idArray=new Array();
	for(var i=0;i<checkboxesLength;i++){
		idArray[i] = checkboxes[i].parentNode.parentNode.id;
	}
	var request = new XMLHttpRequest();
    request.onreadystatechange=function(){
    	if (request.readyState==4 && request.status==200)
        {
    		//alert(request.responseText);
    		e=null;
    		if(isMyPosts===false){
    			requestName(e, jsonObj[0].from_id);
    		}else{
    			requestMyName(e, jsonObj[0].to_id);
    		}
        }
    }
    ajaxObject={
    		'request':'deletePosts',
    		'idArray':idArray
    }
    jsonString = JSON.stringify(ajaxObject);
    request.open("GET", "AJAX.php?obj="+jsonString, false);
    request.send();
}

function requestName(e, from_id){
	view = "requestName";
	var request = new XMLHttpRequest();
    request.onreadystatechange=function(){
    	if (request.readyState==4 && request.status==200)
        {
    	jsonObj=JSON.parse(request.responseText);
    	makePostsTable(jsonObj);
        }
    }
    if(from_id == null){
    	var from_id=e.target.parentNode.id;
    }
    ajaxObject={
    		'request':'getPosts',
    		'from_id':from_id
    }
    jsonString = JSON.stringify(ajaxObject);
    request.open("GET", "AJAX.php?obj="+jsonString, false);
    request.send();
}
function requestMyName(e, to_id){
	view="requestMyName";
	var request = new XMLHttpRequest();
    request.onreadystatechange=function(){
    	if (request.readyState==4 && request.status==200)
        {
    	jsonObj=JSON.parse(request.responseText);
    	makeMyPostsTable(jsonObj);
    	//alert(request.responseText);
        }
    }
    if(to_id == null){
    	var to_id=e.target.parentNode.id;
    }
    ajaxObject={
    		'request':'getMyPosts',
    		'to_id':to_id
    }
    jsonString = JSON.stringify(ajaxObject);
    request.open("GET", "AJAX.php?obj="+jsonString, false);
    request.send();
}

function postReply(e, jsonObject){
	view="postReply";
	var postId=e.target.parentNode.id;
	var post=null;
	var objLength=jsonObj.length;
	for(var i=0;i<objLength; i++){
		if(jsonObj[i].post_id == postId){
			post=jsonObj[i];
			break;
		}
	}
	var fromName=post.name;
	var time=post.date_sent;
	var postBody=post.body;
	var mainDiv=document.getElementById("mainDiv");
	mainDiv.innerHTML="";
	var form = '<div><div id="message"><h2>From'+fromName+'</h2><p>'+time+'</p><br><p><b>'+postBody+'</b></p></div><div id="reply"><textarea rows="10" cols="60" id="replyBody"></textarea><br><button id="replyButton">Reply</button></div></div>';
	mainDiv.innerHTML+=form;
	
	var replyButton=document.getElementById("replyButton");
	var replyBody=document.getElementById("replyBody");
	replyButton.onclick=function(){
		sendPost(post, replyBody.value);
	}
}

function sendPost(fromPost, postBody){
	view="sendPost";
	var to=fromPost.from_id;
	var fromPostId=fromPost.post_id;
	var request = new XMLHttpRequest();
    request.onreadystatechange=function(){
    	if (request.readyState==4 && request.status==200)
        {
    		jsonObj=JSON.parse(request.responseText);
    		var e=null;
    		requestName(e,to);
        }
    }
    ajaxObject={
    		'request':'newPost',
    		'to_id':to,
    		'postBody':postBody,
    		'fromPostId':fromPostId
    }
    jsonString = JSON.stringify(ajaxObject);
    request.open("GET", "AJAX.php?obj="+jsonString, false);
    request.send();
}
