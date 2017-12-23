<?php

/**
 * @param null   $request
 * @param string $method
 */
function getWebByRequest($request = null, $method = 'first')
{
    if (! $request) {
        $request = app('request');
    }

    $domain = strrchr($request->getHost(), '.');
    $host = str_replace($domain, '', str_replace('www.', '', $request->getHost()));

    if (strstr($host, '.')) {
        $findBy = 'subdomain';
        $host = strstr($host, '.', true);
    } else {
        $findBy = 'domain';
        $host = $host.$domain;
    }

    return App\ProteCMS\Core\Models\Webs\Web::where($findBy, $host)->$method() ?: abort(500);
}

if (! function_exists('shelter')) {
    /**
     * @return \Illuminate\Foundation\Application|mixed
     */
    function shelter()
    {
        return app('shelter');
    }
}

if (! function_exists('activity')) {
    /**
     * @param null $user
     *
     * @return \App\ProteCMS\Core\Models\Activity
     */
    function activity($user = null)
    {
        $activity = new \App\ProteCMS\Core\Models\Activity();

        $activity->setWeb(app('App\ProteCMS\Core\Models\Webs\Web') ?: null);

        if (! $user) {
            $activity->setUser(Auth::check() ? Auth::user() : null);
        }

        return $activity;
    }
}

if (! function_exists('checkFolder')) {
    /**
     * @param $path
     * @param int  $chmod
     * @param bool $recursive
     *
     * @return mixed
     */
    function checkFolder($path, $chmod = 0777, $recursive = true)
    {
        if (! is_dir($path)) {
            mkdir($path, $chmod, $recursive);
        }

        return $path;
    }
}

if (! function_exists('removeFolder')) {
    /**
     * @param $path
     */
    function removeFolder($path)
    {
        if (! is_dir($path)) {
            return;
        }

        $files = glob($path.'/*');
        foreach ($files as $file) {
            is_dir($file) ? removeFolder($file) : unlink($file);
        }
        rmdir($path);
    }
}

if (! function_exists('flash')) {
    /**
     * @param $text
     * @param string $type
     */
    function flash($text, $type = 'success')
    {
        session()->flash('flash', [
            'text' => $text,
            'type' => $type,
        ]);
    }
}
