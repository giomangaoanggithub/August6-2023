<?php

function nlp_step6_save_results($step5_output, $user_file){
    $step5_output = str_replace("  ", " ", $step5_output);
    file_put_contents("../user_tfidf_files/".$user_file.".txt", $step5_output);
    echo "file saved successfully";
}

?>