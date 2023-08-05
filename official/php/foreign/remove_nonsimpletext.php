<?php

function nonsimpletext_remover($input){
    $output = '';
    for($i = 0; $i < strlen($input); $i++){
        if ($input[$i] == "-"){
            $i++;
        }
        if (ord($input[$i]) >= 48 && ord($input[$i]) <= 57){
            $output .= $input[$i];
        } else if (ord($input[$i]) >= 65 && ord($input[$i]) <= 90){
            $output .= $input[$i];
        } else if (ord($input[$i]) >= 97 && ord($input[$i]) <= 122){
            $output .= $input[$i];
        } else {
            $output .= ' ';
        }
    }
    return $output;
}

?>