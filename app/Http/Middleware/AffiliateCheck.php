<?php

namespace App\Http\Middleware;

use App\Affiliate;
use Closure;
use Cookie;

class AffiliateCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->has('f')) {
            $code = $request->get('f');
            $affiliate = Affiliate::where('slug', $code)->first();
            $payload = encrypt(null);

            if ($affiliate !== null) {
                $payload = encrypt($affiliate->id);
            }

            Cookie::queue(
                Cookie::make(base64_encode('affiliate'), json_encode($payload))
            );

            return redirect('/');
        }
        return $next($request);
    }
}
