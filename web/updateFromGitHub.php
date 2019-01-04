<?php
if(is_dir("/tmp/webDownload"))
    echo shell_exec("rm -f -r /tmp/webDownload");
echo shell_exec("git clone https://github.com/mada123450/esp_ota.git /tmp/webDownload");
echo shell_exec("rm -r /tmp/webDownload/web/.vs");
echo shell_exec("rm -r /tmp/webDownload/web/projects");
echo shell_exec("cp -r /tmp/webDownload/web/* /var/www/html");
echo shell_exec("rm -f -r /tmp/webDownload");
?>