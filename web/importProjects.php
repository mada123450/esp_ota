<?php
if(!isset($_POST["submit"]))
{
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
</head>
<body>

<form action="importProjects.php" method="post" enctype="multipart/form-data">
    Select projects.zip upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Projects" name="submit">
</form>

</body>
</html>
<?php
}
else
{
    $target_dir = "/tmp/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if($fileType != "zip")
    {
        echo "Only .zip archives allowed!";   
    }

    if(file_exists($target_file))
        unlink($target_file);

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
    {
        shell_exec("unzip -o \"".$target_file."\" -d /var/www/html");
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
</head>
    <body>
        <h1>OK</h1>
        <script>
            close();
        </script>
    </body>
</html>
<?php
        unlink($target_file);
    }
    else
    {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>