<?php

namespace App\Http\Controllers\Admin\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    /**
     * Catat log aktivitas admin/pengguna ke tabel activity_logs
     */
    protected function logActivity(string $module, string $action, string $description): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'module' => $module,
            'action' => $action,
            'description' => $description,
        ]);
    }
}
