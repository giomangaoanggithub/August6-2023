<?php

session_start();

include "../mysql/db_connection.php";

$user_id = "";

if($_SESSION["role"] == 1){
  $user_id = $_SESSION["teacher_user_id"];
} else {
  $user_id = $_SESSION["student_user_id"];
}


$username = $_POST["username"];

try {
    $sql = "UPDATE accounts SET username='$username' WHERE user_id = '$user_id'";
  
    // Prepare statement
    $stmt = $conn->prepare($sql);
  
    // execute the query
    $stmt->execute();
  
    echo "Username is changed to ".$username;
  } catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
  
  $conn = null;

?>