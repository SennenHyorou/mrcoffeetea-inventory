<?php

namespace App\Http\Controllers\Api;

use App\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\Expense\StoreRequest;

class ExpenseController extends Controller
{
    private function formatResponse($message = "", $data = []) {
        return array(
            "data" => $data,
            "message" => $message
        );
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = Expense::latest()->get();
        return response()->json(
            $this->formatResponse("All expenses", $expenses), 200
        );
    }

    public function today_expense()
    {
        try {
            $today = date('Y-m-d');
            $expenses = Expense::latest()->where('date', $today)->get();
            return response()->json(
                $this->formatResponse("Today's expenses", $expenses), 200
            );
        } catch (\Throwable $th) {
            return response()->json(
                $this->formatResponse("There is an error with the server"), 500
            );
        }
    }

    public function month_expense(Request $request)
    {
        try {
            $monthArr = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            $month = $request->month;
            if ($month == null)
            {
                $month = date('F');
            }
            if (in_array($month, $monthArr)) {
                $expenses = Expense::latest()->where('month', $month)->get();
                return response()->json(
                    $this->formatResponse("Monthly expenses", $expenses), 200
                );
            } else {
                return response()->json(
                    $this->formatResponse("Please insert the correct month"), 200
                );
            }
        } catch (\Throwable $th) {
            return response()->json(
                $this->formatResponse("There is an error with the server"), 500
            );
        }
    }

    public function yearly_expense(Request $request)
    {
        try {
            $year = $request->year;
            if ($year == null)
            {
                $year = date('Y');
            }
            $expenses = Expense::latest()->where('year', $year)->get();
            $years = Expense::select('year')->distinct()->take(12)->get();
            return response()->json(
                $this->formatResponse("Yearly expenses", $expenses), 200
            );
        } catch (\Throwable $th) {
            return response()->json(
                $this->formatResponse("There is an error with the server"), 500
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        try {
            $date = Carbon::now();
    
            $expense = new Expense();
            $expense->name = $request->input('name');
            $expense->amount = $request->input('amount');
            $expense->month = $date->format('F');
            $expense->year = $date->format('Y');
            $expense->date = $date->format('Y-m-d');
            if ($expense->save())
            {
                return response()->json(
                    $this->formatResponse("Expense created", $expense), 200
                );
            } else {
                return response()->json(
                    $this->formatResponse("Failed to create expense"), 500
                );
            }
        } catch (\Throwable $throw) {
            return response()->json(
                $this->formatResponse("There is an error with the server"), 500
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request, $id)
    {
        try {
            $date = Carbon::now();
    
            $expense = Expense::find($id);
            if (!$expense) return response()->json($this->formatResponse("Data not available"), 400);

            $expense->name = $request->input('name');
            $expense->amount = $request->input('amount');
            if ($expense->save())
            {
                return response()->json(
                    $this->formatResponse("Expense created", $expense), 200
                );
            } else {
                return response()->json(
                    $this->formatResponse("Failed to create expense"), 500
                );
            }
        } catch (\Throwable $throw) {
            return response()->json(
                $this->formatResponse("There is an error with the server"), 500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $expense = Expense::find($request->id);
            if (!$expense) return response()->json($this->formatResponse("Data not available"), 400);
            $expense->delete();
            
            return response()->json(
                $this->formatResponse("Expense deleted", $expense), 200
            );
        } catch (\Throwable $th) {
            return response()->json(
                $this->formatResponse("There is an error with the server"), 500
            );
        }
    }
}
