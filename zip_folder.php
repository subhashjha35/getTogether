<?php
    if(isset($_POST['url'])){
        $url=$_POST['url'];
        ob_start();
        apache_setenv('no-gzip', 1);
        ini_set('zlib.output_compression', 0);
        $dir = $url;//folder path
        echo $dir;
        $archive = time().'download.zip';

        $zip = new ZipArchive;
        $zip->open($archive, ZipArchive::CREATE);
        $files = scandir($dir);
        unset($files[0], $files[1]);
        foreach ($files as $file) {
            $zip->addFile($dir.DIRECTORY_SEPARATOR.$file);
        }
        $zip->close();
        header('Content-type: application/zip');
        header('Content-Disposition: attachment; filename='.$archive);
        header('Content-Length: '.filesize($archive));
        header("Content-Transfer-Encoding: binary");
        ob_clean();
        readfile($archive);
        exit;
    }
?>
<form action="" method="post">
    <input type="text" name="url">
    <button type="submit">Zip</button>
</form>
