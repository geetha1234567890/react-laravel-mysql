<?php

namespace Modules\Admin\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Models\CountryTimeZones;

class TimeZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function GetAllTimeZones()
    {
        $timeZones = CountryTimeZones::all();
        return response()->json($timeZones);
    }
}
