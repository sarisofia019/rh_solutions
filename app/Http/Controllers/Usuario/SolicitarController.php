<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SolicitarController extends Controller
{
    //
    public function view(){
        return view('user.solicitar');
    }
}
