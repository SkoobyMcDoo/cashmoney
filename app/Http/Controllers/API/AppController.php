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
        return response()->json(Vendor::all());
    }

    private function getTransactionsForWeek($date) {
        $dayofweek = date('w', strtotime($date));
        $start     = date('Y-m-d', strtotime((0 - $dayofweek).' day', strtotime($date)));
        $end       = date('Y-m-d', strtotime((6 - $dayofweek).' day', strtotime($date)));
        $transactions = Transaction::whereBetween('created_at', [$start . " 00:00:00", $end . " 23:59:59"])->get();
        return ["start" => $start, "end" => $end, "transactions" => $transactions];
    }

    public function getTransactions() {
        $transactions = $this->getTransactionsForWeek(now())["transactions"];

        $formatted = [];
        foreach ($transactions as $transaction) {
            $vendor = Vendor::where('id', $transaction->vendor_id)->first();
            $sale_date = date('Y-m-d', strtotime($transaction->created_at));
            $formatted[] = "R" . $transaction->amount . " at " . $vendor->name . " on " . $sale_date;
        }

        return response()->json($formatted);
    }

    public function calculateWeek() {
        $data = $this->getTransactionsForWeek(date('Y-m-d', strtotime("7 days ago")));

        $transactions = $data["transactions"];
        $start = $data["start"];
        $end = $data["end"];

        $total = 0.0;
        $petrol = 0.0;
        $maid = env("MAID", 200);
        foreach ($transactions as $transaction) {
            $vendor = Vendor::where('id', $transaction->vendor_id)->first();
            $total += $transaction->amount;
            if(strcmp($vendor->name, "Petrol") == 0) {
                $petrol += $transaction->amount;
            }
        }
        $total += $maid;

        return response()->json(["data" => "Total for week " . $start . " to " . $end . ": R" . number_format((float)$total, 2, '.', '') . " (Petrol: R" . number_format((float)$petrol, 2, '.', '') . ", Maid: R" . number_format((float)$maid, 2, '.', '') . ")"]);
    }
}
