/*(function() {
	var video = document.getElementById('video'),
		vendorUrl = window.URL || window.webkitURL;
	navigator.getMedia = 	navigator.getUserMedia ||
							navigator.webkitGetUserMedia ||
							navigator.mozGetUserMedia ||
							navigator.msGetUserMedia;
	navigator.getMedia({
		video: true,
		audio: false
	}, function(stream) {
		video.src = vendorUrl.createObjectURL(stream);
		video.play;
	}, function(error) {
		// an error occurred
		// error.code
	});
})();*/

(function()
{
	var video = document.getElementById('video');
	if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia)
	{
		navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
			video.srcObject = stream;
			video.play();
		});
	}

	var canvas = document.getElementById('canvas');
	var context = canvas.getContext('2d');
	var video = document.getElementById('video');
	document.getElementById("snap").addEventListener("click", function() {
		context.drawImage(video, 0, 0, 640, 480);
		var image = new Image();
		image.src = canvas.toDataURL("image/png");
		/*var canvas2 = document.createElement("canvas2");
		canvas2.width = image.width;
		canvas2.height = image.height;
		canvas2.getContext("2d").drawImage(image, 0, 0);
		return canvas2;*/
	});
})();