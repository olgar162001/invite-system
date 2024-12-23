<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Guest;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['confirm', 'deny', 'index','template']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $id = auth()->id();
        $events = Event::where('user_id', $id)->get();
        $guests = Guest::all();
        $attending_guest = Guest::where('status', '2')->count();
        $pending_guest = Guest::where('status', '1')->count();
        $not_guest = Guest::where('status', '0')->count();


        return view('home')->with([
            'events' => $events,
            'guest' => $guests,
            'attending' => $attending_guest,
            'pending' => $pending_guest,
            'not' => $not_guest
    ]);
    }

    public function profile(){
        return view('profile');
    }

    public function template(){
        return view('card-template');
    }

    public function confirm($id)
    {

        $guest = Guest::find($id);
        $guest->status = '2';
        $guest->update();
        return view('response')->with('guest', $guest);
    }

    public function deny($id)
    {

        $guest = Guest::find($id);
        $guest->status = '0';
        $guest->update();
        return view('response')->with('guest', $guest);
    }
}
