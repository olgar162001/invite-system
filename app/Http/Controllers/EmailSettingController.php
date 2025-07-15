<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailSetting;

class EmailSettingController extends Controller
{
    public function index()
    {
        $setting = EmailSetting::first();
        return view('email_settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'mailer' => 'required',
            'host' => 'required',
            'port' => 'required|numeric',
            'username' => 'required',
            'password' => 'required',
            'encryption' => 'nullable',
            'from_address' => 'required|email',
            'from_name' => 'required',
        ]);

        $setting = EmailSetting::first();
        $setting->update($request->all());

        return redirect()->back()->with('success', 'Email settings updated.');
    }
}
