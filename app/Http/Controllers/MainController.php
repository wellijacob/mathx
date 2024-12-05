<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function home(): View
    {
        return view('home');
    }

    public function generateExercises(Request $request)
    {
        // form validation
        $validated = $request->validate([
            'check_sum' => 'required_without_all:check_subtraction,check_multiplication,check_division',
            'check_subtraction' => 'required_without_all:check_sum,check_multiplication,check_division',
            'check_multiplication' => 'required_without_all:check_sum,check_subtraction,check_division',
            'check_division' => 'required_without_all:check_sum,check_subtraction,check_multiplication',
            'number_one' => 'required|integer|min:0|max:999|lt:number_two',
            'number_two' => 'required|integer|min:0|max:999',
            'number_exercises' => 'required|integer|min:5|max:50'

        ]);

        // get selected operations
        $operations = [];

        if ($request->check_sum) {
            $operations[] = 'sum';
        }

        if ($request->check_subtraction) {
            $operations[] = 'subtraction';
        }

        if ($request->check_multiplication) {
            $operations[] = 'multiplication';
        }

        if ($request->check_division) {
            $operations[] = 'division';
        }

        // get numbers (min end max)
        $min = $request->number_one;
        $max = $request->number_two;

        // get number of exercises
        $numberExercises = $request->number_exercises;

        // generation exercises
        $exercises = [];
        for ($index = 1; $index <= $numberExercises; $index++) {

            $operation = $operations[array_rand($operations)];
            $number1 = rand($min, $max);
            $number2 = rand($min, $max);

            $exercise = '';
            $solution = '';

            switch ($operation) {
                case 'sum':
                    $exercise = "$number1 + $number2 =";
                    $solution = $number1 + $number2;
                    break;

                case 'subtraction':
                    $exercise = "$number1 - $number2 =";
                    $solution = $number1 - $number2;
                    break;

                case 'multiplication':
                    $exercise = "$number1 x $number2 =";
                    $solution = $number1 * $number2;
                    break;

                case 'division':
                    // avoid division by zero
                    if ($number2 == 0) {
                        $number2 = 1;
                    }

                    $exercise = "$number1 / $number2 =";
                    $solution = $number1 / $number2;
                    break;
            }

            // if $solution is a float number, round it to 2 decimal places
            if (is_float($solution)) {
                $solution = round($solution, 2);
            }

            $exercises[] = [
                'exercise_number' => $index,
                'exercise' => $exercise,
                'solution' => "$exercise $solution"
            ];
        }

        //dd($request->all());
        dd($exercises);
    }

    public function printExercises()
    {
        echo "Imprimir exercícios";
    }

    public function exportExercises()
    {
        echo "Imprimir exercícios";
    }
}
