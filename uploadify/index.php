<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>UploadiFive Test</title>
<script src="js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="jquery.uploadify.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="uploadify.css">
<style type="text/css">
body {
	font: 13px Arial, Helvetica, Sans-serif;
}
</style>
</head>

<body>
	<h1>Uploadify Demo</h1>
	
	
	<form>
		<div id="queue"></div>
		<input id="file_upload" name="file_upload" type="file" multiple="true">
	</form>
 <form action="../process.php">
		<button id="upload_finish" type="submit" disabled="disabled">开始处理</button>
	</form>
 	
	<script type="text/javascript">
	//var submitButton =
		 //document.getElementById("upload_finish").type="hidden";
	//submitButton.attribute("disabled", "");
		<?php $timestamp = time();?>
		$(function() {
			$('#file_upload').uploadify({
				'formData'     : {
					'timestamp' : '<?php echo $timestamp;?>',
					'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
				},
				'swf'      : 'uploadify.swf',
				'uploader' : 'uploadify.php',
				'fileTypeDesc':'Excel 2003 文件',
				 //允许上传的文件后缀
				'fileTypeExts':'*.xls;',
				'buttonText' : '选择文件',
				//'buttonImage' : 'browse-btn.png'
				'onUploadSuccess' : function(file, data, response) {
					var finish = document.getElementById("upload_finish");
					finish.innerHTML = "wahaha";
					finish.removeAttribute("disabled");
				},
			});
		});
	</script>

</body>
</html>