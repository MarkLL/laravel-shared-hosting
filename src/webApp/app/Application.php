<?php
/**
 * Laravel - App Master class
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylorotwell@gmail.com>
 *
 ** *** Note: This script has been adjusted to enable running on a shared
 **           server situation by MarkLL <mark@markll.com.au> :
 **
 **/

namespace App;

use Illuminate\Foundation\Application as LaravelApplication;

class Application extends LaravelApplication
{
    /**
     * The custom Public path defined by the deployment.
     *
     * @var string
     */
    protected $publicPath;

    /**
     * Create a new Illuminate application instance.
     *
     * @param  string|null $basePath
     * @param  string|null $publicPath
     */
    public function __construct($basePath = null, $publicPath = null)
    {
        // we are first in, so sneak it in before the app 
        // really fires.
        if ($publicPath) {
            $this->publicPath = rtrim($publicPath, '\/');
        }

        // The parent continues on...
        // The new app initialises the 'path.public'
        // IOC item by calling the method publicPath()
        // which we over-ride below.
        parent::__construct($basePath);
    }

    /**
     * Get the path to the public / web directory.
     * *** Override the base class method ***
     *
     * @return string
     */
    public function publicPath()
    {
        return $this->publicPath ?: $this->basePath.DIRECTORY_SEPARATOR.'public';
    }

    /**
     * Set the Public directory.
     *
     * @param  string  $path
     * @return $this
     */
    public function usePublicPath($path)
    {
        $this->publicPath = rtrim($path, '\/');

        $this->instance('path.public', $path);

        return $this;
    }
}
