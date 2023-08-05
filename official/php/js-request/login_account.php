<?php

session_start();

include "../mysql/db_connection.php";

$email = $_POST["email"];
$password = md5($_POST["password"]);
$role = $_POST["role"];

try {
    $stmt = $conn->prepare("SELECT * FROM accounts WHERE email = '$email' AND password_md5 = '$password'");
    $stmt->execute();
    // set the resulting array to associative
    $result = $stmt->FetchAll(PDO::FETCH_ASSOC);
    
    if(count($result) > 0){
        if($role == "teacher"){
            $_SESSION["teacher_account"] = $email;
            $_SESSION["teacher_user_id"] = $result[0]["user_id"];
            $_SESSION["role"] = 1;
        } else {
            $_SESSION["student_account"] = $email;
            $_SESSION["student_user_id"] = $result[0]["user_id"];
            $_SESSION["role"] = 0;
        }
        
        echo "exist";
    } else {
        echo "none";
    }
    
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $conn = null;

?>