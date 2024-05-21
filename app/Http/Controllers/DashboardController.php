<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\API;

class DashboardController extends Controller
{
    public function index()
    {
        $moeda = @$_GET['moeda'];
        
        return ($moeda != null)? API::Atualizar($_GET['moeda']) : 'dashboard';
    }
}
