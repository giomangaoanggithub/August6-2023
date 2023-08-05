<?php

$directory = (scandir("../demoman/all"));
$clean_directory = $directory[2];
for($i = 3; $i < count($directory);$i++){
    $clean_directory .= "<,>".$directory[$i];
}
echo $clean_directory;

?>