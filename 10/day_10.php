<?php

class JoltageSorter
{
    const EFFECTIVE_STARTING_JOLTAGE = 0;


    private $current_joltage;

    public function run()
    {


        // pull sequence into array
        $sequence = file('puzzle_inputs.txt', FILE_IGNORE_NEW_LINES);
        // $sequence = file('test_puzzle_inputs.txt', FILE_IGNORE_NEW_LINES);
        array_push($sequence, max($sequence) + 3);
        sort($sequence);

        $this->current_joltage = self::EFFECTIVE_STARTING_JOLTAGE;
        $jolt_diff_counts['one'] = 0;
        $jolt_diff_counts['three'] = 0;
        foreach ($sequence as $index => $incomming_joltage) {

            echo 'incomming joltage: ' . $incomming_joltage . PHP_EOL;
            echo 'differnce: ' . $incomming_joltage - $this->current_joltage . PHP_EOL;

            $jolt_diff = $incomming_joltage - $this->current_joltage;
            $this->current_joltage = $incomming_joltage;

            if ($jolt_diff === 1) {
                $jolt_diff_counts['one']++;
            }
            if ($jolt_diff === 3) {
                $jolt_diff_counts['three']++;
            }
        }
        print_r($jolt_diff_counts);
        echo '3 jolt * 1 jolt: ' . $jolt_diff_counts['one'] * $jolt_diff_counts['three'];
    }
}



(new JoltageSorter())->run();
