<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function product()
    {
        $this_month = Product::whereMonth('expire_date', date('M'))->count();
        $this_year = Product::whereYear('expire_date', date('Y'))->count();
        $next_year = Product::whereYear('expire_date', (date('Y')+1))->count();
        $total_products = Product::count();
        $products = Product::select(
            DB::raw('count(name) as count'),
            DB::raw("DATE_FORMAT(buying_date,'%m') as months"),
            DB::raw("DATE_FORMAT(buying_date,'%Y') as year"))
            ->whereYear('buying_date',  date('Y'))
            ->groupBy(DB::raw('MONTH(buying_date)'))->get()->toArray();
        
        $months = array();
        foreach($products as $product) {
            array_push($months, $product["months"]);
        }
        // dd(in_array(6, $months));
        for ($i=1; $i < 13; $i++) { 
            if (!in_array($i, $months)) {
                array_push($products, array("count"=>0, "months" => $i, "year" => date('Y')));
            }
        }
        
        usort($products, function($a, $b) {
            return $a['months'] - $b['months'];
        });

        return view('admin.report.product', compact('this_month', 'this_year', 'next_year', 'total_products', 'products'));
    }
}
