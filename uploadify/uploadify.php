<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

// Define a destination
$targetFolder = '/uploads'; // Relative to the root

$verifyToken = md5('unique_salt' . $_POST['timestamp']);

if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	
	//在上传文件的主文件名后追加精确到微秒的Unix时间戳，防止上传的文件重名而发生的先上传的文件被替换掉的情况
	list($usec, $sec) = explode(" ", microtime());
	$targetFile = rtrim($targetPath,'/') . '/' . str_replace('.xls', '', $_FILES['Filedata']['name']) . $sec . substr ($usec,2) . '.xls';
	
	// Validate the file type
	$fileTypes = array('xls',''); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	if (in_array($fileParts['extension'],$fileTypes)) {
		move_uploaded_file($tempFile,$targetFile);
		echo '1';
	} else {
		echo 'Invalid file type.';
	}
}
?>