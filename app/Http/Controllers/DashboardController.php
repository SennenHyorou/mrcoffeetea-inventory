<?php

namespace App\Http\Controllers;

use App\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today_date = date('Y-m-d');
        $month_date = date('m');
        $year_date = date('Y');

        $today_expenses = Expense::whereDate('created_at', $today_date)->get();
        $yesterday_expenses = Expense::whereDate('created_at', date('Y-m-d', strtotime('-1 day')))->get();

        $month_expenses = Expense::whereMonth('created_at', $month_date)->get();
        $previous_month_expenses = Expense::whereMonth('created_at', date('m', strtotime('-1 month')))->get();

        $year_expenses = Expense::whereYear('created_at', $year_date)->get();
        $previous_year_expenses = Expense::whereYear('created_at', date('Y', strtotime('-1 year')))->get();

        $expenses = Expense::all();

        $current_expenses = Expense::select(
            DB::raw('sum(amount) as sums'),
            DB::raw("DATE_FORMAT(created_at,'%m') as months"),
            DB::raw("DATE_FORMAT(created_at,'%Y') as year"))
            ->whereYear('created_at',  date('Y'))
            ->groupBy('months')->get()->toArray();
        
        $months = array();
        foreach($current_expenses as $expense) {
            array_push($months, $expense["months"]);
        }
        // dd(in_array(6, $months));
        for ($i=1; $i < 13; $i++) { 
            if (!in_array($i, $months)) {
                array_push($current_expenses, array("sums"=>0, "months" => $i, "year" => date('Y')));
            }
        }
        
        usort($current_expenses, function($a, $b) {
            return $a['months'] - $b['months'];
        });

        return view('admin.dashboard', compact('today_expenses', 'yesterday_expenses', 'month_expenses', 'previous_month_expenses', 'year_expenses', 'previous_year_expenses', 'expenses', 'current_expenses'));
    }
}
