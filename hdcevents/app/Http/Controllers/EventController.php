<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\User;

class EventController extends Controller
{
    public function index()
    {
        $search = request('search');

        if ($search) {
            $events = Event::where([
                ['title', 'like', '%' . $search . '%']
            ])->get();
        } else {
            $events = Event::all();
        }

        return view('welcome', ['events' => $events, 'search' => $search]);
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $event = new Event;

        $event->title = $request->title;
        $event->date = $request->date;
        $event->city = $request->city;
        $event->description = $request->description;
        $event->private = $request->private;
        $event->items = $request->items;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->image;
            $ext = $image->extension();
            $imageName = md5($image->getClientOriginalName() . strtotime('now')) . '.' . $ext;
            $image->move(public_path('img/events'), $imageName);

            $event->image = $imageName;
        }

        $user = auth()->user();
        $event->user_id = $user->id;

        $event->save();

        return redirect('/')->with('msg', 'Evento criado com sucesso');
    }

    public function show($id)
    {
        $user = auth()->user();
        $event = Event::findOrFail($id);
        $eventOwner = User::where('id', '=', $event->user_id)->first()->toArray();
        $hasUserJoined = false;

        if ($user) {
            $userEvents = $user->eventsAsParticipant->toArray();

            foreach ($userEvents as $userEvent) {
                if ($userEvent['id'] == $id) {
                    $hasUserJoined = true;
                }
            }
        }

        return view('events.show', ['event' => $event, 'eventOwner' => $eventOwner, 'hasUserJoined' => $hasUserJoined]);
    }

    public function dashboard()
    {
        $user = auth()->user();
        $events = $user->events;
        $eventsAsParticipant = $user->eventsAsParticipant;

        return view('events.dashboard', ['events' => $events, 'eventsAsParticipant' => $eventsAsParticipant]);
    }

    public function destroy($id)
    {
        $user = auth()->user();
        $event = Event::findOrFail($id);
        if ($user->id != $event->user_id) {
            return redirect('/dashboard');
        }
        unlink(public_path('img/events/') . $event->image);
        $event->delete();
        return redirect('/dashboard')->with('msg', 'Evento excluído com sucesso');
    }

    public function edit($id)
    {
        $user = auth()->user();
        $event = Event::findOrFail($id);
        if ($user->id != $event->user_id) {
            return redirect('/dashboard');
        }

        return view('events.edit', ['event' => $event]);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $event = Event::findOrFail($id);
        $data = $request->all();
        if ($user->id != $event->user_id) {
            return redirect('/dashboard');
        }

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            unlink(public_path('img/events/') . $event->image);

            $image = $request->image;
            $ext = $image->extension();
            $imageName = md5($image->getClientOriginalName() . strtotime('now')) . '.' . $ext;
            $image->move(public_path('img/events'), $imageName);

            $data['image'] = $imageName;
        }

        Event::findOrFail($id)->update($data);

        return redirect('/dashboard')->with('msg', 'Evento atualizado');
    }

    public function join($id)
    {
        $user = auth()->user();
        $event = Event::findOrFail($id);
        foreach ($event->users as $participant) {
            if ($participant->id == $user->id) {
                return redirect('/dashboard')->with('msg', 'Sua presença já foi confirmada no evento ' . $event->title);
            }
        }
        $user->eventsAsParticipant()->attach($id);

        return redirect('/dashboard')->with('msg', 'Sua presença está confirmada no evento ' . $event->title);
    }

    public function leave($id)
    {
        $user = auth()->user();
        $event = Event::findOrFail($id);
        $user->eventsAsParticipant()->detach($id);

        return redirect('/dashboard')->with('msg', 'Sua presença foi removida do evento ' . $event->title);
    }
}
