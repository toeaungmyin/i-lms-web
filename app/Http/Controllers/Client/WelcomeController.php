<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(){
        $events = Event::where('date', '>=', now()->startOfDay())
            ->orderBy('date', 'asc')
            ->take(4)->get();
        return view('client.welcome.index',['events'=>$events]);
    }
}
