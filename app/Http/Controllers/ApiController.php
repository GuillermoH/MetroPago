<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function returnUserData(){
        $data = [];
        $data["id"] = \Auth::getUser()->id;
        $data["name"] = \Auth::getUser()->name;
        $data["role"] = [];
        foreach (\Auth::getUser()->roles as $role){
            array_push($data["role"], $role->name);
        }
        return json_encode((object)$data);
    }
}
