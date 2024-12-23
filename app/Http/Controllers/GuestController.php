<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Guest;
use Illuminate\Http\Request;

class GuestController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
        
    // }

    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $id)
    {
        $guest = new Guest();
        $guest->name = $request->name;
        $guest->title = $request->title;
        $guest->email = $request->email;
        $guest->phone = $request->phone;
        $guest->type = $request->type;
        $guest->check_status = '0';
        $guest->status = '1';
        $guest->invite_link = $this->generateRandomString();
        $guest->user_id = auth()->id();
        $guest->event_id = $id;
        // dd($this->generateRandomString());
        $guest->save();

        return redirect('/event/'.$id)->with('success','Guest Added');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $guest = Guest::find($id);
        $event = Event::find($id);
        
        return view('card')->with('guest', $guest);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $guest = Guest::find($id);
        return view('edit_guest')->with('guest', $guest);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $guest = Guest::find($id);
        $guest->name = $request->name;
        $guest->title = $request->title;
        $guest->email = $request->email;
        $guest->phone = $request->phone;
        $guest->type = $request->type;
        $guest->check_status = '0';
        if($request->status == 'Attending'){
            $guest->status = '2';
        }else if($request->status == 'Not Attending'){
            $guest->status = '0';
        }else{
            $guest->status = '1';
        }
        $guest->user_id = auth()->id();
        $guest->event_id = $id;
        $guest->update();

        return redirect('/event/'.$id)->with('success', 'Guest Edited');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $guest = Guest::find($id);
        $guest->delete();

        return redirect('/event')->with('success', 'Guest Deleted');
    }

    public function check($id)
    {
        $guest = Guest::find($id);
        $guest->check_status = '1';
        $guest->update();

        return redirect()->back()->with('success', 'Guest Checked Succesfully');
    }
}
