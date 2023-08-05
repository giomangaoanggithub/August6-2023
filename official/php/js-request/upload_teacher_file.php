<?php

session_start();

$email = $_SESSION["teacher_account"];
// $file_content = $_POST["file_content"];
// $filename = $_POST["filename"];

/* Get the name of the uploaded file */
$filename = $_FILES['file']['name'];

/* Choose where to save the uploaded file */
$location = "../../user_files/$email/$filename";

/* Save the uploaded file to the local filesystem */
if ( move_uploaded_file($_FILES['file']['tmp_name'], $location) ) { 
  echo 'Success'; 
} else { 
  echo 'Failed'; 
}

?>