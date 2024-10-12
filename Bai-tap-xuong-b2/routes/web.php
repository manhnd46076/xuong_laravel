<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});

Route::get('/cau1', function () {
    $cau1 = DB::table('sales')
        ->selectRaw('SUM(total) AS total_sales, MONTH(sale_date) AS month,
        YEAR(sale_date) AS year')
        ->groupByRaw('MONTH(sale_date),YEAR(sale_date)')
        ->get();
    dd($cau1->toArray());
    return view('welcome');
});
Route::get('/cau2', function () {
    $cau2 = DB::table('expenses')
        ->selectRaw('SUM(amount) AS total_expenses, MONTH(expense_date) AS month,
        YEAR(expense_date) AS year')
        ->groupByRaw('MONTH(expense_date),YEAR(expense_date)')
        ->get();
    dd($cau2->toArray());
    return view('welcome');
});
Route::get('/cau3', function () {

    $totalSales = DB::table('sales') // TỔng doanh thu 
        ->whereMonth('sale_date', 9)
        ->whereYear('sale_date', 2024)
        ->sum('total');
    // dd($totalSales);
    $totalExpenses = DB::table('expenses') //Tổng chi phí 
        ->whereMonth('expense_date', 9)
        ->whereYear('expense_date', 2024)
        ->sum('amount');

    $profitBeforeTax = $totalSales - $totalExpenses; // Lợi nhuận trước thuế = tổng doanh thu - tổng chi phí

    $taxRate = DB::table('taxes')->where('tax_name', 'VAT')->value('rate'); // giá trị thuế VAT
    $taxAmount = ($totalSales * $taxRate / 100); // tính thuế theo lợi nhuận trước thuế

    $profitAfterTax = $profitBeforeTax - $taxAmount; // lợi nhuận sau thuế = lợi nhuận trươc thuế - tiền thuế 

    DB::table('financial_reports')->insert([
        'month' => 9,
        'year' => 2024,
        'total_sales' => $totalSales,
        'total_expenses' => $totalExpenses,
        'profit_before_tax' => $profitBeforeTax,
        'tax_amount' => $taxAmount,
        'profit_after_tax' => $profitAfterTax,
        'created_at' => now(),
        'updated_at' => now()
    ]);


    return view('welcome');
});


