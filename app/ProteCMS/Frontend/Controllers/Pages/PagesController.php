<?php

namespace App\ProteCMS\Frontend\Controllers\Pages;

use Illuminate\Http\Request;
use App\ProteCMS\Frontend\Controllers\BaseController;

class PagesController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function show(Request $request, $id)
    {
        $page = $this->web->pages()->where('status', 'published')->with('author')->findOrFail($id);

        return view('pages.show', compact('page'));
    }
}
