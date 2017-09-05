
<div class="container-fluid">
    <?php
    @include_once "../adminController.php";
    @include_once("adminController.php");

    $tables=new DbTables();
    $tablesList=$tables->get_tables();

    /*function table_structures(){
        global $db;
        $table_name=get_tables();
        foreach($table_name as $tname){
            //echo "<br><strong>".$tname." :</strong>";
            $sql="describe $tname";
            $res=mysqli_query($db, $sql);
            while($row=mysqli_fetch_array($res)){
                //echo " ".$row["0"];
            }
            //echo "<BR>";
        }
    }*/
    ?>

</div>
<div class="container-fluid">
    <table class="table table-responsive table-bordered table-striped"><tr>
            <?php
            $tname="website_feedback";
            $tables=new DbTables();
            $tcol=$tables->table_structures($tname);
            foreach ($tcol as $row){
                ?>
                <th><?php echo $row; ?></th>
                <?php
            }
            ?>
        </tr>
        <?php
        $row=$tables->show_tables($tname);
        foreach($row as $records){
            echo "<tr>";
            foreach($tcol as $a){
                ?>
                <td><?php echo $records["$a"] ?></td>
                <?php
            }
            echo "</tr>";
        }
        ?>
</div>