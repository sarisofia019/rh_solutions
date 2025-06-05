<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SolicitudController extends Controller
{
    //
    public function view(){
        return view('admin.solicitudes');
    }
}
