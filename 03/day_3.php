<?php

// storing all counts in array to make print_r iteration easier
$counts = [
    'tree' => 0,
    'clear' => 0,
    'line_number' => 0,
    'x_cord' => 0,
];

// 1,1 = 82
// 3,1 = 242
// 5,1 = 71
// 7,1 = 67
// 1,2 =

// slope
$down = 1;
$right = 3;


$input_file = fopen("puzzle_inputs.txt", "r");

while (($line = fgets($input_file)) !== false) {

    // don't count line breaks
    $line = trim($line);

    // don't adjust slope for fist line = 0 
    if ($counts['line_number']) {
        $counts['x_cord'] += $right;
    }

    // Make the line long enough
    $line_repeat = 2;
    while ($counts['x_cord'] >= strlen($line)) {
        $line = str_repeat($line, $line_repeat);
        $line_repeat++;
    }

    $counts['char_we_hit'] = $line[$counts['x_cord']];

    if ($line[$counts['x_cord']] === "#") {
        $counts['tree']++;
        $line[$counts['x_cord']] = 'X';
    } else {
        $counts['clear']++;
        $line[$counts['x_cord']] = '0';
    };
    // $counts['line_with_hit'] = $line;

    $counts['line_number']++;
}
print_r($counts);



fclose($input_file);
