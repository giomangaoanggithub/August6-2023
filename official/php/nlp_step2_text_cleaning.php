<?php

function nlp_step2_text_cleaning($step1_output){

    // Removing non-alphabetical symbols

    //NORMALIZATION_1 = string simplification
    //NORMALIZATION_2 = clear "non-text-symbols"
    //NORMALIZATION_3 = unicode prevention
    //NORMALIZATION_4 = string lowercasing
    //NORMALIZATION_5 = remove stopwords
    //NORMALIZATION_6 = stemming and wordtracker

    $cleansed_corpus_original = array();
    $cleansed_corpus_stemming = array();

    for($i = 0; $i < count($step1_output); $i++){

        $hold_origtext = "";
        // NORMALIZATION_1
        $hold_text = str_replace("'", "`", $step1_output[$i]);
        $hold_text = str_replace('"', '``', $hold_text);
        $hold_text = str_replace("  ", " ", $hold_text);

        // NORMALIZATION_2
        $hold_text = nonsimpletext_remover($hold_text);

        // NORMALIZATION_3
        $hold_text = unwantedunicode_remover($hold_text);

        // NORMALIZATION_4
        $hold_text = strtolower($hold_text);

        // NORMALIZATION_5
        $hold_text = remove_stopwords($hold_text);
        $hold_origtext = $hold_text;

        // NORMALIZATION_6
        $hold_text = porterstemmer_process($hold_text);

        array_push($cleansed_corpus_original, $hold_origtext);
        array_push($cleansed_corpus_stemming, $hold_text);
    }

    // print_r($cleansed_corpus_original); echo "<br><br>";
    // print_r($cleansed_corpus_stemming);

    return array($cleansed_corpus_original, $cleansed_corpus_stemming);
}

?>