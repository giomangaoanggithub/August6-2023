<?php

session_start();

ini_set('memory_limit', '8G');
ini_set('max_execution_time', '0');
$time = microtime(true);
$stemmed_context = $_POST["sc"];
// $stemmed_context = "parker decid spiderman";
// $stemmed_context = "speed";

$data = file_get_contents("../../user_tfidf_files/".$_SESSION["teacher_account"].".txt");

$original_words = "<&original_words&>";
$stemming_words = "<&stemming_words&>";
$phrases = "<&phrases&>";
$tfidf = "<&tfidf&>";
$original_words_num = strpos($data, $original_words) + strlen($original_words);
$stemming_words_num = strpos($data, $stemming_words) + strlen($stemming_words);
$phrases_num = strpos($data, $phrases) + strlen($phrases);
$tfidf_num = strpos($data, $tfidf) + strlen($tfidf);
$data1 = "";
$data2 = "";
$data3 = "";
$data4 = "";
for (
    $i= $original_words_num;
    $i< strpos($data, $stemming_words);
    $i++
) {
    $data1 .= $data[$i];
}
for ($i= $stemming_words_num; $i< strpos($data, $phrases); $i++) {
    $data2 .= $data[$i];
}
for ($i= $phrases_num; $i< strpos($data, $tfidf); $i++) {
    $data3 .= $data[$i];
}
for ($i= $tfidf_num; $i< strlen($data); $i++) {
    $data4 .= $data[$i];
}
$data1 = explode("<,>", $data1);
$data2 = explode("<,>", $data2);
$data3 = explode("<,>", $data3);
$data4 = explode("<,>", $data4);

$context_relation_scores = array(); // same length as data3.
$arr_highestscore_indexs = array(); // array of best index relations
$arr_of_bestcontexts = array();

$arr_stemmed_context = explode(" ", $stemmed_context);
$relation_highest_score = 0;
$highest_phrase_relation = "";

for ($i= 0; $i< count($data3); $i++) {
    $curr_relation_score = 0;
    for ($h= 0; $h < count($arr_stemmed_context); $h++) {
    if (str_contains($data3[$i], $arr_stemmed_context[$h]) && $arr_stemmed_context[$h] != " " && $arr_stemmed_context[$h] != "") {
        $curr_relation_score++;
    }
    }
    if ($relation_highest_score < $curr_relation_score) {
        $relation_highest_score = $curr_relation_score;
        $highest_phrase_relation = $data3[$i];
    }
    array_push($context_relation_scores, $curr_relation_score);
}

for ($i= 0; $i < count($context_relation_scores); $i++) {
    if (
    $context_relation_scores[$i] == $relation_highest_score ||
    $context_relation_scores[$i] >=
        round($relation_highest_score * 0.5)
    ) {
        array_push($arr_highestscore_indexs, $i);
        array_push($arr_of_bestcontexts, $data3[$i]);
    }
}

// alert(hold_phrase);
$xValues = array();
$getx_maxcoordinates = explode(",", $data4[0]);
$max_coord_output = 0;
$string_coordinates = "";
for ($i= 0; $i< count($getx_maxcoordinates); $i++) {
    if (str_contains($getx_maxcoordinates[$i], "0_")) {
    $converter = str_replace("0_", "", $getx_maxcoordinates[$i]);
    for ($h= 0; $h < $converter; $h++) {
        $string_coordinates .= "0,";
    }
    } else {
    $string_coordinates .= $getx_maxcoordinates[$i] . ",";
    }
}
$max_coord_output = count(explode(",",rtrim($string_coordinates, ",")));

for ($i= 0; $i < 15; $i++) {
    array_push($xValues, round(($max_coord_output / 15) * ($i+ 1)));
}

$stringify_xValues = $xValues[0];

for($i = 0; $i < count($xValues) - 1; $i++){
    $stringify_xValues .= ",".$xValues[$i];
}

$phrase_limited_coords = $arr_highestscore_indexs;

$data_phrases = $arr_of_bestcontexts;

$hold_step = 0;

$new_data_phrases = array();

$all_pos_context = array();

for ($i= 0; $i < count($data_phrases); $i++) {
    // $allow_push= round(
    // (count($data_phrases)/ 15) * $hold_step
    // );
    $hold_phrase = $data_phrases[$i];
    $hold_phrase = explode(" ", $hold_phrase);
    for($h = 0; $h < count($hold_phrase); $h++){
        for($g = 0; $g < count($data2); $g++){
            if(str_contains($hold_phrase[$h], $data2[$g])){
                $hold_phrase[$h] = str_replace($data2[$g], $data1[$g], $hold_phrase[$h]);
                $g = count($data2);
            }
        }
    }
    $hold_sentence = $hold_phrase[0];
    for($h = 0; $h < count($hold_phrase); $h++){
        $hold_sentence .= " ".$hold_phrase[$h];
    }
    $hold_phrase = $hold_sentence;
    
    if ($i < 15) {
    // $hold_step++;
    array_push($new_data_phrases, "label: '" . $hold_phrase . "',");
    } else {
        array_push($all_pos_context, "label: '" . $hold_phrase . "',");
    }
}

