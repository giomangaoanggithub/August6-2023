<?php

session_start();

include "foreign/list_of_stopwords.php";
include "foreign/porter2-master/demo/process.inc";
include "foreign/remove_nonsimpletext.php";
include "foreign/prevent_unwantedunicode.php";
include "foreign/Doc2Txt.php";
include "foreign/pdf_reader/vendor/autoload.php";
include "foreign/cosine_similarity.php";

include 'nlp_step2_text_cleaning.php';
include 'nlp_step4_machine_learning.php';

include 'mysql/db_connection.php';

$student = $_SESSION["student_user_id"];

$question_id = $_POST["question_id"];
$grade_grammar = $_POST["grade_grammar"];

$answer = str_replace('"', '\"',str_replace("'", "\'",$_POST["answer"]));
// $answer = "An electromagnet can be defined as a magnet which functions on electricity. Unlike a permanent magnet, the strength of an electromagnet can be changed by changing the amount of electric current that flows through it.";
// $answer = "Spider-Man is my most favourite superhero of all time because he is awesome.";
// $answer = "Spider-Man fought a villain named Electro who falls in a tank of electric eels which gives him powers of electricity, and can shoot bolts of energy coming out from the molecules of his body.";
// $answer = "ElectroMagnet VS Magnet who would win? Magnet would win because it has pizza on its house while magnet only has italian pasta.";
// $answer = "Electromagnet is a magnet that functions as a electricity. ElectroMagnet can be changed by changing the amount of electric current that flows through the Electromagnet in question.";

$check_trickery1 = array_values(array_unique(explode(" ", strtolower($answer))));
$check_trickery1_dup = array_count_values(explode(" ", strtolower($answer)));
$check_trickery1_num = count(explode(" ", strtolower($answer)));

// print_r($check_trickery1_dup);

for($i = 0; $i < count($check_trickery1); $i++){
  if(($check_trickery1_dup[$check_trickery1[$i]] / $check_trickery1_num) > 0.33){
    exit("IMPROPER ANSWER DETECTED");
  }
}

$orig_stemmed_answer = nlp_step2_text_cleaning(explode(" ", remove_stopwords($answer)));

$str_original_answer =  $orig_stemmed_answer[0][0];
$str_stemmed_answer = $orig_stemmed_answer[1][0];

for($i = 1; $i < count($orig_stemmed_answer[1]); $i++){
  $str_original_answer .= " ".$orig_stemmed_answer[0][$i];
  $str_stemmed_answer .= " ".$orig_stemmed_answer[1][$i];
}

$str_stemmed_answer = $str_stemmed_answer."<,>";
// echo $str_stemmed_answer;

$mysql;

try {
    $stmt = $conn->prepare("SELECT documents FROM questions WHERE question_id = '$question_id'");
    $stmt->execute();
  
    // set the resulting array to associative
    $mysql = $stmt->FetchAll(PDO::FETCH_ASSOC)[0]["documents"];
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
// $conn = null;

// print_r($mysql);

$arr_contexts = "";

for($i = strlen("<&contexts&>"); $i < strpos($mysql, "<&tfidf&>"); $i++){
    $arr_contexts .= $mysql[$i];
}
$str_stemmed_answer = $str_stemmed_answer.$arr_contexts;

$arr_contexts = explode("<,>", $str_stemmed_answer);

// print_r($arr_contexts);

$adaptor1 = array(array(". ."), $arr_contexts);

$TO_TS_TFIDF_stemmed = nlp_step4_machine_learning($adaptor1);

$arr_contexts = $TO_TS_TFIDF_stemmed[3];
$arr_scores = $TO_TS_TFIDF_stemmed[2];

// print_r($arr_contexts);

$highest_score = 0;
$HVS = 0;
$HVS_verdict = 0;
$averaging = array();
$averaging_verdict = 0;

for($i = 1; $i < count($arr_contexts); $i++){
  $output = cosine_sim($arr_scores[0], $arr_scores[$i]) * 1000;
  if($output > 100){
    // echo "100 =|= ".$arr_contexts[$i]."<br>";
  } else {
    // echo round($output, 2)." == ".$arr_contexts[$i]."<br>";
  }
  if(round($output, 2) < 5){
    $HVS_verdict++;
  }
  if($highest_score < $output){
    if($output > 100){
      $highest_score = 100;
    } else {
      $highest_score = $output;
    }
    
  }
  $HVS++;
}

// echo "HIGHEST SCORE: ".round($highest_score, 2)."<br>";
// echo $HVS_verdict." / ".$HVS."<br>";
$validity;
if($HVS_verdict / $HVS > 0.6){
  // echo "Invalid";
  $validity = "0";
} else {
  // echo "Valid";
  $validity = "1";
}

$grade = round($highest_score, 2)."<&,&>".$grade_grammar."<&,&>".$validity;
try {
  $sql = "INSERT INTO answers (question_id, answers, grades, answer_owner_id) VALUES ('$question_id', '$answer', '$grade', '$student')";
  // use exec() because no results are returned
  $conn->exec($sql);
  echo "Essay Submitted Successfully.";
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

$conn = null;


?>