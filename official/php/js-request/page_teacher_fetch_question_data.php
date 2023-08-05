<?php

session_start();

$question_id = $_POST["question_id"];
$user_id = $_SESSION["teacher_user_id"];
include "../mysql/db_connection.php";

try {
    $stmt = $conn->prepare("SELECT * FROM (answers LEFT JOIN questions ON answers.question_id = questions.question_id) LEFT JOIN accounts ON answers.answer_owner_id = accounts.user_id WHERE questions.question_owner_id = '$user_id' AND answers.question_id = '$question_id'");
    $stmt->execute();
    $result = $stmt->FetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
    
  } catch(PDOException $e) {
    echo $stmt . "<br>" . $e->getMessage();
  }
  
  $conn = null;