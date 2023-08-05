<?php

function nlp_step4_machine_learning($step3_output){
    $arr_origins = $step3_output[0];
    $arr_stemmed = $step3_output[1];
    $bag_of_words = array();
    $tracked_bag_of_words = array();
    $tracked_origin_words = array();
    
    for($i = 0; $i < count($arr_stemmed); $i++){
        if(count($arr_origins) == count($arr_stemmed)){
            $arr_origins[$i] = explode(" ", $arr_origins[$i]);
        }
        $arr_stemmed[$i] = explode(" ", $arr_stemmed[$i]);
        for($h = 0; $h < count($arr_stemmed[$i]); $h++){
            if($arr_stemmed[$i][$h] != ""){
                array_push($bag_of_words, $arr_stemmed[$i][$h]);
                array_push($tracked_bag_of_words, $arr_stemmed[$i][$h]);
                if(count($arr_origins) == count($arr_stemmed)){
                    array_push($tracked_origin_words, $arr_origins[$i][$h]);
                }
                
            }
        }
    }

    $bag_of_words = array_values(array_unique($bag_of_words));

    // TERM FREQUENCY is an array of records. Calculating the TF in each document.
    $term_frequency_scores = array();

    // INVERSE DOCUMENT FREQUENCY is an array of records. Calculating the IDF in each document.
    $inverse_docfrequency_scores = array();
    $hold_inverse_docfrequency_scores = array();

    for($i = 0; $i < count($arr_stemmed); $i++){
        $hold_arr1 = array_count_values($arr_stemmed[$i]);
        $hold_arr2 = array();
        for($h = 0; $h < count($bag_of_words); $h++){
            if(array_key_exists($bag_of_words[$h], $hold_arr1)){
                array_push($hold_arr2, round($hold_arr1[$bag_of_words[$h]] / count($arr_stemmed[$i]), 10));
            } else {
                array_push($hold_arr2, 0);
            }
        };
        array_push($term_frequency_scores, $hold_arr2);
    }

    for($i = 0; $i < count($bag_of_words); $i++){
        array_push($hold_inverse_docfrequency_scores, 0);
    }

    for($i = 0; $i < count($arr_stemmed); $i++){
        $hold_arr1 = array_unique($arr_stemmed[$i]);
        for($h = 0; $h < count($bag_of_words); $h++){
            if(in_array($bag_of_words[$h], $hold_arr1)){
                $hold_inverse_docfrequency_scores[$h]++;
            }
        }
    }
    
    for($i = 0; $i < count($arr_stemmed); $i++){
        $hold_arr1 = array_unique($arr_stemmed[$i]);
        $hold_arr2 = array();
        for($h = 0; $h < count($bag_of_words); $h++){
            if(in_array($bag_of_words[$h], $hold_arr1)){
                array_push($hold_arr2, round(log10(count($arr_stemmed) / $hold_inverse_docfrequency_scores[$h]), 10));
            } else {
                array_push($hold_arr2, 0);
            }
        }
        array_push($inverse_docfrequency_scores, $hold_arr2);
    }

    $TF_IDF_scores = array();

    for($i = 0; $i < count($arr_stemmed); $i++){
        $hold_arr1 = $term_frequency_scores[$i];
        $hold_arr2 = $inverse_docfrequency_scores[$i];
        $hold_arr3 = array();
        for($h = 0; $h < count($bag_of_words); $h++){
            array_push($hold_arr3, round($hold_arr1[$h] * $hold_arr2[$h], 10));
        }
        array_push($TF_IDF_scores, $hold_arr3);
    }

    $tracing_origin = array();
    $tracing_stem = array();

    for($i = 0; $i < count($bag_of_words); $i++){
        if(count($arr_origins) == count($arr_stemmed)){
            array_push($tracing_origin, $tracked_origin_words[array_search($bag_of_words[$i], $tracked_bag_of_words)]);
        }
        array_push($tracing_stem, $tracked_bag_of_words[array_search($bag_of_words[$i], $tracked_bag_of_words)]);
        // echo $tracing_origin[$i]." == ".$bag_of_words[$i]."<br>"; 
    }
    // print_r($tracing_origin); echo "<br><br>";
    // print_r($TF_IDF_scores);

    return array($tracing_origin, $tracing_stem, $TF_IDF_scores, $step3_output[1]);
}


?>