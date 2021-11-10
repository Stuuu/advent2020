<?php

class XMASValidator
{
    const PREAMBLE_LENGTH = 25;

    private $offset = 0;

    public function run()
    {
        // pull sequence into array
        $sequence = file('puzzle_inputs.txt', FILE_IGNORE_NEW_LINES);

        foreach ($sequence as $index => $number_to_validate) {

            if (!($index >= self::PREAMBLE_LENGTH)) {
                continue;
            }

            $sequence_chunk = array_slice(
                $sequence,
                $this->offset,
                self::PREAMBLE_LENGTH
            );
            $this->offset++;

            $is_valid = false;
            foreach ($sequence_chunk as $chunk_a_k => $chunk_a_v) {
                foreach ($sequence_chunk as $chunk_b_k => $chunk_b_v) {

                    // numbs being summed cant be identical
                    if ($chunk_a_v === $chunk_b_v) {
                        continue;
                    }

                    if (($chunk_a_v + $chunk_b_v) == $number_to_validate) {
                        $is_valid = true;
                    }
                }
            }
            if (!$is_valid) {
                echo "invalid number: {$number_to_validate}" . PHP_EOL;
                exit;
            }
        }
    }
}



(new XMASValidator())->run();
