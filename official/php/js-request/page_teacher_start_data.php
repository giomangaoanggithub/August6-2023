<?php

session_start();

$user_id = $_SESSION["teacher_user_id"];

include "../mysql/db_connection.php";

try {
    $stmt = $conn->prepare("SELECT question_id, question, collected_links, time_of_issue, HPS, due_date FROM questions WHERE question_owner_id = '$user_id'");
    $stmt->execute();
    $result = $stmt->FetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
    
  } catch(PDOException $e) {
    echo $stmt . "<br>" . $e->getMessage();
  }
  
  $conn = null;

?>