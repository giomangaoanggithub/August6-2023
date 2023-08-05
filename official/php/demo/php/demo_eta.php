<?php

$user_account = $_POST["eta"];

$file_content =  file_get_contents("../../../user_tfidf_files/$user_account@email.com.txt");

echo "ETA: ".intval(strlen($file_content) / 500000)."m : ".(round(fmod(strlen($file_content) / 500000, 1), 2)*100)."s";
?>