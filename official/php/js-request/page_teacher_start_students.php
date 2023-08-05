<?php

session_start();

include "../mysql/db_connection.php";

$user_id = $_SESSION["teacher_user_id"];

try {
    $stmt = $conn->prepare("SELECT connection_id, username, email FROM connections LEFT JOIN accounts ON connections.student_id = accounts.user_id WHERE teacher_id = '$user_id'");
    $stmt->execute();
    $result = $stmt->FetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
    
  } catch(PDOException $e) {
    echo $stmt . "<br>" . $e->getMessage();
  }
  
  $conn = null;

?>