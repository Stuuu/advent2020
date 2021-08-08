<?php

// FBFBBFFRLR
// F means "front"
// B means "back"
// L means "left"
// R means "right"

// The first 7 characters will either be F or B


// Example seat IDs 
// BFFFBBFRRR: row 70, column 7, seat ID 567.
// FFFBBBFRRR: row 14, column 7, seat ID 119.
// BBFFBBFRLL: row 102, column 4, seat ID 820.

// Start by considering the whole range, rows 0 through 127.
// F means to take the lower half, keeping rows 0 through 63.
// B means to take the upper half, keeping rows 32 through 63.
// F means to take the lower half, keeping rows 32 through 47.
// B means to take the upper half, keeping rows 40 through 47.
// B keeps rows 44 through 47.
// F keeps rows 44 through 45.
// The final F keeps the lower of the two, row 44.


class SeatParser
{
    const SEAT_ID_ROW_MULTIPLIER = 8;

    public function run()
    {



        // input file
        $input_file = fopen("puzzle_input.txt", "r");

        $seat_hash = [];
        while (($line = fgets($input_file)) !== false) {
            $boarding_pass_code = trim($line);




            $seat_keys = str_split($boarding_pass_code);

            // the aircraft will always have 128 rows starting with row 0
            $range = [
                'low' => 0,
                'high' => 127,
            ];


            $i = 0;
            foreach ($seat_keys as $key) {
                // print the current char for easier development
                $range['current_key'] = $key;
                $range_bisect = ($key === 'F' || $key === 'L') ? 'low' : 'high';


                $range_sum = $range['high'] + $range['low'];

                // Determine if we round down or up when bisecting the range
                if ($range_bisect === 'low') {
                    $mid = floor($range_sum / 2);
                } else {
                    $mid = ceil($range_sum / 2);
                }

                // replace the high or low end of the row range depending on if we want the low or high end
                if ($range_bisect === 'low') {
                    $range['high'] = $mid;
                } else {
                    $range['low'] = $mid;
                }

                $i++;
                if ($i == 7) {
                    $this->seat_row = $range['low'];

                    // reset the range for seat columns 0-7
                    $range['high'] = 7;
                    $range['low'] = 0;
                }

                if ($i == 10) {
                    $this->seat_column = $range['low'];
                    $seat_hash[$boarding_pass_code] = self::calcualteSeatID(
                        $this->seat_row,
                        $this->seat_column,
                        self::SEAT_ID_ROW_MULTIPLIER
                    );
                }
            }
        }

        echo 'seat_row: ' . $this->seat_row . PHP_EOL;
        echo 'seat_column: ' . $this->seat_column . PHP_EOL;

        print_r($seat_hash);

        echo 'max_seat_id: ' . max($seat_hash);
    }


    /**
     * Calculates a seat ID
     * example row_number * seat_multiplier + seat_column = seat_id
     * example 44 * 8 + 5 = 357
     *
     * @param integer $row_num
     * @param integer $seat_column
     * @param integer $row_multiplier
     * 
     * @return integer
     */
    private static function calcualteSeatID(
        int $row_num,
        int $seat_column,
        int $row_multiplier
    ): int {
        return $row_num * $row_multiplier + $seat_column;
    }
}

(new SeatParser)->run();
