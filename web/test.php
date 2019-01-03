<?php
$jsonString = file_get_contents("./projects/default/settings.json");

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
echo $boardArg;
?>