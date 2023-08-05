<?php
session_start();

$user = $_SESSION["teacher_account"];

if (in_array($user, scandir("../../user_files"))){
    if(count(scandir("../../user_files/$user")) <= 2){
        echo "Please upload your references first before simulating...";
    } else {
        echo "start_simulation";
    }
}

?>