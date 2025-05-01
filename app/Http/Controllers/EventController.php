<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\Patient;

class EventController extends Controller
{
    public function create(){
        $doctors = User::where('role', 'doctor')->get();
        $radiologists = User::where('role', 'radiology')->get();
        $patients = Patient::all();
        return view('events.create', compact('doctors', 'radiologists', 'patients'));
    }
    public function store(Request $request){
        $doctor = $request->assigned_doctor ?: $request->custom_doctor;
        $radiologist = $request->assigned_radiologist ?: $request->custom_radiologist;
        Event::create([
            'event' => $request->event,
            'details'=>$request->details,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'assigned_doctor' => $doctor,
            'assigned_radiologist' => $radiologist,
            'patient_id' => $request->patient_id,
        ]);
        return redirect()->route('events.index')->with('success','Cita creada');
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
                'allDay' => false,
                'color' => '#1d4ed8',
            ];            
        }        
        return view('events.index',compact('events'));
    }
    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('events.show', compact('event'));
    }
}
