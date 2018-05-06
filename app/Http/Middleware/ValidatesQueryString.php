<?php

namespace App\Http\Middleware;

use Closure;

class ValidatesQueryString
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->filled('qc')) {
            $queryString = base64_decode($request->get('qc'));

            try {
                $request->query->add($this->rebuildQueryParameters($queryString));
            } catch (\Exception $exception) {
                return $this->invalidRequest();
            }

            $originalQueryString = collect($request->all())->except(['qc', 'hash'])->map(function ($value, $key) {
                return "{$key}={$value}";
            })->implode("&");

            $hash = hash('sha256', $originalQueryString);

            return $this->validateRequestQueryString($request, $hash, $next);
        }

        return $next($request);
    }

    protected function rebuildQueryParameters($queryString)
    {
        return $qsArray = collect(explode("&", $queryString))->mapWithKeys(function ($query) {
            $param = explode("=", $query);
            if (is_array($param) && isset($param[1])) {
                return [$param[0] => $param[1]];
            }
            return null;
        })->toArray();
    }

    protected function validateRequestQueryString($request, $hash, $next)
    {
        if ($request->get('hash') !== $hash) {
            return $this->invalidRequest();
        }

        return $next($request);
    }

    protected function invalidRequest()
    {
        return response([
            'error'   => 'Invalid request.',
            'message' => 'Failed to check request CRC.'
        ], 400);
    }
}
