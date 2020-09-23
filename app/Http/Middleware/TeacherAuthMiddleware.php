<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TeacherAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'teacher')
    {
        if (!Auth::guard($guard)->check()) {
            return redirect('/ProLogin'); //改成『若登入後再回到登入頁面時你要跳轉』的頁面，這邊應該會在LoginController的屬性$redirectTo一樣。
        }

        return $next($request);
    }

}
