<?php

session_start();

include "../mysql/db_connection.php";

error_reporting(0);

$username = "account_".md5($_POST["email"]);
$email = $_POST["email"];
$password = md5($_POST["password"]);
$role = $_POST["role"];
$course_code = md5(md5($email));

try {
    $sql = "INSERT INTO accounts (username, email, password_md5, course_code)
    VALUES ('$username', '$email', '$password', '$course_code')";
    // use exec() because no results are returned
    $conn->exec($sql);
    mkdir("../../user_files/$email");

    $stmt = $conn->prepare("SELECT * FROM accounts WHERE email = '$email' AND password_md5 = '$password'");
    $stmt->execute();
    $result = $stmt->FetchAll(PDO::FETCH_ASSOC);

    if($role == "teacher"){
        $_SESSION["teacher_account"] = $email;
        $_SESSION["teacher_user_id"] = $result[0]["user_id"];
        $_SESSION["role"] = 1;
    } else {
        $_SESSION["student_account"] = $email;
        $_SESSION["student_user_id"] = $result[0]["user_id"];
        $_SESSION["role"] = 0;
    }
    
    echo "New account created successfully";
  } catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
  
  $conn = null;

?>