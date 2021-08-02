<?php



class PassportValidator
{

    private $counts = [
        'passport_fields' => [],
        'passport_count' => 0,
        'valid_passports' => 0,
    ];
    // All fields for a valid passport
    // byr (Birth Year)
    // iyr (Issue Year)
    // eyr (Expiration Year)
    // hgt (Height)
    // hcl (Hair Color)
    // ecl (Eye Color)
    // pid (Passport ID)
    // cid (Country ID) - Optional 

    // The values in this arrays contains the field (keys) 
    // that should exist for a valid passport
    private $required_fields = [
        'byr',
        'iyr',
        'eyr',
        'hgt',
        'hcl',
        'ecl',
        'pid',
    ];

    private $passport_field_keys = [];


    private function validatePassport($passport_field_keys, $required_fields, $counts)
    {
        $counts['passport_count']++;
        if ($passport_field_keys) {
            if (count(array_intersect_key(array_flip($required_fields), $passport_field_keys)) === count($required_fields)) {
                $counts['valid_passports']++;
                $counts[$counts['passport_count']]['passport_fields'] = $passport_field_keys;
                $counts[$counts['passport_count']]['valid'] = 'yes';
            } else {
                $counts[$counts['passport_count']]['passport_fields'] = $passport_field_keys;
                $counts[$counts['passport_count']]['valid'] = 'no';
            }
            // clear out passport fields
            $this->passport_field_keys = [];
        }
        return $counts;
    }



    public function run()
    {
        // input file
        $input_file = fopen("puzzle_inputs.txt", "r");

        while (($line = fgets($input_file)) !== false) {

            $line = trim($line);
            // We're at a new line which means we've got the multi line passport input
            // which means we can validate it
            if ($line === "") {
                $this->counts = $this->validatePassport(
                    $this->passport_field_keys,
                    $this->required_fields,
                    $this->counts
                );
            }

            // convert line into an array of key:value sets e.g ['key:value', 'key:value]
            $current_line_passport_fields = explode(' ', $line);

            // parse each "key:value" string into ["key" => "value"] and push it into instance array
            // so we can continue to count multiple lines
            foreach ($current_line_passport_fields as $key => $value) {
                $proccessed_field = explode(":", $value);
                $this->passport_field_keys[$proccessed_field[0]] = $proccessed_field[0];
            }
        }

        // At the end of the file run the last passports fields through the validator
        $this->counts = $this->validatePassport(
            $this->passport_field_keys,
            $this->required_fields,
            $this->counts
        );





        print_r($this->counts['valid_passports']);


        fclose($input_file);
    }
}

(new PassportValidator)->run();
