<?php

session_start();

include "../mysql/db_connection.php";

$user_id = $_SESSION["student_user_id"];

try {
    $stmt = $conn->prepare("SELECT username, T1.question_id, question, T2.answer_id, answers, due_date, HPS, grades FROM (SELECT * FROM (questions LEFT JOIN connections ON questions.question_owner_id = connections.teacher_id) LEFT JOIN accounts ON connections.teacher_id = accounts.user_id WHERE connections.student_id = '$user_id') AS T1 LEFT JOIN (SELECT * FROM answers WHERE answers.answer_owner_id = '$user_id') AS T2 ON T1.question_id = T2.question_id");
    $stmt->execute();
    $result = $stmt->FetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
    
  } catch(PDOException $e) {
    echo $stmt . "<br>" . $e->getMessage();
  }
  
  $conn = null;

?>