<?php
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/emojione.picker.css">
    <script src="js/jquery-1.8.3.min.js"></script>
    <script src="js/emojione.picker.js"></script>
    <script>
        $(document).ready(function(){
            $("#text").emojionePicker();
        });
    </script>
</head>
<body>
<textarea name="" id="text" cols="30" rows="10"></textarea>
</body>
</html>
