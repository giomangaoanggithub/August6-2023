<?php

function nlp_step3_set_phrases($step2_output){
    $arr_original_phrases = array();
    $arr_stemming_phrases = array();
    $arr_windows = array(10,15);
    for($i = 0; $i < count($step2_output); $i++){
        for($h = 0; $h < count($step2_output[$i]); $h++){
            $curr_text = $step2_output[$i][$h];
            for($g = 0; $g< count($arr_windows); $g++){
                $window_size = $arr_windows[$g];
                for($x = 0; $x < strlen($curr_text); $x++){
                    $hold_phrase = "";
                    $window_limiter = 0;
                    for($y = $x; $y < strlen($curr_text) && $window_limiter < $window_size; $y++){
                        $hold_phrase .= $curr_text[$y];
                        if($curr_text[$y] == " "){
                            $window_limiter++;
                        }
                    }
                    if($window_limiter == $window_size && $i == 0){
                        array_push($arr_original_phrases, $hold_phrase);
                    } else if($window_limiter == $window_size && $i == 1){
                        array_push($arr_stemming_phrases, $hold_phrase);
                    }
                    $x = strpos($curr_text, " ", $x);
                }
            }
        }
    }
    return array($arr_original_phrases, $arr_stemming_phrases);
}

?>