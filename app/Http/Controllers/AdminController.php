<?php

namespace App\Http\Controllers;

use App\Purchase;
use App\Uid;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Deposit;
use DateTime;
use DateTimeZone;
use Charts;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function index(){
        /*
         * deposits, cc, cash and transfer data for deposit chart
         */
        $deposits = Deposit::where('created_at', '>=', Carbon::today()->subDays(6))
            ->where('type', '=', 'Abono')
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get(array(
               DB::raw('Date(created_at) as date'),
               DB::raw('SUM(amount) as amount')
            ));
        $creditCards = Deposit::where('created_at', '>=', Carbon::today()->subDays(6))
            ->where('type', '=', 'TDC')
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get(array(
                DB::raw('Date(created_at) as date'),
                DB::raw('SUM(amount) as amount')
            ));
        $cash = Deposit::where('created_at', '>=', Carbon::today()->subDays(6))
            ->where('type', '=', 'Efectivo')
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get(array(
                DB::raw('Date(created_at) as date'),
                DB::raw('SUM(amount) as amount')
            ));
        $transfers = Deposit::where('created_at', '>=', Carbon::today()->subDays(6))
            ->where('type', '=', 'Transferencia')
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get(array(
                DB::raw('Date(created_at) as date'),
                DB::raw('SUM(amount) as amount')
            ));

        /*
         * purchases data from the last 7 days for line chart
         */
        $purchase = Purchase::where('created_at', '>=', Carbon::today()->subDays(6))
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get(array(
                DB::raw('Date(created_at) as date'),
                DB::raw('SUM(amount) as amount')
            ));

        $depositsAmount = $ccAmount = $cashAmount = $transAmount = $days = $purchases = [];
        for($i = 6; $i >= 0; $i --){
            $depositsAmount[$i] = $deposits->where('date', '=', Carbon::today()->subDays($i)->toDateString())->first()['amount'];
            $ccAmount[$i] = $creditCards->where('date', '=', Carbon::today()->subDays($i)->toDateString())->first()['amount'];
            $cashAmount[$i] = $cash->where('date', '=', Carbon::today()->subDays($i)->toDateString())->first()['amount'];
            $transAmount[$i] = $transfers->where('date', '=', Carbon::today()->subDays($i)->toDateString())->first()['amount'];

            $purchases[$i] = $purchase->where('date', '=', Carbon::today()->subDays($i)->toDateString())->first()['amount'];

            $days[$i] = Carbon::today()->subDays($i)->format('d/m/y');
        };

        $barChart = Charts::multi('bar', 'chartjs')
            // Setup the chart settings
            ->title("Depositos de la semana")
            // colors
            ->colors(['#6096f3', '#eb4236', '#f46e09', '#f4c009'])
            // This defines a preset of colors already done:)
            ->template("material")
            // You could always set them manually
            // ->colors(['#2196F3', '#F44336', '#FFC107'])
            // Setup the diferent datasets (this is a multi chart)
            ->dataset('Abono', $depositsAmount)
            ->dataset('Efectivo', $cashAmount)
            ->dataset('Transferencia', $transAmount)
            ->dataset('TDC', $ccAmount)

            // Setup what the values mean
            ->labels($days);
        $lineChart = Charts::create('line', 'chartjs')
            ->title('Ventas de la semana')
            ->labels($days)
            ->values($purchases)
            ->template('orange-material')
            ->elementLabel('Ventas del día');

        $userCount[0] = Role::with('users')->where('name','user')->get()->first()['users']->count();
        $userCount[1] = Role::with('users')->where('name','store')->get()->first()['users']->count();
        \Debugbar::info($userCount);

        return view('admin.home', ['barChart' => $barChart,'lineChart' => $lineChart , 'userCount' => $userCount]);
    }

    /*
     * List users with data, remove and edit buttons
     */
    public function listUsers(){
        $users = Role::with('users')->where('name','user')->get()->first()['users'];
        $users = $users->where('active','1');
        $values = [
            $users->where('type', 'Estudiante')->count(),
            $users->where('type', 'Profesor')->count(),
            $users->where('type', 'Empleado')->count()
        ];
        \Debugbar::info($values);
        $chart =  Charts::create('pie', 'chartjs')
            ->title('Tipo de usuarios')
            ->labels(['Estudiante', 'Profesor', 'Empleado'])
            ->values($values)
            ->dimensions(600,300)
            ->template('orange-material')
            ->responsive(false);
        return view('admin.listUsers', compact(['users', 'chart']));
    }

    public function listDisabledUsers(){
        $users = Role::with('users')->where('name','user')->get()->first()['users'];
        $users = $users->where('active','0');
        $values = [
            $users->where('type', 'Estudiante')->count(),
            $users->where('type', 'Profesor')->count(),
            $users->where('type', 'Empleado')->count()
        ];
        \Debugbar::info($values);
        $chart =  Charts::create('pie', 'chartjs')
            ->title('Tipo de usuarios')
            ->labels(['Estudiante', 'Profesor', 'Empleado'])
            ->values($values)
            ->dimensions(600,300)
            ->template('orange-material')
            ->responsive(false);
        return view('admin.listDisabledUsers', compact(['users', 'chart']));
    }

    public function listStores(){
        $stores = Role::with('users')->where('name','store')->get()->first()['users'];
        $stores = $stores->where('active', '1');
        return view('admin.listStores', compact(['stores']));
    }

    public function listDisabledStores(){
        $stores = Role::with('users')->where('name','store')->get()->first()['users'];
        $stores = $stores->where('active', '0');
        return view('admin.listDisabledStores', compact(['stores']));
    }

    public function userDestroy(User $user){
        $User = $user;
        $User->active = 0;
        $User->save();
//        $user->delete();
        Session::flash('status', 'Se ha deshabilitado el usuario exitosamente');
        return redirect(route('admin.listUsers'));
    }

    public function userEnable(User $user){
        $User = $user;
        $User->active = 1;
        $User->save();
        Session::flash('status', 'Se ha habilitado el usuario exitosamente');
        return redirect(route('admin.listUsers'));
    }

    public function storeDestroy(User $user){
        $User = $user;
        $User->active = 0;
        $User->save();
        Session::flash('status', 'Se ha deshabilitado el Negocio exitosamente');
        return redirect(route('admin.listStores'));
    }

    public function storeEnable(User $user){
        $User = $user;
        $User->active = 1;
        $User->save();
        Session::flash('status', 'Se ha habilitado el usuario exitosamente');
        return redirect(route('admin.listUsers'));
    }


    public function createUser(){
        return view('admin.createUser');
    }

    public function storeUser(Request $request){
        $user = new User();
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'username' => 'required|unique:users|min:6',
            'c_id' => 'required|unique:users'
            ]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->c_id = $request->c_id;

        $user->password = bcrypt(str_random(8));
        $user->type = $request->type;
        $user->save();

        $user->roles()->attach(3);
        if(isset($request->uid)){
            $uid = new Uid();
            $uid->uid = $request->uid;
            $uid->user_id = $user->id;
        }


        Session::flash('status', 'Se ha creado el usuario "'.$request->name.'" exitosamente');
        return redirect(route('admin.listUsers'));

    }

    public function createStore(){
        return view('admin.createStore');
    }

    public function storeStore(Request $request){
        $user = new User();
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'username' => 'required|unique:users|min:6',
            'c_id' => 'required|unique:users'
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->c_id = "J-".$request->c_id;
        $user->password = bcrypt(str_random(8));
        $user->save();

        $user->roles()->attach(2);

        Session::flash('status', 'Se ha creado el negocio "'.$request->name.'" exitosamente');
        return redirect(route('admin.listStores'));

    }

    public function editUser(User $user){
        return view('admin.editUser', compact(['user']));
    }

    public function updateUser(Request $request, User $user){
        // validate update request, added exceptions to make it pass same user uniqueness
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'username' => 'required|min:6|unique:users,username,' . $user->id,
            'c_id' => 'required|unique:users,c_id,' . $user->id
        ]);
        $User = $user;
        $User->name = $request->name;
        $User->email = $request->email;
        $User->username = $request->username;
        $User->c_id = $request->c_id;
        $User->save();

        Session::flash('status', 'Se ha editado el usuario "'.$request->name.'" exitosamente');
        return redirect(route('admin.listUsers'));
    }

    public function addFunds(Request $request, User $user){
        $now = new DateTime(null, new DateTimeZone('America/Caracas'));

        $Deposit = new Deposit();
        $Deposit->amount = $request->amount;
        $Deposit->type = $request->type;
        $Deposit->reference = preg_replace("/[^a-zA-Z0-9]+/", "", $now->getTimestamp());
        $Deposit->user_id = $user->id;
        $Deposit->approved = 1;
        $Deposit->save();

        Session::flash('status', 'Se han agregado Bs.F '.$request->amount.' exitosamente');

        return redirect()->back();
    }

    public function editStore(User $user){
        return view('admin.editStore', compact(['user']));
    }

    public function updateStore(Request $request, User $user){
        // validate update request, added exceptions to make it pass same user uniqueness
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'username' => 'required|min:6|unique:users,username,' . $user->id,
            'c_id' => 'required|unique:users,c_id,' . $user->id
        ]);
        $User = $user;
        $User->name = $request->name;
        $User->email = $request->email;
        $User->username = $request->username;
        $User->c_id = $request->c_id;
        $User->save();

        Session::flash('status', 'Se ha editado el negocio "'.$request->name.'" exitosamente');
        return redirect(route('admin.listStores'));
    }

    public function listDeposits(){
        $deposits = Deposit::with('user')->get();
        $approvedDeposits = $deposits->where('approved', '=', 1);
        $needApprovalDeposits = $deposits->where('approved', '=', 0);
        $deniedDeposits = $deposits->where('approved', '=', 2);
        return view('admin.listDeposits', compact(['approvedDeposits', 'needApprovalDeposits', 'deniedDeposits']));
    }

    public function getDeposits(){
        return Deposit::with('user')->get()->toJson();
    }

    public function updateDeposit(Request $request, Deposit $deposit){
        $Deposit = $deposit;
        $Deposit->approved = $request->newStatus;
        $Deposit->save();

        if ($request->newStatus == 1){
            Session::flash('status', 'Se ha aprovado el deposito de  "'.$deposit->user->name.'" exitosamente');
        }else if($request->newStatus == 2){
            Session::flash('warning', 'Se ha rechazado el deposito de  "'.$deposit->user->name.'"');
        }

        return redirect()->back();
    }
}
