<?php
$directory = 'projects';
$scanned_directory = array_values(array_diff(scandir($directory), array('..', '.')));
print_r(json_encode($scanned_directory));
?>