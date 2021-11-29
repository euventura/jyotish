<?php

namespace App\Http\Controllers\Maps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\JyotirService;

class CalculateController extends Controller
{
    private $jyotirService;

    public function __construct()
    {
        $this->jyotirService = new JyotirService();
    }

    public function calc(Request $request)
    {
        $request->validate([
            'date' => 'required|datetime',
            'latitude' => 'required|float',
            'longitude' => 'required|float',
            'altitude' => 'float'
        ]);

        $this->jyotirService->calc($request->all());
    }

}
