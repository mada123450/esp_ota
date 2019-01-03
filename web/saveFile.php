<?php
    $myfile = fopen("projects/".$_POST['fileName'], "w") or die("Unable to open file!");
    $txt = $_POST['content'];
    fwrite($myfile, $txt);
    fclose($myfile);
?>