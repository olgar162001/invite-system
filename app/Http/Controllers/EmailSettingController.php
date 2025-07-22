<?php

namespace App\Http\Controllers;

use App\Helpers\AuditHelper;
use Illuminate\Http\Request;
use App\Models\EmailSetting;

class EmailSettingController extends Controller
{
    public function index()
    {
        $setting = EmailSetting::first() ?? new EmailSetting();;
        return view('email_settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'mailer' => 'nullable|string',
            'host' => 'nullable|string',
            'port' => 'nullable|numeric',
            'username' => 'nullable|string',
            'password' => 'nullable|string',
            'encryption' => 'nullable|string',
            'from_address' => 'nullable|email',
            'from_name' => 'nullable|string',
        ]);

        $setting = EmailSetting::first();

        if ($setting) {
            $setting->update($data);
        } else {
            EmailSetting::create($data); // create new record
        }

        AuditHelper::log('Update Email Settings', 'Email settings were updated');
        
        return redirect()->back()->with('success', 'Email settings updated successfully.');
    }
}
