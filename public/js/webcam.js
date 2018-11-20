//untested and incomplete

(function() {
	var streaming = false,
		video = document.querySelector('#video'),
		cover = document.querySelector('#cover'),
		canvas = document.querySelector('#canvas'),
		photo = document.querySelector('#photo'),
		startbutton = document.querySelector('#startbutton'),
		savebutton = document.querySelector('#savebutton'),
		img1 = document.querySelector('#img1'),
		img2 = document.querySelector('#img2'),
		img3 = document.querySelector('#img3'),
		upload = document.querySelector('#uploadpic'),
		submitupload = document.querySelector('#uploadsubmitbutton'),
		data = 0,
		uploadData = 0,
		width = 320,
		height = 240,
		imgselected = 0;

	navigator.getMedia = (navigator.getUserMedia ||
							navigator.webkitGetUserMedia ||
							navigator.mozGetUserMedia ||
							navigator.msGetUserMedia);
	navigator.getMedia(
		{
			video: true,
			audio: false
		},
		function(stream) {
			if (navigator.mozGetUserMedia) {
				video.mozSrcObject = stream;
			} else {
				var vendorURL = window.URL || window.webkitURL;
				video.src = vendorURL.createObjectURL(stream);
			}
			video.play();
		},
		function(err) {
			console.log("An error has occured." + err);
		}
	);

	video.addEventListener('canplay', function(ev){
		if (!streaming) {
			height = video.videoHeight / (video.videoWidth/width);
			video.setAttribute('width', width);
			video.setAttribute('height', height);
			canvas.setAttribute('width', width);
			canvas.setAttribute('height', height);
			streaming = true;
		}
	}, false);

	function mergePicAndDisplay(pic) {
		var picData = pic.replace("data:image/png;base64,", "");
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "../app/mergepic.php", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("pic="+encodeURIComponent(picData)+"&img="+imgselected);
		xhr.onreadystatechange = function () {
			if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
				var response = JSON.parse(xhr.responseText);
				response = "data:image/png;base64,"+response;
				data = response;
				image = new Image();
				image.src = response;
				image.onload = function() {
					canvas.getContext('2d').drawImage(image, 0, 0, width, height);
					canvas.toDataURL('image/png');
				}
			}
		}
	}

	function takePicture(vid) {
		if (imgselected != 0) {
			checkError();
			var newcanvas = document.createElement('canvas');
			newcanvas.width = width;
			newcanvas.height = height;
			canvas.width = width;
			canvas.height = height;
			if (vid == 1) {
				newcanvas.getContext('2d').drawImage(video, 0, 0, width, height);
				var pic = newcanvas.toDataURL('image/png');
				mergePicAndDisplay(pic);
			}
			else {
				var image = new Image();
				image.src = uploadData;
				image.onload = function() {
					newcanvas.getContext('2d').drawImage(image, 0, 0, width, height);
					var pic = newcanvas.toDataURL('image/png');
					mergePicAndDisplay(pic);
				}
			}
		}
		else {
			displayError("NoImg");
		}
	}

	startbutton.addEventListener('click', function(ev){
		if (streaming == true) {
			takePicture(1);
		}
		else {
			displayError("NoVideo");
		}
		ev.preventDefault();
	}, false);

	img1.addEventListener('click', function(ev){
		imgselected = 1;
		var img = document.getElementById("img1");
		img.setAttribute("style", "background-color:#edd15a");
		img = document.getElementById("img2");
		img.setAttribute("style", "background-color:#f2f2f2");
		img = document.getElementById("img3");
		img.setAttribute("style", "background-color:#f2f2f2");
		ev.preventDefault();
	}, false);

	img2.addEventListener('click', function(ev){
		imgselected = 2;
		var img = document.getElementById("img2");
		img.setAttribute("style", "background-color:#edd15a");
		img = document.getElementById("img1");
		img.setAttribute("style", "background-color:#f2f2f2");
		img = document.getElementById("img3");
		img.setAttribute("style", "background-color:#f2f2f2");
		ev.preventDefault();
	}, false);

	img3.addEventListener('click', function(ev){
		imgselected = 3;
		var img = document.getElementById("img3");
		img.setAttribute("style", "background-color:#edd15a");
		img = document.getElementById("img2");
		img.setAttribute("style", "background-color:#f2f2f2");
		img = document.getElementById("img1");
		img.setAttribute("style", "background-color:#f2f2f2");
		ev.preventDefault();
	}, false);

	savebutton.addEventListener('click', function(ev){
		if (data != 0)
			savePicture(data);
		ev.preventDefault();
	}, false);

	
	}