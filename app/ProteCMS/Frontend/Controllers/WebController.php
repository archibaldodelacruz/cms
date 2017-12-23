<?php

namespace App\ProteCMS\Frontend\Controllers;

use App\ProteCMS\Core\Models\Posts\Post;
use Illuminate\Http\Request;

class WebController extends BaseController
{
    protected $post;

    public function __construct(Post $post)
    {
        parent::__construct();

        if (shelter()->subdomain === 'admin' && ! shelter()->getConfig('web')) {
            abort(404);
        }

        $this->post = $post;
    }

    public function index(Request $request)
    {
        $last_posts = $this->post
            ->where('status', 'published')
            ->where('published_at', '<', date('Y-m-d H:i:s'))
            ->with(['author', 'category'])
            ->orderBy('fixed', 1)
            ->orderBy('published_at', 'DESC')
            ->paginate($this->web->getConfig('posts.pagination'));

        dd(app('view'));

        return view('index', compact('last_posts'));
    }

    public function custom_css(Request $request)
    {
        return response()
            ->view('customcss')
            ->header('Content-Type', 'text/css');
    }

    public function error404()
    {
        return view('errors.404');
    }
}
