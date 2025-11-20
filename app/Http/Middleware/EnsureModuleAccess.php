<?php

namespace App\Http\Middleware;

use App\Services\AccessManager;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class EnsureModuleAccess
{
    public function __construct(private AccessManager $access)
    {
    }

    /**
     * Handle an incoming request.
     *
     * Usage: ->middleware('module:nomenclatures,lecture')
     */
    public function handle(Request $request, Closure $next, string $module, string $level = 'lecture')
    {
        if (! $this->access->canAtLeast($module, $level)) {
            throw new AccessDeniedHttpException('Vous n’avez pas les droits nécessaires pour accéder à ce module.');
        }

        return $next($request);
    }
}
