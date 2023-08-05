<?php

session_start();

include "../mysql/db_connection.php";

$teacher_id = $_POST["teacher_id"];
$student_id = $_SESSION["student_user_id"];

try {
    $sql = "INSERT INTO connections (teacher_id, student_id)
    VALUES ('$teacher_id', '$student_id')";
    // use exec() because no results are returned
    $conn->exec($sql);
    
    echo "CONNECTION SAVED";
  } catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
  
  $conn = null;

?>