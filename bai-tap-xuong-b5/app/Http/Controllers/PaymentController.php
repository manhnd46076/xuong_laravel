<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function starttransaction()
    {

        session(['step' => 1]);

        return view('payments.start');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function storeTransaction(Request $request)
    {
        $transaction = [
            'amount' => $request->input('amount'),
            'receiver_account' => $request->input('account'),
            'transaction_id' => uniqid(),
            'status' => 'pending'
        ];
        session(['transaction' => $transaction]);
        // 
        session(['step' => 2]);

        return redirect()->route('payments.confirm');
    }

    /**
     * Display the specified resource.
     */
    public function confirmTransaction()
    {
        if (session('step') != 2) {
            return redirect()->route('payments.start');
        }

        $transaction = session('transaction');
        return view('payments.confirm', compact('transaction'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function processTransaction(Request $request)
    {
        if (session('step') != 2) {
            return redirect()->route('payments.start');
        }

        $otp = $request->input('otp');

        $transaction = session('transaction');





        // dd(session('transaction'));
        DB::table('transactions')->insert([
            'transaction_id' => $transaction['transaction_id'],
            'amount' => $transaction['amount'],
            'receiver_account' => $transaction['receiver_account'],
            'status' => 'success'

        ]);
        session(['transaction_id' => $transaction['transaction_id']]);
        // xóa khi thêm thành công vào database
        session()->forget('transaction');
        // chuyển step
        session(['step' => 3]);

        return redirect()->route('payments.complete');


    }

    public function completeTransaction()
    {
        if (session('step' != 3)) {
            return redirect()->route('payments.start');
        }

        $transactionId = session('transaction_id');
        // dd($transactionId);

        $transaction = DB::table('transactions')
            ->where('transaction_id', $transactionId)
            ->first();
        // dd($transaction);
        return view('payments.complete', compact('transaction'));
    }

    public function cancelTransaction()
    {
        // Xóa
        session()->forget('transaction');
        session()->forget('step');

        return redirect()->route('payments.start')->with('alert', 'Đã hủy giao dịch');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
