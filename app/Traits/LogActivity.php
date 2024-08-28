<?php

namespace App\Traits;

use App\Models\ActivityLog;
use App\Models\Setting;

trait LogActivity
{
    public function CreateLog($activity)
    {
        $setting = Setting::first();
        if (isset($setting->log_activity) && $setting->log_activity == true) {
            ActivityLog::create([
                'user_id' => auth()->user()->id,
                'activity' => $activity,
            ]);
        }
    }
}
