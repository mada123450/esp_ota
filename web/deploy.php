<?php
if(!is_dir("./projects/".dirname($_POST['fileName'])."/deploy")
{
	mkdir("./projects/".dirname($_POST['fileName'])."/deploy");        
}
copy("./projects/".dirname($_POST['fileName'])."/build/".dirname($_POST['fileName']).".ino.bin", 
     "./projects/".dirname($_POST['fileName'])."/deploy/".dirname($_POST['fileName']).".ino.bin");
?>
