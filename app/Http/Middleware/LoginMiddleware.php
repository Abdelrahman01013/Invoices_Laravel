<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // قم بتحديد الشرط الذي يحقق ما إذا كان المستخدم مفعلًا أم لا
        if ($request->user()->Status === 'مفعل') {
            // إذا كان المستخدم مفعلًا، قم بتسجيل الدخول
            Auth::login($request->user());

            return $next($request);
        }

        // إذا لم يكن المستخدم مفعلًا، قم بإعادة توجيهه إلى صفحة تسجيل الدخول أو أي صفحة أخرى تحددها
        return redirect()->route('login')->with('error', 'هذا البريد الإلكتروني غير مفعل.');
    }
}
