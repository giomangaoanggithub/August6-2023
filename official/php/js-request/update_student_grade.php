<?php

include '../mysql/db_connection.php';

$answer_id = $_POST["answer_id"];
$grade = $_POST["grade"];

try {
    $sql = "UPDATE answers SET grades = '$grade' WHERE answer_id=$answer_id";
  
    // Prepare statement
    $stmt = $conn->prepare($sql);
  
    // execute the query
    $stmt->execute();
  
    // echo a message to say the UPDATE succeeded
    echo "essay grade UPDATED successfully";
  } catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
  
  $conn = null;
?>