<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\TrustProxies::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\GetSourseDomain::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        'course.exist'                   => \App\Http\Middleware\Course\Exist::class,
        'course.manage'                  => \App\Http\Middleware\Course\Manage::class,
        'course.syllabus.exist'          => \App\Http\Middleware\Course\SyllabusExist::class,
        'course.feedback'                => \App\Http\Middleware\Course\Feedback::class,
        'course.register'                => \App\Http\Middleware\Course\Register::class,
        'course.syllabus.script'         => \App\Http\Middleware\Course\Script::class,
        'course.access.add'              => \App\Http\Middleware\Course\Add\Access::class,
        'course.instructors.email.exist' => \App\Http\Middleware\Course\Add\InstructorsEmailExist::class,
        'course.valid.color.logo'        => \App\Http\Middleware\Course\Add\ValidColorAndLogo::class,

        'contest.exist'                  => \App\Http\Middleware\Contest\Exist::class,
        'contest.register.due'           => \App\Http\Middleware\Contest\RegisterIsDue::class,
        'contest.manage'                 => \App\Http\Middleware\Contest\Manage::class,
        'contest.access.add'             => \App\Http\Middleware\Contest\AccessAdd::class,

        'organization.exist'             => \App\Http\Middleware\Organization\Exist::class,
    ];

    /**
     * The priority-sorted list of middleware.
     *
     * This forces non-global middleware to always be in the given order.
     *
     * @var array
     */
    protected $middlewarePriority = [
        \App\Http\Middleware\GetSourseDomain::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\Authenticate::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,

        \App\Http\Middleware\Course\Exist::class,
        \App\Http\Middleware\Course\Manage::class,
        \App\Http\Middleware\Course\SyllabusExist::class,
        \App\Http\Middleware\Course\Register::class,
        \App\Http\Middleware\Course\Feedback::class,
        \App\Http\Middleware\Course\Script::class,
        \App\Http\Middleware\Course\Add\Access::class,
        \App\Http\Middleware\Course\Add\InstructorsEmailExist::class,
        \App\Http\Middleware\Course\Add\ValidColorAndLogo::class,

        \App\Http\Middleware\Contest\Exist::class,
        \App\Http\Middleware\Contest\RegisterIsDue::class,
        \App\Http\Middleware\Contest\Manage::class,
        \App\Http\Middleware\Contest\AccessAdd::class
    ];
}
