<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogActivity
{
    public function CreateLog($activity)
    {
        ActivityLog::create([
            'user_id' => auth()->user()->id ?? 1,
            'activity' => $activity,
        ]);
    }
}