$data_phrases = $new_data_phrases;


$raw_graph_data = array();
for ($i = 0; $i< count($phrase_limited_coords); $i++) {
    $tfidf_reader = "";
    $raw_data = explode(",", $data4[$phrase_limited_coords[$i]]); //$data4[$phrase_limited_coords[$i] - 1]
    // alert(raw_data);
    for ($h = 0; $h < count($raw_data); $h++) {
    if (str_contains($raw_data[$h], "0_")) {
        $converter = str_replace("0_", "", $raw_data[$h]);
        for ($g = 0; $g < $converter; $g++) {
            $tfidf_reader .= "0,";
        }
    } else {
        $tfidf_reader .= $raw_data[$h].",";
    }
    }
    $tfidf_reader = rtrim($tfidf_reader, ",");
    array_push($raw_graph_data, $tfidf_reader);
}

// print_r($raw_graph_data);

$raw_graph_data_lim = count(explode(",", $raw_graph_data[0]));
$graph_summaries = array();

for ($i= 0; $i< 15; $i++) {
    array_push($graph_summaries, round(($raw_graph_data_lim / 15) * ($i+ 1)));
}

$graph_data = array();
$allow_push= 0;
for ($i= 0; $i < count($raw_graph_data); $i++) {
    if (
    round((count($raw_graph_data)/ 15) * $allow_push) == $i
    ) {
    $curr_graph_data = explode(",", $raw_graph_data[$i]);
    $curr_graph_coord = array();
    $curr_graph_num = 0;
    $curr_summary = 0;
    for ($h= 0; $h < count($curr_graph_data); $h++) {
        $curr_graph_num += (float) $curr_graph_data[$h];
        if ($h > $graph_summaries[$curr_summary] - 1) {
        // alert(h);
        array_push($curr_graph_coord, $curr_graph_num);
        $curr_summary += 1;
        $curr_graph_num = 0;
        } else if ($h + 1 == count($curr_graph_data)) {
        array_push($curr_graph_coord, $curr_graph_num);
        }
    }
    $string_coordinates = "[";
    for ($h = 0; $h < count($curr_graph_coord); $h++) {
        $string_coordinates .= $curr_graph_coord[$h] . ",";
    }
    $string_coordinates = rtrim($string_coordinates, ",");
    $string_coordinates .= "],";
    array_push($graph_data, $string_coordinates);
    $allow_push++;
    }
}

// alert(graph_data[graph_data.lengt$h- 1]);
$graph_coloration = array();
$definition_coloration = array();
for ($i= 0; $i< count($graph_data); $i++) {
    $percentage_color = (($i+ 1) / count($graph_data)) * 100;
    $curr_rgb = "";
    $def_rgb = "";
    if ($percentage_color < 34) {
    $curr_rgb =
        "borderColor: 'rgb(" .
        round(($percentage_color / 100) * 255) .
        ",0,0)',";
    $def_rgb =
        "rgb(" .
        round(($percentage_color / 100) * 255) .
        ",0,0)";
    } else if ($percentage_color < 67) {
    $curr_rgb =
        "borderColor: 'rgb(255," .
        round(($percentage_color / 100) * 255) .
        ",0)',";
    $def_rgb =
        "rgb(255," .
        round(($percentage_color / 100) * 255) .
        ",0)";
    } else {
    $curr_rgb =
        "borderColor: 'rgb(0,200," .
        round(($percentage_color / 100) * 255) .
        ")',";
    $def_rgb =
        "rgb(0,200," .
        round(($percentage_color / 100) * 255) .
        ")";
    }
    array_push($graph_coloration, $curr_rgb);
    array_push($definition_coloration, $def_rgb);
}

$stringify_data_phrases = "";
for ($i= 0; $i < count($data_phrases); $i++) {
    $hold_phrase = str_replace(
    "label: '",
    "<span style=' color: " . $definition_coloration[$i] . "'>", $data_phrases[$i]
    );
    $stringify_data_phrases .=
    "context_" .
    ($i + 1) .
    ": " .
    str_replace("',", "</span><br>", $hold_phrase);
}

for ($i= 0; $i < count($graph_data); $i++) {
    $graph_data[$i] =
    "{data: " .
    $graph_data[$i] .
    $graph_coloration[$i] .
    "fill: false, " .
    "label: 'context_" .
    ($i + 1) .
    // data_phrases[i] +
    "',},";
}

$graph_output = "";

for ($i= 0; $i< count($graph_data); $i++) {
    $graph_output .= $graph_data[$i];
}

$time = microtime(true) - $time;

$final_output = $graph_output."<,>".$stringify_data_phrases."<,>".$stringify_xValues."<,>".$time;

echo $final_output;

?>