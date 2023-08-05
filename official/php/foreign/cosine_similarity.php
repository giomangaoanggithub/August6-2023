<?php

function cosine_sim($input1, $input2){
    $hold1 = array();
    for($x = 0; $x < count($input1); $x++){
        array_push($hold1, $input1[$x] * $input2[$x]);
    }
    $numerator = 0;
    $deno1 = 0;
    $deno2 = 0;
    for($x = 0; $x < count($hold1); $x++){
        $numerator += $hold1[$x];
        $deno1 += $input1[$x] * $input1[$x];
        $deno2 += $input2[$x] * $input2[$x];
    }
    return $numerator / (sqrt($deno1) * sqrt($deno2));
}

?>