<?php

namespace App\Http\Middleware;

use App\PermissionEnum;
use App\RoleEnum;
use Closure;
use Couchbase\Role;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use function PHPUnit\Framework\isFalse;

class MyAuth
{
    public static array $routesAllowAll = [
        "mdev"
    ];

    public static array $routesAllowLoggedOff = [
        "auth.login"
    ];

    public static array $rolesPermissions = [
        RoleEnum::ROLE_USER->value => [
            "projects.index",
            "projects.detail",
            "files.show",
            "auth.logout",
        ]
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()) {
            if (!array_key_exists("as", $request->route()->action)) {
                return redirect()->route("auth.login");
            }
            if (in_array($request->route()->action["as"], self::$routesAllowAll)) {
                return $next($request);
            }
            if (in_array($request->route()->action["as"], self::$routesAllowLoggedOff)) {
                return $next($request);
            }
            return redirect()->route("auth.login");
        }

        $role = $request->user()->role;
        if (!array_key_exists("as", $request->route()->action)) {
            return redirect()->route("auth.login");
        }
        if (in_array($request->route()->action["as"], self::$routesAllowAll)) {
            return $next($request);
        }
        if (in_array($request->route()->action["as"], self::$routesAllowLoggedOff)) {
            return redirect()->route("projects.index");
        }
        if ($role === RoleEnum::ROLE_ADMIN->value) {
            return $next($request);
        }
        if (in_array($request->route()->action["as"], self::$rolesPermissions[$request->user()->role])) {
            return $next($request);
        }
        var_dump("no perms created");
        return abort(401);
    }

    public static function hasPermission(PermissionEnum $permission, $role) {
        if ($role === RoleEnum::ROLE_ADMIN->value) {
            return true;
        }
        return in_array($permission->value, self::$rolesPermissions[$role]);
    }
}
