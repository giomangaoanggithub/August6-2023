<?php

session_start();

include "../mysql/db_connection.php";

error_reporting(0);

$question_id = $_POST["question_id"];
$answer = str_replace('"', '\"',str_replace("'", "\'",$_POST["answer"]));
$grade = $_POST["grade"];
$user_id = $_SESSION["student_user_id"];

try {
    $sql = "INSERT INTO answers (question_id, answers, grades, answer_owner_id)
    VALUES ('$question_id', '$answer', '$grade', '$user_id')";
    // use exec() because no results are returned
    $conn->exec($sql);
    
    echo "Answer SAVED";
  } catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
  
  $conn = null;

?>