<?php



$file = "logs/log.log";
//$content = date("Y-m-d H:i:s ") . "\n" ;

//$fileHandle = file_put_contents($file, $content, FILE_APPEND);

echo file_get_contents($file);