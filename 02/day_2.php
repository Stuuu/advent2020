<?php

$valid_passwords = 0;

$input_file = fopen("puzzle_inputs.txt", "r");



while (($line = fgets($input_file)) !== false) {

    // example input
    // 7-9 l: vslmtglbc 

    // seperate text into three 
    $line_chunks = explode(" ",  $line);

    // transform input "2-6" in ['low' => 2, 'high' => 6]
    $range = getRange($line_chunks[0]);

    // get required letter
    $required_char = trim($line_chunks[1], ":");

    // raw_password
    $password = $line_chunks[2];

    $required_char_count = substr_count($password, $required_char);
    if ($required_char_count >= $range['low'] && $required_char_count <= $range['high']) {
        $valid_passwords++;
    }
}
echo "valid_password_count: " . $valid_passwords;



fclose($input_file);


function getRange($unprocessed_line)
{
    $processed_line = explode("-", $unprocessed_line);

    return [
        'low' => $processed_line[0],
        'high' => $processed_line[1],
    ];
}
