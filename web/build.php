<?php

$jsonString = file_get_contents("./projects/".dirname($_POST['fileName'])."/settings.json");

$settings = json_decode($jsonString);
$boardModel = $settings->board->BoardModel;

$values = "";

foreach($settings->board as $key => $val)
{
    if($key == "BoardModel")
        continue;
    
    if($values == "")
        $values .= ":";
    else
        $values .= ",";
    $values .= $key . "=" . $val;
}

$boardArg = $boardModel.$values;

echo shell_exec ("arduino --board ".$boardArg." --verify /var/www/html/projects/".$_POST['fileName']." --pref build.path=/var/www/html/projects/".dirname($_POST['fileName'])."/build --pref sketchbook.path=/tmp");
?>