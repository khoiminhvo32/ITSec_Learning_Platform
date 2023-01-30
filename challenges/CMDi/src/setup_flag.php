<?php
if(isset($_GET['level'])){
    $level = $_GET['level'];
    switch($level){
        case "1":
            system("rm ./flag_*\necho '". getenv("FLAG_LEVEL1") . "' > ./flag_level1");
            break;
        case "2":
            system("rm ./flag_*\necho '". getenv("FLAG_LEVEL2") . "' > ./flag_level2");
            break;
        case "3":
            system("rm ./flag_*\necho '". getenv("FLAG_LEVEL3") . "' > ./flag_level3");
            break;
    }
}
?>