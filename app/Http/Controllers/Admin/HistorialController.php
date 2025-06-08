<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HistorialController extends Controller
{
    //
    public function view(){
        return view('admin.historialCertificados');
    }
}
