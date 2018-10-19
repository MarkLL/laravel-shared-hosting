<?php
/**
 * Laravel - App Bootstrap
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylorotwell@gmail.com>
 *
 * *** Note: This script has been adjusted to enable running on a shared
 *           server situation by MarkLL <mark@markll.com.au> :
 *
 **/

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
| To facilitate working on a standard Shared Hosting platform we need to
| tell the application where the public path actually is. It's really
| important that the public root is specified even if your app is
| installed in a sub directory.
|
*/

// One simple change is all that is needed to enable the correct public path...
// e.g. we replace the original code...
//
// $app = new Illuminate\Foundation\Application(
//     realpath(__DIR__.'/../')
// );
//
// with our replacement Application subclass
$app = new App\Application(
    realpath(__DIR__.'/../'),                       // @param  string|null  $basePath
    realpath(__DIR__.'/../../public_html')          // @param  string|null  $publicPath; Must be Hard coded path
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
