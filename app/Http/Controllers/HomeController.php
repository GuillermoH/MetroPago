<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::user()->id) ;
        /*
         * Cuando el usuario inicia sesion es enviado a /home, en caso de tener mas de un role este puede seleccionar a donde quiere ir
         * en caso contrario es redirigido al panel de su rol unico
         */
        if(count($user->roles) == 1){
            return redirect('/'.strtolower($user->roles()->first()->name));
        }elseif(count($user->roles) > 1){
            $rl = [];
            foreach ($user->roles as $role){
                array_push($rl, $role->name);
            }
            return view('home', compact(['rl']));
        }else{
            return redirect('/');
        }
    }
}
