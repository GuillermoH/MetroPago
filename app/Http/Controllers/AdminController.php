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
        $users = Role::with('users')->where('name','admin')->get()->first()['users'];
        return view('admin.listUsers', compact(['users']));
    }

    public function listStores(){
        $stores = Role::with('users')->where('name','store')->get()->first()['users'];
        return view('admin.listStores', compact(['stores']));
    }
}
