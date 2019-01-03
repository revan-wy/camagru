(function() {
	//console.log("gallery script loaded");
})();

function addLike(id)
{
	var src = document.getElementById('like_'+id).attributes.getNamedItem("src").value;
	if (src == "../public/img/like.png")
	{
		document.getElementById('like_'+id).src = "../public/img/like_red.png";
		var elem = document.getElementById('nblike_'+id);
		var nb = elem.innerHTML;
		nb = parseInt(nb);
		nb++;
		if (nb == 1)
			elem.innerHTML = nb+' Like';
		else
			elem.innerHTML = nb+' Likes';
		var xhr = new XMLHttpRequest();
		xhr.open("GET", "../app/savelike.php?pic_id="+id, true);
		xhr.send();
	}
	else if (src == "../public/img/like_red.png")
	{
		document.getElementById('like_'+id).src = "../public/img/like.png";
		var elem = document.getElementById('nblike_'+id);
		var nb = elem.innerHTML;
		nb = parseInt(nb);
		nb--;
		if (nb == 1)
			elem.innerHTML = nb+' Like';
		else
			elem.innerHTML = nb+' Likes';
		var xhr = new XMLHttpRequest();
		xhr.open("GET", "../app/deletelike.php?pic_id="+id, true);
		xhr.send();
	}
}

function addComment(id, comment, login)
{
	//console.log("java function started");
	com = htmlEntities(comment.value);
	if (com.trim() === "")
	return ;
	var xhr = new XMLHttpRequest();
	xhr.open("POST", "../app/savecomment.php", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	//console.log("id = "+id+", com = "+com+", login = "+login);
	xhr.onreadystatechange = function () {
		//console.log("request");
		if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
			var div = document.createElement("DIV");
			div.setAttribute("class", "allcomments");
			div.innerHTML = "<b>"+login+"</b> "+com;
			document.getElementById('firstcomment_'+id).appendChild(div);
			comment.value = "";
			console.log(xhr.responseText);
		}
	}
	xhr.send("pic_id="+id+"&comment="+com);
}

function htmlEntities(str) {
	return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

function deletePicture(id) {
	document.getElementById('delete_'+id).parentNode.remove();
	var xhr = new XMLHttpRequest();
	xhr.open("GET", "../app/deletepic.php?pic_id="+id, true);
	xhr.send();
}