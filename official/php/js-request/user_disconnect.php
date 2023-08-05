<?php

session_start();

include "../mysql/db_connection.php";

$connection_id = $_POST["connection_id"];
$connection = $_POST["connection_name"];

try {
    // sql to delete a record
    $sql = "DELETE FROM connections WHERE connection_id='$connection_id'";
  
    // use exec() because no results are returned
    $conn->exec($sql);

    
    echo "You Disconnected ".$connection;
  } catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
  
  $conn = null;

?>