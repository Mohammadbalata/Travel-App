<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Front\HomePageService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(protected HomePageService $homePageService){
    }
    
    public function index(Request $request){
        return $this->homePageService->index($request);
    }
}
