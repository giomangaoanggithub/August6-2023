<?php

include '../../foreign/strpos_num.php';
include '../../foreign/compare_length.php';

ini_set('memory_limit', '8G');
ini_set('max_execution_time', '0');

$time = microtime(true);

$file_content = file_get_contents("../demoman/mapping/demoman@email.com.txt");

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

$num_of_phrases = substr_count($phrases_content,"<,>") + 1;

$contexts = array();

for($i = 0; $i < 7; $i++){
    $h = strpos_num($phrases_content, "<,>", round((((((100 / 7) * $i) + ((100 / 7) * ($i + 1))) / 2) / 100) * $num_of_phrases)) + strlen("<,>");
    $end_str = strpos_num($phrases_content, "<,>", round((((((100 / 7) * $i) + ((100 / 7) * ($i + 1))) / 2) / 100) * $num_of_phrases) + 1);
    $hold_str = "";
    while($h < $end_str){
        $hold_str .= $phrases_content[$h];
        $h++;
    };
    array_push($contexts, $hold_str);
}

$str_contexts = $contexts[0];

for($i = 1; $i < 7; $i++){
    $str_contexts .= "<,>".$contexts[$i];
}

$original_words_content = explode("<,>", $original_words_content);
$stemming_words_content = explode("<,>", $stemming_words_content);

for($i = count($stemming_words_content) - 1; $i >= 0 ; $i--){
    if($stemming_words_content[$i] != "" && $stemming_words_content[$i] != " " && str_contains($str_contexts, $stemming_words_content[$i]." ")){
        $str_contexts = str_replace($stemming_words_content[$i]." ", $original_words_content[$i]." ", $str_contexts);
    } else if ($stemming_words_content[$i] != "" && $stemming_words_content[$i] != " " && str_contains($str_contexts, $stemming_words_content[$i]."<")){
        $str_contexts = str_replace($stemming_words_content[$i]."<", $original_words_content[$i]."<", $str_contexts);
    }
}

$str_contexts = str_replace("> ", ">", $str_contexts);

$time = microtime(true) - $time;

$output = $time."<&time&>".$num_of_phrases."<&num_phrases&>".$str_contexts."<&phrases&>";

echo $output;

?>