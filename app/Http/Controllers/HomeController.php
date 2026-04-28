<?php

namespace App\Http\Controllers;

use App\Services\UniversityService;

class HomeController extends Controller
{
    public function __construct(private UniversityService $svc) {}
    
    public function index()
    {   
        $stats = [];
        $stats = $this->svc->getStats();
        return view('pages.home', compact('stats'));
    }
}
