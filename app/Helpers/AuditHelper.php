<?php

namespace App\Helpers;

use App\Models\Audit;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

class AuditHelper
{
    public static function log($actionType, $description = null)
    {
        $user = Auth::user();
        $agent = new Agent();

        Audit::create([
            'user_id'    => $user?->id,
            'action_type'=> $actionType,
            'description'=> $description,
            'os'         => $agent->platform(),
            'machine'    => gethostname(),
            'ip_address' => request()->ip(),
        ]);
    }
}
