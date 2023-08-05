<?php
session_start();
error_reporting(0);
$display_teacher = $_SESSION["teacher_account"];// = "Snape@gmail.come";
$display_student = $_SESSION["student_account"];
$display_teacher_id = $_SESSION["teacher_user_id"];// = "9";
$display_student_id = $_SESSION["student_user_id"];
$display_current_role = $_SESSION["role"];

echo "<&teacher_email&>".$display_teacher."<&student_email&>".$display_student."<&teacher_id&>".$display_teacher_id."<&student_id&>".$display_student_id."<&current_role&>".$display_current_role;

?>