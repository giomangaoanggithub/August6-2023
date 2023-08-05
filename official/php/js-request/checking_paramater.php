<?php

session_start();

include '../mysql/db_connection.php';

$user = $_SESSION["teacher_account"];

try {
    $stmt = $conn->prepare("SELECT * FROM questions WHERE question_id = '31'");
    $stmt->execute();
    $result = $stmt->FetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
    
  } catch(PDOException $e) {
    echo $stmt . "<br>" . $e->getMessage();
  }
  
  $conn = null;


?>