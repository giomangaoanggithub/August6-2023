<?php

session_start();

include "foreign/list_of_stopwords.php";
include "foreign/porter2-master/demo/process.inc";
include "foreign/remove_nonsimpletext.php";
include "foreign/prevent_unwantedunicode.php";
include "foreign/Doc2Txt.php";
include "foreign/pdf_reader/vendor/autoload.php";

include "nlp_step1_fetch_corpus.php";
include "nlp_step2_text_cleaning.php";
include "nlp_step3_set_phrases.php";
include "nlp_step4_machine_learning.php";
include "nlp_step5_stringify_data.php";
include "nlp_step6_save_results.php";

// error_reporting(0);

$user_account = $_SESSION["teacher_account"];
// $question = "spiderman is my most favorite superhero of all time and it is created by stan lee";

$timer = microtime(true);
$step1 = nlp_step1_fetch_corpus($user_account);
$step2 = nlp_step2_text_cleaning($step1);
unset($step1);
$step3 = nlp_step3_set_phrases($step2);
unset($step2);
$step4 = nlp_step4_machine_learning($step3);
unset($step3);
$step5 = nlp_step5_stringify_data($step4);
unset($step4);
$step6 = nlp_step6_save_results($step5, $user_account);
$timer = microtime(true) - $timer;


// echo round($timer, 4)." seconds<br><br>";
// $memory = substr(ini_get('memory_limit'), 0, -1) * 1000000000;
// echo round((memory_get_usage()/$memory)*100,2)."%";



?>