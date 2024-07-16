<?php

namespace Modules\Admin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Admin\Models\APIKey;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $api_key = $request->header('API-KEY');
       
        $get_api_key = APIKey::where(["key"=>$api_key])->first();

        if (empty($get_api_key)) {
            return response()->json(['error' => 'Invalid API key'], 401);
        }

        return $next($request);
    }
}
