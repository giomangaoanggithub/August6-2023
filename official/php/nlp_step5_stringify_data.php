<?php

function nlp_step5_stringify_data($step4_output){
    $word_original = "<&original_words&>";
    $word_stemming = "<&stemming_words&>";
    $address_phrases = "<&tfidf&>";
    $stem_phrases = "<&phrases&>";
    for($i = 0; $i < count($step4_output); $i++){
        if($i == 0){
            $word_original .= $step4_output[$i][0];
            for($h = 1; $h < count($step4_output[$i]); $h++){
                $word_original .= "<,>".$step4_output[$i][$h];
            }
        }else if($i == 1){
            $word_stemming .= $step4_output[$i][0];
            for($h = 1; $h < count($step4_output[$i]); $h++){
                $word_stemming .= "<,>".$step4_output[$i][$h];
            }
        }
    }

    for($i = 0; $i < count($step4_output[2][0]); $i++){
        $count_zeros = 0;
        if($step4_output[2][0][$i] == "0"){
            while( $i < count($step4_output[2][0]) && $step4_output[2][0][$i] == "0"){
                $count_zeros++;
                $i++;
            }
            $address_phrases .= "0_".$count_zeros.",";
        }
        if($i < count($step4_output[2][0])){
            $address_phrases .= $step4_output[2][0][$i].",";
        }
        
    }
    for($i = 1; $i < count($step4_output[2]); $i++){
        $address_phrases[strlen($address_phrases) - 1] = "<";
        $address_phrases .= ",>";
        for($h = 0; $h < count($step4_output[2][$i]); $h++){
            $count_zeros = 0;
            if($step4_output[2][$i][$h] == "0"){
                while( $h < count($step4_output[2][$i]) && $step4_output[2][$i][$h] == "0"){
                    $count_zeros++;
                    $h++;
                }
                $address_phrases .= "0_".$count_zeros.",";
            }
            if($h < count($step4_output[2][$i])){
                $address_phrases .= $step4_output[2][$i][$h].",";
            }
        }
    }

    $stem_phrases .= $step4_output[3][0];
    for($i = 1; $i < count($step4_output[3]); $i++){
        $stem_phrases .= "<,>".$step4_output[3][$i];
    }

    $final_output = substr($word_original.$word_stemming.$stem_phrases.$address_phrases, 0, -1);

    $final_output = str_replace("> ", ">", $final_output);
    $final_output = str_replace(" <", "<", $final_output);

    // echo strlen($final_output);

    // echo "array_count: ".count($step4_output[0])." | ".count($step4_output[1])." | ".count($step4_output[2])." | ".count($step4_output[3])."<br><br>";
    return $final_output;
}

?>