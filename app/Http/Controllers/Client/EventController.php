<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $date = $request->date;
        $query = Event::query();
        if ($search) {
            $query->where('title', 'like', "%$search%")
            ->orWhere('description', 'like', "%$search%");
        }

        if ($date) {
            $query->whereDate('date', '=', Carbon::parse($date))
                ->whereTime('date', '>=', '00:00:00')
                ->whereTime('date', '<=', '23:59:59');
        }

        $events = $query->orderBy('date', 'asc')->paginate(10);
        return view('client.events.index', ['events' => $events]);
    }
}
