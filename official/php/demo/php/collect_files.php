<?php

$user = $_POST["demo_user"];

$arr_files = scandir("../$user/");

$string_files = $arr_files[2];

for($i = 3; $i < count($arr_files); $i++){
    $string_files .= ",".$arr_files[$i];
}

echo $string_files;

?>