<?php

namespace App\Http\Controllers;

use App\Purchase;
use Barryvdh\Debugbar\Middleware\Debugbar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Charts;

class StoreController extends Controller
{
    public function index(){
        $purchasesList = Purchase::with('user')
            ->where('store_id', '=', Auth::getUser()->id)
            ->where('created_at', '>=', Carbon::today()->subDay(6))
            ->orderBy('created_at', 'DESC')
            ->get();
        $purchasesAmounts = Purchase::where('created_at', '>=', Carbon::today()->subDays(6))
            ->where('store_id', '=', Auth::getUser()->id)
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get(array(
                DB::raw('Date(created_at) as date'),
                DB::raw('SUM(amount) as amount')
            ));
        $userTypes = DB::table('purchases')
            ->where('purchases.store_id','=', Auth::getUser()->id)
            ->join('users', 'purchases.user_id', '=', 'users.id')
            ->select('purchases.id', 'users.type as type')
            ->get();

        $userType[0] = $userTypes->where('type', 'Estudiante')->count();
        $userType[1] = $userTypes->where('type', 'Profesor')->count();
        $userType[2] = $userTypes->where('type', 'Empleado')->count();

        $days = $purchasesByDay = [];

        for($i = 6; $i >= 0; $i --){
            $purchasesByDay[$i] = $purchasesAmounts->where('date', '=', Carbon::today()->subDays($i)->toDateString())->first()['amount'];

            $days[$i] = Carbon::today()->subDays($i)->format('d/m/y');
        };
        $lineChart = Charts::create('line', 'chartjs')
            ->title('Ventas de los últimos 7d')
            ->labels($days)
            ->values($purchasesByDay)
            ->template('orange-material')
            ->elementLabel('Ventas del día');
        $pieChart =  Charts::create('pie', 'chartjs')
            ->title('Número de compras por tipo de usuario (7d)')
            ->labels(['Estudiante', 'Profesor', 'Empleado'])
            ->values($userType)
            ->dimensions(600,300)
            ->template('orange-material')
            ->responsive(false);
        return view('store.home', compact(['purchasesList', 'lineChart', 'pieChart']));
    }

    public function listSells(Request $request){
        \Debugbar::info(isset($request->from));
        $purchases = Purchase::where('store_id', '=', Auth::getUser()->id)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('store.listSells', compact(['purchases']));

    }
}
