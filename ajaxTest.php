<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script type="text/javascript" src="./js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="./js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <script>
        function con_list(){
            $abc=$("#conList").val();
            $.get("abc.php", {key:$abc},function(data){
                $("#databox").html(data);
            });
        }
    </script>
</head>
<body>

<input type="text" id="conList" onkeyup="con_list()">
<div id="databox"></div>
</body>
</html>