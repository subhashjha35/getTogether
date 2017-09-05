<?php
    if(isset($_GET['x1'])){
        $x1 = $_GET['x1'];
        $y1 = $_GET['y1'];
        $x2 = $_GET['x2'];
        $y2 = $_GET['y2'];
        $h = $_GET['h'];
        $w = $_GET['w'];
        /*echo $x1."<br>".$x2."<br>".$y1."<br>".$y2."<br>";*/
        /*echo $width."<br>".$height;*/

        $img=imagecreatetruecolor(256,256);
        $src="resources/web/images/section-1.jpg";
        $source_img=imagecreatefromjpeg($src);
        //$dest_img=imagecrop($source_img,['x'=>$x1,'y'=>$y1,'width'=>$w,'height'=>$h]);
        /*$dest1_img=resizeImage($dest_img);*/
        imagecopyresampled($img,$source_img,0,0,$x1,$y1,256,256,$w,$h);
        if($source_img!=FALSE){
            $cropped_image_dest="resources/images/img2.jpg";
            //header('Content-Type: image/jpeg');
            imagejpeg($img,$cropped_image_dest,100);
        }
    }
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="css/imgareaselect-default.css" />
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.imgareaselect.js"></script>

    <script type="text/javascript">

        $(document).ready(function () {
            var image = document.getElementById('ladybug_ant');
            var originalHeight = image.naturalHeight;
            var originalWidth = image.naturalWidth;
            function getCoordinates(img, selection) {
                if (!selection.width || !selection.height){
                    return;
                }
                // With this two lines i take the proportion between the original size and
                // the resized img
                var porcX = image.naturalWidth / image.width;
                var porcY = image.naturalHeight / image.height;
                // Send the corrected coordinates to some inputs:
                // Math.round to get integer number
                // (selection.x1 * porcX) to correct the coordinate to real size

                console.log("selection x1:"+ selection.x1);
                console.log("selection x2:"+ selection.x2);


                $('input[name="x1"]').val(Math.round(selection.x1));
                $('input[name="y1"]').val(Math.round(selection.y1));
                $('input[name="x2"]').val(Math.round(selection.x2));
                $('input[name="y2"]').val(Math.round(selection.y2));
                $('input[name="w"]').val(Math.round(selection.width));
                $('input[name="h"]').val(Math.round(selection.height));
            }

            // Take the original size from image with naturalHeight - Width


            // Show original size in console to make sure is correct (optional):
            console.log('IMG width: ' + originalWidth + ', heigth: ' + originalHeight);
            console.log('IMG width: ' + image.width + ', heigth: ' + image.height);
            console.log($("input[name='x1']").val());

            // Enable imgAreaSelect on your image

            $('#ladybug_ant').imgAreaSelect({ aspectRatio: '1:1', handles: true, x1: 0, y1: 0, x2: 200, y2: 200,
                fadeSpeed: 200,
                imageHeight: originalHeight,
                imageWidth: originalWidth,
                onSelectChange: getCoordinates // this function below
            });
        });

    </script>
</head>
<body>
<img src="resources/web/images/section-1.jpg" id="ladybug_ant" style="height:400px">
<img src="resources/images/img2.jpg" alt=""><br>

<form action="<?=$_SERVER['PHP_SELF'];?>" method="get">
    <input type="hidden" name="x1"/>
    <input type="hidden" name="y1"/>
    <input type="hidden" name="x2"/>
    <input type="hidden" name="y2"/>
    <input type="hidden" name="w"/>
    <input type="hidden" name="h"/>
    <input type="submit" name="submit" value="Submit" />
</form>

</body>
</html>
