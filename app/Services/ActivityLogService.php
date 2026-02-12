<?php

namespace App\Services;

use App\Models\ActivityLog;

class ActivityLogService
{
    /**
     * Create a new activity log.
     *
     * @param int $userId
     * @param string $activity
     * @return void
     */
    public function log($userId, $activity)
    {
        ActivityLog::create([
            'user_id' => $userId,
            'activity' => $activity
        ]);
    }
}
