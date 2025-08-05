<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request \$request, Closure \$next)
    {
        // Temporary: allow all (disable check) for testing
        // return \$next(\$request);

        // Real check example (commented for now)
        // if (!auth()->check() || !auth()->user()->is_admin) {
        //     abort(403);
        // }
        return \$next(\$request);
    }
}
