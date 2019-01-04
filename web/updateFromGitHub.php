<?php
echo shell_exec("rm -t /tmp/web")
echo shell_exec("git clone https://github.com/mada123450/esp_ota.git/ /tmp/web");
echo shell_exec("rm -r /tmp/web/web/.vs");
echo shell_exec("rm -r /tmp/web/web/projects");
echo shell_exec("cp -r -v /tmp/web/web /var/www/html");
echo shell_exec("rm -r /tmp/web");
?>