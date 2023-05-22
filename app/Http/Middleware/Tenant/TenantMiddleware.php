<?php

namespace App\Http\Middleware\Tenant;

use App\Models\Company;
use App\Tenant\ManagerTenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $manager_tenant = app(ManagerTenant::class);

        if ($manager_tenant->isMainDomain())
            return $next($request);

        $tenant = $this->getCompany($request->getHost());

        if (!$tenant && $request->url() != route('404')) {
            return redirect()->route('404');
        } else if ($request->url() != route('404') && !$manager_tenant->isMainDomain()) {
           $manager_tenant->setConnection($tenant);
        }

        return $next($request);
    }

    private function getCompany(string $host): ?Company
    {
        /**@var Company*/
        return Company::query()->where('domain', $host)->first();
    }
}
