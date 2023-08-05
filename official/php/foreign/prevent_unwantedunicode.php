<?php

function unwantedunicode_remover($input){
    $examine = explode(' ',$input);
    $output = '';
    for($i = 0; $i < count($examine); $i++){
        if($examine[$i] == intval($examine[$i])){
            if($examine[$i] >= 8192 && $examine[$i] <= 8303){
                $output .= '';
            } else {
                $output .= $examine[$i].' '; 
            }
        } else {
            $output .= $examine[$i].' ';
        }
    }
    return $output;
}

?>