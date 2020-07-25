<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StatusController extends Controller
{
    public function getStatus(): Response 
    {
        return response()->json(['status' => 'up']); 
    }
}
