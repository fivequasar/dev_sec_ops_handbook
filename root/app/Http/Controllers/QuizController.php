<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;


class QuizController extends Controller
{
    public function xss_quiz_checker(Request $request) {

        $q1 = $request->input('q1'); 
        $q2 = $request->input('q2'); 
        $q3 = $request->input('q3'); 
        $q4 = $request->input('q4'); 
        $q5 = $request->input('q5'); 

        $sum = 0;

        foreach ($q2 as $n) {

            $sum += $n;

          }

        if ($sum == 2){
            $q2 = 1;
        } else {
            $q2 = 0;
        }

        $total_marks = $q1 + $q2 + $q3 + $q4 + $q5;

        if ($total_marks >= 3){

            $id = Auth::user()->id;
            DB::update('update users set xss = ? where id = ?', ['1', $id]);
            return redirect(route('xss_quiz'))->with('status', 'Completed! Marked as Done!'); 

        } else {
            echo "You Failed!";
            return redirect(route('xss_quiz'))->with('status', 'Try Again');
        }
    }

    public function xss_quiz_out_checker(Request $request){

        $q1 = $request->input('q1'); 
        $q2 = $request->input('q2'); 
        $q3 = $request->input('q3'); 
        $q4 = $request->input('q4'); 
        $q5 = $request->input('q5'); 

        $sum = 0;

        foreach ($q2 as $n) {

            $sum += $n;

          }

        if ($sum == 2){
            $q2 = 1;
        } else {
            $q2 = 0;
        }

        $total_marks = $q1 + $q2 + $q3 + $q4 + $q5;

        if ($total_marks >= 3){

            return redirect(route('xss_quiz_out'))->with('status', 'Completed! Marked as Done!'); 

        } else {
            echo "You Failed!";
            return redirect(route('xss_quiz_out'))->with('status', 'Try Again');
        }

    }

    public function sql_quiz_checker(Request $request) {

        $q1 = $request->input('q1'); 
        $q2 = $request->input('q2');      
        $q3 = $request->input('q3'); 
        $q4 = $request->input('q4'); 
        $q5 = $request->input('q5'); 

        $sum = 0;

        foreach ($q2 as $n) {

            $sum += $n;

          }

        if ($sum == 2){
            $q2 = 1;
        } else {
            $q2 = 0;
        }

        $total_marks = $q1 + $q2 + $q3 + $q4 + $q5;

        if ($total_marks >= 3){

            $id = Auth::user()->id;
            DB::update('update users set sqli = ? where id = ?', ['1', $id]);
            return redirect(route('sql_quiz'))->with('status', 'Completed! Marked as Done!'); 

        } else {
            echo "You Failed!";
            return redirect(route('sql_quiz'))->with('status', 'Try Again');
        }
    }

    public function sql_quiz_out_checker(Request $request){

        $q1 = $request->input('q1'); 
        $q2 = $request->input('q2');      
        $q3 = $request->input('q3'); 
        $q4 = $request->input('q4'); 
        $q5 = $request->input('q5'); 

        $sum = 0;

        foreach ($q2 as $n) {

            $sum += $n;

          }

        if ($sum == 2){
            $q2 = 1;
        } else {
            $q2 = 0;
        }

        $total_marks = $q1 + $q2 + $q3 + $q4 + $q5;

        if ($total_marks >= 3){

            return redirect(route('sqli_quiz_out'))->with('status', 'Completed! Marked as Done!'); 

        } else {
            echo "You Failed!";
            return redirect(route('sqli_quiz_out'))->with('status', 'Try Again');
        }

    }
}
