window.onload=function(){
var submit = document.getElementById("tryAJAX");
var jsonObj;
var jsonString;

submit.onclick = function(e){	
	e.preventDefault();
    var request = new XMLHttpRequest();
    request.onreadystatechange=function(){
    	if (request.readyState==4 && request.status==200)
        {
    	jsonObj=JSON.parse(request.responseText);
    	makeActions(jsonObj);
    	//alert("Incoming AJAX! " + jsonObj[0].from_id);
        }
    }
    ajaxObject={
    		'request':'getGroups'
    }
    jsonString = JSON.stringify(ajaxObject);
    request.open("GET", "AJAX.php?obj="+jsonString, false);
    request.send();
}
}
function makeActions(jsonObj){
	var table=document.getElementById("mainTable");
	for(var i = table.rows.length-1; i >= 0; i--){
		table.deleteRow(i);
	}
	var row=table.insertRow(0);
	var cell0 = row.insertCell(0);
    cell0.innerHTML = "From";
    //var cell1 = row.insertCell(1);
    //cell1.innerHTML = "Message";
    
    for(var i=0;i<jsonObj.length;i++){
    	var row=table.insertRow(table.rows.length);
    	row.id=jsonObj[i].from_id;
    	var cell0 = row.insertCell(0);
        cell0.innerHTML = jsonObj[i].name;
        //var cell1 = row.insertCell(1);
        //cell1.innerHTML = jsonObj[i].body;
        //if(jsonObj[i].isRead=="0"){
        //	row.style.backgroundColor = "green";
        //}
        
        row.onclick = function(e){
        	requestName(e,row);
        }
    }
    
    var row=table.insertRow(table.rows.length);
	var cell0 = row.insertCell(0);
    cell0.innerHTML = "From";
    //var cell1 = row.insertCell(1);
    //cell1.innerHTML = "Message"; 
}

function makePostsTable(jsonObj){
	var table=document.getElementById("mainTable");
	for(var i = table.rows.length-1; i >= 0; i--){
		table.deleteRow(i);
	}
	var row=table.insertRow(0);
	var cell0 = row.insertCell(0);
    cell0.innerHTML = "From";
    var cell1 = row.insertCell(1);
    cell1.innerHTML = "Message";
    
    for(var i=0;i<jsonObj.length;i++){
    	var row=table.insertRow(table.rows.length);
    	row.id=jsonObj[i].from_id;
    	var cell0 = row.insertCell(0);
        cell0.innerHTML = jsonObj[i].name;
        var cell1 = row.insertCell(1);
        cell1.innerHTML = jsonObj[i].body;
        if(jsonObj[i].isRead=="0"){
        	row.style.backgroundColor = "green";
        }
        
        row.onclick = function(e){
        	requestName(e,row);
        }
    }
    
    var row=table.insertRow(table.rows.length);
	var cell0 = row.insertCell(0);
    cell0.innerHTML = "From";
    var cell1 = row.insertCell(1);
    cell1.innerHTML = "Message"; 
}

function requestName(e){
	var request = new XMLHttpRequest();
    request.onreadystatechange=function(){
    	if (request.readyState==4 && request.status==200)
        {
    	jsonObj=JSON.parse(request.responseText);
    	makePostsTable(jsonObj);
        }
    }
    var from_id=e.target.parentNode.id;
    ajaxObject={
    		'request':'getPosts',
    		'from_id':from_id
    }
    jsonString = JSON.stringify(ajaxObject);
    request.open("GET", "AJAX.php?obj="+jsonString, false);
    request.send();
}