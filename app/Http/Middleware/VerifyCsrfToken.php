<?php namespace App\Http\Middleware;

use Closure;
use Symfony\Component\Security\Core\Util\StringUtils;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		return parent::handle($request, $next);
	}
        
        function tokensMatch($request)
    {
        $token = $request->session()->token();

        $header = $request->header('x-xsrf-token');//in keys case sensitivity is important!!!!

        return StringUtils::equals($token, $request->input('_token')) ||
        ($header && StringUtils::equals($token, $header)) ;

    }

}
