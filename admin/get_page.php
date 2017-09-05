<?php

if(isset($_GET['page_id'])){
    $page=$_GET['page_id'];
    echo $page="./page/$page";
    require $page;
}
?>