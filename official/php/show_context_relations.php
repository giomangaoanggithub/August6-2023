<?php

include 'nlp_step2_text_cleaning.php';
include 'foreign/remove_nonsimpletext.php';
include 'foreign/prevent_unwantedunicode.php';
include 'foreign/list_of_stopwords.php';
include 'foreign/porter2-master/demo/process.inc';

$question = array($_POST["question"]);

// $question = array("spider-man is my most favorite superhero of all time and it is created by stan lee");

$output1 = nlp_step2_text_cleaning($question);

$sub1_output1 = $output1[1][0];

echo $sub1_output1;

?>