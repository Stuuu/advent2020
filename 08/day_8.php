<?php

// acc increases or decreases a single global value called the accumulator by the value given in the argument. For example, acc +7 would increase the accumulator by 7. The accumulator starts at 0. After an acc instruction, the instruction immediately below it is executed next.
// jmp jumps to a new instruction relative to itself. The next instruction to execute is found using the argument as an offset from the jmp instruction; for example, jmp +2 would skip the next instruction, jmp +1 would continue to the instruction immediately below it, and jmp -20 would cause the instruction 20 lines above to be executed next.
// nop stands for No OPeration - it does nothing. The instruction immediately below it is executed next.


class BugLoopDebugger
{

    const NO_OPERATION = 'nop';
    const JUMP_OPERATION = 'jmp';
    const ACCUMULATOR_OPERATION = 'acc';

    const INCRMEANT_SYMBOL = '+';
    const DECREMEANT_SYMBOL = '-';

    private $global_value = 0;

    private $loop_detected = false;

    private $current_instruction = 0;

    private $instruction_log = [];

    public function run()
    {
        // put all operations into an array
        $all_operations = file('puzzle_inputs.txt', FILE_IGNORE_NEW_LINES);

        do {
            print_r(
                [
                    'op' => $this->current_operation,
                    'acc' => $this->current_instruction,
                    'global_value' => $this->global_value,
                ]
            );
            $this->doInstruction($all_operations[$this->current_instruction]);
        } while ($this->loop_detected === false);

        echo 'Loop detected' . PHP_EOL;
        exit;
    }

    private function doInstruction($current_instruction)
    {
        // Check if we are re-running an opt
        if (array_key_exists($this->current_instruction, $this->instruction_log)) {
            $this->loop_detected = true;
            return;
        }

        $this->instruction_log[$this->current_instruction] = true;

        $this->parseOpt($current_instruction);
        $this->parseArgument($current_instruction);
        $this->parseIncrement($current_instruction);


        if ($this->current_operation === self::NO_OPERATION) {
            // Do nothing for no ops
            $this->current_instruction++;
            return;
        };

        if ($this->current_operation === self::ACCUMULATOR_OPERATION) {
            // Increase global value if +
            if ($this->current_arg === self::INCRMEANT_SYMBOL) {
                $this->global_value += $this->current_incremeant;
            } else {
                $this->global_value -= $this->current_incremeant;
            }
            $this->current_instruction++;
            return;
        }

        // If we're here this is a jump opt
        if ($this->current_arg === self::INCRMEANT_SYMBOL) {
            $this->current_instruction = ($this->current_instruction + $this->current_incremeant);
        } else {
            $this->current_instruction = ($this->current_instruction - $this->current_incremeant);
        }
        return;
    }

    private function parseOpt($line)
    {
        $instruction = explode(" ", $line)[0];

        switch ($instruction) {
            case self::NO_OPERATION:
            case self::ACCUMULATOR_OPERATION:
            case self::JUMP_OPERATION:
                break;
            default:
                throw new Exception(('Operation not recognized'));
                break;
        }

        $this->setOpteration($instruction);
    }

    private function parseArgument($line)
    {
        $argument =  explode(" ", $line)[1];

        // get the first char of the string e.g. +/-
        $argument = $argument[0];

        switch ($argument) {
            case self::DECREMEANT_SYMBOL:
            case self::INCRMEANT_SYMBOL:
                break;
            default:
                throw new Exception("argument is not one of (+, -)");
                break;
        }

        $this->setArgument($argument);
    }

    private function parseIncrement($line)
    {
        $increment_with_arithmatic =  explode(" ", $line)[1];

        // remove the first char of the string e.g. +/-
        $increment = substr($increment_with_arithmatic, 1);

        $this->setIncrement($increment);
    }

    private function setIncrement(int $increment)
    {
        $this->current_incremeant = $increment;
    }

    private function setOpteration($operation)
    {
        $this->current_operation = $operation;
    }

    private function setArgument($argument)
    {
        $this->current_arg = $argument;
    }
}


(new BugLoopDebugger())->run();
