<?php

session_start();

$_SESSION["loading_percentage"] = "1%";

$time = microtime(true);

ini_set('memory_limit', '8G');
ini_set('max_execution_time', '0');

include 'nlp_step2_text_cleaning.php';
include 'foreign/remove_nonsimpletext.php';
include 'foreign/prevent_unwantedunicode.php';
include 'foreign/list_of_stopwords.php';
include 'foreign/porter2-master/demo/process.inc';
include 'mysql/db_connection.php';

$user_account = $_SESSION["teacher_account"];
$user_id = $_SESSION["teacher_user_id"];
$question = array($_POST["question"]);
$user_grade = $_POST["hps"];
$user_due_date = $_POST["due"];

// $question = array("What is electromagnet?");
// $user_grade = "6868";
// $user_due_date = "2023-07-14 15:30:41";

$file_content =  file_get_contents("../user_tfidf_files/$user_account.txt");

// echo $file_content;

$original_words = "<&original_words&>";
$stemming_words = "<&stemming_words&>";
$phrases = "<&phrases&>";
$tfidf = "<&tfidf&>";

$original_words_content = "";
$stemming_words_content = "";
$phrases_content = "";
$tfidf_content = "";

for($i = strlen($original_words); $i < strpos($file_content, $stemming_words); $i++){
    $original_words_content .= $file_content[$i];
}
$_SESSION["loading_percentage"] = "10%";
for($i = strpos($file_content, $stemming_words) + strlen($stemming_words); $i < strpos($file_content, $phrases); $i++){
    $stemming_words_content .= $file_content[$i];
}
$_SESSION["loading_percentage"] = "15%";
for($i = strpos($file_content, $phrases) + strlen($phrases); $i < strpos($file_content, $tfidf); $i++){
    $phrases_content .= $file_content[$i];
}
$_SESSION["loading_percentage"] = "20%";
for($i = strpos($file_content, $tfidf) + strlen($tfidf); $i < strlen($file_content); $i++){
    $tfidf_content .= $file_content[$i];
}
$_SESSION["loading_percentage"] = "25%";

// echo $original_words_content;
// echo $stemming_words_content;
// echo $phrases_content;
// echo $tfidf_content;

$stemmed_question = array_values(array_filter(array_unique(explode(" ", nlp_step2_text_cleaning($question)[1][0]))));
$_SESSION["loading_percentage"] = "30%";
// print_r($stemmed_question);

$phrases_content = explode("<,>", $phrases_content);
$tfidf_content = explode("<,>", $tfidf_content);

// print_r($phrases_content);

$arr_phrase_score = array();
$highest_score = 0;

for($i = 0; $i < count($phrases_content); $i++){
    $phrase_score = 0;
    for($h = 0; $h < count($stemmed_question); $h++){
        if(str_contains($phrases_content[$i], $stemmed_question[$h])){
            $phrase_score++;
        }
    }
    array_push($arr_phrase_score, $phrase_score);
    if($highest_score < $phrase_score){
        $highest_score = $phrase_score;
    }
}
$_SESSION["loading_percentage"] = "35%";
// echo "Highest Score: ".$highest_score."<br><br>";
// print_r($arr_phrase_score);

$arr_passed_context = array();
$arr_passed_indexes = array();

for($i = 0; $i < count($arr_phrase_score); $i++){
    if($arr_phrase_score[$i] > $highest_score * 0.5){
        array_push($arr_passed_indexes, $i);
        for($h = 1; $h < count($arr_phrase_score) && $h < 3 && $h * -1 + $i > -1; $h++){
            array_push($arr_passed_indexes, $i + $h);
            array_push($arr_passed_indexes, $i - $h);
        }
    }
}
$_SESSION["loading_percentage"] = "55%";

$arr_passed_indexes = array_values(array_filter(array_unique($arr_passed_indexes)));
$arr_passed_tfidf = array();

for($i = 0; $i < count($arr_passed_indexes); $i++){
    array_push($arr_passed_context, $phrases_content[$arr_passed_indexes[$i]]);
    array_push($arr_passed_tfidf, $tfidf_content[$arr_passed_indexes[$i]]);
}
$_SESSION["loading_percentage"] = "75%";
// print_r($arr_passed_context); echo "<br><br>";
// print_r($arr_passed_indexes);

$stringify_contexts = $arr_passed_context[0];
$stringify_tfidf = $arr_passed_tfidf[0];

for($i = 1; $i < count($arr_passed_context); $i++){
    $stringify_contexts .= "<,>".$arr_passed_context[$i];
    $stringify_tfidf .= "<,>".$arr_passed_tfidf[$i];
}
$_SESSION["loading_percentage"] = "95%";
// echo $stringify_contexts;
// echo $stringify_tfidf;

$final_output = "<&contexts&>".$stringify_contexts."<&tfidf&>".$stringify_tfidf;

echo $final_output;

$time = microtime(true) - $time;

echo "<br><br>".$time;

try {
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "INSERT INTO questions (question, collected_links, documents, HPS, due_date, question_owner_id)
  VALUES ('".$question[0]."', '', '$final_output',  '$user_grade', '$user_due_date', '$user_id')";
  // use exec() because no results are returned
  $conn->exec($sql);
  echo "New record created successfully";
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

$conn = null;

$_SESSION["loading_percentage"] = "100%";


?>