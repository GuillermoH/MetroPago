<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;

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
}
