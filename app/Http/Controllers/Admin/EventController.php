<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $search = $request->search;
        $query = Event::query();


        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        $events = $query->paginate(10);

        return view('admin.events.index', ['events' => $events]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'cover' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'description' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|string',
        ]);

        try {
            $validated = $request->all();

            $dateString = Carbon::parse($validated['date'])->format('m/d/Y') . ' ' . $validated['time'];

            $date = Carbon::createFromFormat('m/d/Y g A', $dateString);

            $formattedDate = $date->format('Y-m-d H:i:s');

            $validated['date'] = $formattedDate;

            if ($request->hasFile('cover')) {
                $cover = $request->file('cover');
                $coverName = time() . '.' . $cover->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('events/images', $cover, $coverName);
                $validated['cover'] = 'storage/events/images/' . $coverName;
            }

            Event::create($validated);

            return redirect(route('dashboard.events'))->with(
                'message',
                [
                    'status' => 'success',
                    'content' => 'Event is created successfully',
                ]
            );
        } catch (\Exception $e) {
            Log::error('Failed to create event: ' . $e->getMessage());

            return redirect()->back()->with(
                'message',
                [
                    'status' => 'error',
                    'content' => 'Failed to create event',
                    'log' => $e->getMessage(),
                ]
            )->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Event::find($id);
        return view('admin.events.show', ['event' => $event]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'time' => 'nullable|string',
        ]);

        try {
            $validated = $request->all();

            $event = Event::find($id);

            if (!$event) {
                throw new \Exception('Event not found');
            }

            if ($request->hasFile('cover')) {
                $cover = $request->file('cover');
                $coverName = time() . '.' . $cover->getClientOriginalExtension();

                if ($event->cover) {
                    Storage::disk('public')->delete($event->cover);
                }

                Storage::disk('public')->putFileAs('events/images', $cover, $coverName);
                $validated['cover'] = 'storage/events/images/' . $coverName;
            }

            if ($request->has('date') && $request->has('time')) {

                $dateString = Carbon::parse($validated['date'])->format('m/d/Y') . ' ' . $validated['time'];

                $date = Carbon::createFromFormat('m/d/Y g A', $dateString);

                $formattedDate = $date->format('Y-m-d H:i:s');

                $validated['date'] = $formattedDate;
            }

            $event->update(array_filter($validated, function ($value) {
                return $value !== null;
            }));

            return redirect(route('dashboard.events'))->with(
                'message',
                [
                    'status' => 'success',
                    'content' => 'Event is updated successfully',
                ]
            );
        } catch (\Exception $e) {
            Log::error('Failed to create event: ' . $e->getMessage());

            return redirect()->back()->with(
                'message',
                [
                    'status' => 'error',
                    'content' => 'Failed to update event',
                    'log' => $e->getMessage(),
                ]
            )->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = Event::find($id);

        $message = $event->name . ' is deleted successfully';

        if (!$event) {
            redirect(route('dashboard.users'))->with(
                'message',
                [
                    'status'  => 'error',
                    'content' => 'Event is not found',
                ]
            );
        }

        $event->delete();

        return redirect(route('dashboard.events'))->with(
            'message',
            [
                'status' => 'success',
                'content' => $message,
            ]
        );
    }
}
