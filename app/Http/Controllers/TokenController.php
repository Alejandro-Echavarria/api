<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api')->except(['index', 'show']);
        // $this->middleware('scopes:read-post')->only('index', 'show');
        $this->middleware('can:edit.posts')->only('index');
        // $this->middleware(['scopes:update-post', 'can:edit.posts'])->only(['update']);
        // $this->middleware(['scopes:delete-post', 'can:delete.posts'])->only(['destroy']);
    }
    public function index()
    {
        return view('tokens.index');
    }
}
