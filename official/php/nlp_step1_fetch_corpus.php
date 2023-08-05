<?php

function nlp_step1_fetch_corpus($user){
    ini_set('memory_limit', '8G');
    $user_dir = '../user_files/'.$_SESSION['teacher_account'].'/';
    $arr_textfiles = array();
    $arr_textcontents = array();

    $arr_files = array_values(scandir($user_dir));
    
    unset($arr_files[0]);
    unset($arr_files[1]);
    $arr_files = array_values($arr_files);
    $arr_filetypes = array();
    $arr_filecontents = array();

    for($i = 0; $i < count($arr_files); $i++){
        $output = '';
        for($h = strlen($arr_files[$i]) - 1; $h > -1 && $arr_files[$i][$h] != '.'; $h--){
            $output = $arr_files[$i][$h].$output;
        }
        array_push($arr_filetypes, $output);
    }

    for($i = 0; $i < count($arr_filetypes); $i++){
        if ($arr_filetypes[$i] == 'txt') {
            array_push($arr_filecontents, file_get_contents($user_dir.$arr_files[$i]));
        } else if ($arr_filetypes[$i] == 'pdf') {
            $parser = new \Smalot\PdfParser\Parser(); 
            $file = $user_dir.$arr_files[$i];  
            $pdf = $parser->parseFile($file); 
            $textContent = $pdf->getText();
            array_push($arr_filecontents, $textContent);
        } else {
            $docObj = new Doc2Txt($user_dir.$arr_files[$i]);
            $txt = $docObj->convertToText();
            array_push($arr_filecontents, $txt);
        }
    }

    return $arr_filecontents;
}



?>