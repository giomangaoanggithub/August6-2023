<?php

/**
 * @file
 * Demonstration file of the PHP Porter 2 English stemming algorithm.
 */

require 'process.inc';

// Some default text.
$text = 'consist
consisted
consistency
consistent
consistently
consisting
consists
consolation
consolations
consolatory
console
consoled
consoles';


echo '<pre><code>' . porterstemmer_process($text) . '</code></pre>';
  