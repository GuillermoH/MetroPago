<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Deposit;
use DateTime;
use DateTimeZone;

use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function index(){
//        Session::flash('status', 'Prueba de flash ');
        return view('admin.home');
    }

    public function listUsers(){
        $users = Role::with('users')->where('name','user')->get()->first()['users'];
        return view('admin.listUsers', compact(['users']));
    }

    public function listStores(){
        $stores = Role::with('users')->where('name','store')->get()->first()['users'];
        return view('admin.listStores', compact(['stores']));
    }

    public function userDestroy(User $user){
        $user->delete();
        Session::flash('status', 'Se ha eliminado el usuario exitosamente');
        return redirect(route('admin.listUsers'));
    }

    public function storeDestroy(User $user){
        $user->delete();
        Session::flash('status', 'Se ha eliminado el Negocio exitosamente');
        return redirect(route('admin.listStores'));
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
        $user->uid = $request->uid;
        $user->password = bcrypt(str_random(8));
        $user->save();

        $user->roles()->attach(3);

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
        $user->c_id = $request->c_id;
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
        $Deposit->type = "Abono";
        $Deposit->reference = preg_replace("/[^a-zA-Z0-9]+/", "", $now->getTimestamp());
        $Deposit->user_id = $user->id;
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
}
