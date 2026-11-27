<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        $activities = ActivityLog::latest()
            ->paginate(15);

        return view('admin.activity-log.index', compact('activities'));
    }
}