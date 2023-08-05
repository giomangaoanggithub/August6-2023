<?php

session_start();

ini_set('memory_limit', '8G');
ini_set('max_execution_time', '0');

$user_account = $_SESSION["teacher_account"];

$file_content = file_get_contents("../../user_tfidf_files/$user_account.txt");

echo "ETA: ".intval(strlen($file_content) / 500000)."m : ".(round(fmod(strlen($file_content) / 500000, 1), 2)*100)."s";

?>