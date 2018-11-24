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
})();