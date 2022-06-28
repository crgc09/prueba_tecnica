<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index(){
        return response()->json([
            'message' => "API PT Traxion. Version 1.0.",
        ], 200);
    }
}
