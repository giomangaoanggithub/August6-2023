<?php

session_start();

$time = microtime(true);

ini_set('memory_limit', '8G');
ini_set('max_execution_time', '0');

include 'nlp_step2_text_cleaning.php';
include 'foreign/remove_nonsimpletext.php';
include 'foreign/prevent_unwantedunicode.php';
include 'foreign/list_of_stopwords.php';
include 'foreign/porter2-master/demo/process.inc';
include 'mysql/db_connection.php';

$user_account = $_POST["demo_user"];
$question = $_POST["demo_question"];

$question = array($question);

// print_r($question);

$file_content =  file_get_contents("../user_tfidf_files/$user_account@email.com.txt");

// echo "working";

// exit(" well");

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

for($i = strpos($file_content, $stemming_words) + strlen($stemming_words); $i < strpos($file_content, $phrases); $i++){
    $stemming_words_content .= $file_content[$i];
}

for($i = strpos($file_content, $phrases) + strlen($phrases); $i < strpos($file_content, $tfidf); $i++){
    $phrases_content .= $file_content[$i];
}

for($i = strpos($file_content, $tfidf) + strlen($tfidf); $i < strlen($file_content); $i++){
    $tfidf_content .= $file_content[$i];
}

// echo $original_words_content;
// echo $stemming_words_content;
// echo $phrases_content;
// echo $tfidf_content;

$stemmed_question = array_values(array_filter(array_unique(explode(" ", nlp_step2_text_cleaning($question)[1][0]))));

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


$arr_passed_indexes = array_values(array_filter(array_unique($arr_passed_indexes)));
$arr_passed_tfidf = array();

for($i = 0; $i < count($arr_passed_indexes); $i++){
    array_push($arr_passed_context, $phrases_content[$arr_passed_indexes[$i]]);
    array_push($arr_passed_tfidf, $tfidf_content[$arr_passed_indexes[$i]]);
}

// print_r($arr_passed_context); echo "<br><br>";
// print_r($arr_passed_indexes);

$stringify_contexts = "";
$stringify_tfidf = "";
if(count($arr_passed_context) > 0){
    $stringify_contexts = $arr_passed_context[0];
    $stringify_tfidf = $arr_passed_tfidf[0];
} else {
    $time = microtime(true) - $time;
    echo "<&contexts&>".$stringify_contexts."<&tfidf&>".$stringify_tfidf."<&time&>".$time;
    exit();
}


for($i = 1; $i < count($arr_passed_context); $i++){
    $stringify_contexts .= "<,>".$arr_passed_context[$i];
    $stringify_tfidf .= "<,>".$arr_passed_tfidf[$i];
}
// echo $stringify_contexts;
// echo $stringify_tfidf;

$time = microtime(true) - $time;

$final_output = "<&contexts&>".$stringify_contexts."<&tfidf&>".$stringify_tfidf."<&time&>".$time;

echo $final_output;


?>