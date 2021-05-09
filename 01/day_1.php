<?php

$input_file = fopen("puzzle_inputs.txt", "r");


$nums = [];
while (($line = fgets($input_file)) !== false) {
    $nums[] = $line;
}

for ($i = 0; $i <= count($nums); $i++) {
    if (($i + 1)  >= count($nums)) {
        continue;
    }
    $count_two = 0;
    foreach ($nums as $num) {
        $sum = $nums[$i] + $num;
        if ($sum === 2020) {
            echo "anser is " . $nums[$i] . "and " . $num;
            echo "\n multid: " . $nums[$i] * $num;
            die;
        }
    }

    $count_two++;
    echo $sum . "\n";
}



fclose($input_file);
