<?php
$binary = "";
$timestamp = "";

foreach (getallheaders() as $name => $value) 
{
    if( $name == "x-ESP8266-version")
    {
        $parts = explode(" ## ", $value);
        $binary = ".".$parts[0];
        $timestamp = date_create_from_format("M j Y H:i:s", $parts[1]);
    }
}
//error_log("Binary ".$binary." requested. Timestamp: ".$timestamp);
//echo filemtime ($binary);
//echo "<br/>";
//echo date_timestamp_get($timestamp);
if(filemtime ($binary) - 60 > date_timestamp_get($timestamp))
    sendfile($binary);
else
{
   header($_SERVER["SERVER_PROTOCOL"].' 304 Not Modified', true, 304);
}

function sendFile($path) 
{
    if(!is_file($path))
    {
        header($_SERVER["SERVER_PROTOCOL"].' 404 Not Found', true, 404);
        echo $path;
        return;
    }
    header($_SERVER["SERVER_PROTOCOL"].' 200 OK', true, 200);
    header('Content-Type: application/octet-stream', true);
    header('Content-Disposition: attachment; filename='.basename($path));
    header('Content-Length: '.filesize($path), true);
    header('x-MD5: '.md5_file($path), true);
    readfile($path);
}
?>