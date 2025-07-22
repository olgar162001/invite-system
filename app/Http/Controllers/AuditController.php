<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Audit;

class AuditController extends Controller
{

    public function index()
    {
        $audits = Audit::all();

        return view('audits.index', compact('audits'));
    }

    public function clear()
    {
        Audit::truncate();

        return back()->with('success', 'Audit Logs cleared successfully.');
    }
}
