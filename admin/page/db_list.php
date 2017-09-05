
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
            <nav class="navbar bg-success navbar-light navbar-static-top">
                <ul class="nav navbar-nav">
        <?php foreach($tablesList as $tab){
            ?>
                <li><a href="#" onclick=get_table("<?php echo $tab; ?>")><?php echo strtoupper($tab); ?></a></li>
            <?php
                }
        ?>
            </ul>
        </nav>
</div>
<div class="container-fluid">
    <?php
        if(isset($_GET['tname'])){
            ?>
            <table class="table table-responsive table-bordered table-striped"><tr>
            <?php
            $tname=$_GET['tname'];
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
        }
    ?>
</div>