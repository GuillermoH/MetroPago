<?php

namespace App\Http\Controllers;

use App\Deposit;
use App\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
use DateTime;
use DateTimeZone;
use Charts;

class UserController extends Controller
{
    public function index(){
//        $purchases = Purchase::with
//            ->where('user_id', '=', Auth::getUser()->id)
//            ->where('created_at', '=', Carbon::now()->subDays(6))
//            ->join('users', 'purchases.store_id', '=', 'users.id')
//            ->get();
        $purchases = DB::table('purchases')
            ->select('purchases.id','purchases.amount', 'purchases.created_at', 'users.name')
            ->where('user_id', '=', Auth::getUser()->id)
            ->where('purchases.created_at', '>=', Carbon::now()->subDays(6))
            ->join('users', 'purchases.store_id', '=', 'users.id')
            ->orderBy('created_at', 'DESC')
            ->get();

        $availableAmount = Deposit::where('user_id', '=', Auth::getUser()->id)
            ->where('approved', '1')
            ->sum('amount') -
            Purchase::where('user_id', Auth::getUser()->id)->sum('amount');
        \Debugbar::info($availableAmount);

        $purchasesByDay = Purchase::where('user_id', '=', Auth::getUser()->id)
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get(array(
                DB::raw('Date(created_at) as date'),
                DB::raw('SUM(amount) as amount')
            ));

        $days = $purchases7d = [];
        for($i = 6; $i >= 0; $i --){
            $purchases7d[$i] = $purchasesByDay->where('date', '=', Carbon::today()->subDays($i)->toDateString())->first()['amount'];

            $days[$i] = Carbon::today()->subDays($i)->format('d/m/y');
        };

        $lineChart = Charts::create('line', 'chartjs')
            ->title('Gastos de los últimos 7d')
            ->labels($days)
            ->values($purchases7d)
            ->template('orange-material')
            ->elementLabel('Total por día');
        if ($purchasesByDay->count() > 0){
            $purchaseByDayRelation = $purchasesByDay->sum('amount') / $purchasesByDay->count();
        }else{
            $purchaseByDayRelation = 0;
        }



        return view('user.home', compact(['purchases', 'availableAmount', 'purchaseByDayRelation', 'lineChart']));
    }

    public function addFunds(){
        return view('user.addFunds');
    }

    public function viewBalance(){
        $deposits = Deposit::where('user_id',Auth::getUser()->id)->orderBy('created_at', 'ASC')->get();
        $purchases = DB::table('purchases')
            ->select('purchases.id','purchases.amount', 'purchases.created_at', 'users.name')
            ->where('user_id', '=', Auth::getUser()->id)
            ->join('users', 'purchases.store_id', '=', 'users.id')
            ->orderBy('created_at', 'ASC')
            ->get();

        $balance = [];

        foreach ($deposits as $deposit){
            if ($deposit->approved == 1){
                $object = (object)[
                    'amount' => $deposit->amount,
                    'type' => $deposit->type,
                    'reference' => $deposit->reference,
                    'created_at' => $deposit->created_at->toDateTimeString()

                ];
                array_push($balance, $object);
            }

        }

        foreach ($purchases as $purchase){
            $object = (object)[
                'amount' => 0 - $purchase->amount,
                'business' => $purchase->name,
                'created_at' => $purchase->created_at

            ];
            array_push($balance, $object);
        }
        usort($balance, array($this, "cmp"));
        \Debugbar::info($balance);
        array_reverse($balance, true);
        \Debugbar::info($balance);
        return view('user.viewBalance', compact(['balance']));
    }

    public function cmp($a, $b)
    {
        return strcmp($b->created_at, $a->created_at);
    }

    public function storeDeposit(Request $request){
        $now = new DateTime(null, new DateTimeZone('America/Caracas'));

        $deposit = new Deposit();
        $deposit->amount = $request->amount;
        if (isset($request->reference)){
            $deposit->reference = $request->reference;
            $deposit->approved = 0;
        }else{
            $deposit->reference = preg_replace("/[^a-zA-Z0-9]+/", "", $now->getTimestamp());
            $deposit->approved = 1;
        }

        $deposit->type = $request->type;

        $deposit->user_id = Auth::getUser()->id;

        $deposit->save();
        if (isset($request->reference)){
            Session::flash('status', 'Se ha enviado la información sobre la transferencia '.$request->reference.' para ser validada.');
        }else{
            Session::flash('status', 'Ha depositado '.$request->amount.' exitosamente con su tarjeta de credito.');
        }

        return back();
    }
}
