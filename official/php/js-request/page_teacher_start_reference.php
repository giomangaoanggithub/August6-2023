<?php

session_start();

$user_dir = "../../user_files/".$_SESSION["teacher_account"];

echo json_encode(array_values(scandir($user_dir)));
?>