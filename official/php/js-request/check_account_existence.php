<?php
session_start();

include "../mysql/db_connection.php";

$email = $_POST["email"];

try {
    $stmt = $conn->prepare("SELECT * FROM accounts WHERE email = '$email'");
    $stmt->execute();
    // set the resulting array to associative
    $result = $stmt->FetchAll(PDO::FETCH_ASSOC);
    
    if(count($result) > 0){
        echo "exist";
    } else {
        echo "none";
    }
    
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  $conn = null;

?>