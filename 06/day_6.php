<?php

// This list represents answers from five groups:

// The first group contains one person who answered "yes" to 3 questions: a, b, and c.
// The second group contains three people; combined, they answered "yes" to 3 questions: a, b, and c.
// The third group contains two people; combined, they answered "yes" to 3 questions: a, b, and c.
// The fourth group contains four people; combined, they answered "yes" to only 1 question, a.
// The last group contains one person who answered "yes" to only 1 question, b.
// In this example, the sum of these counts is 3 + 3 + 3 + 1 + 1 = 11.


class CustomsDeclarationTotaler
{




    public function run()
    {
        // input file
        $input_file = fopen("puzzle_inputs.txt", "r");

        $group_count = 0;
        while (($line = fgets($input_file)) !== false) {

            $line = trim($line);
            // We're at a new line which means we're at the end of a group
            if ($line === "") {
                $group_count++;
                continue;
            }


            // convert line into an array of char answers 
            $individuals_customs_answers = str_split($line);


            foreach ($individuals_customs_answers as $value) {
                $this->group_custom_answers[$group_count][$value] = 1;
            }
        }



        $yes_count = 0;
        foreach ($this->group_custom_answers as $group_answers) {
            $yes_count = $yes_count + count($group_answers);
        }
        print_r($yes_count);


        fclose($input_file);
    }
}

(new CustomsDeclarationTotaler)->run();
