<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\Patient;
use Carbon\Carbon;

class EventController extends Controller
{
    public function create(){
        $doctors = User::where('role', 'doctor')->get();
        $radiologists = User::where('role', 'radiology')->get();
        $patients = Patient::all();
        return view('events.create', compact('doctors', 'radiologists', 'patients'));
    }
    public function store(Request $request){
    $request->validate([
        'event' => 'required|string',
        'start_date' => 'required|date',
        'duration_minutes' => 'required|integer|min:1',
        'room' => 'required|in:Sala 1,Sala 2',
        'patient_id' => 'required|exists:patients,id',
    ]);

    $start = Carbon::parse($request->start_date);
    $duration = $request->duration_minutes + 10;
    $end = $start->copy()->addMinutes($duration);

    $conflict = Event::where('room', $request->room)
        ->where(function($query) use ($start, $end) {
            $query->whereBetween('start_date', [$start, $end])
                  ->orWhereBetween('end_date', [$start, $end])
                  ->orWhere(function($query) use ($start, $end) {
                      $query->where('start_date', '<=', $start)
                            ->where('end_date', '>=', $end);
                  });
        })->exists();

    if ($conflict) {
        return back()->withErrors(['room' => 'La sala ya está ocupada en ese horario.'])->withInput();
    }

    Event::create([
        'event' => $request->event,
        'details' => $request->details,
        'start_date' => $start,
        'end_date' => $end,
        'duration_minutes' => $request->duration_minutes,
        'room' => $request->room,
        'assigned_doctor' => $request->assigned_doctor ?: $request->custom_doctor,
        'assigned_radiologist' => $request->assigned_radiologist ?: $request->custom_radiologist,
        'patient_id' => $request->patient_id,
    ]);

    return redirect()->route('events.index')->with('success', 'Cita creada');
    }
    public function calendar(){
        $all_events=Event::all();
        $events=[];
        foreach($all_events as $event){
            $events[] = [
                'id' => $event->id,
                'title' => $event->event,
                'start' => date('Y-m-d\TH:i:s', strtotime($event->start_date)),
                'end'   => date('Y-m-d\TH:i:s', strtotime($event->end_date)),
                'room' => $event->room,
                'allDay' => false,
            ];            
        }        
        return view('events.index',compact('events'));
    }
    public function show($id){
        $event = Event::findOrFail($id);
        return view('events.show', compact('event'));
    }
}
