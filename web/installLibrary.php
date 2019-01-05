<?php
echo shell_exec("arduino --install-library \"".$_POST['libraryName']."\"");
?>