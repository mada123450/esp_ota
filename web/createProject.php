<?php
    mkdir("projects/".$_POST['projectName']);
    mkdir("projects/".$_POST['projectName']."/build");
    mkdir("projects/".$_POST['projectName']."/deploy");
    copy("projects/default/default.ino", "projects/".$_POST['projectName']."/".$_POST['projectName'].".ino");
    copy("projects/default/settings.json", "projects/".$_POST['projectName']."/settings.json");
?>