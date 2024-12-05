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
        $operations[] = ($request->check_sum ?? null) ? 'sum' : null;
        $operations[] = ($request->check_subtraction ?? null) ? 'subtraction' : null;
        $operations[] = ($request->check_multiplication ?? null) ? 'multiplication' : null;
        $operations[] = ($request->check_division ?? null) ? 'division' : null;

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
                    $exercise = "$number1 * $number2 =";
                    $solution = $number1 * $number2;
                    break;

                case 'division':
                    $exercise = "$number1 / $number2 =";
                    $solution = $number1 / $number2;
                    break;
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
