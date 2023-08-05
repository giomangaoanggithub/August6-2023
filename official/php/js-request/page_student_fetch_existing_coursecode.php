<?php

session_start();

include "../mysql/db_connection.php";

$course_code = $_POST["course_code"];

try {
    $stmt = $conn->prepare("SELECT * FROM `accounts` WHERE course_code = '$course_code'");
    $stmt->execute();
    $result = $stmt->FetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
    
  } catch(PDOException $e) {
    echo $stmt . "<br>" . $e->getMessage();
  }
  
  $conn = null;

?>