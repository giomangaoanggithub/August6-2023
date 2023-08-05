<?php

session_start();

$confirmation = $_SESSION["teacher_account"];
$user_folder = $_POST["user_folder"];
$user_file = $_POST["user_file"];

error_reporting(0);

if($confirmation == $user_folder){
    if(unlink("../../user_files/$user_folder/$user_file")){
        echo $user_file." permanently deleted.";
    } else {
        echo "The file is not existed or may be deleted from another device.";
    }
    
} else if ($confirmation != $user_folder) {
    echo "The $user_file cannot deleted due to authentication problems.";
} 

?>