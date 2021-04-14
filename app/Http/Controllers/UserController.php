<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

Class UserController extends Controller{
    private $request;

    public function _construct(Request $request){
        $this->request=$request;
    }
    public function getUsers(){
        $users= User::all();
        return response()->json($users,200);
    }
}
?>