<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Log;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use App\Exceptions\NotAuthorisedException; //401
use App\Exceptions\NoPermissionException; //403

class ManageToken extends BaseMiddleware
{

    /**
     * Handle an incoming request.
     *
     */
    public function handle(Request $request, Closure $next, string $allowedGuards, string $role)
    {
        $submittedGuard = 'api_' . $request->header('Mg-Type');
        $guards = explode('|', $allowedGuards);

        foreach($guards as $guard) {
            if($guard === $submittedGuard) {
                auth()->shouldUse($guard);
            }
        }
        try {
            if(auth()->authenticate()) {
                if($this->hasPermission($role, auth()->user())) {
                    return $next($request);;
                }

                throw new NoPermissionException('You do not have permission to view this page.'); //403
            }
        } catch (AuthenticationException $e) {
            
            try {
                $this->checkForToken($request);
                $this->auth->parseToken()->authenticate();
            } catch (TokenExpiredException $e) {
                try {
                    $newtoken = $this->auth->parseToken()->refresh();
                    $response = $next($request);

                    if($this->hasPermission($role, auth()->user())) {
                        $response->header('Authorization', 'Bearer ' . $newtoken);

                        return $response;
                    }
                    
                    return $response->json(['message' => 'You do not have permission to view this page.'], 403)
                        ->header('Authorization', 'Bearer ' . $newtoken);
                        
                } catch (TokenExpiredException $e) {
                    //refresh token expired
                    throw new NotAuthorisedException('You are not authorised to view this page. Please log in.'); //401
                }
            }
        }
        
        throw new NotAuthorisedException('You are not authorised to view this page. Please log in.'); //401
    }

    /**
     * check user has permission to access
     *
     */
    private function hasPermission(string $allowedRoles, object $user): bool
    {
        $roles = explode('|', $allowedRoles);

        foreach($roles as $role) {
            if($role == $user->role) {
                return true;
            }
        }

        throw new NoPermissionException('You do not have permission to view this page.'); //403
    }
   
}
