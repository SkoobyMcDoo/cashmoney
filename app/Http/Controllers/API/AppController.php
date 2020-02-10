<?php

namespace App\Http\Controllers\API;

use App\Transaction;
use App\Vendor;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class AppController extends BaseController
{
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('CashMoneyApp')-> accessToken;
            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'User login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }

    public function createTransaction(Request $request) {
        $vendor = Vendor::where('name', $request->vendor)->first();
        if($vendor == null) {
            $vendor = new Vendor();
            $vendor->name = $request->vendor;
            $vendor->save();
        }
        $transaction = new Transaction();
        $transaction->amount = $request->amount;
        $transaction->vendor_id = $vendor->id;
        $transaction->save();
        return response()->json(["message" => $transaction]);
    }

    public function getVendors() {
        return response()->json(Vendor::all(["name"]));
    }

    private function getTransactionsInRange($from, $to) {
        $start     = date('Y-m-d', strtotime($from));
        $end       = date('Y-m-d', strtotime($to));
        $transactions = Transaction::whereBetween('created_at', [$start . " 00:00:00", $end . " 23:59:59"])->get();
        return $transactions;
    }

    public function getTransactions(Request $request) {
        $transactions = $this->getTransactionsInRange($request->from, $request->to);

        $formatted = [];
        foreach ($transactions as $transaction) {
            $vendor = Vendor::where('id', $transaction->vendor_id)->first();
            $sale_date = date('Y-m-d', strtotime($transaction->created_at));
            $formatted[] = "R" . $transaction->amount . " at " . $vendor->name . " on " . $sale_date;
        }

        return response()->json($formatted);
    }

    public function calculateTransactions(Request $request) {
        $transactions = $this->getTransactionsInRange($request->from, $request->to);

        $start = date('Y-m-d', strtotime($request->from));
        $end = date('Y-m-d', strtotime($request->to));

        $total = 0.0;
        $petrol = 0.0;
        $maid = 0.0;
        foreach ($transactions as $transaction) {
            $vendor = Vendor::where('id', $transaction->vendor_id)->first();
            $total += $transaction->amount;
            if(strcmp($vendor->name, "Petrol") == 0) {
                $petrol += $transaction->amount;
            }
            if(strcmp($vendor->name, "Maid") == 0) {
                $maid += env("MAID", 200);
            }
        }

        return response()->json(["data" => "Total for range " . $start . " to " . $end . ": R" . number_format((float)$total, 2, '.', '') . " (Petrol: R" . number_format((float)$petrol, 2, '.', '') . ", Maid: R" . number_format((float)$maid, 2, '.', '') . ")"]);
    }
}
