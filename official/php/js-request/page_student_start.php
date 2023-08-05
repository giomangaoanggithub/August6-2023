<?php

session_start();

$email = $_SESSION["student_account"];

include "../mysql/db_connection.php";

try {
    $stmt = $conn->prepare("SELECT username, user_id FROM accounts WHERE email = '$email'");
    $stmt->execute();
    $result = $stmt->FetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
    
  } catch(PDOException $e) {
    echo $stmt . "<br>" . $e->getMessage();
  }
  
  $conn = null;



?>